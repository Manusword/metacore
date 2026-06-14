<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

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
	
	
	//checking fun_supplier_gst is exits or not
	public function fun_supplier_gst()
	{
		if(isset($_REQUEST['gst']) and strlen($_REQUEST['gst'])>0)
		{
			$gst=$_REQUEST['gst'];
			$res = $this->Suppliermodel->check_supplier_gst($gst);
			if(isset($res) and !empty($res))
			{
				echo "TRUE";
			}
		}
	}//function close


	//checking supplier gst type like he is in igst or cgst / sgst
	public function fun_get_supplier_gst_type()
	{
		if(isset($_REQUEST['id']) and strlen($_REQUEST['id'])>0)
		{
			$id = $_REQUEST['id'];
			echo $this->Suppliermodel->get_supplier_gst_type($id);
		}
	}//function close


	//geting supplier basic details at new po entry
	public function get_supplier_basic_details()
	{
		if(isset($_REQUEST['id']) and strlen($_REQUEST['id'])>0)
		{
			$id = $_REQUEST['id'];
			$res = $this->Suppliermodel->get_supplier_with_id($id);
			$gst_type = $this->Suppliermodel->get_supplier_gst_type($id);
			echo $gst_type.'~'.$res[0]['payment_terms'].'~'.$res[0]['del_place'].'~'.$res[0]['mod_of_dis'];
		}
	}//function close


	public function add()
	{
		$result['state']=$this->Base->get_all_state();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Suppliermodel->get_supplier_with_id($id);
		}//strlen
		$this->load->view('supplier/entry',$result);
	}//function close

	
	

	public function save()
	{
		
		$today=date("Y-m-d H:i:s");
		$login_username=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['gst'])){$gst=$_REQUEST['gst'];}else{$gst='';}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(isset($_REQUEST['product_type'])){$product_type=$_REQUEST['product_type'];}else{$product_type='';}
		if(isset($_REQUEST['name'])){$name=$_REQUEST['name'];}else{$name='';}
		if(isset($_REQUEST['approved_no'])){$approved_no=$_REQUEST['approved_no'];}else{$approved_no='';}
		if(isset($_REQUEST['telphone'])){$telphone=$_REQUEST['telphone'];}else{$telphone='';}
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}else{$email='';}
		if(isset($_REQUEST['state'])){$state=$_REQUEST['state'];}else{$state='';}
		if(isset($_REQUEST['city'])){$city=$_REQUEST['city'];}else{$city='';}
		if(isset($_REQUEST['address'])){$address=$_REQUEST['address'];}else{$address='';}
		if(isset($_REQUEST['country'])){$country=$_REQUEST['country'];}else{$country='';}
		if(isset($_REQUEST['zip'])){$zip=$_REQUEST['zip'];}else{$zip='';}
		
		if(isset($_REQUEST['con_name1'])){$con_name1=$_REQUEST['con_name1'];}else{$con_name1='';}
		if(isset($_REQUEST['con_mob1'])){$con_mob1=$_REQUEST['con_mob1'];}else{$con_mob1='';}
		if(isset($_REQUEST['con_email1'])){$con_email1=$_REQUEST['con_email1'];}else{$con_email1='';}
		if(isset($_REQUEST['designation1'])){$designation1=$_REQUEST['designation1'];}else{$designation1='';}
		
		if(isset($_REQUEST['con_name2'])){$con_name2=$_REQUEST['con_name2'];}else{$con_name2='';}
		if(isset($_REQUEST['con_mob2'])){$con_mob2=$_REQUEST['con_mob2'];}else{$con_mob2='';}
		if(isset($_REQUEST['con_email2'])){$con_email2=$_REQUEST['con_email2'];}else{$con_email2='';}
		if(isset($_REQUEST['designation2'])){$designation2=$_REQUEST['designation2'];}else{$designation2='';}
		
		if(isset($_REQUEST['payment_terms'])){$payment_terms=$_REQUEST['payment_terms'];}else{$payment_terms='';}
		if(isset($_REQUEST['del_place'])){$del_place=$_REQUEST['del_place'];}else{$del_place='';}
		if(isset($_REQUEST['mod_of_dis'])){$mod_of_dis=$_REQUEST['mod_of_dis'];}else{$mod_of_dis='';}
		if(isset($_REQUEST['logistrick'])){$logistrick=$_REQUEST['logistrick'];}else{$logistrick='';}
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['gst']))
		{
			
			$gst=$_REQUEST['gst'];
			$where=" gst_no='$gst' ";
			$res_chk=$this->Mymodel->select_where('supplier',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
			if(isset($id2))
			{
				echo "Not Save. $gst GST NO Already Available";
			}
			else
			{
				if(strlen($approved_no)>0)
				{
					$where=" approved_no='$approved_no' ";
					$res_chk=$this->Mymodel->select_where('supplier',$where);
					if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
					if(isset($id2))
					{
						echo "Not Save. $approved_no Approved NO Already Available";
						exit;	
					}
				}
					$data=array(
								  'type'=>"$type",
								  'product_type'=>"$product_type",
								  'name'=>"$name",
								  'approved_no'=>"$approved_no",
								  'telphone'=>"$telphone",
								  'email'=>"$email",
								  'address'=>"$address",
								  'city'=>"$city",
								  'state'=>"$state",
								  'country'=>"$country",
								  'zip'=>"$zip",
								  'gst_no'=>"$gst",
								  'con_name1'=>"$con_name1",
								  'con_mob1'=>"$con_mob1",
								  'con_email1'=>"$con_email1",
								  'designation1'=>"$designation1",
								  'con_name2'=>"$con_name2",
								  'con_mob2'=>"$con_mob2",
								  'con_email2'=>"$con_email2",
								  'designation2'=>"$designation2",
								  'payment_terms'=>"$payment_terms",
								  'del_place'=>"$del_place",
								  'mod_of_dis'=>"$mod_of_dis",
								  'logistrick'=>"$logistrick",
								  'save_by'=>"$login_username",
								  'save_date'=>"$today",
								  'status'=>"$active",
								);
					$cat_id=$this->Mymodel->insertdata_withid('supplier',$data);
					if ($cat_id > 0) {
						$ledger_data = array(
							'name' => NULL,
							'group_id' => 8, // Sundry Creditors
							'opening_balance' => 0.00,
							'opening_type' => 'Cr',
							'supplier_id' => $cat_id,
							'description' => 'Auto-created supplier account'
						);
						$this->db->insert('acc_ledgers', $ledger_data);
					}
					echo "Save";
			}//gst
		}//insert
		
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['gst']))
		{
			$id=$_REQUEST['id'];
			$where=" gst_no='$gst' ";
			$res_chk=$this->Mymodel->select_where('supplier',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
			if(isset($id2) and $id!=$id2)
			{
				echo "Not Save. $gst GST NO Already Available";
			}
			else
			{
				if(strlen($approved_no)>0)
				{
					$where=" approved_no='$approved_no' ";
					$res_chk=$this->Mymodel->select_where('supplier',$where);
					if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
					if(isset($id2) and $id!=$id2)
					{
						echo  "Not Save. $approved_no Approved NO Already Available";
						exit;
					}
				}
				$data=array(
								'type'=>"$type",
								'product_type'=>"$product_type",
								'name'=>"$name",
								'approved_no'=>"$approved_no",
								'telphone'=>"$telphone",
								'email'=>"$email",
								'address'=>"$address",
								'city'=>"$city",
								'state'=>"$state",
								'country'=>"$country",
								'zip'=>"$zip",
								'gst_no'=>"$gst",
								'con_name1'=>"$con_name1",
								'con_mob1'=>"$con_mob1",
								'con_email1'=>"$con_email1",
								'designation1'=>"$designation1",
								'con_name2'=>"$con_name2",
								'con_mob2'=>"$con_mob2",
								'con_email2'=>"$con_email2",
								'designation2'=>"$designation2",
								'payment_terms'=>"$payment_terms",
								'del_place'=>"$del_place",
								'mod_of_dis'=>"$mod_of_dis",
								'logistrick'=>"$logistrick",
								'update_by'=>"$login_username",
								'update_date'=>"$today",
								'status'=>"$active",
							);
					$where=array('id'=>"$id");   
					$this->Mymodel->update('supplier',$data,$where);
					$ledger_exists = $this->db->get_where('acc_ledgers', array('supplier_id' => $id))->num_rows();
					if ($ledger_exists == 0) {
						$ledger_data = array(
							'name' => NULL,
							'group_id' => 8, // Sundry Creditors
							'opening_balance' => 0.00,
							'opening_type' => 'Cr',
							'supplier_id' => $id,
							'description' => 'Auto-created supplier account'
						);
						$this->db->insert('acc_ledgers', $ledger_data);
					}
					echo "Update";
			}//gst
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close
	
	
	
	
	
	//supplier->list search
	public function list()
	{
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['type'])){$type=$_REQUEST['type'];$where.=" and  type='$type'   ";}
			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  name like '%$name%'   ";}
			if(!empty($_REQUEST['city'])){$city=$_REQUEST['city'];$where.=" and  city='$city'   ";}
			$where.=" ORDER by name ASC ";
			$result['res2'] = $this->Suppliermodel->get_all_supplier_with_search($where);
			$this->load->view('supplier/show_table',$result);
		}
		else
		{
			$where = " and id!='' ORDER by name ASC ";
			$result['res2'] = $this->Suppliermodel->get_all_supplier_with_search($where);
			$this->load->view('supplier/show',$result);
		}
	}//function close
	
	
	
	  
	  
	  
	  
	  
	  
	  
	public function supplier_rate_list()
	{
	 	if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['sup']=$id;
			
			//----name
			$query=" SELECT name FROM supplier WHERE id='$id' ";
			$out8=$this->Mymodel->query1($query);
			$result['cname']=$out8[0]['name'];
			
			$query=" SELECT `product_id` FROM `product_invoice_entry_details` WHERE `supplier_id`='$id' GROUP by `product_id` ";
			$result['out4']=$this->Mymodel->query1($query);
			
			$this->load->view('supplier/supplier_rate_list',$result);
			
			
		}//if 3 exits
		else
		{
			echo "NO Id Found";
		}
		
	}//function close
	
	
	
	
	
	
	
	  
	public function supplier_pcc()
	{
	 	$query=" SELECT * FROM company_setting WHERE id='16' ";
		$result['res2']=$this->Mymodel->query1($query);
		
		$this->load->view('supplier/supplier_ppc',$result);
		
	}//function close
	
	
	
	
	
	

	
	
	//-------------------------rate_diff
	 public function rate_diff()
	 {
		//--------------------------------------------------access
		//if(strlen($this->uri->segment(1))>0){$controler_name=$this->uri->segment(1);}else{$controler_name='';}
		//if(strlen($this->uri->segment(2))>0){$function_name=$this->uri->segment(2);}else{$function_name='';}
		//$this->Mymodel->access($controler_name,$function_name);
		//--------------------------------------------------access
			
			if(isset($_REQUEST['search']))
			{
				
				if(isset($_REQUEST['from_date'])){
					$test = new DateTime($_REQUEST['from_date']);
					$from_date= date_format($test, 'Y-m-d');	
				 }//from 
				 
				 if(isset($_REQUEST['to_date'])){
					
					$test = new DateTime($_REQUEST['to_date']);
					$to_date= date_format($test, 'Y-m-d');	
				 }//TO date
				
				if(isset($_REQUEST['category'])){$category=$_REQUEST['category'];}else{$category='';}
				if(isset($_REQUEST['group_by'])){$group_by=$_REQUEST['group_by'];}else{$group_by='';}
				
				 
				if(strlen($category)>0)
				{
					    $query2="
						SELECT 
								A.product_id,
								B.name as bname,
								B.details as bdetails,
								sum(A.net) as total_qty
								
						FROM product_invoice_entry_details as A
						
						LEFT JOIN product B ON A.product_id=B.product_id
						WHERE B.category_id='$category' and  A.details_save_date between '$from_date' and '$to_date'  GROUP BY A.product_id ;
						";

						$result['product_list']=$this->Mymodel->query1($query2);
						//print_r($result['product_list']);
				 
				}
				else
				{
					echo "Go back and select Category";
					exit;
				}
				
				 //search
				 $result['from_date2'] = $_REQUEST['from_date'];
				 $result['to_date2'] = $_REQUEST['to_date'];
				 $result['cat_id'] = $category;
				 $result['group_by'] = $group_by;
				
			}
			else
			{
				 $result['from_date2'] = date('01-m-Y');
				 $result['to_date2'] = date('d-m-Y');
				 $result['cat_id'] = '';
				 $result['product_list']=array();
				 $result['group_by'] = 'Yes';
			}
			
			
			
			
			$where="id='1' ";
			$result['company_setting']=$this->Mymodel->select_where('company_setting',$where);

			$where=" status='Active' ";
			$result['cat']=$this->Mymodel->select_where('category',$where);
			
			$this->load->view('supplier/rate_diff',$result);
		
		
		
	  }//function close	
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	//----------------------------------------------------------------------update_training
	public function supplier_reg_form_upload()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('email');
		
		
		//search
		if(isset($_REQUEST['search']))
		{
			if(isset($_REQUEST['supplier_id'])){$id=$_REQUEST['supplier_id'];}else{$id='';}
		}
		
		
		//new entry save
		if(isset($_REQUEST['save']))
		{
			if(isset($_REQUEST['supplier_id'])){$id=$_REQUEST['supplier_id'];}else{$id='';}
			if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{$grade='';}
			if(isset($_REQUEST['reg_form_remarks'])){$reg_form_remarks=$_REQUEST['reg_form_remarks'];}else{$reg_form_remarks='';}
			
			//update
			$data=array(
							'reg_grade'=>"$grade",
							'reg_form_remarks'=>"$reg_form_remarks",
						);
			 $where=array('id'=>"$id");   
			 $this->Mymodel->update('supplier',$data,$where);
			
			
			
			
			//insert
			if(isset($_FILES['img1']))
			{
				$img1 = $_FILES['img1'];
				$img_name = $img1['name'];
				$img_temp = $img1['tmp_name'];
			}
			else
			{
				$img_name='';
			}
			//----------------------------------------------------image
			$foldername1="supplier/$id";
			$foldername2="supplier/$id/training";
			if(!file_exists($foldername1)){mkdir($foldername1);}
			if(!file_exists($foldername2)){mkdir($foldername2);}
			if(strlen($img_name)>0)
			{
				$path1 = $foldername2.'/'.$img_name;  
				move_uploaded_file($img_temp,$path1);
				$data2=array('reg_form_pic'=>"$path1");
				$where2=array('id'=>"$id");   
				$this->Mymodel->update('supplier',$data2,$where2);
			}
			
			//redirect('Supplier/supplier_reg_form_upload');
			
		}//save
		
		
		if(isset($_REQUEST['supplier_id']))
		{
			$where=" id='$id' ";
			$result['res2']=$this->Mymodel->select_where('supplier',$where);
		}
		
		//select page details
		$where=" 1=1 ";
		$result['company_info']=$this->Mymodel->select_where('company_setting',$where);

		
		$where=" status='Active' ";
		$result['supplier']=$this->Mymodel->select_where('supplier',$where);
	
		
		$this->load->view('supplier/sup_reg',$result);
	
	}//function close
	
	  
	
	
	

	

}//close class