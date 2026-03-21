<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

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


	public function update_stock_with_all_product_with_zero_qty()
	{
		$where=" 1=1";
		$res = $this->Mymodel->select_where('product',$where);
		foreach($res as $r)
		{
			$product_id = $r['product_id'];
			$data7 = array($product_id,'','',0,0,0,0);
			$this->Storemodel->update_stock("NEW","New Product",$data7);
		}
		echo "done";
	}//function close


	//-------get grade list form product id
    function get_all_grade_list_with_product_id()
    {
        if(isset($_REQUEST['product_id']))
        {
            $product_id = $_REQUEST['product_id'];
            ?>
                <option value="">Select</option> 
                <option value="None">None</option> 
            <?php
			$out = $this->Storemodel->get_all_grade_list_with_product_id($product_id);
			foreach($out as $c)
            {
                ?>
					<option  value="<?php echo $c['product_grade_id'];?>">
						<?php echo $c['bname'].' (Qty : '.$c['qty'].')';?>
					</option>
				<?php
            }
        }//product id
    }//function close


	//-------get grade list form product id
	function get_all_lotno_list_with_product_id()
	{
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			?>
				<option value="">Select</option> 
				<option value="None">None</option> 
			<?php
			//---------for lotno
			$out = $this->Storemodel->get_all_lotno_list_with_product_id($product_id);
			$i=1;
			foreach($out as $c)
			{
				?>
					<option <?php if($i!=1){echo "disabled";}?> value="<?php echo $c['lotno'];?>">
						<?php echo $c['lotno'].' '.$c['sname'].' (Qty : '.$c['qty'].')';?>
					</option>
				<?php
				$i++;
			}//foreach
		}//product id
	}//function close



	//-------get total qty form product id,grade,lotno
	function get_total_qty_with_product_id_grade_lotno()
	{
  		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			$lotno_val = $_REQUEST['lotno_val'];
			$grade_val = $_REQUEST['grade_val'];
			$res = $this->Storemodel->get_stock_product_lot_grade($product_id,$lotno_val,$grade_val);
			if(isset($res) and count($res)>0){
				$qty = $res[0]['recive_stock_level'];
				$pkg = $res[0]['pkg'];
			}else{
				$qty='0.00';$pkg = 0;
			}
			echo $qty." (P: $pkg)";
		}//product id
	}//function close







	


	//store->list_stock 
	public function list_stock()
	{
		$result['cat2']=$this->Base->get_all_category();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['cat'])){$cat=$_REQUEST['cat'];$where.=" and  P.category_id='$cat'   ";}
			if(!empty($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id']; $where.="and A.product_id='$product_id'  ";}
			$where.=" GROUP by A.product_id,A.product_grade_id ORDER by P.name,P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_product_form_store_with_search($where);
			$this->load->view('store/show_table',$result);
		}
		else
		{
			$default_category =  $this->Productmodel->get_default_category_product_search();
			$where = "  and P.category_id ='$default_category'   GROUP by A.product_id,A.product_grade_id ORDER by P.name,P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_product_form_store_with_search($where);
			$this->load->view('store/show',$result);
		}
	}//function close


	//store->list_stock 
	public function list_stock2()
	{
		$result['cat2']=$this->Base->get_all_category();
		if(isset($_REQUEST['search1']))
		{
			// $where = "";
			// if(!empty($_REQUEST['cat'])){$cat=$_REQUEST['cat'];$where.=" and  P.category_id='$cat'   ";}
			// if(!empty($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id']; $where.="and A.product_id='$product_id'  ";}
			// $where.=" GROUP by A.product_id,A.product_grade_id ORDER by P.name,P.size ASC ";
			// $result['res2'] = $this->Storemodel->get_all_product_form_store_with_search($where);
			// $this->load->view('store/show_table3',$result);
		}
		else
		{
			$default_category =  $this->Productmodel->get_default_category_product_search();
			$where = "  and P.category_id ='$default_category'   GROUP by A.product_id,A.product_grade_id ORDER by P.name,P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_product_form_store_with_search($where);
			$this->load->view('store/show3',$result);
		}
	}//function close


	//store->list_stock 
	public function raw_material_stock()
	{
		$result = array();
		$this->load->view('store/raw_material_stock',$result);
	}//function close



	//store->list_stock_update 
	public function list_stock_update()
	{
		$result['cat2']=$this->Base->get_all_category();
		$result['grade']=$this->Base->get_all_grade();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['cat'])){$cat=$_REQUEST['cat'];$where.=" and  P.category_id='$cat'   ";}
			if(!empty($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id']; $where.="and A.product_id='$product_id'  ";}
			$where.="  ORDER by P.name,P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_product_form_store_with_search_without_group_by($where);
			$this->load->view('store/show_table2',$result);
		}
		else
		{
			$default_category =  $this->Productmodel->get_default_category_product_search();
			$where = "  and P.category_id ='$default_category'  ORDER by P.name,P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_product_form_store_with_search_without_group_by($where);
			$this->load->view('store/show2',$result);
		}
	}//function close

	
	public function stock_update_direct_save()
	{
		if(isset($_REQUEST['productid_id']))
		{
			$productid_id = $_REQUEST['productid_id'];
			if(isset($_REQUEST['totalgrade_val'])){$totalgrade_val = $_REQUEST['totalgrade_val'];}else{$totalgrade_val ='';}
			if(isset($_REQUEST['totalqty_val'])){$totalqty_val = $_REQUEST['totalqty_val'];}else{$totalqty_val ='';}
			if(isset($_REQUEST['totalcost_val'])){$totalcost_val = $_REQUEST['totalcost_val'];}else{$totalcost_val ='';}
			if(isset($_REQUEST['totalpkg_val'])){$totalpkg_val = $_REQUEST['totalpkg_val'];}else{$totalpkg_val ='';}
			if(isset($_REQUEST['status_val'])){$status_val = $_REQUEST['status_val'];}else{$status_val ='';}
			
			$data = array($productid_id,'',$totalgrade_val,$totalqty_val,$totalcost_val,$totalpkg_val,$status_val);
			$this->Storemodel->update_stock("RESET","Reset direct via row",$data);
			echo "Save";
		}
		else{
			echo "No Row ID found.";
			exit;
		}
		
	}//function close





	



	//store->issue_list 
	public function issue_list()
	{
		$result['cat2']=$this->Base->get_all_category();
		$result['dept']=$this->Base->get_all_dept();
		$result['grade']=$this->Base->get_all_grade();
		if(isset($_REQUEST['search1']))
		{
			$where = ""; 
			if(!empty($_REQUEST['issue_no'])){$issue_no=$_REQUEST['issue_no'];$where.=" and  B.indent_no='$issue_no'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  B.dept ='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  B.mc_no ='$mc_no'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade ='$grade'   ";}
			if(!empty($_REQUEST['product_id'])){$product_id=$_REQUEST['product_id'];$where.=" and  A.product_id='$product_id'   ";}
			if(!empty($_REQUEST['req_by'])){$req_by=$_REQUEST['req_by'];$where.=" and  A.receivedby ='$req_by'   ";}
			if(!empty($_REQUEST['cat'])){$cat=$_REQUEST['cat'];$where.=" and  P.category_id ='$cat'   ";}
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  B.stage ='$status'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and B.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" GROUP BY A.details_id ORDER by B.entry_date,B.indent_no DESC ";
			$result['res2'] = $this->Storemodel->store_indent_serach_query($where);
			$this->load->view('store/issue/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = " and B.entry_date between '$search_date1' and '$search_date2' GROUP BY A.details_id ORDER by B.entry_date,B.indent_no DESC ";
			$result['res2'] = $this->Storemodel->store_indent_serach_query($where);
			$this->load->view('store/issue/show',$result);
		}
	}//function close

	//store->issue_list2
	public function issue_list2()
	{
		if(isset($_REQUEST['search_date']))
		{
			$result['search_date'] = $this->Base->change_date_ymd($_REQUEST['search_date']);
			$this->load->view('store/issue/list2',$result);
		}
	}//function close

	




	//issue form stock
	public function issue_request()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Storemodel->get_store_req_slip_with_id($id);
			$result['res3'] = $this->Storemodel->get_store_req_slip_details_with_id($id);
		}//strlen
		$result['dept']=$this->Base->get_all_dept();
		$result['grade']=$this->Base->get_all_grade();
		$this->load->view('store/issue/entry',$result);
	}//function close

	
	
	
	//store/issue/entry
	public function stock_issue_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		if(isset($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date=date('Y-m-d');}
		$vr_no = $this->Storemodel->get_next_issue_slip_no();
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		//if(!empty($_REQUEST['current_stage'])){echo $stage=$_REQUEST['current_stage'];}else{$stage='1';}
		$stage = 2;
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		if(isset($_REQUEST['comment'])){$comment=$_REQUEST['comment'];}else{$comment='';}
		if(isset($_REQUEST['indentor'])){$indentor=$_REQUEST['indentor'];}else{$indentor='';}
		if(isset($_REQUEST['request_by'])){$request_by=$_REQUEST['request_by'];}else{$request_by='';}
		//------------------row
		if(isset($_REQUEST['oldproductid'])){$oldproductid=explode('~',$_REQUEST['oldproductid']);}else{$oldproductid='';}
		if(isset($_REQUEST['oldlotno'])){$oldlotno=explode('~',$_REQUEST['oldlotno']);}else{$oldlotno='';}
		if(isset($_REQUEST['oldgrade'])){$oldgrade=explode('~',$_REQUEST['oldgrade']);}else{$oldgrade='';}
		if(isset($_REQUEST['oldqty'])){$oldqty=explode('~',$_REQUEST['oldqty']);}else{$oldqty='';}
		if(isset($_REQUEST['oldamt'])){$oldamt=explode('~',$_REQUEST['oldamt']);}else{$oldamt='';}
		if(isset($_REQUEST['oldpkg'])){$oldpkg=explode('~',$_REQUEST['oldpkg']);}else{$oldpkg='';}
		if(isset($_REQUEST['detailsid'])){$detailsid=explode('~',$_REQUEST['detailsid']);}else{$detailsid='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);$no_of_row=count($goods);}else{$goods='';$no_of_row=0;}
		if(isset($_REQUEST['goods2'])){$goods2=explode('~',$_REQUEST['goods2']);}else{$goods2='';}
		if(isset($_REQUEST['grade'])){$grade=explode('~',$_REQUEST['grade']);}else{$grade='';}
		if(isset($_REQUEST['lotno'])){$lotno=explode('~',$_REQUEST['lotno']);}else{$lotno='';}
		if(isset($_REQUEST['issueqty'])){$issueqty=explode('~',$_REQUEST['issueqty']);}else{$issueqty='';}
		if(isset($_REQUEST['issuepkg'])){$issuepkg=explode('~',$_REQUEST['issuepkg']);}else{$issuepkg='';}
		if(isset($_REQUEST['receivedby'])){$receivedby=explode('~',$_REQUEST['receivedby']);}else{$receivedby='';}
		

		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
				$data=array(
							  'indent_no'=>"$vr_no",
							  'entry_date'=>"$entry_date",
							  'dept'=>"$dept",
							  'mc_no'=>"$mc_no",
							  'comment'=>"$comment",
							  'indentor'=>"$indentor",
							  'request_by'=>"$request_by",
							  'stage'=>"$stage",
							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							);
				$store_req_id=$this->Mymodel->insertdata_withid('indent_store_req',$data);
				
				if($store_req_id>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						if($issueqty[$i]>0 and $goods[$i]>0)
						{
							$product_id = $goods[$i];
							if($lotno[$i]=='None'){$lotno2='';}else{$lotno2=$lotno[$i];}
							if($grade[$i]=='None'){$grade2='';}else{$grade2=$grade[$i];}
							//geting last rate or this item
							$last_rate = $this->Pomodel->get_product_last_rate_form_invoice($product_id,$lotno2,$grade2,'');
							if($last_rate>0){$amt = round(($issueqty[$i]*$last_rate));}else{$amt=0;}
							
							$data2=array();
							$data2=array(
											'indent_store_req_id'=>"$store_req_id",
											'product_id'=>"$goods[$i]",
											'grade'=>"$grade2",
											'lotno'=>"$lotno2",
											'issuequnt'=>"$issueqty[$i]",
											'receivedby'=>"$receivedby[$i]",
											'amt'=>"$amt",
											'pkg'=>"$issuepkg[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$detailsid2 = $this->Mymodel->insertdata_withid('indent_store_req_details',$data2);
							
							//update into stock table
							if($stage==2){
								$data7 = array($product_id,$lotno2,$grade2,$issueqty[$i],$amt,$issuepkg[$i],0);
								$this->Storemodel->update_stock("SUB","Sub form issue update time details no $detailsid2",$data7);
								//$this->Wip->product_issue($goods[$i],$grade2,$lotno2,$issueqty[$i]);
							}
						}//amount
					}//for loop
				}//id
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'dept'=>"$dept",
						'mc_no'=>"$mc_no",
						'comment'=>"$comment",
						'indentor'=>"$indentor",
						'request_by'=>"$request_by",
						'stage'=>"$stage",
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
			$where=array('indent_store_req_id'=>"$id");   
			$this->Mymodel->update('indent_store_req',$data,$where);
			$store_req_id = $id;
			if($store_req_id>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($issueqty[$i]>0 and $goods[$i]>0)
					{
						$product_id = $goods[$i];
						if($lotno[$i]=='None'){$lotno2='';}else{$lotno2=$lotno[$i];}
						if($grade[$i]=='None'){$grade2='';}else{$grade2=$grade[$i];}
						//geting last rate or this item
						$last_rate = $this->Pomodel->get_product_last_rate_form_invoice($product_id,$lotno2,$grade2,'');
						if($last_rate>0){$amt = round(($issueqty[$i]*$last_rate));}else{$amt=0;}
						
						//update
						if($detailsid[$i]>0)
						{
							//update row
							$detailsid2 = $detailsid[$i];

							$oldproductid2 = $oldproductid[$i];
							$oldlotno2 = $oldlotno[$i];
							$oldgrade2 = $oldgrade[$i];
							$oldqty2 = $oldqty[$i];
							$oldamt2 = $oldamt[$i];
							$oldpkg2 = $oldpkg[$i];
							
							//add into stock table
							if($stage==2){
								$data7 = array($oldproductid2,$oldlotno2,$oldgrade2,$oldqty2,$oldamt2,$oldpkg2,0);
								$this->Storemodel->update_stock("ADD","Add form issue update time details no $detailsid2",$data7);
								//$this->Wip->product_issue($goods[$i],$grade2,$lotno2,$issueqty[$i]);
							}

							$data3=array();
							$data3=array(
											'indent_store_req_id'=>"$store_req_id",
											'product_id'=>"$goods[$i]",
											'grade'=>"$grade2",
											'lotno'=>"$lotno2",
											'issuequnt'=>"$issueqty[$i]",
											'receivedby'=>"$receivedby[$i]",
											'amt'=>"$amt",
											'pkg'=>"$issuepkg[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							
							$where3 = array('details_id'=>"$detailsid2");   
							$this->Mymodel->update('indent_store_req_details',$data3,$where3);
							if($stage==2){
								//sub into stock table
								$data7 = array($product_id,$lotno2,$grade2,$issueqty[$i],$amt,$issuepkg[$i],0);
								$this->Storemodel->update_stock("SUB","Sub form issue update time details no $detailsid2",$data7);
								//$this->Wip->product_issue($goods[$i],$grade2,$lotno2,$issueqty[$i]);
							}
						}
						else
						{
							//new insert 
							
							$data2=array();
							$data2=array(
											'indent_store_req_id'=>"$store_req_id",
											'product_id'=>"$goods[$i]",
											'grade'=>"$grade2",
											'lotno'=>"$lotno2",
											'issuequnt'=>"$issueqty[$i]",
											'receivedby'=>"$receivedby[$i]",
											'amt'=>"$amt",
											'pkg'=>"$issuepkg[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$detailsid2 = $this->Mymodel->insertdata_withid('indent_store_req_details',$data2);
							//sub into stock table
							if($stage==2){
								$data7 = array($product_id,$lotno2,$grade2,$issueqty[$i],$amt,$issuepkg[$i],0);
								$this->Storemodel->update_stock("SUB","Sub form issue update time details no $detailsid2",$data7);
								//$this->Wip->product_issue($goods[$i],$grade2,$lotno2,$issueqty[$i]);
							}
						}//if($detailsid[$i]>0)
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







	






	//------------------------------------------------------------------------------Stock
	//store->stocklist 
	public function stocklist()
	{
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.stock_dept='$dept'   ";}
			if(!empty($_REQUEST['size'])){$size=$_REQUEST['size'];$where.=" and  P.product_id='$size'   ";}
			if(!empty($_REQUEST['dia'])){$dia=$_REQUEST['dia'];$where.=" and  A.dia='$dia'   ";}
			if(!empty($_REQUEST['oil'])){$oil=$_REQUEST['oil'];$where.=" and  A.oil='$oil'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade_id='$grade'   ";}
			if(!empty($_REQUEST['unit'])){$unit=$_REQUEST['unit'];$where.=" and  A.unit='$unit'   ";}
			
			
			$where.="  ORDER by P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_stock_with_search($where);
			$this->load->view('stock/show_table',$result);
		}
		else
		{
			$where = "  and A.stock_dept ='FG'   ORDER by P.size ASC ";
			$result['res2'] = $this->Storemodel->get_all_stock_with_search($where);
			$this->load->view('stock/show',$result);
		}
	}//function close



	//delete stock 
	public function stockDelete()
	{
		if(isset($_REQUEST['search1']) and !empty($_REQUEST['stockid']))
		{
			$stockid = $_REQUEST['stockid'];
			$where9=array('stock_id'=>"$stockid");   
			$this->Mymodel->deletedata('stock',$where9);
			echo "Item Deleted";
		}
		else
		{
			echo "Id not found";
			exit;
		}
	}//function close





	//FG stock add
	public function update_stock_via_id($inout_id,$flag)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');

		$out = $this->Storemodel->get_stockinout_id($inout_id);
		if(!empty($out)){
			$stock_dept = $out[0]['stock_dept'];
			$size = $out[0]['size'];
			$dia = $out[0]['dia'];
			$oil = $out[0]['oil'];
			$grade_id = $out[0]['grade_id'];
			$no_of_coils = $out[0]['no_of_coils'];
			$weight = $out[0]['weight'];
			$unit = $out[0]['unit'];

			//setect id form stock
			$where = " 	and stock_dept='$stock_dept' 
						and size='$size' 
						and dia='$dia' 
						and oil='$oil' 
						and grade_id='$grade_id' 
						and unit='$unit' 
						";
			$stock = $this->Storemodel->get_qty_stock_with_search($where);
			if(!empty($stock)){
				//update stock with add new qty
				$stock_id = $stock[0]['stock_id'];
				if($flag == 'ADD'){
					$updated_no_of_coils = (float)$stock[0]['no_of_coils'] + (float)$no_of_coils;
					$updated_weight = (float)$stock[0]['weight'] + (float)$weight;
				}
				else if($flag == 'SUB'){
					$updated_no_of_coils = (float)$stock[0]['no_of_coils'] - (float)$no_of_coils;
					$updated_weight = (float)$stock[0]['weight'] - (float)$weight;
				}
				//update stock
				$data=array(
					'no_of_coils'=>"$updated_no_of_coils",
					'weight'=>"$updated_weight",
					'update_by'=>"$user_email",
					'update_date'=>"$today",
				);
				$where=array('stock_id'=>"$stock_id");   
				$this->Mymodel->update('stock',$data,$where);
			}else{
				//new Entry 
				$data=array(
					'stock_dept'=>"$stock_dept",
					'size'=>"$size",
					'dia'=>"$dia",
					'oil'=>"$oil",
					'grade_id'=>"$grade_id",
					'no_of_coils'=>"$no_of_coils",
					'weight'=>"$weight",
					'unit'=>"$unit",
					'save_by'=>"$user_email",
					'save_date'=>"$today",
				);
				$this->Mymodel->insertdata('stock',$data);
			}//if(!empty($stock)){
		}//if(!empty($out)){
	}//function close





	//FG stock list
	public function receive_stock_entry()
	{
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Storemodel->get_stockinout_id($id);
		}//strlen
		$this->load->view('stock/inout/receive',$result);
	}//function close


	//FG stock_inout list
	//store->stock->inout->show
	public function stockinoutlist()
	{
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.stock_dept='$dept'   ";}
			if(!empty($_REQUEST['inout'])){$inout=$_REQUEST['inout'];$where.=" and  A.inout='$inout'   ";}
			if(!empty($_REQUEST['in_from'])){$in_from=$_REQUEST['in_from'];$where.=" and  A.in_from='$in_from'   ";}
			if(!empty($_REQUEST['inout'])){$inout=$_REQUEST['inout'];$where.=" and  A.inout='$inout'   ";}
			if(!empty($_REQUEST['size'])){$size=$_REQUEST['size'];$where.=" and  P.product_id='$size'   ";}
			if(!empty($_REQUEST['dia'])){$dia=$_REQUEST['dia'];$where.=" and  A.dia='$dia'   ";}
			if(!empty($_REQUEST['oil'])){$oil=$_REQUEST['oil'];$where.=" and  A.oil='$oil'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade_id='$grade'   ";}
			if(!empty($_REQUEST['unit'])){$unit=$_REQUEST['unit'];$where.=" and  A.unit='$unit'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			
			$where.="  ORDER by A.entry_date,A.size,A.grade_id ASC ";
			$result['res2'] = $this->Storemodel->get_all_inout_stock_with_search($where);
			$this->load->view('stock/inout/show_table',$result);
		}
		else
		{
			$entry_date = date('Y-m-d');
			$where = " and A.entry_date= '$entry_date' and A.stock_dept ='FG'   ORDER by A.entry_date,A.size,A.grade_id ASC ";
			$result['res2'] = $this->Storemodel->get_all_inout_stock_with_search($where);
			$this->load->view('stock/inout/show',$result);
		}
	}//function close

	
	
	public function receive_stock_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{ echo "Dept. Not Found";exit;}
		if(isset($_REQUEST['in_from'])){$in_from=$_REQUEST['in_from'];}else{ echo "Receive From. Not Found";exit;}
		if(isset($_REQUEST['size'])){$size=$_REQUEST['size'];}else{ echo "size. Not Found";exit;}
		if(isset($_REQUEST['dia'])){$dia=$_REQUEST['dia'];}else{ echo "dia. Not Found";exit;}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{ echo "grade. Not Found";exit;}
		if(isset($_REQUEST['oil'])){$oil=$_REQUEST['oil'];}else{ echo "oil. Not Found";exit;}
		if(isset($_REQUEST['no_of_coils'])){$no_of_coils=$_REQUEST['no_of_coils'];}else{ echo "no_of_coils. Not Found";exit;}
		if(isset($_REQUEST['weight'])){$weight=$_REQUEST['weight'];}else{ echo "weight. Not Found";exit;}
		if(isset($_REQUEST['unit'])){$unit=$_REQUEST['unit'];}else{ echo "unit. Not Found";exit;}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{ $remarks= '';}
		
		//checked coils
		if (isset($_REQUEST['allcheckBox'])) {$allcheckBox = $_REQUEST['allcheckBox'];} else {$allcheckBox = '';}
		if (isset($_REQUEST['checkedBox'])) {$checkedBox = $_REQUEST['checkedBox'];} else {$checkedBox = '';}
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['stock_inout_id']))
		{
			
			$data=array(
							'entry_date'=>"$entry_date",
							'inout'=>"IN",
							'stock_dept'=>"$dept",
							'in_from'=>"$in_from",
							'size'=>"$size",
							'dia'=>"$dia",
							'oil'=>"$oil",
							'grade_id'=>"$grade",
							'no_of_coils'=>"$no_of_coils",
							'weight'=>"$weight",
							'unit'=>"$unit",
							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
				$stock_inout_id=$this->Mymodel->insertdata_withid('stock_inout',$data);
				$this->update_stock_via_id($stock_inout_id,'ADD');//add old qty in stock

				//update in QC table
				if(!empty($checkedBox)){
					$checkedBox_str2 = implode(",", $checkedBox);
					$data = array('issue_to_despatch' => "1",'stock_in_id' => "$stock_inout_id");
					$where = " id  in ($checkedBox_str2) ";
					$this->Mymodel->update('qc_test1', $data, $where);
				}
				echo "Save";
		}//insert
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['stock_inout_id']))
		{
			$stock_inout_id =$_REQUEST['stock_inout_id'];
			$this->update_stock_via_id($stock_inout_id,'SUB');//sub old qty in stock
			$data=array(
							'entry_date'=>"$entry_date",
							'stock_dept'=>"$dept",
							'in_from'=>"$in_from",
							'size'=>"$size",
							'dia'=>"$dia",
							'oil'=>"$oil",
							'grade_id'=>"$grade",
							'no_of_coils'=>"$no_of_coils",
							'weight'=>"$weight",
							'unit'=>"$unit",
							'remarks'=>"$remarks",
							  
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
				$where=array('stock_inout_id'=>"$stock_inout_id");   
				$this->Mymodel->update('stock_inout',$data,$where);
				$this->update_stock_via_id($stock_inout_id,'ADD');//add old qty in stock
				
				//unckeck all  in QC table
				if(!empty($allcheckBox)){
					$allcheckBox_str = implode(",", $allcheckBox);
					$data = array('issue_to_despatch' => "0",'stock_in_id' => "");
					$where = " id  in ($allcheckBox_str) ";
					$this->Mymodel->update('qc_test1', $data, $where);
				}
				

				//update in QC table
				if(!empty($checkedBox)){
					$checkedBox_str2 = implode(",", $checkedBox);
					$data = array('issue_to_despatch' => "1",'stock_in_id' => "$stock_inout_id");
					$where = " id  in ($checkedBox_str2) ";
					$this->Mymodel->update('qc_test1', $data, $where);
				}
				
				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close






	
	//FG stock list
	public function despatch_stock_entry()
	{
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Storemodel->get_stockinout_id($id);
		}//strlen
		$this->load->view('stock/inout/despatch',$result);
	}//function close

	public function despatch_stock_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		
		
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{ echo "Dept. Not Found";exit;}
		if(isset($_REQUEST['out_to'])){$out_to=$_REQUEST['out_to'];}else{ echo "Despatch To Not Found";exit;}
		if(isset($_REQUEST['size'])){$size=$_REQUEST['size'];}else{ echo "size. Not Found";exit;}
		if(isset($_REQUEST['dia'])){$dia=$_REQUEST['dia'];}else{ echo "dia. Not Found";exit;}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{ echo "grade. Not Found";exit;}
		if(isset($_REQUEST['oil'])){$oil=$_REQUEST['oil'];}else{ echo "oil. Not Found";exit;}
		if(isset($_REQUEST['no_of_coils'])){$no_of_coils=$_REQUEST['no_of_coils'];}else{ echo "no_of_coils. Not Found";exit;}
		if(isset($_REQUEST['weight'])){$weight=$_REQUEST['weight'];}else{ echo "weight. Not Found";exit;}
		if(isset($_REQUEST['unit'])){$unit=$_REQUEST['unit'];}else{ echo "unit. Not Found";exit;}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{ $remarks= '';}
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['stock_inout_id']))
		{
			
			$data=array(
							'entry_date'=>"$entry_date",
							'inout'=>"OUT",
							'stock_dept'=>"$dept",
							'out_to'=>"$out_to",
							'size'=>"$size",
							'dia'=>"$dia",
							'oil'=>"$oil",
							'grade_id'=>"$grade",
							'no_of_coils'=>"$no_of_coils",
							'weight'=>"$weight",
							'unit'=>"$unit",
							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
				$stock_inout_id=$this->Mymodel->insertdata_withid('stock_inout',$data);
				$this->update_stock_via_id($stock_inout_id,'SUB');//add old qty in stock
				echo "Save";
		}//insert
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['stock_inout_id']))
		{
			$stock_inout_id =$_REQUEST['stock_inout_id'];
			$this->update_stock_via_id($stock_inout_id,'ADD');//sub old qty in stock
			$data=array(
							'entry_date'=>"$entry_date",
							'stock_dept'=>"$dept",
							'out_to'=>"$out_to",
							'size'=>"$size",
							'dia'=>"$dia",
							'oil'=>"$oil",
							'grade_id'=>"$grade",
							'no_of_coils'=>"$no_of_coils",
							'weight'=>"$weight",
							'unit'=>"$unit",
							'remarks'=>"$remarks",
							  
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
				$where=array('stock_inout_id'=>"$stock_inout_id");   
				$this->Mymodel->update('stock_inout',$data,$where);
				$this->update_stock_via_id($stock_inout_id,'SUB');//add old qty in stock
				echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	
	}//function close
	
	
	
	

}//close class
