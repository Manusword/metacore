<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

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


	//checking product is exits or not
	public function fun_check_product()
	{
		if(isset($_REQUEST['name']) and strlen($_REQUEST['name'])>0 and isset($_REQUEST['category_id']) and strlen($_REQUEST['category_id'])>0)
		{
			$name = $_REQUEST['name'];
			$category_id = $_REQUEST['category_id'];
			$res = $this->Productmodel->get_product_data_with_name_and_category($name,$category_id);
			if(isset($res) and !empty($res))
			{
				echo "TRUE";
			}
		}
	}//function close

	//product_autocomplate_search 
	public function product_autocomplate_search()
	{
		$name =$_REQUEST['term'];
		echo  json_encode($this->Productmodel->product_autocomplate_search_via_name($name));
	}//function close



	//all product unit
    public function get_unit_name_from_id()
    {
        if(isset($_REQUEST['product_id']))
        {
			$product_id = $_REQUEST['product_id'];
			
			$pro = $this->Productmodel->get_product_column_data_with_id($product_id,'unit_id');
			$unit_id = $pro[0]['unit_id']; 
			echo $this->Base->get_unit_name_from_id($unit_id);
		}
		
	}//function close



	//add /edit new product
	public function add()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Productmodel->get_product_data_with_id($id);
		}//strlen
		$result['category']=$this->Base->get_all_category();
		$result['unit']=$this->Base->get_all_unit();
		$this->load->view('product/entry',$result);
	}//function close

	
	
	//product->list search
	public function list()
	{
		$result['cat2']=$this->Base->get_all_category();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['cat'])){$cat=$_REQUEST['cat'];$where.=" and  A.category_id='$cat'   ";}
			if(!empty($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id']; $where.="and A.product_id='$product_id'  ";}
			$where.=" ORDER by A.name ASC ";
			$result['res2'] = $this->Productmodel->get_all_product_with_search($where);
			$this->load->view('product/show_table',$result);
		}
		else
		{
			$default_category =  $this->Productmodel->get_default_category_product_search();
			$where = " and A.category_id='$default_category' ORDER by A.name ASC ";
			$result['res2'] = $this->Productmodel->get_all_product_with_search($where);
			$this->load->view('product/show',$result);
		}
	}//function close


	
	//save new product
	public function save()
	{
		$today=date("Y-m-d H:i:s");
		$login_username=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['name'])){$name=$_REQUEST['name'];}else{$name='';}
		if(isset($_REQUEST['details'])){$details=$_REQUEST['details'];}else{$details='';}
		if(isset($_REQUEST['product_cat'])){$product_cat=$_REQUEST['product_cat'];$result['selected_product']=$product_cat;}else{$product_cat='';}
		if(isset($_REQUEST['unit1'])){$unit=$_REQUEST['unit1'];$result['selected_unit']=$unit;}else{$unit='';}
		if(isset($_REQUEST['no_of_days'])){$no_of_days=$_REQUEST['no_of_days'];}else{$no_of_days='';}
		if(isset($_REQUEST['reorder'])){$reorder=$_REQUEST['reorder'];}else{$reorder='';}
		if(isset($_REQUEST['economic'])){$economic=$_REQUEST['economic'];}else{$economic='';}
		if(isset($_REQUEST['max_level'])){$max_level=$_REQUEST['max_level'];}else{$max_level='';}
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}	
		if(isset($_REQUEST['size'])){$size=$_REQUEST['size'];}else{$size='';}	
		if(isset($_REQUEST['is_repeated'])){$is_repeated=$_REQUEST['is_repeated'];}else{$is_repeated='';}	
		if(isset($_REQUEST['row_mat_puc'])){$row_mat_puc=$_REQUEST['row_mat_puc'];}else{$row_mat_puc='';}	
		if(isset($_REQUEST['con_mat_puc'])){$con_mat_puc=$_REQUEST['con_mat_puc'];}else{$con_mat_puc='';}	
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['name']))
		{
			$where=" category_id='$product_cat' and name='$name' ";
			$res_chk=$this->Mymodel->select_where('product',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['product_id'];}
			if(isset($id2))
			{
				echo "$name Product Already Available";
			}
			else
			{
				$data=array(
							  'category_id'=>"$product_cat",
							  'name'=>"$name",
							  'details'=>"$details",
							  'unit_id'=>"$unit",
							  
							  'no_of_days'=>"$no_of_days",
							  'reorder'=>"$reorder",
							  'economic'=>"$economic",
							  'max_level'=>"$max_level",
							  'size'=>"$size",
							  'repeated'=>"$is_repeated",
							  'row_mat_puc'=>"$row_mat_puc",
							  'con_mat_puc'=>"$con_mat_puc",
							  
							  'save_by'=>"$login_username",
							  'save_date'=>"$today",
							  'status'=>"$active",
							);
				$product_id=$this->Mymodel->insertdata_withid('product',$data);
				//update into stock
				$data7 = array($product_id,'','',0,0,0,0);
				$this->Storemodel->update_stock("NEW","New Product",$data7);
				echo "Save";
			}
			
		}//insert
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['name']))
		{
			$where=" category_id='$product_cat' and name='$name' ";
			$res_chk=$this->Mymodel->select_where('product',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['product_id'];}
			if(isset($id2) and $id!=$id2)
			{
				echo "$name Product Already Available";
			}
			else
			{
				$data=array(
							  'category_id'=>"$product_cat",
							  'name'=>"$name",
							  'details'=>"$details",
							  'unit_id'=>"$unit",
							 
							  'no_of_days'=>"$no_of_days",
							  'reorder'=>"$reorder",
							  'economic'=>"$economic",
							  'max_level'=>"$max_level",
							  
							  'size'=>"$size",
							  'repeated'=>"$is_repeated",
							  'row_mat_puc'=>"$row_mat_puc",
							  'con_mat_puc'=>"$con_mat_puc",
							  
							  'update_by'=>"$login_username",
							  'update_date'=>"$today",
							  'status'=>"$active",
							);
				$where=array('product_id'=>"$id");   
				$this->Mymodel->update('product',$data,$where);
				echo "Update";
			}//not repeat
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
	}//function close
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	
	
	
	
	
	
	
	
	
	
	
	  
	  
	  
	  
	  
	  
	  
	  





























	/*
	  
	public function product_drawing()
		{
			$today=date("Y-m-d H:i:s");
			$user_email=$this->session->userdata('email');
			
			
			//search
			if(isset($_REQUEST['search']))
			{
				if(isset($_REQUEST['year'])){$year=$_REQUEST['year'];}else{$year=date('Y');}
				if(isset($_REQUEST['staff'])){$staff=$_REQUEST['staff'];}else{$staff=1;}
				
				$result['staff1']=$staff;
				$result['year1']=$year;
				
				//geting training_ list
				$query=" SELECT 
							A.emp_training_table1_id,A.name
							
							FROM emp_training_list as A 
							WHERE   A.status='active' and A.for_staff='$staff'   ";
				$result['training_list']=$this->Mymodel->query1($query);
			}//search
			
			
			
			elseif(isset($_REQUEST['upload']))
			{
					if(isset($_REQUEST['product'])){$product=$_REQUEST['product'];}else{$product='';$result['msg']= "<span style='color:red'>Select Partname</span>";}
					$query=" SELECT id FROM product_drawing  WHERE product_id='$product'  ";
					$out=$this->Mymodel->query1($query);
					if(!empty($out))
					{
						//update
						$last_id=$out[0]['id'];
					}
					else
					{
						//insert
						$data=array(
								'product_id'=>"$product",
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							  );
					 	$last_id=$this->Mymodel->insertdata_withid('product_drawing',$data);	
					}//$out
					
					
					if($last_id>0)
					{
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
						$foldername1="product/$last_id";
						if(!file_exists($foldername1)){mkdir($foldername1);}
						
						if(strlen($img_name)>0)
						{
							$path1 = $foldername1.'/'.$img_name;  
							move_uploaded_file($img_temp,$path1);
							$data2=array('pic1'=>"$path1");
							$where2=array('id'=>"$last_id");   
							$this->Mymodel->update('product_drawing',$data2,$where2);
							$result['msg']= "<span style='color:green'>file Uploaded successful</span>";
							redirect('Product/product_drawing');
						}//img name/
						else
						{
							$result['msg']= "<span style='color:red'>No Drawing Found</span>";
						}
					}//$last_id
					
					
					$result['training_list']=array();
			}//upload
			else
			{
				$result['training_list']=array();
			}
			
			$query=" SELECT 
					A.id,A.product_id,A.pic1,A.pic2,
					P.name as pname
					
					FROM product_drawing as A 
					LEFT JOIN product as P ON P.product_id = A.product_id
					WHERE  A.product_id!='' ORDER BY P.name ";
			$result['res2']=$this->Mymodel->query1($query);
			
			$this->load->view('product/pic',$result);
		}//function close
	  
	
	






		//Function get priduction of product producttion
		public function prediction_of_product_production()
		{
			$today=date("Y-m-d");
			$user_email=$this->session->userdata('email');

			$this_month_from = date("Y-m-01");
			$this_month_to =  date("Y-m-t", strtotime($this_month_from));

			$yesterday = date('Y-m-d', strtotime('-1 day')); 
			
			//Emp code 
			$where=" status='Active'   ";
			$result['company_role']=$this->Mymodel->select_where('company_role',$where);
			
			//search
			if(isset($_REQUEST['search']))
			{
				if(isset($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id'];}else{$product_id='';}
				$result['product_id']=$product_id;
			
				$query=" SELECT name FROM product WHERE product_id='$product_id' ";
				$result['pro_name']=$this->Mymodel->query1($query);
				
				
			
				//getting total order 
				$query=" SELECT 
						 sum(A.order_qty) as order_qty, sum(A.send_qty) as send_qty ,
						 P.name as pname,P.details,
						 U.name as uname
						 FROM customer_schedule_details as A
						 LEFT JOIN product as P ON P.product_id = A.product_id
						 LEFT JOIN unit as U ON U.unit_id = P.unit_id
						 WHERE A.product_id='$product_id' and A.from_date between '$this_month_from' and '$this_month_to' GROUP BY A.product_id
						";
				$result['total_order']=$this->Mymodel->query1($query);

			

				// current running on machine 
				$query=" SELECT 
						 A.total_qty_mtr,
						 A.mc_id,
						 M.name as mc_name
						 FROM rope_mc_production as A
						 LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
						 WHERE A.outward='$product_id' and A.entry_date = '$yesterday'  GROUP BY A.mc_id
						";
				$result['current_mc']=$this->Mymodel->query1($query);




				// old running on machine details
				$query=" SELECT 
						 A.entry_date,
						 A.mc_id,
						 M.name as mc_name
						 FROM rope_mc_production as A
						 LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
						 WHERE A.outward='$product_id' and A.entry_date != '$yesterday'  GROUP BY A.mc_id
						";
				$result['old_mc']=$this->Mymodel->query1($query);

				//print_r($result['current_mc']);

			}//search
			else
			{
				$result['res2']=array();
			}
			
			$this->load->view('product/prediction/page1',$result);
		
		}//function close



		*/









	
	
	
	

}//close class
