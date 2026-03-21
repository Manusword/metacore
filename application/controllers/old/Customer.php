<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

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

	//checking fun_customer_gst is exits or not
	public function fun_customer_gst()
	{
		if(isset($_REQUEST['gst']) and strlen($_REQUEST['gst'])>0)
		{
			$gst=$_REQUEST['gst'];
			$res = $this->Customermodel->check_customer_gst($gst);
			if(isset($res) and !empty($res))
			{
				echo "TRUE";
			}
		}
	}//function close


	//checking fun_check_customer_code is exits or not
	public function fun_check_customer_code()
	{
		if(isset($_REQUEST['customer_code']) and strlen($_REQUEST['customer_code'])>0)
		{
			$customer_code=$_REQUEST['customer_code'];
			$where=" customer_code='$customer_code' ";
			$res_chk=$this->Mymodel->select_where('customer',$where);
			if(isset($res_chk) and count($res_chk)>0)
			{
				echo "Not Save. $customer_code Customer No Already Available";
			}
			
		}
	}//function close



	


	public function get_all_product_of_this_customer()
	{
		?> <option value="">Select</option><?php
		if(isset($_REQUEST['customer_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$out1 = $this->Customermodel->get_customer_rate_with_id($customer_id);
			foreach($out1 as $o)
			{
				$pro = $this->Productmodel->get_product_data_with_id($o['product_id']);
				?><option value="<?php echo $o['product_id'];?>"><?php echo $pro[0]['name'];?></option><?php
			}//foreach
		}//isset
	}//function close



	public function get_customer_product_rate()
	{
		if(isset($_REQUEST['customer_id']) and isset($_REQUEST['product_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$product_id = $_REQUEST['product_id'];
			echo $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
		}
	}//function close








































	public function add()
	{
		$result['state']=$this->Base->get_all_state();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Customermodel->get_customer_with_id($id);
			$result['res3'] = $this->Customermodel->get_customer_rate_with_id($id);
		}//strlen
		$this->load->view('customer/entry',$result);
	}//function close


	


	public function save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['gst'])){$gst=$_REQUEST['gst'];}else{$gst='';}
		if(isset($_REQUEST['gst2'])){$gst2=$_REQUEST['gst2'];}else{$gst2='';}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(isset($_REQUEST['name'])){$name=$_REQUEST['name'];}else{$name='';}
		if(isset($_REQUEST['customer_code'])){$customer_code=$_REQUEST['customer_code'];}else{$customer_code='';}
		if(isset($_REQUEST['telphone'])){$telphone=$_REQUEST['telphone'];}else{$telphone='';}
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}else{$email='';}
		if(isset($_REQUEST['state'])){$state=$_REQUEST['state'];}else{$state='';}
		if(isset($_REQUEST['city'])){$city=$_REQUEST['city'];}else{$city='';}
		if(isset($_REQUEST['address'])){$address=$_REQUEST['address'];}else{$address='';}
		if(isset($_REQUEST['country'])){$country=$_REQUEST['country'];}else{$country='';}
		if(isset($_REQUEST['zip'])){$zip=$_REQUEST['zip'];}else{$zip='';}
		if(isset($_REQUEST['vender_code'])){$vender_code=$_REQUEST['vender_code'];}else{$vender_code='';}
		if(isset($_REQUEST['con_name1'])){$con_name1=$_REQUEST['con_name1'];}else{$con_name1='';}
		if(isset($_REQUEST['con_mob1'])){$con_mob1=$_REQUEST['con_mob1'];}else{$con_mob1='';}
		if(isset($_REQUEST['con_email1'])){$con_email1=$_REQUEST['con_email1'];}else{$con_email1='';}
		if(isset($_REQUEST['designation1'])){$designation1=$_REQUEST['designation1'];}else{$designation1='';}
		if(isset($_REQUEST['con_name2'])){$con_name2=$_REQUEST['con_name2'];}else{$con_name2='';}
		if(isset($_REQUEST['con_mob2'])){$con_mob2=$_REQUEST['con_mob2'];}else{$con_mob2='';}
		if(isset($_REQUEST['con_email2'])){$con_email2=$_REQUEST['con_email2'];}else{$con_email2='';}
		if(isset($_REQUEST['designation2'])){$designation2=$_REQUEST['designation2'];}else{$designation2='';}
		if(isset($_REQUEST['bill_name'])){$bill_name=$_REQUEST['bill_name'];}else{$bill_name='';}
		if(isset($_REQUEST['bill_address'])){$bill_address=$_REQUEST['bill_address'];}else{$bill_address='';}
		if(isset($_REQUEST['bill_city'])){$bill_city=$_REQUEST['bill_city'];}else{$bill_city='';}
		if(isset($_REQUEST['bill_state'])){$bill_state=$_REQUEST['bill_state'];}else{$bill_state='';}
		if(isset($_REQUEST['bill_country'])){$bill_country=$_REQUEST['bill_country'];}else{$bill_country='';}
		if(isset($_REQUEST['bill_zip'])){$bill_zip=$_REQUEST['bill_zip'];}else{$bill_zip='';}
		if(isset($_REQUEST['limit_of_dis'])){$limit_of_dis=$_REQUEST['limit_of_dis'];}else{$limit_of_dis='';}
		if(isset($_REQUEST['limit_of_days'])){$limit_of_days=$_REQUEST['limit_of_days'];}else{$limit_of_days='';}
		if(isset($_REQUEST['scheme1'])){$scheme1=$_REQUEST['scheme1'];}else{$scheme1='';}
		if(isset($_REQUEST['dis_val1'])){$dis_val1=$_REQUEST['dis_val1'];}else{$dis_val1='';}
		if(isset($_REQUEST['dis_day1'])){$dis_day1=$_REQUEST['dis_day1'];}else{$dis_day1='';}
		if(isset($_REQUEST['dis_val2'])){$dis_val2=$_REQUEST['dis_val2'];}else{$dis_val2='';}
		if(isset($_REQUEST['dis_day2'])){$dis_day2=$_REQUEST['dis_day2'];}else{$dis_day2='';}
		if(isset($_REQUEST['dis_val3'])){$dis_val3=$_REQUEST['dis_val3'];}else{$dis_val3='';}
		if(isset($_REQUEST['dis_day3'])){$dis_day3=$_REQUEST['dis_day3'];}else{$dis_day3='';}
		if(isset($_REQUEST['area_location'])){$area_location=$_REQUEST['area_location'];}else{$area_location='';}
		if(isset($_REQUEST['sales_person'])){$sales_person=$_REQUEST['sales_person'];}else{$sales_person='';}
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}
		if(isset($_REQUEST['is_tcs'])){$is_tcs=$_REQUEST['is_tcs'];}else{$is_tcs='';} 
		if(isset($_REQUEST['show_in_follow_up'])){$show_in_follow_up=$_REQUEST['show_in_follow_up'];}else{$show_in_follow_up=0;}
		if(isset($_REQUEST['disputed_issue'])){$disputed_issue=$_REQUEST['disputed_issue'];}else{$disputed_issue=0;}
		//--------------------------------------row
		if(isset($_REQUEST['details_id'])){$details_id=explode('~',$_REQUEST['details_id']);}else{$details_id='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);}else{$goods='';}
		if(isset($_REQUEST['rate'])){$rate=explode('~',$_REQUEST['rate']);$no_of_row=count($rate);}else{$rate='';}
		if(isset($_REQUEST['custname'])){$custname=explode('~',$_REQUEST['custname']);}else{$custname='';}

		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['gst']))
		{
			
			$gst=$_REQUEST['gst'];
			$where=" gst_no='$gst' ";
			$res_chk=$this->Mymodel->select_where('customer',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
			if(isset($id2))
			{
				echo "Not Save. $gst GST NO Already Available";
			}
			else 
			{
				$data=array(
							  'type'=>"$type",
							  'customer_code'=>"$customer_code",
							  'name'=>"$name",
							  'telphone'=>"$telphone",
							  'email'=>"$email",
							  'address'=>"$address",
							  'city'=>"$city",
							  'state'=>"$state",
							  'country'=>"$country",
							  'zip'=>"$zip",
							  'vender_code'=>"$vender_code",
							  'bill_name'=>"$bill_name",
							  'bill_address'=>"$bill_address",
							  'bill_city'=>"$bill_city",
							  'bill_state'=>"$bill_state",
							  'bill_country'=>"$bill_country",
							  'bill_zip'=>"$bill_zip",
							  'gst_no'=>"$gst",
							  'gst_no2'=>"$gst2",
							  'con_name1'=>"$con_name1",
							  'con_mob1'=>"$con_mob1",
							  'con_email1'=>"$con_email1",
							  'designation1'=>"$designation1",
							  'con_name2'=>"$con_name2",
							  'con_mob2'=>"$con_mob2",
							  'con_email2'=>"$con_email2",
							  'designation2'=>"$designation2",
							  'limit_of_dis'=>"$limit_of_dis",
							  'limit_of_days'=>"$limit_of_days",
							  'scheme1'=>"$scheme1",
							  'dis_val1'=>"$dis_val1",
							  'dis_day1'=>"$dis_day1",
							  'dis_val2'=>"$dis_val2",
							  'dis_day2'=>"$dis_day2",
							  'dis_val3'=>"$dis_val3",
							  'dis_day3'=>"$dis_day3",
							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							  'status'=>"$active", 
							  'is_tcs'=>"$is_tcs", 
							  'show_in_follow_up'=>"$show_in_follow_up",
							  'disputed_issue'=>"$disputed_issue",
							  'sales_person'=>"$sales_person",
							  'area_location'=>"$area_location",
							);
				$cat_id = $this->Mymodel->insertdata_withid('customer',$data);
				
				//customer rate entry
				if($this->Company->customer_rate_entry_via_customer_add() == 'TRUE')
				{
					if($cat_id>0)
					{
						for($i=0;$i<$no_of_row;$i++)
						{
							if($rate[$i]>0)
							{
								$data2=array(
											  'customer_id'=>"$cat_id",
											  'product_id'=>"$goods[$i]",
											  'rate'=>"$rate[$i]",
											  'custname'=>"$custname[$i]",
											  'save_by'=>"$user_email",
											  'save_date'=>"$today",
											);
								$this->Mymodel->insertdata('customer_rate',$data2);
							}
						}
					}//if($cat_id>0)
				}//customer_rate_entry_via_customer_add
				
				
				echo "Save";
			}//gst
		}//insert
		
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['gst']))
		{
			$id=$_REQUEST['id'];
			$old_day_limit = 0;
			$where=" gst_no='$gst' ";
			$res_chk=$this->Mymodel->select_where('customer',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id']; $old_day_limit = $res_chk[0]['limit_of_days'];}
			if(isset($id2) and $id!=$id2)
			{
				echo "Not Save. $gst GST NO Already Available";
			}
			else
			{
				
				$data=array(
							  'type'=>"$type",
							  'customer_code'=>"$customer_code",
							  'name'=>"$name",
							  'telphone'=>"$telphone",
							  
							  'email'=>"$email",
							  'address'=>"$address",
							  'city'=>"$city",
							  
							  'state'=>"$state",
							  'country'=>"$country",
							  'zip'=>"$zip",
							  'vender_code'=>"$vender_code",
							  'bill_name'=>"$bill_name",
							  'bill_address'=>"$bill_address",
							  'bill_city'=>"$bill_city",
							  'bill_state'=>"$bill_state",
							  'bill_country'=>"$bill_country",
							  'bill_zip'=>"$bill_zip",
							  
							  'gst_no'=>"$gst",
							  'gst_no2'=>"$gst2",
							  
							  'con_name1'=>"$con_name1",
							  'con_mob1'=>"$con_mob1",
							  'con_email1'=>"$con_email1",
							  'designation1'=>"$designation1",
							  
							  'con_name2'=>"$con_name2",
							  'con_mob2'=>"$con_mob2",
							  'con_email2'=>"$con_email2",
							  'designation2'=>"$designation2",
							  
							  'limit_of_dis'=>"$limit_of_dis",
							  'limit_of_days'=>"$limit_of_days",
							  'scheme1'=>"$scheme1",
							  'dis_val1'=>"$dis_val1",
							  'dis_day1'=>"$dis_day1",
							  'dis_val2'=>"$dis_val2",
							  'dis_day2'=>"$dis_day2",
							  'dis_val3'=>"$dis_val3",
							  'dis_day3'=>"$dis_day3",
							  
							  'update_by'=>"$user_email",
							  'update_date'=>"$today",
							  'status'=>"$active",
							  'is_tcs'=>"$is_tcs",
							  'show_in_follow_up'=>"$show_in_follow_up",
							  'disputed_issue'=>"$disputed_issue",
							  'sales_person'=>"$sales_person",
							  'area_location'=>"$area_location",
							);
				$where=array('id'=>"$id");   
				$this->Mymodel->update('customer',$data,$where);


				//update day limi in cr dr master
				if($old_day_limit != $limit_of_days){
					
					$noti_days = $this->Base->get_debit_payment_notifi_days();
					if($limit_of_days >$noti_days){$limit_of_days2 = $limit_of_days-$noti_days;}else{$limit_of_days2 =$limit_of_days;}
					$sql2 = "SELECT cr_dr_id,day_limit,entry_date,last_date,notifi_date from cr_dr_master  where customer_id ='$id'  ";
					$query2 = $this->db->query($sql2);
					$res3 = $query2->result_array();
					if(!empty($res3)){
						//print_r($res3);
						foreach($res3 as $m){
							$cr_dr_id = $m['cr_dr_id'];
							$entry_date = $m['entry_date'];
							
							$new_last_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date($entry_date),"+$limit_of_days"));
							$new_follow_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date($entry_date),"+$limit_of_days2"));
							
							//update table
							$data5=array(
											'day_limit'=>"$limit_of_days",
											'last_date'=>"$new_last_date",
											'notifi_date'=>"$new_follow_date",
											
										);
							$where5=array('cr_dr_id'=>"$cr_dr_id");   
							$this->Mymodel->update('cr_dr_master',$data5,$where5);
						}
					}
				}//days

				
				
				if($this->Company->customer_rate_entry_via_customer_add() == 'TRUE')
				{
					//-------------------------delete
					$this->Customermodel->customer_rate_delete($id);
					//-------------------------delete
					
					if($id>0)
					{
						for($i=0;$i<$no_of_row;$i++)
						{
							if($rate[$i]>0)
							{
								$data2=array(
											  'customer_id'=>"$id",
											  'product_id'=>"$goods[$i]",
											  'rate'=>"$rate[$i]",
											  'custname'=>"$custname[$i]",
											  'save_by'=>"$user_email",
											  'save_date'=>"$today",
											);
								$this->Mymodel->insertdata('customer_rate',$data2);
							}
						}
					}//if($id>0)
				}//customer_rate_entry_via_customer_add
				
				echo "Update";
			}//gst
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close
	
	
	
	
	
	
	//customer->list search
	public function list()
	{
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['type'])){$type=$_REQUEST['type'];$where.=" and  type='$type'   ";}
			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  name like '%$name%'   ";}
			if(!empty($_REQUEST['city'])){$city=$_REQUEST['city'];$where.=" and  city='$city'   ";}
			if(!empty($_REQUEST['sales_person'])){$sales_person=$_REQUEST['sales_person'];$where.=" and  sales_person='$sales_person'   ";}
			if(!empty($_REQUEST['area_location'])){$area_location=$_REQUEST['area_location'];$where.=" and  city='$area_location'   ";}
			if(!empty($_REQUEST['show_in_follow_up'])){
				$show_in_follow_up=$_REQUEST['show_in_follow_up'];
				if($show_in_follow_up == 'Yes'){
					$where.=" and  show_in_follow_up = 1   ";
				}else{
					$where.=" and  show_in_follow_up != 1   ";
				}
				
			}
			
			$where.=" ORDER by name ASC ";
			$result['res2'] = $this->Customermodel->get_all_customer_with_search($where);
			$this->load->view('customer/show_table',$result);
		}
		else
		{
			$where = " and id!='' ORDER by name ASC ";
			$result['res2'] = $this->Customermodel->get_all_customer_with_search($where);
			$this->load->view('customer/show',$result);
		}
	}//function close


	
	
	
	
	
	
	
	
	
	 public function edit()
	 {
		//--------------------------------------------------access
		if(strlen($this->uri->segment(1))>0){$controler_name=$this->uri->segment(1);}else{$controler_name='';}
		if(strlen($this->uri->segment(2))>0){$function_name=$this->uri->segment(2);}else{$function_name='';}
		$this->Mymodel->access($controler_name,$function_name);
		//--------------------------------------------------access
		$where=" id=10 ";
		$result['company_setting']=$this->Mymodel->select_where('company_setting',$where);
		
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			if(strlen($this->uri->segment(4))>0){$last_value=$this->uri->segment(4);$result= $this->Mymodel->error($last_value);}
	
			$where="1=1 and id='$id' ";
			$result['res2']=$this->Mymodel->select_where('customer',$where);


			$where="1=1 and customer_id='$id' ";
			$result['res3']=$this->Mymodel->select_where('customer_rate',$where);
			
			$where="1=1 and sno!='' ORDER by state_name ASC ";
			$result['state']=$this->Mymodel->select_where('state_code',$where);
			
			
			$this->load->view('customer/entry',$result);
		}//if 3 exits
		else
		{
			//redirect('Customer/create/');
			echo "NO Id Found";
		}
	  }//function close
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	public function comp_entry()
	{
		
		$where="1=1 and id!=''  ORDER by name ASC ";
		$result['customer']=$this->Mymodel->select_where('customer',$where);
		
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
	
			$where="comp_id='$id' ";
			$result['res2']=$this->Mymodel->select_where('customer_complain',$where);
		}//if 3 exits
	 
		$this->load->view('customer/comp/entry',$result);
	}//function close
	
	
	
	
	
	
	
	
	
	
	public function complaint_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(!empty($_REQUEST['complain_date'])){$complain_date=$this->Base->change_date_ymd($_REQUEST['complain_date']);}else{$complain_date='';}
		if(isset($_REQUEST['customer_name'])){$customer_name=$_REQUEST['customer_name'];}else{$customer_name='';}
		if(isset($_REQUEST['defect_qty'])){$defect_qty=$_REQUEST['defect_qty'];}else{$defect_qty='';}
		if(isset($_REQUEST['defect_amount'])){$defect_amount=$_REQUEST['defect_amount'];}else{$defect_amount='';}
		if(isset($_REQUEST['defect_unit'])){$defect_unit=$_REQUEST['defect_unit'];}else{$defect_unit='';}
		if(isset($_REQUEST['defect_bobbin'])){$defect_bobbin=$_REQUEST['defect_bobbin'];}else{$defect_bobbin='';}

		if(isset($_REQUEST['type_of_wire1'])){$type_of_wire1=$_REQUEST['type_of_wire1'];}else{$type_of_wire1='';}
		if(isset($_REQUEST['tag_size1'])){$tag_size1=$_REQUEST['tag_size1'];}else{$tag_size1='';}
		if(isset($_REQUEST['tag_grade1'])){$tag_grade1=$_REQUEST['tag_grade1'];}else{$tag_grade1='';}
		if(isset($_REQUEST['tag_coil_no1'])){$tag_coil_no1=$_REQUEST['tag_coil_no1'];}else{$tag_coil_no1='';}
		if(!empty($_REQUEST['tag_date1'])){$tag_date1=$this->Base->change_date_ymd($_REQUEST['tag_date1']);}else{$tag_date1='';}
		if(isset($_REQUEST['tag_shift1'])){$tag_shift1=$_REQUEST['tag_shift1'];}else{$tag_shift1='';}
		
		if(isset($_REQUEST['type_of_wire2'])){$type_of_wire2=$_REQUEST['type_of_wire2'];}else{$type_of_wire2='';}
		if(isset($_REQUEST['tag_size2'])){$tag_size2=$_REQUEST['tag_size2'];}else{$tag_size2='';}
		if(isset($_REQUEST['tag_grade2'])){$tag_grade2=$_REQUEST['tag_grade2'];}else{$tag_grade2='';}
		if(isset($_REQUEST['tag_coil_no2'])){$tag_coil_no2=$_REQUEST['tag_coil_no2'];}else{$tag_coil_no2='';}
		if(!empty($_REQUEST['tag_date2'])){$tag_date2=$this->Base->change_date_ymd($_REQUEST['tag_date2']);}else{$tag_date2='';}
		if(isset($_REQUEST['tag_shift2'])){$tag_shift2=$_REQUEST['tag_shift2'];}else{$tag_shift2='';}
		
		if(isset($_REQUEST['desc_problem'])){$desc_problem=$_REQUEST['desc_problem'];}else{$desc_problem='';}
		if(isset($_REQUEST['scope'])){$scope=$_REQUEST['scope'];}else{$scope='';}
		if(isset($_REQUEST['comp_by'])){$comp_by=$_REQUEST['comp_by'];}else{$comp_by='';}

		if(isset($_REQUEST['rece_by'])){$rece_by=$_REQUEST['rece_by'];}else{$rece_by='';}
		if(isset($_REQUEST['priority'])){$priority=$_REQUEST['priority'];}else{$priority='';}
		if(isset($_REQUEST['department'])){$department=$_REQUEST['department'];}else{$department='';}

		if(isset($_REQUEST['assigned_to'])){$assigned_to=$_REQUEST['assigned_to'];}else{$assigned_to='';}
		if(isset($_REQUEST['root_cause'])){$root_cause=$_REQUEST['root_cause'];}else{$root_cause='';}
		if(isset($_REQUEST['corrective_action'])){$corrective_action=$_REQUEST['corrective_action'];}else{$corrective_action='';}

		if(isset($_REQUEST['preventive_action'])){$preventive_action=$_REQUEST['preventive_action'];}else{$preventive_action='';}
		if(isset($_REQUEST['verification'])){$verification=$_REQUEST['verification'];}else{$verification='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}

		if(!empty($_REQUEST['resolution'])){$resolution=$this->Base->change_date_ymd($_REQUEST['resolution']);}else{$resolution='';}
		if(isset($_REQUEST['followup_req'])){$followup_req=$_REQUEST['followup_req'];}else{$followup_req='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		/*
		if(isset($_FILES['img1']))
		{
			$img1 = $_FILES['img1'];
			$img_name = $img1['name'];
			$img_temp = $img1['tmp_name'];
		}else{$img_name='';}

		$customer_folder = "pic/complaint/$customer_name/";
		// Check if folder exists
		if (!is_dir($customer_folder)) {
			mkdir($customer_folder, 0777, true); // true = create nested directories if needed
		}
		*/
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer_name']))
		{
			
			$data=array(
								'type'=>"$type",
								'complain_date'=>"$complain_date",
								'customer_name'=>"$customer_name",
								'defect_qty'=>"$defect_qty",
								'defect_amount'=>"$defect_amount",
								'defect_unit'=>"$defect_unit",
								'defect_bobbin'=>"$defect_bobbin",
								'type_of_wire1'=>"$type_of_wire1",
								'tag_size1'=>"$tag_size1",
								'tag_grade1'=>"$tag_grade1",
								'tag_coil_no1'=>"$tag_coil_no1",
								'tag_date1'=>"$tag_date1",
								'tag_shift1'=>"$tag_shift1",
								
								'type_of_wire2'=>"$type_of_wire2",
								'tag_size2'=>"$tag_size2",
								'tag_grade2'=>"$tag_grade2",
								'tag_coil_no2'=>"$tag_coil_no2",
								'tag_date2'=>"$tag_date2",
								'tag_shift2'=>"$tag_shift2",

								'desc_problem'=>"$desc_problem",
								'scope'=>"$scope",
								'comp_by'=>"$comp_by",
								'rece_by'=>"$rece_by",
								'priority'=>"$priority",
								'department'=>"$department",
								'assigned_to'=>"$assigned_to",
								'root_cause'=>"$root_cause",
								'corrective_action'=>"$corrective_action",

								'preventive_action'=>"$preventive_action",
								'verification'=>"$verification",
								'status'=>"$status",

								'resolution'=>"$resolution",
								'followup_req'=>"$followup_req",
								'remarks'=>"$remarks",

							   
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							 
							);
				$cat_id=$this->Mymodel->insertdata_withid('customer_complain',$data);
				
				//photo
				if (!empty($_FILES['img1']['name'][0])) {
					$file_count = count($_FILES['img1']['name']);

					for ($i = 0; $i < $file_count; $i++) {
						$img_name = $_FILES['img1']['name'][$i];
						$img_tmp = $_FILES['img1']['tmp_name'][$i];

						// make sure folder exists
						$folder = "pic/complaint/$customer_name/$cat_id/";
						if (!is_dir($folder)) {mkdir($folder, 0777, true);}

						// create path
						$path = $folder . $img_name;

						move_uploaded_file($img_tmp, $path);
					}
				}
				echo "Save";
		}//insert
		
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['customer_name']))
		{
			$id=$_REQUEST['id'];
			
			$data=array(
								'type'=>"$type",
								'complain_date'=>"$complain_date",
								'customer_name'=>"$customer_name",
								'defect_qty'=>"$defect_qty",
								'defect_amount'=>"$defect_amount",
								'defect_unit'=>"$defect_unit",
								'defect_bobbin'=>"$defect_bobbin",
								'type_of_wire1'=>"$type_of_wire1",
								'tag_size1'=>"$tag_size1",
								'tag_grade1'=>"$tag_grade1",
								'tag_coil_no1'=>"$tag_coil_no1",
								'tag_date1'=>"$tag_date1",
								'tag_shift1'=>"$tag_shift1",
								
								'type_of_wire2'=>"$type_of_wire2",
								'tag_size2'=>"$tag_size2",
								'tag_grade2'=>"$tag_grade2",
								'tag_coil_no2'=>"$tag_coil_no2",
								'tag_date2'=>"$tag_date2",
								'tag_shift2'=>"$tag_shift2",


								'desc_problem'=>"$desc_problem",
								'scope'=>"$scope",
								'comp_by'=>"$comp_by",
								'rece_by'=>"$rece_by",
								'priority'=>"$priority",
								'department'=>"$department",
								'type'=>"$type",
								'assigned_to'=>"$assigned_to",
								'root_cause'=>"$root_cause",
								'corrective_action'=>"$corrective_action",

								'preventive_action'=>"$preventive_action",
								'verification'=>"$verification",
								'status'=>"$status",

								'resolution'=>"$resolution",
								'followup_req'=>"$followup_req",
								'remarks'=>"$remarks",
							  
							  
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							 
							);
				$where=array('comp_id'=>"$id");   
				$this->Mymodel->update('customer_complain',$data,$where);

				//photo
				if (!empty($_FILES['img1']['name'][0])) {
					$file_count = count($_FILES['img1']['name']);

					for ($i = 0; $i < $file_count; $i++) {
						$img_name = $_FILES['img1']['name'][$i];
						$img_tmp = $_FILES['img1']['tmp_name'][$i];

						// make sure folder exists
						$folder = "pic/complaint/$customer_name/$id/";
						if (!is_dir($folder)) {mkdir($folder, 0777, true);}

						// create path
						$path = $folder . $img_name;

						move_uploaded_file($img_tmp, $path);
					}
				}

				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close
	
	


















	//debit->list search
	public function comp_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['type'])){$type=$_REQUEST['type'];$where.=" and  A.type='$type'   ";}
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_name='$search_customer'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.complain_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.complain_date ASC ";
			$result['res2'] = $this->Customermodel->get_all_cust_comp_with_search($where);
			$this->load->view('customer/comp/show_table',$result);
		}
		else
		{
			$search_date1=date('Y-m-01');
			$search_date2=date('Y-m-d');
			$where =" and A.complain_date between '$search_date1' and '$search_date2' ORDER by A.complain_date ASC ";
			$result['res2']=$this->Customermodel->get_all_cust_comp_with_search($where);
			$this->load->view('customer/comp/show',$result);
		}
	}//function close


	
	  
	public function comp_report()
	{
		
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
	
			$where=" and comp_id='$id' ";
			$result['res2']=$this->Customermodel->get_all_cust_comp_with_search($where);

			$this->load->view('customer/comp/report',$result);
		}//if 3 exits
	}//function close
	









	
	
































	//--------------------------------------------------------------------------cheque--------------------------------------------
	//payment system
	public function cheque_entry()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Customermodel->get_cr_advance_cheque_with_id($id);
		}//strlen
		$this->load->view('customer/payment/cheque/entry',$result);
	}//function close


	//cheque->list search
	public function cheque_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.receive_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.receive_date ASC ";
			$result['res2'] = $this->Customermodel->get_all_cr_advance_cheque_with_search($where);
			$this->load->view('customer/payment/cheque/show_table',$result);
		}
		else
		{
			$search_date1 = date("Y-m-01");
			$search_date2 = date("Y-m-d");
			$where=" and A.receive_date between '$search_date1' and '$search_date2'  ORDER by A.receive_date ASC ";
			$result['res2']=$this->Customermodel->get_all_cr_advance_cheque_with_search($where);
			$this->load->view('customer/payment/cheque/show',$result);
		}
	}//function close
	
	public function cheque_entry_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}
		if(!empty($_REQUEST['receive_date'])){$receive_date=$this->Base->change_date_ymd($_REQUEST['receive_date']);}else{$receive_date=date('Y-m-d');}
		
		if(isset($_REQUEST['cheque_no'])){$cheque_no=$_REQUEST['cheque_no'];}else{$cheque_no='';}
		if(isset($_REQUEST['authorized_person'])){$authorized_person=$_REQUEST['authorized_person'];}else{$authorized_person='';}

		if(isset($_REQUEST['bank_name'])){$bank_name=$_REQUEST['bank_name'];}else{$bank_name='';}
		if(isset($_REQUEST['account_no'])){$account_no=$_REQUEST['account_no'];}else{$account_no='';}
		if(isset($_REQUEST['ifsc_code'])){$ifsc_code=$_REQUEST['ifsc_code'];}else{$ifsc_code='';}
		if(isset($_REQUEST['bank_address'])){$bank_address=$_REQUEST['bank_address'];}else{$bank_address='';}
		if(isset($_REQUEST['amount_status'])){$amount_status=$_REQUEST['amount_status'];}else{$amount_status='';}
		if(isset($_REQUEST['cheque_amount'])){$cheque_amount=$_REQUEST['cheque_amount'];}else{$cheque_amount='';}
		if(!empty($_REQUEST['expiry_date'])){$expiry_date=$this->Base->change_date_ymd($_REQUEST['expiry_date']);}else{$expiry_date='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			
			$data=array(
							'customer_id'=>"$customer_id",
							'receive_date'=>"$receive_date",
							'cheque_no'=>"$cheque_no",
							'authorized_person'=>"$authorized_person",
							'bank_name'=>"$bank_name",
							'account_no'=>"$account_no",
							'ifsc_code'=>"$ifsc_code",
							'bank_address'=>"$bank_address",
							'amount_status'=>"$amount_status",
							'cheque_amount'=>"$cheque_amount",
							'expiry_date'=>"$expiry_date",
							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
				$cat_id=$this->Mymodel->insertdata_withid('cr_advance_cheque',$data);
				echo "Save";
		}//insert
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			$id=$_REQUEST['id'];

			$data=array(
							'customer_id'=>"$customer_id",
							'receive_date'=>"$receive_date",
							'cheque_no'=>"$cheque_no",
							'authorized_person'=>"$authorized_person",
							'bank_name'=>"$bank_name",
							'account_no'=>"$account_no",
							'ifsc_code'=>"$ifsc_code",
							'bank_address'=>"$bank_address",
							'amount_status'=>"$amount_status",
							'cheque_amount'=>"$cheque_amount",
							'expiry_date'=>"$expiry_date",
							'remarks'=>"$remarks",
							  
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
				$where=array('id'=>"$id");   
				$this->Mymodel->update('cr_advance_cheque',$data,$where);
				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close









	//--------------------------------------------------------------------------Debit--------------------------------------------
	//payment system
	public function debit_entry()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Customermodel->get_cr_dr_master_with_id($id);
		}//strlen
		$this->load->view('customer/payment/entry',$result);
	}//function close



	//debit->list search
	public function debit_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Customermodel->get_all_debit_with_search($where);
			$this->load->view('customer/payment/debit_show_table',$result);
		}
		else
		{
			$search_date = date("Y-m-d");
			$where=" and A.entry_date = '$search_date'  ORDER by A.entry_date ASC ";
			$result['res2']=$this->Customermodel->get_all_debit_with_search($where);
			$this->load->view('customer/payment/debit_show',$result);
		}
	}//function close

	


	



	
	public function customer_debit_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['invoice_no'])){$invoice_no=strtoupper($_REQUEST['invoice_no']);}else{$invoice_no='';}
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}
		if(isset($_REQUEST['debit_amount'])){$debit_amount=$_REQUEST['debit_amount'];}else{$debit_amount='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['fin_year'])){$fin_year=$_REQUEST['fin_year'];}else{$fin_year='';}
		
		
		
		
		
		//getting day limit
		$out3 = $this->Customermodel->get_customer_with_id($customer_id);
		if(!empty($out3)){
			$limit_of_days = $out3[0]['limit_of_days'];
		}//empty
		else{
			$limit_of_days = 30;
		}
		
		$noti_days = $this->Base->get_debit_payment_notifi_days();
		
		//notification limit
		if($limit_of_days > $noti_days){ $noti_limit = ($limit_of_days-$noti_days);}else{ $noti_limit = $limit_of_days;}
		
		$last_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd($entry_date,"$limit_of_days"));
		$notifi_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd($entry_date,"$noti_limit"));
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			
			$data=array(
							'entry_date'=>"$entry_date",
							'day_limit'=>"$limit_of_days",
							'last_date'=>"$last_date",
							'notifi_date'=>"$notifi_date",
							'invoice_no'=>"$invoice_no",
							'fin_year'=>"$fin_year",
							'customer_id'=>"$customer_id",
							'debit_amount'=>"$debit_amount",
							'rem_amount'=>"$debit_amount",
							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
				$cat_id=$this->Mymodel->insertdata_withid('cr_dr_master',$data);
				echo "Save";
		}//insert
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			$id=$_REQUEST['id'];

			//getting rem_amount 
			$out3 = $this->Customermodel->get_cr_dr_master_with_id($id);
			if(!empty($out3)){
				//$old_debit_amount = $out3[0]['debit_amount'];
				$old_credit_amount = (float)$out3[0]['credit_amount'];
				$rem_amount = ($debit_amount - $old_credit_amount);
			}//empty
			else{
				$rem_amount = $debit_amount;
			}
			
			$data=array(
							'entry_date'=>"$entry_date",
							'day_limit'=>"$limit_of_days",
							'last_date'=>"$last_date",
							'notifi_date'=>"$notifi_date",
							'invoice_no'=>"$invoice_no",
							'fin_year'=>"$fin_year",
							'customer_id'=>"$customer_id",
							'debit_amount'=>"$debit_amount",
							'rem_amount'=>"$rem_amount",
							'remarks'=>"$remarks",
							  
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
				$where=array('cr_dr_id'=>"$id");   
				$this->Mymodel->update('cr_dr_master',$data,$where);
				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close


	
	
	public function customer_cr_dr_follow_up_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['next_follow_up_date'])){$next_follow_up_date=$this->Base->change_date_ymd($_REQUEST['next_follow_up_date']);}else{$next_follow_up_date='';}
		if(isset($_REQUEST['follow_up_last_status'])){$follow_up_last_status=$_REQUEST['follow_up_last_status'];}else{$follow_up_last_status='';}
		if(isset($_REQUEST['current_cumments'])){$current_cumments=$_REQUEST['current_cumments'];}else{$current_cumments='';}
		
		
		//----------------------------------------------------------------------insert
		if(!empty($_REQUEST['follow_up_customer_id']) and !empty($_REQUEST['next_follow_up_date']))
		{
			$follow_up_customer_id = $_REQUEST['follow_up_customer_id'];

				// New Entry
					$data=array(
								'customer_id'=>"$follow_up_customer_id",
								'entry_date'=>"$today",
								'last_status'=>"$follow_up_last_status",
								'current_comments'=>"$current_cumments",
								'next_follow_up_date'=>"$next_follow_up_date",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
					$cat_id=$this->Mymodel->insertdata_withid('cr_dr_master_follow_up',$data);

					//update in customer table
					$data=array(
						'follow_up_date'=>"$next_follow_up_date",
						'follow_up_last_status'=>"$follow_up_last_status",
						'follow_up_comments'=>"$current_cumments",
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
					$where=array('id'=>"$follow_up_customer_id");   
					$this->Mymodel->update('customer',$data,$where);
				echo "Save";
		}//insert
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close




































	//--------------------------------------------------------------------------Credit--------------------------------------------
	//payment system
	public function credit_entry()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Customermodel->get_cr_dr_master_with_id($id);
		}//strlen
		$this->load->view('customer/payment/credit_entry',$result);
	}//function close

	//payment system
	public function credit_entry2()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Customermodel->get_cr_dr_master_with_id($id);
		}//strlen
		$this->load->view('customer/payment/credit_entry2',$result);
	}//function close

	//credit->list search
	public function credit_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			
			if(!empty($_REQUEST['search_from_history']) and $_REQUEST['search_from_history'] == "No"){
				
				//from mail table where payment_date is last payemnt date
				if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
				if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
				{
					$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
					$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
					$where.="  and A.payment_date between '$search_date1' and '$search_date2'  ";
				}
				$where.="  ORDER by A.payment_date ASC ";
				$result['res2'] = $this->Customermodel->get_all_credit_with_search($where);
				$this->load->view('customer/payment/credit_show_table',$result);
			}
			else{
				
				//from payment history table where paid_date is last payemnt date
				if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
				if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
				{
					$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
					$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
					$where.="  and B.paid_date between '$search_date1' and '$search_date2'  ";
				}
				$where.="  ORDER by B.paid_date ASC ";
				$result['res2'] = $this->Customermodel->get_all_credit_history_with_search($where);
				$this->load->view('customer/payment/credit_show_table2',$result);
			}
			
			
		}
		else
		{
			$search_date = date("Y-m-d");
			$where=" and A.payment_date = '$search_date'  ORDER by A.payment_date ASC ";
			$result['res2']=$this->Customermodel->get_all_credit_with_search($where);
			$this->load->view('customer/payment/credit_show',$result);
		}
	}//function close


	public function customer_credit_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		

		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}
		//if(isset($_REQUEST['credit_amount'])){$credit_amount=$_REQUEST['credit_amount'];}else{$credit_amount='';}
		//if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		//------------------row
		if(isset($_REQUEST['all_cr_dr_id'])){$all_cr_dr_id=explode('~',$_REQUEST['all_cr_dr_id']);$no_of_row=count($all_cr_dr_id);}else{$all_cr_dr_id='';$no_of_row=0;}
		if(isset($_REQUEST['all_paid_amount'])){$all_paid_amount=explode('~',$_REQUEST['all_paid_amount']);}else{$all_paid_amount='';}
		
		//no need to check
		/*
		//check
		if($no_of_row>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($all_paid_amount[$i]>0)
					{
						$edit_id = $all_cr_dr_id[$i];
						$paid_amt = $all_paid_amount[$i];
						$out3 = $this->Customermodel->get_cr_dr_master_with_id($edit_id);
						if(!empty($out3)){
							
							$bill_amt = $out3[0]['debit_amount'];
							$old_paid_amt = (float)$out3[0]['credit_amount'];
							$new_amt = ($old_paid_amt+$paid_amt);
							$new_balance = round($bill_amt -$new_amt);
							
							if($new_amt > $bill_amt){
								echo "In Invoice No : ".$out3[0]['invoice_no']." Total Amt is : $bill_amt, Already Paid: $old_paid_amt, Now paying $paid_amt, Total Paying $new_amt. is more than bill amt. ";
								exit;
							}

						}//empty
					}//if($all_paid_amount[$i]>0)
				}//for
			}//no
		*/
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			if($no_of_row>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($all_paid_amount[$i]>0)
					{
						$edit_id = $all_cr_dr_id[$i];
						$paid_amt = $all_paid_amount[$i];
						$out3 = $this->Customermodel->get_cr_dr_master_with_id($edit_id);
						if(!empty($out3)){
							$bill_amt = $out3[0]['debit_amount'];
							$old_paid_amt = (float)$out3[0]['credit_amount'];
							$new_amt = ($old_paid_amt+$paid_amt);
							$new_balance = round($bill_amt -$new_amt);
							
							//update
							$data=array(
								'payment_date'=>"$entry_date",
								'customer_id'=>"$customer_id",
								'credit_amount'=>"$new_amt",
								'rem_amount'=>"$new_balance",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
							$where = array('cr_dr_id'=>"$edit_id");   
							$this->Mymodel->update('cr_dr_master',$data,$where);


							//history
							$data5=array(
								'cr_dr_master_id'=>"$edit_id",
								'paid_date'=>"$entry_date",
								'paid_amt'=>"$paid_amt",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
							$cr_dr_paid_amt_history_id = $this->Mymodel->insertdata_withid('cr_dr_paid_amt_history',$data5);



						}//empty
					}//if($all_paid_amount[$i]>0)
				}//for
			}//no
				
				
			echo "Save";
		}//insert
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close


	public function customer_credit_save2()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$cr_dr_id=$_REQUEST['id'];}else{$cr_dr_id='';}
		if(isset($_REQUEST['payment_date'])){$payment_date=$this->Base->change_date_ymd($_REQUEST['payment_date']);}else{$payment_date='';}
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}
		if(isset($_REQUEST['credit_amount'])){$paid_amt=$_REQUEST['credit_amount'];}else{$paid_amt='';}
		
		

		//------------------------------------------------------------------update
		if(!empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
			$out3 = $this->Customermodel->get_cr_dr_master_with_id($cr_dr_id);
			
			//no need to stop
			if(!empty($out3)){
				
				$bill_amt = (float)$out3[0]['debit_amount'];
				$new_balance = round($bill_amt -$paid_amt);
				
				// if($paid_amt > $bill_amt){
				// 	echo "In Invoice No : ".$out3[0]['invoice_no']." Total Amt is : $bill_amt,Now paying $paid_amt, is more than bill amt. ";
				// 	exit;
				// }
			
				
			
				$data=array(
							'payment_date'=>"$payment_date",
							'customer_id'=>"$customer_id",
							'credit_amount'=>"$paid_amt",
							'rem_amount'=>"$new_balance",
							
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
				$where=array('cr_dr_id'=>"$cr_dr_id");   
				$this->Mymodel->update('cr_dr_master',$data,$where);


				//-------------------------delete
				$where9=array('cr_dr_master_id'=>"$cr_dr_id");   
				$this->Mymodel->deletedata('cr_dr_paid_amt_history',$where9);
				//-------------------------delete


				//history
				$data5=array(
					'cr_dr_master_id'=>"$cr_dr_id",
					'paid_date'=>"$payment_date",
					'paid_amt'=>"$paid_amt",
					
					'save_by'=>"$user_email",
					'save_date'=>"$today",
				);
				$cr_dr_paid_amt_history_id = $this->Mymodel->insertdata_withid('cr_dr_paid_amt_history',$data5);
			}//empty

				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close













	//---------------------------------------------credit & Debit
	//credit and debit->list search
	public function cr_dr_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			
			$where = "";
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by cname,A.entry_date ASC ";
			$result['res2'] = $this->Customermodel->get_all_cr_dr_with_search($where);
			$this->load->view('customer/payment/cr_dr_show_table',$result);
		}
		else
		{
			$search_date = date("Y-m-d");
			$where=" and A.entry_date = '$search_date'  ORDER by cname,A.entry_date ASC ";
			$result['res2']=$this->Customermodel->get_all_cr_dr_with_search($where);
			$this->load->view('customer/payment/cr_dr_show',$result);
		}
	}//function close


	public function cus_payment_flowup_list()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		$result['sales']=$this->Customermodel->get_all_sales_person_customer();
		
		
		if(isset($_REQUEST['search1']))
		{
			$today_date = date('Y-m-d');
			$where = "";
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}
			if(!empty($_REQUEST['search_color'])){ 
				$search_color = $_REQUEST['search_color'];
				
				if($search_color =='Red'){
					$where.=" and  (SELECT sum(A.rem_amount) as  rem_amount FROM cr_dr_master  
					WHERE  last_date < '$today_date' and customer_id = A.customer_id and  rem_amount > 0  
					GROUP BY customer_id) >0   "; 
				}
				elseif($search_color =='Orange'){
					$where.=" and  (SELECT sum(A.rem_amount) as  rem_amount FROM cr_dr_master  
					WHERE  notifi_date <= '$today_date' and last_date >= '$today_date'   and customer_id = A.customer_id and  rem_amount > 0  
					GROUP BY customer_id) >0   "; 
				}
				elseif($search_color =='Green'){
					$where.=" and  (SELECT sum(A.rem_amount) as  rem_amount FROM cr_dr_master  
					WHERE  notifi_date > '$today_date'   and customer_id = A.customer_id and  rem_amount > 0  
					GROUP BY customer_id) >0   "; 
				}
				
			}
			if(!empty($_REQUEST['search_sales']) )
			{
				$search_sales = $_REQUEST['search_sales'];
				$where.="  and C.sales_person = '$search_sales'   ";
			}

			if(!empty($_REQUEST['show_in_follow_up'])){
				$show_in_follow_up=$_REQUEST['show_in_follow_up'];
				if($show_in_follow_up == 'Yes'){
					$where.=" and  C.show_in_follow_up = 1   ";
				}else{
					$where.=" and  C.show_in_follow_up != 1   ";
				}
			}


			if(!empty($_REQUEST['search_date1']) )
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$where.="  and C.follow_up_date = '$search_date1'   ";
			}
			/*
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				//$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			*/
			$where.="   ";
			$result['res2'] = $this->Customermodel->get_cus_flowup_with_search($where);
			$this->load->view('customer/payment/flowup/show_table',$result);
			
		}
		else
		{
			$search_date = $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'-30'));
			//$where=" and A.entry_date = '$search_date'   ";
			$where=" and C.show_in_follow_up = 1  ";
			if(strlen($this->uri->segment(3))>0)
			{
				$search_date_url =  $this->uri->segment(3);
				$where.="  and C.follow_up_date <= '$search_date_url'   ";
			}
			$result['res2']=$this->Customermodel->get_cus_flowup_with_search($where);
			$this->load->view('customer/payment/flowup/show',$result);
		}
	}//function close



	public function cus_payment_flowup_list2()
	{
		$result['cus']=$this->Customermodel->get_all_active_customer();
		
		if(isset($_REQUEST['search1']))
		{
			$today_date = date('Y-m-d');
			$where = "";
			if(!empty($_REQUEST['search_customer'])){$search_customer=$_REQUEST['search_customer'];$where.=" and  A.customer_id='$search_customer'   ";}else{$search_customer="ALL";}
			
			
			if(!empty($_REQUEST['search_date1']) )
			{
				$fdate = $this->Base->change_date_ymd($_REQUEST['search_date1']);
			}else{$fdate =  date('Y-m-d');}

			if(!empty($_REQUEST['search_date2']) )
			{
				$tdate = $this->Base->change_date_ymd($_REQUEST['search_date2']);
			}else{$tdate =  date('Y-m-t');}
			
			
			$result['fdate'] = $fdate;
			$result['tdate'] = $tdate;
			$result['res2']['orange'] = $this->Customermodel->get_orange_payment_groupby_date($fdate,$tdate,$search_customer,'A.notifi_date');
			$result['res2']['red'] = $this->Customermodel->get_red_payment_groupby_date($fdate,$tdate,$search_customer,'A.last_date');
			$result['search_customer_id'] = $search_customer;
			//total rem amount of this month
			$result['res2']['total_red']  = $this->Customermodel->get_red_payment_groupby_date($fdate,$tdate,$search_customer,'NO');
			
			
			//last month
			$fdate_last = $this->Base->get_last_month_first_ymd($fdate); $result['fdate_last'] = $fdate_last;
			$tdate_last = $this->Base->get_last_month_last_ymd($fdate); $result['tdate_last'] = $tdate_last;
			//total rem amount of last month
			$result['res2']['total_red_last']  = $this->Customermodel->get_red_payment_groupby_date($fdate_last,$tdate_last,$search_customer,'NO');
			$this->load->view('customer/payment/flowup/show_table2',$result);
			
		}
		else
		{
			$fdate =  date('Y-m-01');$result['fdate'] = $fdate;
			$tdate =  date('Y-m-t');$result['tdate'] = $tdate;
			
			$result['res2']['orange'] = $this->Customermodel->get_orange_payment_groupby_date($fdate,$tdate,"ALL",'A.notifi_date');
			$result['res2']['red'] = $this->Customermodel->get_red_payment_groupby_date($fdate,$tdate,"ALL",'A.last_date');
			$result['search_customer_id'] = "ALL";
			//total rem amount of this month
			$result['res2']['total_red']  = $this->Customermodel->get_red_payment_groupby_date($fdate,$tdate,"ALL",'NO');
			
			//last month
			$fdate_last = $this->Base->get_last_month_first_ymd($fdate); $result['fdate_last'] = $fdate_last;
			$tdate_last = $this->Base->get_last_month_last_ymd($fdate); $result['tdate_last'] = $tdate_last;
			//total rem amount of last month
			$result['res2']['total_red_last']  = $this->Customermodel->get_red_payment_groupby_date($fdate_last,$tdate_last,"ALL",'NO');

			$this->load->view('customer/payment/flowup/show2',$result);
		}
	}//function close








	//payment receive from customer entry
	function fun_get_payment_entry_block_details()
	{
		$today = date("Y-m-d");
		$today_date = $this->Base->change_date_dmy($today);
		if(isset($_REQUEST['customer_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			//payment history
			$where=" and A.customer_id = '$customer_id'  ORDER by A.entry_date,invoice_no ASC ";
			$out2 = $this->Customermodel->get_rem_payment_history_search($where);
			//print_r($out2);
			?>
				<table>
					<tr>
						<th>#</th>
						<th>Invoice Date</th>
						<th>Invoice No.</th>
						<th>Amount (Rs.)</th>
						<th>Paid Amount (Rs.)</th>
						<th>Rem. Amount (Rs.)</th>
						<th>Receive Amount (Rs.)</th>
						<th>Balance (Rs.)</th>
					</tr>
					<?php 
						$i=1;
						foreach($out2 as $r)
						{
							//if($r['rem_amount'] >0){
							if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
							?>
								<tr>
									<td>
										<?php echo $i;?>
										<input type="hidden" class="form-control all_cr_dr_id" readonly   id="crdrid_<?php echo $r['cr_dr_id'];?>" value="<?php echo $r['cr_dr_id'];?>"  autocomplete="off" >
									</td>
									<td><input type="text" class="form-control" readonly   id="invoicedate_<?php echo $r['cr_dr_id'];?>" value="<?php echo $entry_date;?>"  autocomplete="off" ></td>
									<td><input type="text" class="form-control" readonly   id="invoicenoid_<?php echo $r['cr_dr_id'];?>" value="<?php echo $r['invoice_no'];?>"  autocomplete="off" ></td>
									<td><input type="text" class="form-control" readonly   id="amountid_<?php echo $r['cr_dr_id'];?>" value="<?php echo $r['debit_amount'];?>"  autocomplete="off" ></td>
									<td><input type="text" class="form-control" readonly   id="paidamountid_<?php echo $r['cr_dr_id'];?>" value="<?php echo $r['credit_amount'];?>"  autocomplete="off" ></td>
									<td><input type="text" class="form-control" readonly   id="recamount_id_<?php echo $r['cr_dr_id'];?>" value="<?php echo $r['rem_amount'];?>"  autocomplete="off" ></td>
									
									
									<td><input type="number" class="form-control all_paid_amount"   id="creditamount_<?php echo $r['cr_dr_id'];?>"  autocomplete="off" onkeyup="get_row_balance_amt(this.id,this.value)"></td>
									<td><input type="number" class="form-control all_balance_amount"   id="balanceamount_<?php echo $r['cr_dr_id'];?>"  autocomplete="off" ></td>
								</tr>
							<?php 
							$i++;	
							//}
						
						}
					
						?>
				</table>
				<br>
				<h5>Total Amount (Rs.) : <span style="color:blue" id="total_row_amt_display"></span> </h5>
				
			<?php
		}else{
			echo "No customer id found";
			exit;
		}
	}//function close








	function fun_get_cust_details()
	{
		$today = date("Y-m-d");
		$date2 = $this->Base->change_date_dmy($today);
		if(isset($_REQUEST['customer_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$all_value = explode("~",$_REQUEST['all_value']);
			$limit_days = $all_value[0];
			$limit_amt = $all_value[1];
			$redzone_amt = $all_value[2];
			$orangezone_amt = $all_value[3];
			$greenzone_amt = $all_value[4];
			$zone_total = $all_value[5];
			$limit_text = $all_value[6];
			$limit_balance = round($limit_amt - $zone_total);
			if($limit_balance > 0){ $limit_text = $this->Base->money($limit_balance); $limit_color="green";}else{$limit_text = "Limit already exceeded"; $limit_color="red";}
			

			//customer details
			$cdet = $this->Customermodel->get_customer_with_id($customer_id);
			if(!empty($cdet[0]['follow_up_date']) and $cdet[0]['follow_up_date'] != '0000-00-00'){$follow_up_date = $this->Base->change_date_dmy($cdet[0]['follow_up_date']);}else{$follow_up_date='';}
			
			
		
			?>

				<div class="modal-content">
					<div class="modal-header">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item"><a class="nav-link active" id="tab1-basic-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="true">Follow-up</a></li>
								<li class="nav-item"><a class="nav-link" id="tab2-basic-tab" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="false">Follow-up History</a></li>
								<li class="nav-item"><a class="nav-link" id="tab3-basic-tab" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="false">Payment History</a></li>
								<li class="nav-item"><a class="nav-link" id="tab4-basic-tab" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="false">Dispute History</a></li>
								<li class="nav-item"><a class="nav-link" id="tab5-basic-tab" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="false">Cheque List</a></li>
								<li class="nav-item"><a class="nav-link" id="tab6-basic-tab" data-toggle="tab" href="#tab6" role="tab" aria-controls="tab6" aria-selected="false">Complaint List</a></li>
							</ul>
					</div>
					<div class="modal-body">
						
					<?php //---------------TAB------ ?>

						
						<div class="tab-content" id="myTabContent" >
							<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-basic-tab" style="background-color:white;">
									
										
								<div class="card-body" style="border-radius: 10px; background-color:#f0f4f5; ">
									<h5 class="card-title">Customer : <?php echo $cdet[0]['name'];?></h5>
									<p class="card-text">
										Address : <?php echo $cdet[0]['address'].', '.$cdet[0]['city'].', '.$cdet[0]['state'];?>
										<br>
										<span style="color:blue">Sales Person Name : <?php echo $cdet[0]['sales_person'];?></span>
										<br>
										<?php if(!empty($cdet[0]['telphone']))echo "Tele : ".$cdet[0]['telphone'];?>, 
										<?php if(!empty($cdet[0]['email']))echo "Email : ".$cdet[0]['email'];?>  
										<br>
										Contact Person 1: <?php if(!empty($cdet[0]['con_name1'])){echo $person1 = $cdet[0]['con_name1'];}else{ $person1 = "";}?>, 
										 <?php if(!empty($cdet[0]['con_mob1']))echo "Mob : ".$cdet[0]['con_mob1'];$mob1=$cdet[0]['con_mob1'];?>, 
										 <?php if(!empty($cdet[0]['con_email1']))echo "Email : ".$cdet[0]['con_email1'];?> 
										 <br>
										 Contact Person 2: <?php if(!empty($cdet[0]['con_name2'])){echo $person2 = $cdet[0]['con_name2'];}else{ $person2 = "";}?>, 
										 <?php if(!empty($cdet[0]['con_mob2']))echo "Mob : ".$cdet[0]['con_mob2'];$mob2=$cdet[0]['con_mob2'];?>, 
										 <?php if(!empty($cdet[0]['con_email2']))echo "Email : ".$cdet[0]['con_email2'];?> 
									</p>
								</div>

							 

								<div class="row" style=" margin-top:20px;  ">
									<div class="col-md-12">
										<div class="card mb-4">
											<div class="card-body">
													<div class="row">
														
														<div class="col-md-12 form-group mb-3">
															<label> <span style="color:blue">Date Given :</span> <span style="color:red"> <?php  echo $follow_up_date;?> </span></label><br>
															<label> <span style="color:blue">Status :</span> <span style="color:">  <?php echo $cdet[0]['follow_up_last_status'];?> </span></label><br>
															<label> <span style="color:blue">Comment's :</span> <span style="color:"> <?php echo $cdet[0]['follow_up_comments'];?> </span></label><br>
														</div>

														<div class="col-md-12 form-group mb-3">
															<p>Current Status</P>
															<table class="table-hover" border=1 width="100%" style="font-size:12px" >
																<thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
																	<tr>
																		<th>Day's Limit</th>
																		<th>Amount Limit</th>
																		<th>Red Zone</th>
																		<th>Orange Zone</th>
																		<th>Green Zone</th>
																		<th>Total Rem. Payment</th>
																		<th>Limit Balance</th>
																	</tr>
																</thead>
																<tbody>
																	<tr >
																		<th><?php  if(!empty($limit_days))echo $limit_days;?></th>
																		<th><?php  if($limit_amt >0){echo  $this->Base->money($limit_amt);}?></th>
																		
																		<td style="color:red;font-weight:bold"><?php if($redzone_amt >= 0){  echo  $this->Base->money($redzone_amt);}?></td>
																		<td style="color:orange;font-weight:bold"><?php if($orangezone_amt >0 ){ echo  $this->Base->money($orangezone_amt);}?></td>
																		<td style="color:green;font-weight:bold"><?php if($greenzone_amt >0 ){ echo  $this->Base->money($greenzone_amt);}?></td>
																		<td style="font-weight:bold"><?php if($zone_total >0 ){echo  $this->Base->money($zone_total);}?></td>
																		<th style="color:<?php echo $limit_color;?>;font-weight:bold"><?php  echo $limit_text; ?></th>
						
					

																	</tr>
																</tbody>
															</table>
														</div>

														<div class="col-md-12 form-group mb-3">
															<?php 
															//rem payment in red color
															$filter = array("red rem amt");
															$total_rem_amount_here = $this->Customermodel->get_payment_history_with_table($customer_id,$filter);

															$diff_bt_two_red_amt = round($redzone_amt - $total_rem_amount_here);
															if($diff_bt_two_red_amt > 3){
																?>
																<h1 style="color:red;">Total of both Red Amount are not equal. So please check and don't send any mail to this party.</h1>
																<?php
															}
															?>
															
														</div>

														
														<input   id="follow_up_customer_id" type="hidden" value="<?php echo $customer_id;?>" />
														<input   id="follow_up_last_status" type="hidden" value="<?php echo "Red zone amount : $redzone_amt, Orange zone amt : $orangezone_amt, Green zone amt : $greenzone_amt, Total Rem Amount :$zone_total and your Limit status is : $limit_text ";?>" />
														
														
														
														<div class="col-md-12 form-group mb-3">
															<label for="lastName1">Comments</label>
															<textarea class="form-control" id="current_cumments"></textarea>
														</div>

														<div class="col-md-12 form-group mb-3">
															<label>Next Follow up Date</label>
															<input class="form-control"  id="next_follow_up_date" type="date" autocomplete="off" />
														</div>


														<div class="col-md-12" style="margin-bottom:30px">
															<p id="final_msg" style="color:green;font-weight:bold"></p>
															<button class="btn btn-primary" id="follow_up_save">Save Follow Up</button>
															<hr>
														</div>

														
														<?php 
															//what's massage 1
															$subject = "Subject:  Reminder for overdue payment release 🚨.";
															$wa = $subject."%0a %0a I trust this message finds you well. I am writing to follow up on the outstanding payment as of, the payment is now overdue. I kindly request your immediate attention to this matter and expedite processing of the payment.%0a%0a Attached, Please find the invoice details for your reference.%0a";


															$filter = array("red rem amt","return ans");
															$list = $this->Customermodel->get_payment_history_with_table($customer_id,$filter);
															//print_r($list);
															$last_date = ""; $invoice_no = ""; $rem_amount = "";
															$k=1;
															$sum_amt = 0;
															$today_date = date('Y-m-d');
															$interest_arr = array();
															foreach($list as $l){
																if(isset($l['last_date'])){
																	$last_date=$this->Base->change_date_dmy($l['last_date']);
																	$overDays = $this->Base->get_diff_no_bw_two_days($l['last_date'],$today_date);
																}else{$last_date='';}
																
																$invoice_no = $l['invoice_no'];
																$rem_amount = $this->Base->money($l['rem_amount']);
																
																//interest amt
																if(!empty($l['rem_amount']) and $l['rem_amount'] > 1 and $overDays > 0){
																	$interest_arr[] = $int_amt = round(((((float)$l['rem_amount']*24)/100)/365)*(float)$overDays);
																	$int_amt_final =  $this->Base->money($int_amt);
																}

																$wa .= "%0a $k. Invoice No: $invoice_no, Amount: $rem_amount/-, Due-Date: $last_date.";
																$sum_amt = $sum_amt + $l['rem_amount'];
																$k++;
															}
															if(!empty($interest_arr)){ $total_interest_amt = $this->Base->money(round(array_sum($interest_arr),2));}else{$total_interest_amt='';}
															$sum_amt2 = $this->Base->money($sum_amt);
															$wa .= "%0a%0a🔔 Total Amount: $sum_amt2/- 🔔 %0a%0a  Interest Amount: $total_interest_amt/- %0a%0a Important note: Kindly release the payment immediately otherwise you have to bear the interest @24% p.a. as mentioned. %0a%0a Please Note: Its a humble request that we do not accept payment through cheques, only through RTGS and NEFT payments are accepted. %0a%0a If there are any issues or concerns on your end, please let us know at your earliest convenience so that we can work together to address them.%0a%0a

															
															As per government guidelines of MSME, the payment is to be released within 15 days, if terms are not agreed, and maximum 45 days if the terms are agreed. Otherwise if the payment is not done in these manner, the overdue amount will be considered as income and will also attract income tax, interest and penalty etc.
															%0a%0a
															
															Thank You for your attention to this matter and we look forward to a swift resolution.%0a%0aBest Regard,%0aRKS Steel Industries Pvt. Ltd.";


															
															//what's massage 2
															$subject2 = "Subject: Reminder for upcoming payment is due in the coming week   🚨.";
															$wa2 = $subject2."%0a %0a  I trust this email find you well. I am writing to provide you with a friendly reminder that the upcoming payment is due in the coming week.%0a%0a We greatly appreciate your promptness in setting your accounts and this Pre intimation is intended to ensure you have ample of time to make the necessary arrangements.%0a";


															$filter2 = array("orange rem amt","return ans");
															$list2 = $this->Customermodel->get_payment_history_with_table($customer_id,$filter2);
															//print_r($list);
															$last_date = ""; $invoice_no = ""; $rem_amount = "";
															$k=1;
															$sum_amt_2 = 0;
															
															foreach($list2 as $l){
																if(isset($l['last_date'])){$last_date=$this->Base->change_date_dmy($l['last_date']);}else{$last_date='';}

																$invoice_no = $l['invoice_no'];
																$rem_amount = $this->Base->money($l['rem_amount']);
																
																$wa2 .= "%0a $k. Invoice No: $invoice_no, Amount: $rem_amount/-, Due-Date: $last_date.";
																$sum_amt_2 = $sum_amt_2 + $l['rem_amount'];
																$k++;
															}
															

															$sum_amt2 = $this->Base->money($sum_amt_2);
															$wa2 .= "%0a%0a🔔 Total Amount: $sum_amt2/- 🔔 %0a%0a Please Note: Its a humble request that we do not accept payment through cheques, only through RTGS and NEFT payments are accepted. %0a%0a We encourage you to review the attached statement of account for your reference, which outline the details of the upcoming payment.%0a%0a 
															
															As per government guidelines of MSME, the payment is to be released within 15 days, if terms are not agreed, and maximum 45 days if the terms are agreed. Otherwise if the payment is not done in these manner, the overdue amount will be considered as income and will also attract income tax, interest and penalty etc.
															%0a%0a
															
															if you have any concerns regarding the invoice or Payment procedure, please do not hesitate to reach out to us.%0a%0aThank You for your attention to this matter.%0a%0aBest Regard,%0aRKS Steel Industries Pvt. Ltd.";

															
															//geting CC and BCC mail details 
															$out = $this->Company->mail_details();
															if(!empty($out[0]['details7'])){$cc_mail = $out[0]['details7'];}else{$cc_mail = '';} 
															if(!empty($out[0]['details8'])){$bcc_mail = $out[0]['details8'];}else{$bcc_mail = '';} 
														?>
														
														<div class="col-md-12"  >
															To : <?php if(!empty($cdet[0]['email']))echo $cdet[0]['email']?>
														</div>
														
														<div class="col-md-4">
															<label>Select Mail</label>
															<select class="form-control" id="search_mail_type_single">
																<option  value="">No Mail</option>
																<option  value="1">Red Mail</option>
																<option  value="2">Upcoming</option>
																<option  value="">Mail Type 3</option>
															</select>
														</div>
														
														<div class="col-md-8">
															<input type="hidden" id="part_email" value="<?php if(!empty($cdet[0]['email']))echo $cdet[0]['email']?>">
															<button  onClick="fun_export_pdf()" class="btn btn-warning" style=" margin-top:25px;">Save As PDF</button>
															<?php 
																if(!empty($cdet[0]['email'])){
																	$mailto = $cdet[0]['email'];
																	?>
																		<a  class="btn btn-primary"  style=" margin-top:25px;"
																			href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=test &body=hello">
																			📧 Attch. & Mail
																		</a>
																	<?php 
																}
															?>
															<input type="button" id="cus_send_mail_single"   class="btn btn-info"  style=" margin-top:25px; margin-left:100px" value="Direct Mail" >
														</div>
														
														

														<div class="col-md-12" style="margin-top:30px">
															
															<?php 
																//----------------------Wa 1
																$both_red_diff =  $sum_amt - $redzone_amt;
																if($both_red_diff > -3 && $both_red_diff < 3)
																{
																	
																	echo "<hr>";
																	echo "<h6>Send Red message through What's App</h6>";
																	
																	if(!empty($mob1)){
																		/*
																			<a target="_blank" class="btn btn-success m-1" href="https://wa.me/<?php echo $mob1;?>?text=<?php echo $wa;?>">What's app on Mobile 1</a>
																		*/
																		?>
																			<a target="_blank" class="btn btn-danger m-1" href="https://api.whatsapp.com/send?phone=<?php echo $mob1;?>&text=<?php echo $wa;?>">💭<?php echo $mob1. ", ".$person1;?></a>
																		<?php 
																	}

																	if(!empty($mob2)){
																		?>
																			<a target="_blank" class="btn btn-danger m-1" href="https://api.whatsapp.com/send?phone=<?php echo $mob2;?>&text=<?php echo $wa;?>">💭<?php echo $mob2. ", ".$person2;?></a>
																		<?php 
																	}

																	if(!empty($cdet[0]['email'])){
																		$mailto = $cdet[0]['email'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject;?> &body=<?php echo $wa?>">
																				📧 <?php echo $mailto;?>
																			</a>
																		<?php 
																	}

																	if(!empty($cdet[0]['con_email1'])){
																		$mailto = $cdet[0]['con_email1'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject;?> &body=<?php echo $wa?>">
																				📧 <?php echo $mailto. ", ".$person1;?>
																			</a>
																		<?php 
																	}

																	if(!empty($cdet[0]['con_email2'])){
																		$mailto = $cdet[0]['con_email2'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject;?> &body=<?php echo $wa?>">
																				📧 <?php echo $mailto. ", ".$person2;?>
																			</a>
																		<?php 
																	}
																}//both_red_diff
																else{
																	echo "<h1>Red amount not matching</h1>";
																}

																//----------------------Wa 2
																$both_orange_diff =  $sum_amt_2 - $orangezone_amt;
																if($both_orange_diff > -3 && $both_orange_diff < 3)
																{
																	echo "<hr>";
																	echo "<h6>Send Orange message through What's App </h6>";
																	
																	if(!empty($mob1)){
																		?>
																			<a target="_blank" class="btn btn-warning m-1" href="https://api.whatsapp.com/send?phone=<?php echo $mob1;?>&text=<?php echo $wa2;?>">💭<?php echo $mob1. ", ".$person1;?></a>
																		<?php 
																	}

																	if(!empty($mob2)){
																		?>
																			<a target="_blank" class="btn btn-warning m-1" href="https://api.whatsapp.com/send?phone=<?php echo $mob2;?>&text=<?php echo $wa2;?>">💭<?php echo $mob2. ", ".$person2;?></a>
																		<?php 
																	}

																	if(!empty($cdet[0]['email'])){
																		$mailto = $cdet[0]['email'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject2;?> &body=<?php echo $wa2?>">
																				📧 <?php echo $mailto;?>
																			</a>
																		<?php 
																	}

																	if(!empty($cdet[0]['con_email1'])){
																		$mailto = $cdet[0]['con_email1'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject2;?> &body=<?php echo $wa2?>">
																				📧 <?php echo $mailto. ", ".$person1;?>
																			</a>
																		<?php 
																	}

																	if(!empty($cdet[0]['con_email2'])){
																		$mailto = $cdet[0]['con_email2'];
																		?>
																			<a class="btn btn-info m-1"
																				href="mailto:<?php echo $mailto;?>?cc=<?php echo $cc_mail;?> &bcc=<?php echo $bcc_mail;?> &subject=<?php echo $subject2;?> &body=<?php echo $wa2?>">
																				📧 <?php echo $mailto. ", ".$person2;?>
																			</a>
																		<?php 
																	}
																}//both_orange_diff
																else{
																	echo "<h1>Orange amount not matching</h1>";
																}

															?>
														</div>


														<script>
															//export as pdf
															function fun_export_pdf()
															{
																let  search_mail_type_single=$('#search_mail_type_single').val();
																let url;
																if(search_mail_type_single == 1){
																	url = "<?php echo base_url()."index.php/Welcome/mail_type_1_body?customer_id=$customer_id";?>"
																}
																else{
																	url = "<?php echo base_url()."index.php/Welcome/mail_type_2_body?customer_id=$customer_id";?>"
																}
																
																if(search_mail_type_single){

																	setTimeout(function() {
																		jQuery.post(url, 
																		{
																			search1:1,
																		}, 
																		function(data, textStatus)
																		{	
																			newWin= window.open("");
																			newWin.document.write(data);
																			newWin.print('hello');
																			newWin.close();
																		});
																	});//loader
																}
																else{
																	fun_message('warning','Warning','Select Mail Type','toast-bottom-right');
																}
															}//function close
													
															//-----------------------------------------------search
																$('#cus_send_mail_single').click(function(){
																	var search_mail_type_single=$('#search_mail_type_single').val();
																	var part_email = $('#part_email').val();if(part_email==''){fun_message('warning','Warning','Main Email ID not Found.','toast-bottom-right');return false;}
																	
																	$('#cus_send_mail_single').hide();setTimeout(()=>{$('#cus_send_mail_single').show();},3000)
																	
																	setTimeout(function() {
																		jQuery.post("<?php echo base_url().'index.php/Customer/cus_send_mail_single';?>", 
																		{
																			search1:1,
																			search_mail_type_single:search_mail_type_single,
																			part_email:part_email,
																			customer_id:<?php echo $customer_id;?>,
																		}, 
																		function(data, textStatus)
																		{	
																			//alert(data);
																			
																			if(data=='Save'){
																				fun_message('success',data,'Send Successfully','toast-bottom-right');
																				//showPage(url);
																			}
																			else{
																				fun_message('error','Error',data,'toast-bottom-right');
																			}
															
																			//$('.loader').hide();
																			
																		});
																	});//loader
																	
																});//search close
														</script>

														
														


													</div>
												
											</div>
										</div>
									</div>
								</div>
								
								<script>
									$(function () {
										//$( "#next_follow_up_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
									});

									$(document).ready(function(e) {
										$('#follow_up_save').click(function(){
												
												var url=$('#url').val();
												var follow_up_customer_id =$('#follow_up_customer_id').val();
												var follow_up_last_status =$('#follow_up_last_status').val();
												

												var next_follow_up_date = $('#next_follow_up_date').val();if(next_follow_up_date==''){$('#next_follow_up_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}

												var current_cumments = $('#current_cumments').val();if(current_cumments==''){$('#current_cumments').focus();fun_message('warning','Warning','Enter Current Cumments','toast-bottom-right');return false;}
												
												<?php 
													/*
													url : index.php/Customer/customer_cr_dr_follow_up_save					
													
													date: 
													follow_up_customer_id:follow_up_customer_id,
													follow_up_last_status:follow_up_last_status,
													next_follow_up_date:next_follow_up_date,
													current_cumments:current_cumments,

													*/
												?>
												let repeat_status = "Daily";
												let status = "Pending";
												let priority = "Medium";
												let show_to = "Everyone";
												let location = "Customer";

												//-------------------------------save
												$('#wait').show();
												$('#follow_up_save').hide();
												setTimeout(function() {
														jQuery.post("<?php echo base_url().'index.php/Maintenance/reminder_save';?>", 
																{
																	task:current_cumments,
																	event_date:next_follow_up_date,
																	repeat_status:repeat_status,
																	status:status,
																	priority:priority,
																	show_to:show_to,
																	location:location,
																	customer_id:follow_up_customer_id,
																}, 
																function(data, textStatus)
																{	
																	//alert(data);
																	if(data=='Save')
																	{
																		fun_message('success',data,'Save Successfully','toast-bottom-right');
																		//showPage(url);
																		$('#next_follow_up_date').val('');
																		$('#current_cumments').val('');
																		$('#final_msg').html("Saved");
																	}
																	else if(data=='Update')
																	{
																		fun_message('success',data,'Updated Successfully','toast-bottom-right');
																		showPage(url);
																	}
																	else
																	{
																		fun_message('error','Error',data,'toast-bottom-right');
																	}
																	$('#wait').hide();
																	$('#follow_up_save').show();
																	
																});
														
																
													});
											});//-------------------------------save
									});
 								</script>
										
									




							</div><!-- tab 1 end -->
							<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-basic-tab" style="background-color:white;">
								<h5 align="center">Follow Up History</h5>	
									<table class="table-hover" border=1 width="100%"  >
										<tr>
											<th>#</th>
											<th>Calling Date</th>
											<th>Comments</th>
											<th>Next Follow Up Date</th>
										</tr>
										<?php 
											//followup history
											//old data from follow up table
											//$where=" and A.customer_id = '$customer_id'  ORDER by A.entry_date ASC ";
											//$out2 = $this->Customermodel->get_follow_up_his_search($where);
											
											//new data from reminder table
											$where=" and A.customer_id = '$customer_id'  ORDER by A.event_date ASC ";
											$out2 = $this->Maintenancemodel->get_all_reminder_with_search($where);
											
											
											$i=1;
											foreach($out2 as $r)
											{
												if(isset($r['event_date'])){$event_date=$this->Base->change_date_dmy($r['event_date']);}else{$event_date='';}
												if(isset($r['next_event_date'])){$next_event_date=$this->Base->change_date_dmy($r['next_event_date']);}else{$next_event_date='';}
												?>
												<tr>
													<td><?php echo $i;?></td>
													<td><?php if(isset($event_date))echo $event_date;?></td>
													<td><?php if(isset($r['task']))echo $r['task'];?></td>
													<td><?php if(isset($next_event_date))echo $next_event_date;?></td>
												<tr>
												<?php
												$i++; 
											}
										?>
									</table>
								
							</div><!-- tab 2 end -->
							<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-basic-tab" style="background-color:white; overflow:auto">
								
								<?php 
								//all payment history invoice wise 
								$filter = array("All Invoices");
								$this->Customermodel->get_payment_history_with_table($customer_id,$filter);
								?>

								<br>
								<br>
								<br>

								<?php 
									$fdate = $this->Base->add_no_of_days_in_date_ymd(date('Y-m-d'),'-90');
									//$fdate = date("Y-m-d");
									$tdate = date("Y-m-d");
									$where=" and A.customer_id = '$customer_id' and A.payment_date between '$fdate' and '$tdate' GROUP BY A.payment_date  ORDER by A.payment_date ASC ";
									$res2=$this->Customermodel->get_all_credit_with_search2($where);
									//$this->load->view('customer/payment/credit_show',$result);
								?>

								<h5 align="center">Payment Received (Last 90 Day's)</h5>	
								<div class="table-responsive">
									<table class="table-hover" border=1 width="100%" style="font-size:12px" >
										<tr>
											<th>#</th>
											<th>Payment Date</th>
											<th>Paid Amount (Rs.)</th>
										</tr>
										<tbody>
										<?php 
											$i=1;
											$credit_amt = array();
											foreach($res2 as $r)
											{
												if(isset($r['payment_date'])){$payment_date=$this->Base->change_date_dmy($r['payment_date']);}else{$payment_date='';}
												?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php if(isset($payment_date))echo $payment_date;?></td>
														<td><?php if(isset($r['credit_amount'])) $credit_amt[] = round($r['credit_amount'],2); echo  $this->Base->money($r['credit_amount']);?></td>
													<tr>
												<?php
												$i++; 
											}
										?>
										</tbody>
											<tr style="font-weight:bold">
												<td></td>
												<td>Total Received</td>
												<td><?php if(!empty($credit_amt)){$a = round(array_sum($credit_amt),2);  echo  $this->Base->money($a);}?></td>
											<tr>
									</table>
									</div>
								
								

							</div><!-- tab 3 end -->
							<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-basic-tab" style="background-color:white; overflow:auto">
								
								<?php 
									//$search_date1=date('Y-m-01');
									//$search_date2=date('Y-m-d');
									//$where =" and A.complain_date between '$search_date1' and '$search_date2' ORDER by A.complain_date ASC ";
									$where =" and A.customer_name = '$customer_id' and A.type='Dispute' and A.status != 'Resolved' ORDER by A.complain_date ASC ";
									$res2=$this->Customermodel->get_all_cust_comp_with_search($where);
									//print_r($res2);
								?>

								<h5 align="center">Dispute List</h5>	
								<div class="table-responsive">
									<table class="table-hover" border=1 width="100%" style="font-size:12px" >
										<tr>
											<th>#</th>
											<th>Dispute Date</th>
											<th>Qty</th>
											<th>Amount (Rs.)</th>
											<th>Unit</th>
											<th>No of Coils</th>
											<th>Priority</th>
											<th>Status</th>
										</tr>
										<tbody>
										<?php 
											$i=1;
											$dis_total_amt = array();
											foreach($res2 as $r)
											{
												if(isset($r['complain_date'])){$complain_date=$this->Base->change_date_dmy($r['complain_date']);}else{$complain_date='';}
											?>
											<tr>
												<td><?php echo $i;?>.</td>	
												<td><?php echo $complain_date;?></td>
												<td><?php if(isset($r['defect_qty']))echo $r['defect_qty'];?></td>
												<td><?php if(!empty($r['defect_amount'])) $dis_total_amt[] = round($r['defect_amount'],2); echo  $this->Base->money($r['defect_amount']);?></td>
												<td><?php if(isset($r['defect_unit']))echo $r['defect_unit'];?></td>
												<td><?php if(isset($r['defect_bobbin']))echo $r['defect_bobbin'];?></td>
												<td><?php if(isset($r['priority']))echo $r['priority'];?></td>
												<td><?php if(isset($r['status']))echo $r['status'];?></td>
											<tr>
											<?php
											$i++; 
										}
										?>
										</tbody>
											<tr style="font-weight:bold">
												<td></td>
												<td>Total</td>
												<td></td>
												<td><?php if(!empty($dis_total_amt)){$a = round(array_sum($dis_total_amt),2);  echo  $this->Base->money($a);}?></td>
											<tr>
									</table>
								</div>
								

							</div><!-- tab 4 end -->

							<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-basic-tab" style="background-color:white; overflow:auto">
								
								<?php 
									//----------------------------------------Same as coustomer->payment->cheque->show_table
									//$search_date1 = date("Y-m-01");
									//$search_date2 = date("Y-m-d");
									$where=" and A.customer_id = '$customer_id'  ORDER by A.receive_date ASC ";
									$res2=$this->Customermodel->get_all_cr_advance_cheque_with_search($where);
									//print_r($res2);
								?>

								<h5 align="center">Cheque List</h5>	
								<div class="table-responsive">
									<table class="table-hover" border=1 width="100%" style="font-size:12px" >
										<tr>
											<th>#</th>
											<th>Customer Name</th>
											<th>Receive Date</th>
											<th>Bank name</th>
											<th>Account No.</th>
											<th>IFSC Code</th>
											<th>Address</th>
											<th>Cheque No.</th>
											<th>Authorized Person</th>
											
											<th>Amount Status</th>
											<th>Amount (Rs.)</th>
											<th>Expiry Date</th>
											<th>Remarks</th>
										</tr>
										<tbody>
										<?php 
											$i=1;
											$cheque_amount = array();
											foreach($res2 as $r)
											{
												if(isset($r['receive_date'])){$receive_date=$this->Base->change_date_dmy($r['receive_date']);}else{$receive_date='';}
												if(isset($r['expiry_date']) and $r['expiry_date'] != '0000-00-00'){$expiry_date=$this->Base->change_date_dmy($r['expiry_date']);}else{$expiry_date='';}
												?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php if(isset($r['cname']))echo $r['cname'];?></td>
														<td><?php if(isset($receive_date))echo $receive_date;?></td>
														<td><?php if(isset($r['bank_name']))echo $r['bank_name'];?></td>
														<td><?php if(isset($r['account_no']))echo $r['account_no'];?></td>
														<td><?php if(isset($r['ifsc_code']))echo $r['ifsc_code'];?></td>
														<td><?php if(isset($r['bank_address']))echo $r['bank_address'];?></td>
														
														<td><?php if(isset($r['cheque_no']))echo $r['cheque_no'];?></td>
														<td><?php if(isset($r['authorized_person']))echo $r['authorized_person'];?></td>
														
														<td><?php if(isset($r['amount_status']))echo $r['amount_status'];?></td>
														

														<td><?php if(isset($r['cheque_amount']) and $r['cheque_amount']>0){ $cheque_amount[] = round($r['cheque_amount']); echo  $this->Base->money($r['cheque_amount']);}?></td>
														<td><?php if(isset($expiry_date))echo $expiry_date;?></td>
														<td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
													<tr>
												<?php
											$i++; 
										}
										?>
										</tbody>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>Total</td>
											<td><?php if(!empty($cheque_amount)){$a = round(array_sum($cheque_amount),2); echo  $this->Base->money($a);}?></td>
											<td></td>
											<td></td>
											
										<tr>
									</table>
								</div>
								
								

							</div><!-- tab 5 end -->

							<div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab5-basic-tab" style="background-color:white; overflow:auto">
								
								<?php 
									//$search_date1=date('Y-m-01');
									//$search_date2=date('Y-m-d');
									//$where =" and A.complain_date between '$search_date1' and '$search_date2' ORDER by A.complain_date ASC ";
									$where =" and A.customer_name = '$customer_id' and A.type='Complaint' ORDER by A.complain_date ASC ";
									$res2=$this->Customermodel->get_all_cust_comp_with_search($where);
									//print_r($res2);
								?>

								<h5 align="center">Complaint List</h5>	
								<div class="table-responsive">
									<table class="table-hover" border=1 width="100%" style="font-size:12px" >
										<tr>
											<th>#</th>
											<th>Complain Date</th>
											<th>Qty</th>
											<th>Amount (Rs.)</th>
											<th>Unit</th>
											<th>No of Coils</th>
											<th>Priority</th>
											<th>Status</th>
											<th>Report</th>
										</tr>
										<tbody>
										<?php 
											$i=1;
											$dis_total_amt = array();
											foreach($res2 as $r)
											{
												if(isset($r['complain_date'])){$complain_date=$this->Base->change_date_dmy($r['complain_date']);}else{$complain_date='';}
											?>
											<tr>
												<td><?php echo $i;?>.</td>	
												<td><?php echo $complain_date;?></td>
												<td><?php if(isset($r['defect_qty']))echo $r['defect_qty'];?></td>
												<td><?php if(!empty($r['defect_amount'])) $dis_total_amt[] = round($r['defect_amount'],2); echo  $this->Base->money($r['defect_amount']);?></td>
												<td><?php if(isset($r['defect_unit']))echo $r['defect_unit'];?></td>
												<td><?php if(isset($r['defect_bobbin']))echo $r['defect_bobbin'];?></td>
												<td><?php if(isset($r['priority']))echo $r['priority'];?></td>
												<td><?php if(isset($r['status']))echo $r['status'];?></td>
												<td>
													<a  target="_blank" href="<?php echo base_url();?>index.php/Customer/comp_report/<?php if(isset($r['comp_id']))echo $r['comp_id']?>"  class="btn btn-info" style="width:100%;" >Report</a>
												</td>
											<tr>
											<?php
											$i++; 
										}
										?>
										</tbody>
											<tr style="font-weight:bold">
												<td></td>
												<td>Total</td>
												<td></td>
												<td><?php if(!empty($dis_total_amt)){$a = round(array_sum($dis_total_amt),2);  echo  $this->Base->money($a);}?></td>
											<tr>
									</table>
                                </div>
								
								

							</div><!-- tab 6 end -->

						</div><!-- tab-content end -->
                         
					<?php //-----------tab end-----------------------?>


					</div>
					<div class="modal-footer">
						<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
					</div>
				</div>
			
			<?php
			}else{
				echo "No customer id found";
				exit;
			}
	}//function close 











	public function cus_send_mail()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['search_mail_type'])){$mail_type =$_REQUEST['search_mail_type'];}else{$mail_type='';}
		//------------------row
		if(isset($_REQUEST['all_check_id'])){$all_check_id=explode('~',$_REQUEST['all_check_id']);$no_of_row=count($all_check_id);}else{$all_check_id='';$no_of_row=0;}
		
		

		//------------------------------------------------------------------mail send
		if(!empty($_REQUEST['search_mail_type']) and   $_REQUEST['search_mail_type'] != 'No Mail')
		{
			//check
			if($no_of_row>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($all_check_id[$i]>0)
					{
						$customer_id = $all_check_id[$i];
						$out3 = $this->Customermodel->get_customer_with_id($customer_id);
						if(!empty($out3)){
							
							//---api
							
							//getting mail content
							if($_REQUEST['search_mail_type'] == 1){
								//getting data form RKS ERP
								$mail_subject = "RKS Steel Industries Pvt. Ltd : Pending Payment Details.";
								$url = base_url()."index.php/Welcome/mail_type_1_body?customer_id=$customer_id";
							}
							elseif($_REQUEST['search_mail_type'] == 2){
								$mail_subject = "RKS Steel Industries Pvt. Ltd : Pending Payment Details.";
								$url = base_url()."index.php/Welcome/mail_type_2_body?customer_id=$customer_id";
							}
							elseif($_REQUEST['search_mail_type'] == 3){
								$mail_subject = "RKS Steel Industries Pvt. Ltd : Pending Payment Details.";
							}
							else{
								$mail_subject = "Mail";
							}
							
							

							$ch = curl_init($url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$mail_body = curl_exec($ch);

							if(!empty($out3[0]['email'])){ 
								$email1 = $out3[0]['email'];
								$this->Base->send_mail($email1,$mail_subject,$mail_body);//sending mail
							}
							// if(!empty($out3[0]['con_email1'])){ 
							// 	$con_email1 = $out3[0]['con_email1'];
							// 	$this->Base->send_mail($con_email1,$mail_subject,$mail_body);//sending mail
							// }
							// if(!empty($out3[0]['con_email2'])){ 
							// 	$con_email2 = $out3[0]['con_email2'];
							// 	$this->Base->send_mail($con_email2,$mail_subject,$mail_body);//sending mail
							// }
							
							/*
							// New Entry
							$data=array(
								'customer_id'=>"$customer_id",
								'entry_date'=>"$today",
								'last_status'=>"$follow_up_last_status",
								'current_comments'=>"$current_cumments",
								'next_follow_up_date'=>"$next_follow_up_date",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
							$cat_id=$this->Mymodel->insertdata_withid('cr_dr_master_follow_up',$data);
							*/

						}//empty
					}//if($all_paid_amount[$i]>0)
				}//for

				
				



				//echo "Save";
			}//no
			
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit

	}//function close


	public function cus_send_mail_single()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
	
		
		//------------------------------------------------------------------mail send
		if(!empty($_REQUEST['search_mail_type_single']) and   $_REQUEST['search_mail_type_single'] != 'No Mail' and !empty($_REQUEST['part_email']) and  !empty($_REQUEST['customer_id']))
		{
			$mail_type =$_REQUEST['search_mail_type_single'];
			$part_email =$_REQUEST['part_email'];
			$customer_id =$_REQUEST['customer_id'];
			

			//---mail api
			//getting mail content
			if($mail_type == 1){
				//getting data form RKS ERP
				$mail_subject = "RKS Steel Industries Pvt. Ltd : Pending Payment Details.";
				$url = base_url()."index.php/Welcome/mail_type_1_body?customer_id=$customer_id";
			}
			elseif($mail_type == 2){
				$mail_subject = "RKS Steel Industries Pvt. Ltd : Pending Payment Details.";
				$url = base_url()."index.php/Welcome/mail_type_2_body?customer_id=$customer_id";
			}
			
			if(isset($url)){
				//mail body
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$mail_body = curl_exec($ch);

				//sending mail
				$this->Base->send_mail($part_email,$mail_subject,$mail_body);//sending mail
			}
			else{
				echo "Wrong Mail type. Url not found. ";
			}
			
			

		}//update
		else
		{
			//exit
			echo "Not Save. Email id, Mail Type or Customer id not found.";
		}//exit

	}//function close


	
	/*
	public function party_typewise_mail_send()
	{
		$sql = "SELECT details4 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details4']);
		
		$current_date = date('d-m-Y');
		$yesterday_date = date( "d-m-Y",strtotime("-1 day",strtotime($current_date)));
		$sub = "$yesterday_date : Production Summary";
		
		//---api
		//getting data form RKS ERP
		//$url = "https://rkserp.com/online/index.php/Welcome/daily_production_mail_content";
		$url = "http://localhost/class/rks/index.php/Customer/party_mail_type_body?customer_id=13&mail_type=1";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$body = curl_exec($ch);
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body);}
	}//function close
	

	

	public function party_mail_type_body()
	{
		if(isset($_REQUEST['customer_id'])){$customer_id =$_REQUEST['customer_id'];}else{$customer_id='';}
		if(isset($_REQUEST['mail_type'])){$mail_type =$_REQUEST['mail_type'];}else{$mail_type='';}
		
		//------------------------------------------------------------------mail send
		if(!empty($_REQUEST['customer_id']) and   !empty($_REQUEST['mail_type']))
		{
			//mail template
			$out4 = $this->Customermodel->get_customer_mail_temp_with_id($mail_type); 
			echo $mail_body  = $out4[0]['mail_details'];

			// customer details
			$where=" and A.customer_id = '$customer_id'  ";
			$out5 = $this->Customermodel->get_cus_flowup_with_search($where);
		
		}//update
	}//function close

	*/
		
	
	
	
	
		
	
	
	  
	  
	  
	  
	  
	  
	  
	  
	

	

}//close class