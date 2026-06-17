<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Po extends CI_Controller {

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


	//geting last purchase deatisl at new po entry
	public function get_product_last_purchase_details()
	{
		if(isset($_REQUEST['product_id']) and isset($_REQUEST['supplier_id']))
		{
			$product_id = $_REQUEST['product_id'];
			$supplier_id = $_REQUEST['supplier_id'];
			$out = $this->Pomodel->get_product_data_with_id($supplier_id,$product_id);
			if(isset($out) and !empty($out))
			{
				$rate=$out[0]['rate'];
				$rate_disc=$out[0]['disc'];
				$rate_net=$out[0]['net'];
				$po_entry_id=$out[0]['po_entry_id'];
				$pcc_img_status =  $this->Pomodel->get_pcc_image_details_with_id($po_entry_id);
				$product_unit=$out[0]['unitname_id'];
				$hsn=$out[0]['hsn'];
				$itemigst=$out[0]['itemigst'];
				$itemcgst=$out[0]['itemcgst'];
				$itemsgst=$out[0]['itemsgst'];
				$gst_details = " SGST = $itemsgst, CGST = $itemcgst, IGST = $itemigst  ";
			}
			else
			{
				//if no product found in this supplier
				$product_unit = $this->Pomodel->get_product_unit_form_last_purchase($product_id);
				$rate = "";
				$pcc_img_status = "NO";
				$hsn = $this->Pomodel->get_product_hsn_form_last_purchase($product_id);
				$itemigst2 = $this->Pomodel->get_product_igst_per_form_last_purchase($product_id);
				$itemcgst2 = $this->Pomodel->get_product_cgst_per_form_last_purchase($product_id);
				$itemsgst2 = $this->Pomodel->get_product_sgst_per_form_last_purchase($product_id);
				$gst_details = " SGST = $itemsgst2, CGST = $itemcgst2, IGST = $itemigst2  ";
				$rate_disc="";
				$rate_net="";
				//becouse suplier is diff
				$itemsgst="";
				$itemcgst="";
				$itemigst="";
			}//if no product found in this supplier
			
			echo $product_unit.'~'.$rate.'~'.$pcc_img_status.'~'.$hsn.'~'.$gst_details.'~'.$rate_disc.'~'.$rate_net.'~'.$itemsgst.'~'.$itemcgst.'~'.$itemigst;
		}//if isset
	}//function close


	//get product list form po when po invoice entry time
	function get_product_form_po_details_with_supplier_id()
	{
		if(isset($_REQUEST['id']))
		{
			$supplier_id = $_REQUEST['id'];
			$validity_permisson = $this->Company->po_invoice_entry_details_validation();
			$out = $this->Pomodel->get_product_form_po_details_with_supplier_id($supplier_id,$validity_permisson,'');
			?>
				<option value="">Select</option>
			<?php
			if(!empty($out))
			{
				foreach($out as $r)
				{
					?><option value="<?php echo $r['product_id'];?>"><?php echo $r['name'];?></option><?php
				}
			}//else
		}//get id
	}//function close


	//get po no  list form po when po invoice entry time
	function get_pono_form_po_details_with_supplier_id_and_product_id()
	{
		if(isset($_REQUEST['supplier_id']) and isset($_REQUEST['product_id']))
		{
			$supplier_id = $_REQUEST['supplier_id'];
			$product_id = $_REQUEST['product_id'];
			$validity_permisson = $this->Company->po_invoice_entry_details_validation();
			$out = $this->Pomodel->get_pono_form_po_details_with_supplier_id_and_product_id($supplier_id,$product_id,$validity_permisson,'');
			?>
				<option value="">Select</option>
			<?php
			if(!empty($out))
			{
				foreach($out as $r)
				{
					?><option value="<?php echo $r['po_entry_details_id'];?>"><?php echo $r['po_no'];?></option><?php
				}
			}//else
		}//get id
	}//function close


	//po full details form po details id
	public function get_po_details()
	{
		if(isset($_REQUEST['poid_details_id']))
		{
			if(strlen($_REQUEST['poid_details_id'])>0 and $_REQUEST['poid_details_id']!='Direct')
			{
				$poid_details_id = $_REQUEST['poid_details_id'];
				$product = $this->Pomodel->get_po_product_details_with_podetails_id($poid_details_id);
				$qty = (int)$product[0]['qunt'];
				$rec = (int)$product[0]['rev_qunt'];
				$rem = $qty-$rec;
				echo  $product[0]['qunt'].'~'.$product[0]['rev_qunt'].'~'.$rem.'~'.$product[0]['unitname_id'].'~'.$product[0]['hsn'].'~'.$product[0]['net'];
			}
		}
	}//function close







	//-delete product form po
	public function delete_po_product()
	{
		if(isset($_REQUEST['po_details_val2']) and $_REQUEST['po_details_val2']>0)
		{
			$po_entry_details_id = $_REQUEST['po_details_val2'];
			echo $this->Pomodel->delete_po_product_with_id($po_entry_details_id);
		}
		else
		{
			echo "No Id Found.";
		}//if
	}//function close


	
	



















	//-------------------------------new po
	public function add()
	{
		$result['supplier'] = $this->Suppliermodel->get_all_active_supplier();
		$result['unit'] = $this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Pomodel->get_po_details_with_id($id);
			$result['res3'] = $this->Pomodel->get_po_product_details_with_id($id);
		}
		$this->load->view('po/new_po',$result);
	}//function close


	//Po Save
	public function save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['supplier_id'])){ $supplier_id=$_REQUEST['supplier_id'];}else{ echo "No supplier found";exit;}
		if(isset($_REQUEST['po_date']))
		{ 
			$po_date1 = $this->Base->change_date_ymd($_REQUEST['po_date']);
			$po_save_no = $this->Pomodel->get_next_po_no($po_date1);
		}
		if(isset($_REQUEST['po_valid'])){ $po_valid = $this->Base->change_date_ymd($_REQUEST['po_valid']);}
		if(isset($_REQUEST['com_qut_ref'])){$com_qut_ref=$_REQUEST['com_qut_ref'];}else{$com_qut_ref='';}
		if(isset($_REQUEST['com_indent_ref'])){$com_indent_ref=$_REQUEST['com_indent_ref'];}else{$com_indent_ref='';}
		if(!empty($_REQUEST['current_stage'])){$current_stage=$_REQUEST['current_stage'];}else{$current_stage='1';}
		//--------------------------------------row
		if(isset($_REQUEST['po_details_id'])){$po_details_id=explode('~',$_REQUEST['po_details_id']);}else{$po_details_id='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);}else{$goods='';}
		if(isset($_REQUEST['goodsdetails'])){$goodsdetails=explode('~',$_REQUEST['goodsdetails']);}else{$goodsdetails='';}
		if(isset($_REQUEST['hsn'])){$hsn=explode('~',$_REQUEST['hsn']);}else{$hsn='';}
		if(isset($_REQUEST['unitname'])){$unitname=explode('~',$_REQUEST['unitname']);}else{$unitname='';}
		if(isset($_REQUEST['qunt'])){$qunt=explode('~',$_REQUEST['qunt']);}else{$qunt='';}
		if(isset($_REQUEST['rate'])){$rate=explode('~',$_REQUEST['rate']);}else{$rate='';}
		if(isset($_REQUEST['disc'])){$disc=explode('~',$_REQUEST['disc']);}else{$disc='';}
		if(isset($_REQUEST['net'])){$net=explode('~',$_REQUEST['net']);}else{$net='';}
		if(isset($_REQUEST['total_amount'])){$amount=explode('~',$_REQUEST['total_amount']);$no_of_row=count($amount);}else{$amount='';$no_of_row=0;}
		if(isset($_REQUEST['itemsgst'])){$itemsgst=explode('~',$_REQUEST['itemsgst']);}else{$itemsgst='';}
		if(isset($_REQUEST['itemcgst'])){$itemcgst=explode('~',$_REQUEST['itemcgst']);}else{$itemcgst='';}
		if(isset($_REQUEST['itemigst'])){$itemigst=explode('~',$_REQUEST['itemigst']);}else{$itemigst='';}
		if(isset($_REQUEST['itemgstrs'])){$itemgstrs=explode('~',$_REQUEST['itemgstrs']);}else{$itemgstrs='';}
		//--------------------------------------row
		if(isset($_REQUEST['total_old'])){$total_old=$_REQUEST['total_old'];}else{$total_old='';}
		if(isset($_REQUEST['dis_per'])){$dis_per=$_REQUEST['dis_per'];}else{$dis_per='';}
		if(isset($_REQUEST['dis_amt'])){$dis_amt=$_REQUEST['dis_amt'];}else{$dis_amt='';}
		if(isset($_REQUEST['total'])){$total=$_REQUEST['total'];}else{$total='';}
		if(isset($_REQUEST['ffc_charge'])){$ffc_charge=$_REQUEST['ffc_charge'];}else{$ffc_charge='';}
		if(isset($_REQUEST['ffc_gst_per'])){$ffc_gst_per=$_REQUEST['ffc_gst_per'];}else{$ffc_gst_per='';}
		if(isset($_REQUEST['ffc_gst_amt'])){$ffc_gst_amt=$_REQUEST['ffc_gst_amt'];}else{$ffc_gst_amt='';}
		if(isset($_REQUEST['ffc_amt'])){$ffc_amt=$_REQUEST['ffc_amt'];}else{$ffc_amt='';}
		if(isset($_REQUEST['gst_type'])){$gst_type=$_REQUEST['gst_type'];}else{$gst_type='';}
		if(isset($_REQUEST['gstval'])){$gstval=$_REQUEST['gstval'];}else{$gstval='';}
		if(isset($_REQUEST['gstcharge'])){$gstcharge=$_REQUEST['gstcharge'];}else{$gstcharge='';}
		if(isset($_REQUEST['gstval2'])){$gstval2=$_REQUEST['gstval2'];}else{$gstval2='';}
		if(isset($_REQUEST['gstcharge2'])){$gstcharge2=$_REQUEST['gstcharge2'];}else{$gstcharge2='';}
		if(isset($_REQUEST['gstval3'])){$gstval3=$_REQUEST['gstval3'];}else{$gstval3='';}
		if(isset($_REQUEST['gstcharge3'])){$gstcharge3=$_REQUEST['gstcharge3'];}else{$gstcharge3='';}
		if(isset($_REQUEST['roundoff'])){$roundoff=$_REQUEST['roundoff'];}else{$roundoff='';}
		if(isset($_REQUEST['rs_word'])){$rs_word=$_REQUEST['rs_word'];}else{$rs_word='';}
		if(isset($_REQUEST['grandtotal'])){$grandtotal=$_REQUEST['grandtotal'];}else{$grandtotal='';}
		if(isset($_REQUEST['del_schedule'])){$del_schedule=$_REQUEST['del_schedule'];}else{$del_schedule='';}
		if(isset($_REQUEST['payment_terms'])){$payment_terms=$_REQUEST['payment_terms'];}else{$payment_terms='';}
		if(isset($_REQUEST['del_place'])){$del_place=$_REQUEST['del_place'];}else{$del_place='';}
		if(isset($_REQUEST['mod_of_dis'])){$mod_of_dis=$_REQUEST['mod_of_dis'];}else{$mod_of_dis='';}
		if(isset($_REQUEST['loading_charge'])){$loading_charge=$_REQUEST['loading_charge'];}else{$loading_charge='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['order_by'])){$order_by=$_REQUEST['order_by'];}else{$order_by='';}
		if(isset($_REQUEST['department'])){$department=$_REQUEST['department'];}else{$department='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['supplier_id']))
		{
				$data=array(
							 	'po_no'=>"$po_save_no",
								'po_date'=>"$po_date1",
								'po_validity'=>"$po_valid",
								'quotation_ref'=>"$com_qut_ref",
								'indent_ref'=>"$com_indent_ref",
								'supplier_id'=>"$supplier_id",
								'total_old'=>"$total_old",
								'dis_per'=>"$dis_per",
								'dis_amt'=>"$dis_amt",
								'total'=>"$total",
								'ffc_charge'=>"$ffc_charge",
								'ffc_gst_per'=>"$ffc_gst_per",
								'ffc_gst_amt'=>"$ffc_gst_amt",
								'ffc_amt'=>"$ffc_amt",
								'gstcharge'=>"$gstcharge",
								'gst_type'=>"$gst_type",
								'roundoff'=>"$roundoff",
								'amount_word'=>"$rs_word",
								'grandtotal'=>"$grandtotal",
								'del_schedule'=>"$del_schedule",
								'payment_terms'=>"$payment_terms",
								'del_place'=>"$del_place",
								'mod_of_dis'=>"$mod_of_dis",
								'loading_charge'=>"$loading_charge",
								'remarks'=>"$remarks",
								'stage'=>"$current_stage",
								'created_by'=>"$user_email",
								'created_date'=>"$today",
								'status'=>"Active",
							  	'order_by'=>"$order_by",
							 	'department'=>"$department",
							 	'mc_no'=>"$mc_no",
							 	'save_by'=>"$user_email",
							  	'save_date'=>"$today",
							);
				$po_entry_id=$this->Mymodel->insertdata_withid('po_entry',$data);
				
				if($po_entry_id>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						if($goods[$i]>0 and $qunt[$i]>0 and $net[$i]>0 and $amount[$i]>0)
						{
							$data2=array();
							$data2=array(
											'po_entry_id'=>"$po_entry_id",
											'po_no'=>"$po_save_no",
											'po_date'=>"$po_date1",
											'supplier_id'=>"$supplier_id",
											'product_id'=>"$goods[$i]",
											'goodsdetails'=>"$goodsdetails[$i]",
											'hsn'=>"$hsn[$i]",
											'unitname_id'=>"$unitname[$i]",
											'qunt'=>"$qunt[$i]",
											'rate'=>"$rate[$i]",
											'disc'=>"$disc[$i]",
											'net'=>"$net[$i]",
											'amount'=>"$amount[$i]",
											'itemsgst'=>"$itemsgst[$i]",
											'itemcgst'=>"$itemcgst[$i]",
											'itemigst'=>"$itemigst[$i]",
											'itemgstrs'=>"$itemgstrs[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$this->Mymodel->insertdata('po_entry_details',$data2);
						}//amount
					}//for loop
				}//id
			
			//send mail
			//po email list
			//$po_email_list = $this->Company->po_email_list();
			//$store_head_list = $po_email_list[0]['details2'];
			//$this->Pomodel->po_action_email($po_entry_id,0,1,3,$user_email,$store_head_list);
			echo "Save";
		}//insert
		
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['supplier_id']))
		{
				$id=$_REQUEST['id'];
				if(isset($_REQUEST['po_no2'])){$po_no=$_REQUEST['po_no2'];}else{$po_no='';}
				
				if($current_stage>=5)
				{
					$text_edited=2;
				}
				else
				{
					$text_edited=1;
				}
				
				//---------------if edited than send to GM
				if($current_stage>=2)
				{
					$current_stage2=2;
				}
				else
				{
					$current_stage2=$current_stage;
				}
				
				
				$data=array(
								'po_date'=>"$po_date1",
								'po_validity'=>"$po_valid",
								'quotation_ref'=>"$com_qut_ref",
								'indent_ref'=>"$com_indent_ref",
								'supplier_id'=>"$supplier_id",
								'total_old'=>"$total_old",
								'dis_per'=>"$dis_per",
								'dis_amt'=>"$dis_amt",
								'total'=>"$total",
								'ffc_charge'=>"$ffc_charge",
								'ffc_gst_per'=>"$ffc_gst_per",
								'ffc_gst_amt'=>"$ffc_gst_amt",
								'ffc_amt'=>"$ffc_amt",
								'gstval'=>"$gstval",
								'gstcharge'=>"$gstcharge",
								'gstval2'=>"$gstval2",
								'gstcharge2'=>"$gstcharge2",
								'gstval3'=>"$gstval3",
								'gstcharge3'=>"$gstcharge3",
								'gst_type'=>"$gst_type",
								'roundoff'=>"$roundoff",
								'amount_word'=>"$rs_word",
								'grandtotal'=>"$grandtotal",
								'del_schedule'=>"$del_schedule",
								'payment_terms'=>"$payment_terms",
								'del_place'=>"$del_place",
								'mod_of_dis'=>"$mod_of_dis",
								'loading_charge'=>"$loading_charge",
								'remarks'=>"$remarks",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
								'status'=>"Active",
								'text_edited'=>"$text_edited",
								'out_print_option_set'=>"0",
								'no_of_page'=>"",
								'order_by'=>"$order_by",
								'department'=>"$department",
								'mc_no'=>"$mc_no",
								'save_by'=>"$user_email",
								'save_date'=>"$today",
								'stage'=>"$current_stage2",
							);
						$where=array('po_id'=>"$id");   
						$this->Mymodel->update('po_entry',$data,$where);
						
						//-------------------------delete
						//$where9=array('po_entry_id'=>"$id");   
						//$this->Mymodel->deletedata('po_entry_details',$where9);
						//-------------------------delete
				
						if($id>0)
						{
							for($i=0;$i<$no_of_row;$i++)
							{
								if($goods[$i]>0 and $qunt[$i]>0 and $net[$i]>0 and $amount[$i]>0)
								{
										//update
										if($po_details_id[$i]>0)
										{
											
											$data3=array(
														'po_entry_id'=>"$id",
														'po_no'=>"$po_no",
														'po_date'=>"$po_date1",
														'supplier_id'=>"$supplier_id",
														'product_id'=>"$goods[$i]",
														'goodsdetails'=>"$goodsdetails[$i]",
														'hsn'=>"$hsn[$i]",
														'unitname_id'=>"$unitname[$i]",
														'qunt'=>"$qunt[$i]",
														'rate'=>"$rate[$i]",
														'disc'=>"$disc[$i]",
														'net'=>"$net[$i]",
														'amount'=>"$amount[$i]",
														'itemsgst'=>"$itemsgst[$i]",
														'itemcgst'=>"$itemcgst[$i]",
														'itemigst'=>"$itemigst[$i]",
														'itemgstrs'=>"$itemgstrs[$i]",
														'update_by'=>"$user_email",
														'update_date'=>"$today",
													);
											$po_details_id2=$po_details_id[$i];
											$where3=array('po_entry_details_id'=>"$po_details_id2");   
											$this->Mymodel->update('po_entry_details',$data3,$where3);
										}//update
										else
										{
											//new entry
											$data2=array(
														'po_entry_id'=>"$id",
														'po_no'=>"$po_no",
														'po_date'=>"$po_date1",
														'supplier_id'=>"$supplier_id",
														'product_id'=>"$goods[$i]",
														'goodsdetails'=>"$goodsdetails[$i]",
														'hsn'=>"$hsn[$i]",
														'unitname_id'=>"$unitname[$i]",
														'qunt'=>"$qunt[$i]",
														'rate'=>"$rate[$i]",
														'disc'=>"$disc[$i]",
														'net'=>"$net[$i]",
														'amount'=>"$amount[$i]",
														'itemsgst'=>"$itemsgst[$i]",
														'itemcgst'=>"$itemcgst[$i]",
														'itemigst'=>"$itemigst[$i]",
														'itemgstrs'=>"$itemgstrs[$i]",
														'save_by'=>"$user_email",
														'save_date'=>"$today",
													);
											$this->Mymodel->insertdata('po_entry_details',$data2);
										}//new
										
										
								}//amount
							}//for loop
						}//id
						
						
						echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
	
	}//function close
	
	
	
	public function new_po_list()
	{
		$stage = 1;//new po
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2']=$this->Pomodel->get_po_list_from_stage($stage);
		$this->load->view('po/new_po_list',$result);
	}//function close
	
	public function po_reject_display()
	{
		$stage = 3;//reject stage
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2']=$this->Pomodel->get_po_list_from_stage($stage);
		$this->load->view('po/new_po_list',$result);
	}//function close
	
	public function gm_po_list()
	{
		$stage = 2; //gm stage
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2']=$this->Pomodel->get_po_list_from_stage($stage);
		$this->load->view('po/new_po_list',$result);
	}//function close

	public function mp_po_list()
	{
		$stage = 11;//md stage
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2']=$this->Pomodel->get_po_list_from_stage($stage);
		$this->load->view('po/new_po_list',$result);
	}//function close
	
	public function po_approved_list_by_mp()
	{
		$stage = 4;//approved by all
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2']=$this->Pomodel->get_po_list_from_stage($stage);
		$this->load->view('po/new_po_list',$result);
	}//function close
	
	public function po_send_to_customer()
	{
		$stage = 5;//approved by all
		$result['po_search_stage']=$stage;
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		$result['res2'] = $this->Pomodel->get_product_total_order_total_rec_in_no(date('Y-m-d'),date('Y-m-d'));
		$this->load->view('po/new_po_list',$result);
	}//function close
	
	
	
	
	
	
	
	
	public function po_search()
	{
		$today=date("Y-m-d");
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		if(isset($_REQUEST['search1']))
		{
			$where = " and A.status='Active' "; 
			if(!empty($_REQUEST['po_search_stage'])){$po_search_stage=$_REQUEST['po_search_stage'];$result['po_search_stage'] = $po_search_stage;$where.=" and  A.stage='$po_search_stage'  ";}
			if(!empty($_REQUEST['pono'])){$pono=$_REQUEST['pono'];$where.=" and  A.po_no ='$pono'   ";}
			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  A.supplier_id ='$name'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.po_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" GROUP BY A.po_id ORDER by A.po_no DESC ";
			$result['res2'] = $this->Pomodel->po_serach_query($where);
			$this->load->view('po/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = " and A.status='Active' and A.po_date between '$search_date1' and '$search_date2' GROUP BY A.po_id ORDER by A.po_no DESC ";
			$result['res2'] = $this->Pomodel->po_serach_query($where);
			$this->load->view('po/show_table',$result);
		}
	}//function close


	public function po_product_status()
	{
		$today=date("Y-m-d");
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		if(isset($_REQUEST['search1']))
		{
			$where = " and  B.stage='5'  "; 
			if(!empty($_REQUEST['supplier'])){$supplier=$_REQUEST['supplier'];$where.=" and  B.supplier_id='$supplier'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  A.product_id ='$product'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.po_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.po_date DESC ";
			$result['res2'] = $this->Pomodel->po_product_serach_query($where);
			$this->load->view('po/show_table_product',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = " and B.stage='5' and A.po_date between '$search_date1' and '$search_date2'  ORDER by A.po_date DESC ";
			$result['res2'] = $this->Pomodel->po_product_serach_query($where);
			$this->load->view('po/display_product_wise',$result);
		}
	}//function close
 
	
	
	public function po_action()
	{
		$emp_id=$this->session->userdata('login_emp_id');
		if(strlen($this->uri->segment(3)>0))
		{
			$po_id = $this->uri->segment(3);
			$result['po'] = $this->Pomodel->get_po_details_with_id($po_id);
			if(isset($result['po']) and count($result['po'])>0)
			{
				//----------if url comes form after editing
				if(strlen($this->uri->segment(5))>0){
						 
					$last_stage_befor_edit = $this->uri->segment(5);
					$result['po2']=$this->Pomodel->get_po_product_details_with_id($po_id);
					$this->load->view('po/po_action',$result);
				}
				else //seg 5 url comes form edit;
				{
					$stage=$result['po'][0]['stage'];
					if($stage=='1' or $stage=='3')
					{
						$stage_no=2;
					}
					elseif($stage=='2')
					{
						$stage_no=4;//stage ko ready kr dega mail send krne k liye
					} 
					elseif($stage=='11')
					{
						$stage_no=16;//stage ko ready kr dega mail send krne k liye
					}
					elseif($stage=='4')
					{
						$stage_no=5;//mail Sended to customer
					}
					/*					
						$where=" emp_id='$emp_id' and access_name='$stage_no'  ";
						$access=$this->Mymodel->select_where('emp_access',$where);
						if(isset($access) and count($access)>0)
						{
							$result['po2']=$this->Pomodel->get_po_product_details_with_id($po_id);
							$this->load->view('po/po_action',$result);
						}//not access
						else
						{
							redirect('control/');
						}
					*/
					$result['po2']=$this->Pomodel->get_po_product_details_with_id($po_id);
					$this->load->view('po/po_action',$result);
				}//seg 5 url comes form edit;
			}//po
		}//id
	
	}//function close
	
	
	
	public function po_action_save()
	{
		$today_date=date("Y-m-d H:i:s");
		$iduser=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}
		if(isset($_REQUEST['po_id'])){$po_id=$_REQUEST['po_id'];}else{echo "No PO ID Found.";exit;}
		if(isset($_REQUEST['comment'])){$comment=$_REQUEST['comment'];}else{$comment='';}
		if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action='';}
		//getting amt
		$out = $this->Pomodel->get_po_all_amt_form_id($po_id);
		if(isset($out) and count($out)>0){$total_amt=$out[0]['total'];}else{echo "No Amount Found.";exit;}
		//getting limit amount
		$approved_amt_by_gm = $this->Company->po_approval_limit_amt_for_gm();
		
		//po email list
		$po_email_list = $this->Company->po_email_list();
		$store_person_list = $po_email_list[0]['details1'];
		$store_head_list = $po_email_list[0]['details2'];
		$gm_list = $po_email_list[0]['details3'];
		$md_list = $po_email_list[0]['details4'];
		
		if(!empty($po_id) and !empty($current_status))
		{
			if($action=='accept')
			{
				if($current_status==1)
				{
					$data2=array(
								'stage'=>"2",
								'dept_aproved_by'=>"$iduser",
								'dept_aproved_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
					$this->Pomodel->po_action_email($po_id,2,11,3,$iduser,$gm_list);			
				}//satge1
				if($current_status==3)
				{
					$data2=array(
								'stage'=>"2",
								'dept_aproved_by'=>"$iduser",
								'dept_aproved_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
					$this->Pomodel->po_action_email($po_id,2,11,3,$iduser,$gm_list);			
				}//satge3
				//////////////-----------------------------------Approved with GM
				if($current_status==2)
				{
					if($total_amt<$approved_amt_by_gm)
					{
						////direct approved
						$data2=array(
								'stage'=>"4",
								'aproved_by'=>"$iduser",
								'aproved_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
						//$this->Pomodel->po_action_email_to_creater($po_id,$iduser,$md_list);
						$this->Pomodel->po_action_email($po_id,4,5,3,$iduser,$store_person_list);			
					}
					else
					{
						//--send to MD
						$data2=array(
								'stage'=>"11",
								'aproved_by'=>"$iduser",
								'aproved_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
						$this->Pomodel->po_action_email($po_id,11,4,3,$iduser,$md_list);	
					}
				}//satge2
				if($current_status==11)
				{
					$data2=array(
								'stage'=>"4",
								'aproved_by'=>"$iduser",
								'aproved_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
					//$this->Pomodel->po_action_email_to_creater($po_id,$iduser);	
					$this->Pomodel->po_action_email($po_id,4,5,3,$iduser,$store_person_list);	
				}//satge2
				if($current_status==4)
				{
					$data2=array(
								'stage'=>"5",
								'mail_send_by'=>"$iduser",
								'mail_send_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);	
				}//satge2
				//----------------------------------update				
				$where2=array('po_id'=>"$po_id");   
				$this->Mymodel->update('po_entry',$data2,$where2);
				echo "Save";
				
			}//accept
				
			if($action=='reject')
			{
				$data2=array(
								'stage'=>"3",
								'reject_by'=>"$iduser",
								'reject_date'=>"$today_date",
								'comment'=>"$comment",
								'update_by'=>"$iduser",
								'update_date'=>"$today_date",
							);
				$where2=array('po_id'=>"$po_id");   
				$this->Mymodel->update('po_entry',$data2,$where2);
				echo "Save";
			}
		}//reject
		else
		{
			echo "Not Save. No Id Found.";
			exit;
		}
	}//function close

	
	
	
	
	
	
	
	
	
	//print
	public function po_print()
	{
		if(strlen($this->uri->segment(3))>0){
			$id = $this->uri->segment(3);
			if(strlen($this->uri->segment(4))>0){$no = $this->uri->segment(4);}else{$no=0;}
			if(strlen($this->uri->segment(5))>0){$no_of_item = $this->uri->segment(5);}else{$no_of_item=10;}
			if(strlen($this->uri->segment(6))>0){$page_no = $this->uri->segment(6);}else{$page_no=1;}
			if(strlen($this->uri->segment(7))>0){$last_page = $this->uri->segment(7);}else{$last_page=0;}

			$result['page_no']=$page_no;
			$result['no_start']=$no;
			$result['last_page']=$last_page;

			$where="po_id='$id'  ";
			$result['res2']=$this->Mymodel->select_where('po_entry',$where);

			$where=" po_entry_id='$id'  LIMIT $no,$no_of_item   ";
			$result['res3']=$this->Mymodel->select_where('po_entry_details',$where);

			$this->load->view('po/print/po_print',$result);
		}
		else{redirect('Welcome/');}
	}//function close
























	//---------------------Invoice without PO
	public function add_invoice()
	{
		$result['supplier'] = $this->Suppliermodel->get_all_active_supplier();
		$result['unit'] = $this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Pomodel->get_po_invoice_details_with_id($id);
			$result['res3'] = $this->Pomodel->get_po_invoice_product_details_with_id($id);
		}
		$this->load->view('po/invoice/entry2',$result);
	}//function close

	//---------------------Invoice with PO
	public function add_invoice2()
	{
		$result['supplier'] = $this->Suppliermodel->get_all_active_supplier();
		$result['unit'] = $this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Pomodel->get_po_invoice_details_with_id($id);
			$result['res3'] = $this->Pomodel->get_po_invoice_product_details_with_id($id);
		}
		$this->load->view('po/invoice/entry',$result);
	}//function close


	public function add_invoice_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['old_entry_date'])){$old_entry_date=$_REQUEST['old_entry_date'];}else{$old_entry_date='';}
		if(isset($_REQUEST['old_invoice_no'])){$old_invoice_no=$_REQUEST['old_invoice_no'];}else{$old_invoice_no='';}
		if(isset($_REQUEST['supplier_id'])){$supplier_id=$_REQUEST['supplier_id'];}else{$supplier_id='';}
		if(isset($_REQUEST['product_invoice_save_date']))
		{ 
			$product_invoice_save_date1 = $this->Base->change_date_ymd($_REQUEST['product_invoice_save_date']);
			$product_invoice_save_no = $this->Pomodel->get_next_invoice_no($product_invoice_save_date1); 
		}else{$product_invoice_save_date1 = date('Y-m-d');$product_invoice_save_no = date('Ymd').'01';}
		if(isset($_REQUEST['invoice_no'])){$invoice_no=$_REQUEST['invoice_no'];}else{$invoice_no='';}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(isset($_REQUEST['raw_material_from'])){$raw_material_from=$_REQUEST['raw_material_from'];}else{$raw_material_from='';}
		
		if(isset($_REQUEST['invoice_date'])){
			$invoice_date1 = $this->Base->change_date_ymd($_REQUEST['invoice_date']);
		}else{$invoice_date1='';}
		if(isset($_REQUEST['transport_mode'])){$transport_mode=$_REQUEST['transport_mode'];}else{$transport_mode='';}
		if(isset($_REQUEST['vehicle_no'])){$vehicle_no=$_REQUEST['vehicle_no'];}else{$vehicle_no='';}
		if(isset($_REQUEST['gate_pass_no'])){$gate_pass_no=$_REQUEST['gate_pass_no'];}else{$gate_pass_no='';}
		if(isset($_REQUEST['same_company'])){$same_company=$_REQUEST['same_company'];}else{$same_company='';}
		if(isset($_REQUEST['total_old'])){$total_old=$_REQUEST['total_old'];}else{$total_old='';}
		if(isset($_REQUEST['dis_per'])){$dis_per=$_REQUEST['dis_per'];}else{$dis_per='';}
		if(isset($_REQUEST['dis_amt'])){$dis_amt=$_REQUEST['dis_amt'];}else{$dis_amt='';}
		if(isset($_REQUEST['total'])){$total=$_REQUEST['total'];}else{$total='';}
		if(isset($_REQUEST['ffc_charge'])){$ffc_charge=$_REQUEST['ffc_charge'];}else{$ffc_charge='';}
		if(isset($_REQUEST['ffc_gst_per'])){$ffc_gst_per=$_REQUEST['ffc_gst_per'];}else{$ffc_gst_per='';}
		if(isset($_REQUEST['ffc_gst_amt'])){$ffc_gst_amt=$_REQUEST['ffc_gst_amt'];}else{$ffc_gst_amt='';}
		if(isset($_REQUEST['ffc_amt'])){$ffc_amt=$_REQUEST['ffc_amt'];}else{$ffc_amt='';}
		if(isset($_REQUEST['gstval'])){$gstval=$_REQUEST['gstval'];}else{$gstval='';}
		if(isset($_REQUEST['gstcharge'])){$gstcharge=$_REQUEST['gstcharge'];}else{$gstcharge='';}
		if(isset($_REQUEST['gst_type'])){$gst_type=$_REQUEST['gst_type'];}else{$gst_type='';}
		if(isset($_REQUEST['gstval2'])){$gstval2=$_REQUEST['gstval2'];}else{$gstval2='';}
		if(isset($_REQUEST['gstcharge2'])){$gstcharge2=$_REQUEST['gstcharge2'];}else{$gstcharge2='';}
		if(isset($_REQUEST['gstval3'])){$gstval3=$_REQUEST['gstval3'];}else{$gstval3='';}
		if(isset($_REQUEST['gstcharge3'])){$gstcharge3=$_REQUEST['gstcharge3'];}else{$gstcharge3='';}
		if(isset($_REQUEST['roundoff'])){$roundoff=$_REQUEST['roundoff'];}else{$roundoff='';}
		if(isset($_REQUEST['amount_weight_sum'])){$amount_weight_sum=$_REQUEST['amount_weight_sum'];}else{$amount_weight_sum='';}
		if(isset($_REQUEST['grandtotal'])){$grandtotal=$_REQUEST['grandtotal'];}else{$grandtotal='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}

		if(isset($_REQUEST['ext_weight_bridge'])){$ext_weight_bridge=$_REQUEST['ext_weight_bridge'];}else{$ext_weight_bridge='';}
		if(isset($_REQUEST['int_weight_bridge'])){$int_weight_bridge=$_REQUEST['int_weight_bridge'];}else{$int_weight_bridge='';}
		if(isset($_REQUEST['diff_weight_bridge'])){$diff_weight_bridge=$_REQUEST['diff_weight_bridge'];}else{$diff_weight_bridge='';}
		if(isset($_REQUEST['coil_wise_details'])){$coil_wise_details=$_REQUEST['coil_wise_details'];}else{$coil_wise_details='';}
		//--------------------------------------row
		if(isset($_REQUEST['details_id'])){$details_id=explode('~',$_REQUEST['details_id']);}else{$details_id='';}
		if(isset($_REQUEST['oldqty'])){$oldqty=explode('~',$_REQUEST['oldqty']);}else{$oldqty='';}
		if(isset($_REQUEST['oldamt'])){$oldamt=explode('~',$_REQUEST['oldamt']);}else{$oldamt='';}
		if(isset($_REQUEST['oldlot'])){$oldlot=explode('~',$_REQUEST['oldlot']);}else{$oldlot='';}
		if(isset($_REQUEST['oldgrade'])){$oldgrade=explode('~',$_REQUEST['oldgrade']);}else{$oldgrade='';}
		if(isset($_REQUEST['oldpoid'])){$oldpoid=explode('~',$_REQUEST['oldpoid']);}else{$oldpoid='';}
		if(isset($_REQUEST['oldqc'])){$oldqc=explode('~',$_REQUEST['oldqc']);}else{$oldqc='';}
		if(isset($_REQUEST['oldproduct'])){$oldproduct=explode('~',$_REQUEST['oldproduct']);}else{$oldproduct='';}
		if(isset($_REQUEST['oldpkg'])){$oldpkg=explode('~',$_REQUEST['oldpkg']);}else{$oldpkg='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);}else{$goods='';}
		if(isset($_REQUEST['poid'])){$poid=explode('~',$_REQUEST['poid']);}else{$poid='';}
		if(isset($_REQUEST['totalqty'])){$totalqty=explode('~',$_REQUEST['totalqty']);}else{$totalqty='';}
		if(isset($_REQUEST['recqty'])){$recqty=explode('~',$_REQUEST['recqty']);}else{$recqty='';}
		if(isset($_REQUEST['amount_weight'])){$net=explode('~',$_REQUEST['amount_weight']);}else{$net='';}
		if(isset($_REQUEST['unitname'])){$unitname=explode('~',$_REQUEST['unitname']);}else{$unitname='';}
		if(isset($_REQUEST['hsn'])){$hsn=explode('~',$_REQUEST['hsn']);}else{$hsn='';}
		if(isset($_REQUEST['package'])){$package=explode('~',$_REQUEST['package']);}else{$package='';}
		
		if(isset($_REQUEST['prePrice'])){$prePrice=explode('~',$_REQUEST['prePrice']);}else{$prePrice='';}
		if(isset($_REQUEST['discount'])){$discount=explode('~',$_REQUEST['discount']);}else{$discount='';}
		if(isset($_REQUEST['price'])){$price=explode('~',$_REQUEST['price']);}else{$price='';}
		
		if(isset($_REQUEST['total_amount'])){$amount=explode('~',$_REQUEST['total_amount']);$no_of_row=count($amount);}else{$amount='';$no_of_row='';}
		if(isset($_REQUEST['itemsgst'])){$itemsgst=explode('~',$_REQUEST['itemsgst']);}else{$itemsgst='';}
		if(isset($_REQUEST['itemcgst'])){$itemcgst=explode('~',$_REQUEST['itemcgst']);}else{$itemcgst='';}
		if(isset($_REQUEST['itemigst'])){$itemigst=explode('~',$_REQUEST['itemigst']);}else{$itemigst='';}
		if(isset($_REQUEST['itemgstrs'])){$itemgstrs=explode('~',$_REQUEST['itemgstrs']);}else{$itemgstrs='';}
		if(isset($_REQUEST['notrepeat'])){$notrepeat=explode('~',$_REQUEST['notrepeat']);}else{$notrepeat='';}
		//--------------------------------------row
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['supplier_id']))
		{
			//-------------------------------------------------checking invoice is already exites or not start
			$where3=" supplier_id='$supplier_id' and invoice_no='$invoice_no' and invoice_date='$invoice_date1'    ";
			$out=$this->Mymodel->select_where('product_invoice_entry',$where3);
			if(!empty($out))
			{
				echo "Not Save. Invoice No: $invoice_no and Invoice date $invoice_date1 is Already Exits.";
				exit;
			}
			//-------------------------------------------------checking invoice is already exites or not end
			
			$data = array(
							'type'=>"$type",
							'supplier_id'=>"$supplier_id",
							'invoice_no'=>"$invoice_no",
							'invoice_date'=>"$invoice_date1",
							'transport_mode'=>"$transport_mode",
							'vehicle_no'=>"$vehicle_no", 
							'raw_material_from'=>"$raw_material_from",
							'gate_pass_no'=>"$gate_pass_no",
							'purchase_dept'=>"",
							'product_invoice_save_date'=>"$product_invoice_save_date1",
							'product_invoice_save_no'=>"$product_invoice_save_no",
							'total_old'=>"$total_old",
							'dis_per'=>"$dis_per",
							'dis_amt'=>"$dis_amt",
							'total'=>"$total",
							'ffc_charge'=>"$ffc_charge",
							'ffc_gst_per'=>"$ffc_gst_per",
							'ffc_gst_amt'=>"$ffc_gst_amt",
							'ffc_amt'=>"$ffc_amt",
							'gst_type'=>"$gst_type",
							'gstcharge'=>"$gstcharge",
							'roundoff'=>"$roundoff",
							'amount_weight_sum'=>"$amount_weight_sum",
							'grandtotal'=>"$grandtotal",
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							'status'=>"Active",
							'ext_weight_bridge'=>"$ext_weight_bridge",
							'int_weight_bridge'=>"$int_weight_bridge",
							'diff_weight_bridge'=>"$diff_weight_bridge",
							'coil_wise_details'=>"$coil_wise_details",
							'remarks'=>"$remarks",
							'same_company'=>"$same_company",
					);
			$product_invoice_entry_id=$this->Mymodel->insertdata_withid('product_invoice_entry',$data);
			if($product_invoice_entry_id>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($net[$i]>0 and $goods[$i]>0)
					{
						//item repeated or not
						if($notrepeat[$i]!=1){$randam_no=$i+1;}else{$randam_no=0;}
						
						//row matrial or not
						$out7 = $this->Productmodel->get_product_data_with_id($goods[$i]);
						//$is_it_row_mat = $out7[0]['row_mat_puc']; // if yes than it will go to qulatity 
						$is_it_row_mat =0;
						if($is_it_row_mat != 1) // or qc check == 0
						{
							//it is not raw matrial than update stock or po
							//---update stock and balance
							$data7 = array($goods[$i],'','',$net[$i],$amount[$i],$package[$i],0);
							$this->Storemodel->update_stock("ADD","Invoice Entry $product_invoice_entry_id",$data7);
							//---update PO
							if(!empty($poid[$i]))
							{
								$this->Pomodel->recieve_qty_amount($poid[$i],$net[$i],$amount[$i]);
							}
							
						}
						if(!empty($poid[$i])){$poid_save = $poid[$i]; }else{$poid_save = '';}
						if(!empty($totalqty[$i])){$totalqty_save = $poid[$i]; }else{$totalqty_save = '';}
						if(!empty($recqty[$i])){$recqty_save = $poid[$i]; }else{$recqty_save = '';}
					
						$data2=array();
						$data2=array(
										'product_invoice_entry_id'=>"$product_invoice_entry_id",
										'product_invoice_save_no'=>"$product_invoice_save_no",
										'invoice_no'=>"$invoice_no",
										'invoice_date'=>"$invoice_date1",
										'supplier_id'=>"$supplier_id",
										'product_id'=>"$goods[$i]",
										'hsn'=>"$hsn[$i]",
										'package'=>"$package[$i]",
										'net'=>"$net[$i]",
										'unitname_id'=>"$unitname[$i]",
										'prePrice'=>"$prePrice[$i]",
										'discount'=>"$discount[$i]",
										'price'=>"$price[$i]",
										'amount'=>"$amount[$i]",
										'notrepeat'=>"$randam_no",
										'poid'=>"$poid_save",
										'total_po_qty'=>"$totalqty_save",
										'total_rec'=>"$recqty_save",
										'qc_check'=>"$is_it_row_mat",
										'itemsgst'=>"$itemsgst[$i]",
										'itemcgst'=>"$itemcgst[$i]",
										'itemigst'=>"$itemigst[$i]",
										'itemgstrs'=>"$itemgstrs[$i]",
										'details_save_date'=>"$product_invoice_save_date1",
										'save_by'=>"$user_email",
										'save_date'=>"$today",
						);
						$this->Mymodel->insertdata('product_invoice_entry_details',$data2);
					}//amount
				}//for loop
			}//product_invoice_entry_id
			
			echo "Save";
		}//insert
		
		
	
		
		//----------------------------------------------------------------------update
		if(!empty($_REQUEST['id']) and !empty($_REQUEST['supplier_id']))
		{
			//-------------------------------------------------checking invoice is already exites or not start
			$where3=" supplier_id='$supplier_id' and invoice_no='$invoice_no' and invoice_date='$invoice_date1'    ";
			$out=$this->Mymodel->select_where('product_invoice_entry',$where3);
			if(!empty($out) and $out[0]['product_invoice_entry_id'] != $_REQUEST['id'])
			{
				echo "Not Save. Invoice No: $invoice_no and Invoice date $invoice_date is Already Exits.";
				exit;
			}
			
			$data = array(
							'type'=>"$type",
							'supplier_id'=>"$supplier_id",
							'invoice_no'=>"$invoice_no",
							'invoice_date'=>"$invoice_date1",
							'transport_mode'=>"$transport_mode",
							'vehicle_no'=>"$vehicle_no",
							'gate_pass_no'=>"$gate_pass_no",
							'raw_material_from'=>"$raw_material_from",
							'purchase_dept'=>"",
							'total_old'=>"$total_old",
							'dis_per'=>"$dis_per",
							'dis_amt'=>"$dis_amt",
							'total'=>"$total",
							'ffc_charge'=>"$ffc_charge",
							'ffc_gst_per'=>"$ffc_gst_per",
							'ffc_gst_amt'=>"$ffc_gst_amt",
							'ffc_amt'=>"$ffc_amt",
							'gst_type'=>"$gst_type",
							'gstcharge'=>"$gstcharge",
							'roundoff'=>"$roundoff",
							'amount_weight_sum'=>"$amount_weight_sum",
							'grandtotal'=>"$grandtotal",
							'update_by'=>"$user_email",
							'update_date'=>"$today",
							'remarks'=>"$remarks",
							'ext_weight_bridge'=>"$ext_weight_bridge",
							'int_weight_bridge'=>"$int_weight_bridge",
							'diff_weight_bridge'=>"$diff_weight_bridge",
							'coil_wise_details'=>"$coil_wise_details",
							'same_company'=>"$same_company",
					);
			$where=array('product_invoice_entry_id'=>"$id");   
			$this->Mymodel->update('product_invoice_entry',$data,$where);
			$product_invoice_entry_id=$id;//--------------------------------------------new no
			$product_invoice_save_date1=$old_entry_date;//------------------------------new date
			$product_invoice_save_no=$old_invoice_no;//---------------------------------new invoice no
			if($product_invoice_entry_id>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($net[$i]>0 and $goods[$i]>0)
					{
						if(!empty($poid[$i])){$poid_save = $poid[$i]; }else{$poid_save = '';}
						if(!empty($totalqty[$i])){$totalqty_save = $poid[$i]; }else{$totalqty_save = '';}
						if(!empty($recqty[$i])){$recqty_save = $poid[$i]; }else{$recqty_save = '';}

						//update
						$data2=array();
						if($details_id[$i]>0)
						{
							$id2=$details_id[$i];
							$data2=array(
										'invoice_no'=>"$invoice_no",
							 			'invoice_date'=>"$invoice_date1",
										'supplier_id'=>"$supplier_id",
										
										'product_id'=>"$goods[$i]",
										'hsn'=>"$hsn[$i]",
										'package'=>"$package[$i]",
										'net'=>"$net[$i]",
										'unitname_id'=>"$unitname[$i]",
										'prePrice'=>"$prePrice[$i]",
										'discount'=>"$discount[$i]",
										'price'=>"$price[$i]",
										'amount'=>"$amount[$i]",
										
										'poid'=>"$poid_save",
										'total_po_qty'=>"$totalqty_save",
										'total_rec'=>"$recqty_save",

										'itemsgst'=>"$itemsgst[$i]",
										'itemcgst'=>"$itemcgst[$i]",
										'itemigst'=>"$itemigst[$i]",
										'itemgstrs'=>"$itemgstrs[$i]",
										
										'details_save_date'=>"$product_invoice_save_date1",
										'update_by'=>"$user_email",
										'update_date'=>"$today",
									);
								$where2=array('details_id'=>"$id2");   
								$this->Mymodel->update('product_invoice_entry_details',$data2,$where2);
								
								if($oldqc[$i]!=1)// qc check == 0
								{
									//---sub update stock and balance
									$data7 = array($oldproduct[$i],$oldlot[$i],$oldgrade[$i],$oldqty[$i],$oldamt[$i],$oldpkg[$i],0);
									$this->Storemodel->update_stock("SUB","SUB Invoice update $product_invoice_entry_id",$data7);
									
									//---sub update PO
									if(!empty($poid[$i]))
									{
										$this->Pomodel->min_recieve_qty_amount($oldpoid[$i],$oldqty[$i],$oldamt[$i]);
									}
									
									//---add update stock and balance
									$data7 = array($goods[$i],$oldlot[$i],$oldgrade[$i],$net[$i],$amount[$i],$package[$i],0);
									$this->Storemodel->update_stock("ADD","add Invoice update $product_invoice_entry_id",$data7);
									//---add update PO
									if(!empty($poid[$i]))
									{
										$this->Pomodel->recieve_qty_amount($poid[$i],$net[$i],$amount[$i]);
									}
									
									
								}//Qc not =1
								
						}//update
						else
						{
							//new entry
								
								//item repeated or not
								if($notrepeat[$i]!=1){$randam_no=$i+1;}else{$randam_no=0;}
								
								//row matrial or not
								$out7 = $this->Productmodel->get_product_data_with_id($goods[$i]);
								$is_it_row_mat = $out7[0]['row_mat_puc']; // if yes than it will go to qulatity 
								if($is_it_row_mat != 1) // or qc check == 0
								{
									//it is not raw matrial than update stock or po
									//---update stock and balance
									$data7 = array($goods[$i],'','',$net[$i],$amount[$i],$package[$i],0);
									$this->Storemodel->update_stock("ADD","Invoice Entry $product_invoice_entry_id",$data7);
									//---update PO
									if(!empty($poid[$i]))
									{
										$this->Pomodel->recieve_qty_amount($poid[$i],$net[$i],$amount[$i]);
									}
									
								}
								
								$data2=array();
								$data2=array(
												'product_invoice_entry_id'=>"$product_invoice_entry_id",
												'product_invoice_save_no'=>"$product_invoice_save_no",
												'invoice_no'=>"$invoice_no",
												'invoice_date'=>"$invoice_date1",
												'supplier_id'=>"$supplier_id",
												'product_id'=>"$goods[$i]",
												'hsn'=>"$hsn[$i]",
												'package'=>"$package[$i]",
												'net'=>"$net[$i]",
												'unitname_id'=>"$unitname[$i]",
												'prePrice'=>"$prePrice[$i]",
												'discount'=>"$discount[$i]",
												'price'=>"$price[$i]",
												'amount'=>"$amount[$i]",
												'notrepeat'=>"$randam_no",
												
												'poid'=>"$poid_save",
												'total_po_qty'=>"$totalqty_save",
												'total_rec'=>"$recqty_save",
												
												'qc_check'=>"$is_it_row_mat",
												'itemsgst'=>"$itemsgst[$i]",
												'itemcgst'=>"$itemcgst[$i]",
												'itemigst'=>"$itemigst[$i]",
												'itemgstrs'=>"$itemgstrs[$i]",
												'details_save_date'=>"$product_invoice_save_date1",
												'save_by'=>"$user_email",
												'save_date'=>"$today",
								);
							$this->Mymodel->insertdata('product_invoice_entry_details',$data2);
						}//new insert
					}//amount
				}//for
			}//id
			
			echo "Update";
		}//update
		
		
	}//function close



	public function invoice_list()
	{
		$today=date("Y-m-d");
		$result['supplier'] = $this->Suppliermodel->get_all_active_supplier();
		if(isset($_REQUEST['search1']))
		{
			$where = " and A.status='Active' "; 
			if(!empty($_REQUEST['supplier'])){$supplier=$_REQUEST['supplier'];$where.=" and  A.supplier_id ='$supplier'   ";}
			if(!empty($_REQUEST['invoice_no'])){$invoice_no=$_REQUEST['invoice_no'];$where.=" and  A.invoice_no ='$invoice_no'   ";}
			if(!empty($_REQUEST['gate_pass'])){$gate_pass=$_REQUEST['gate_pass'];$where.=" and  A.gate_pass_no ='$gate_pass'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.product_invoice_save_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by product_invoice_save_date DESC ";
			$result['res2'] = $this->Pomodel->po_invoice_serach_query($where);
			$this->load->view('po/invoice/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = " and  A.status='Active' and A.product_invoice_save_date between '$search_date1' and '$search_date2'  ORDER by product_invoice_save_date DESC ";
			$result['res2'] = $this->Pomodel->po_invoice_serach_query($where);
			$this->load->view('po/invoice/show',$result);
		}
	}//function close



	public function invoice_list_product()
	{
		$today=date("Y-m-d");
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		if(isset($_REQUEST['search1']))
		{
			$where = "   "; 
			if(!empty($_REQUEST['supplier'])){$supplier=$_REQUEST['supplier'];$where.=" and  B.supplier_id='$supplier'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  A.product_id ='$product'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.details_save_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="   ";
			$result['res2'] = $this->Pomodel->product_group_by_rate($where);
			$this->load->view('po/invoice/show_table2',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where="  and A.details_save_date between '$search_date1' and '$search_date2'   ";
			$result['res2']=$this->Pomodel->product_group_by_rate($where);
			$this->load->view('po/invoice/show2',$result);
		}
	}//function close


	
	public function invoice_list_product_for_rod()
	{
		$today=date("Y-m-d");
		$result['supplier']=$this->Suppliermodel->get_all_active_supplier();
		if(isset($_REQUEST['search1']))
		{
			$where = "   "; 
			if(!empty($_REQUEST['supplier'])){$supplier=$_REQUEST['supplier'];$where.=" and  B.supplier_id='$supplier'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  A.product_id ='$product'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.details_save_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="   ";
			$result['res2'] = $this->Pomodel->product_group_by_rod($where);
			$result['issue']=$_REQUEST['issue'];
			$this->load->view('po/rod/show_table2',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$result['issue']="YES";
			$where="  and A.details_save_date between '$search_date1' and '$search_date2'   ";
			$result['res2']=$this->Pomodel->product_group_by_rod($where);
			$this->load->view('po/rod/show2',$result);
		}
	}//function close



	
	
	
	function fun_get_get_all_coil_made_by_baseCoil_id_popop_wireRod_list()
	{
		if(isset($_REQUEST['rodid']))
		{
			$rodid = $_REQUEST['rodid'];
			$this->Qcmodel->getAllWdCoilsList_from_base_rodid($rodid);
		}
	}//function close

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 

}//close class