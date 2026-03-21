<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rgp extends CI_Controller {

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


	public function newrgp()
	{
		// //--------------------------------------------------access
		// if(strlen($this->uri->segment(1))>0){$controler_name=$this->uri->segment(1);}else{$controler_name='';}
		// if(strlen($this->uri->segment(2))>0){$function_name=$this->uri->segment(2);}else{$function_name='';}
		// $this->Mymodel->access($controler_name,$function_name);
		// //--------------------------------------------------access
		
		// $user_email=$this->session->userdata('email');
		
		// if(strlen($this->uri->segment(4))>0){$last_value=$this->uri->segment(4);$result= $this->Mymodel->error($last_value);}
		
		
		// $where=" status='Active'  ORDER by name ASC ";
		// $result['product_grade']=$this->Mymodel->select_where('product_grade',$where);
		
		// $where=" status='Active'  ORDER by name ASC ";
		// $result['product_lotno']=$this->Mymodel->select_where('product_lotno',$where);
		
		// $where=" status='Active'  ORDER by name ASC ";
		// $result['supplier']=$this->Mymodel->select_where('supplier',$where);
		// $where=" status='Active'  ORDER by name ASC ";
		// $result['customer']=$this->Mymodel->select_where('customer',$where);
		
		
		// $where="1=1 and status='Active'  ORDER by name ASC ";
		// $result['category']=$this->Mymodel->select_where('category',$where);
		
		// $where=" status='Active'  ORDER by name ASC ";
		// $result['product']=$this->Mymodel->select_where('product',$where);
		
		
		// $where="1=1 and status='Active'  ORDER by name ASC ";
		// $result['unit']=$this->Mymodel->select_where('unit',$where);
		$result['unit']="";
		
		$this->load->view('rgp/entry',$result);
	
	}//function close

	










	
	
	
	

}//close class
