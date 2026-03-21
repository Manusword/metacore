<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajex extends CI_Controller {
	
	
	function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');
		
		$user_email=$this->session->userdata('login_username');
		if(!$user_email>0){redirect('welcome/');}
	}//function close



	
	

	public function index()
	{
		redirect('welcome/');
	}



	public function test()
	{
		print_r($_REQUEST['state']);
	}
	
	

	
	public function customer_gst()
	{
			$gst=$_REQUEST['gst'];
		
			$where=" gst_no='$gst' ";
			$res_chk=$this->Mymodel->select_where('customer',$where);
			if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
			if(isset($id2))
			{
				echo "$gst GST NO Already Available";
			}
	}
	
	
	/*
	public function fun_check_email()
	{
			$email=$_REQUEST['email'];
		
			$where=" email='$email' ";
			$res_chk=$this->Mymodel->select_where('login',$where);
			if(!empty($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['emp_id'];}
			if(!empty($id2))
			{
				echo "$email Already Available";
			}
			
	}
	
	
	public function fun_check_emp_code()
	{
			$emp_code=$_REQUEST['id'];
		
			$where=" emp_code='$emp_code' ";
			$res_chk=$this->Mymodel->select_where('employee',$where);
			if(!empty($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['emp_id'];}
			if(!empty($id2))
			{
				echo "$emp_code Already Exits";
			}
			
	}
	*/
	
	
	
	public function delete_po_details()
	{
			if(isset($_REQUEST['po_details_val2']) and $_REQUEST['po_details_val2']>0)
			{
				$id=$_REQUEST['po_details_val2'];
			
				$where9=" po_entry_details_id='$id' ";
				$this->Mymodel->deletedata('po_entry_details',$where9);
				echo "Deleted";
			}
			else
			{
				echo "No Id Found.";
			}
	}//delete






	

	public function popup_notification_from_header()
	 {
		if(isset($_REQUEST['id']))
		{
			echo $id = $_REQUEST['id'];
		 	echo "manu";
		}
	}//function close





	

	public function get_goods_from_cat()
	 {
		if(isset($_REQUEST['cat_val']))
		{
			$cat_val = $_REQUEST['cat_val'];
			$where=" category_id='$cat_val' and status='Active'  ORDER by name ASC ";
			$product=$this->Mymodel->select_where('product',$where);
			?>
            <option value="">Select</option>
			<?php
			foreach($product as $p)
			{
			?>
				<option value="<?php echo $p['product_id'];?>"><?php echo $p['name'];?></option>
			<?php
			}
		}
	 }//function close

	 /*


	public function get_unit_from_good()
	 {
	
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			$supplier_id = $_REQUEST['supplier_id'];
			
			$where=" product_id='$product_id' ";
			$product=$this->Mymodel->select_where('product',$where);
			if(isset($product[0]['unit_id']))
			{
				$product_unit=$product[0]['unit_id'];
			}
			else
			{
				$product_unit='1';
			}
			
			//geting last po rate
			$where=" supplier_id='$supplier_id' and  product_id='$product_id' ORDER BY po_no DESC LIMIT 1";
			$out=$this->Mymodel->select_where('po_entry_details',$where);
			if(isset($out[0]['rate']))
			{
				$rate=$out[0]['rate'];
				$rate_disc=$out[0]['disc'];
				$rate_net=$out[0]['net'];
				$po_entry_id=$out[0]['po_entry_id'];
			}
			else
			{
				$rate='';
				$rate_disc='';
				$rate_net='';
				$po_entry_id='';
			}
			

			//geting last HSN
			$where=" product_id='$product_id' and hsn!='' ORDER BY po_no DESC LIMIT 1";
			$out=$this->Mymodel->select_where('po_entry_details',$where);
			if(isset($out[0]['hsn']))
			{
				$hsn=$out[0]['hsn'];
			}
			else
			{
				$hsn='';
			}


			//geting last IGST 
			$where=" product_id='$product_id' and itemigst!='' ORDER BY po_no DESC LIMIT 1";
			$out=$this->Mymodel->select_where('po_entry_details',$where);
			if(isset($out[0]['itemigst']))
			{
				$itemigst=$out[0]['itemigst'];
			}
			else
			{
				$itemigst='';
			}
			
			//geting last CGST and SGST 
			$where=" product_id='$product_id' and itemcgst!='' and itemsgst!='' ORDER BY po_no DESC LIMIT 1";
			$out=$this->Mymodel->select_where('po_entry_details',$where);
			if(isset($out[0]['itemcgst']))
			{
				$itemcgst=$out[0]['itemcgst'];
				$itemsgst=$out[0]['itemsgst'];
			}
			else
			{
				$itemcgst='';
				$itemsgst='';
			}
			
			$gst_details = " SGST = $itemsgst, CGST = $itemcgst, IGST = $itemigst  ";
			


			//-----checking pcc file is aviable or not
			if($po_entry_id>0)
			{
				$where=" po_id='$po_entry_id'";
				$out2=$this->Mymodel->select_where('po_entry',$where);
				if(isset($out2[0]['pcc_img_status']) and $out2[0]['pcc_img_status']==1)
				{
					$pcc_img_status='YES';
				}
				else
				{
					$pcc_img_status='NO';
				}
			}
			else
			{
				$pcc_img_status='NO';
			}
			
			echo $product_unit.'~'.$rate.'~'.$pcc_img_status.'~'.$hsn.'~'.$gst_details.'~'.$rate_disc.'~'.$rate_net;
			
		}
	 }//function close
	 */




	public function get_qty_from_good()
	 {
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			$where=" product_id='$product_id' ";
			$product=$this->Mymodel->select_where('product_stock',$where);
			echo $product[0]['recive_stock_level'];
            
		}
	 }//function close
	
	
	
	
	//check product name is valid
	public function check_pro_name_valid()
	 {
		if(isset($_REQUEST['product_val']))
		{
			$product_name = $_REQUEST['product_val'];
			$where=" name='$product_name' ";
			$out=$this->Mymodel->select_where('product',$where);
			if(!empty($out))
            {
				echo 'Yes';
			}
			else
			{
				echo "No";
			}
		}
	 }//function close
	
	
	
	
	
	
	
	
	
	
	 /*
	public function convert_number_to_words2()
	{
		if(isset($_REQUEST['rs']))
		{
			$rs=$_REQUEST['rs'];
			$word= $this->Mymodel->convert_number_to_words($rs);

			echo ucwords($word);
		}
	}//function close
	*/



	





	//-----------------------------------------------from  product/product_entry_by_bill_display.php

	public function invoice_receive_print()
	 {
		if(strlen($this->uri->segment(3)>0))
		{
			
			// comapany data getting
			$where=" id=1 OR id=5 OR id=18 OR id=21 OR id=25  ";
			$result['company_setting']=$this->Mymodel->select_where('company_setting',$where);			
			
			
			$id = $this->uri->segment(3);
			$where=" product_invoice_entry_id='$id' ";
			
			
			$data2=array('print_status'=>'1');
			$this->Mymodel->update('product_invoice_entry',$data2,$where);


			$result['res2']=$this->Mymodel->select_where('product_invoice_entry',$where);
			
			
			$where=" product_invoice_entry_id='$id'   ";
			$this->load->model('Invoice_model');
			$result['res3']=$this->Invoice_model->product_group_by_rate($where);
			
			
			
			$supplier_id=$result['res2'][0]['supplier_id'];
			$where=" id='$supplier_id'   ";
			$result['supplier']=$this->Mymodel->select_where('supplier',$where);
			$this->load->view('invoice/invoice_receive_print',$result);
		}
		else
		{
			redirect('control/');
		}
	  }//function close





	 public function supplier_ledger()
	 {
		$supplier_id = $this->uri->segment(3);
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31");
		
		if(isset($_REQUEST['search']))
		{
			$supplier_id = $_REQUEST['id'];
		}
		
		 $query2="
					SELECT 
							A.product_id,
							B.name as bname
							
					FROM po_entry_details as A
					
					LEFT JOIN product B ON A.product_id=B.product_id
					WHERE supplier_id='$supplier_id' GROUP BY A.product_id
					";
		$result['product_list']=$this->Mymodel->query1($query2);
		
		
		
		//$where=" supplier_id='$supplier_id' and details_save_date between '$fdate1' and '$tdate1'  GROUP BY details_save_date DESC  ";
		//$result['res3']=$this->Mymodel->select_where('product_invoice_entry_details',$where);
		//print_r($result['res3']);
		
		
		 $query="
					SELECT  A.po_entry_details_id,A.po_date,A.po_no,A.supplier_id,A.product_id,
							A.unitname_id,A.qunt,A.rate,A.disc,A.net,A.amount,A.rev_qunt,
							
							S.name as sname,
							P.name as pname,
							U.name as uname,
							B.out_print_option_set,
							B.po_id
					
					FROM po_entry_details as A
					
					LEFT JOIN po_entry B ON A.po_entry_id=B.po_id
					LEFT JOIN supplier S ON S.id=A.supplier_id
					LEFT JOIN product P ON A.product_id=P.product_id
					LEFT JOIN unit U ON A.unitname_id=U.unit_id
					WHERE
				";
		
		
		//$where="A.supplier_id='$supplier_id' and  B.stage='5' and A.po_date between '$last_month_from' and '$last_month_to'  ";
		$where="A.supplier_id='$supplier_id' and  B.stage='5' ";
		
		
		
		if(isset($_REQUEST['search']))
		{
			if(isset($_REQUEST['from_date']))
			{
				$fdate=$_REQUEST['from_date'];
				$date2=explode('-',$fdate);
				$fdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];
			}
			
			if(isset($_REQUEST['to_date']))
			{
				$tdate=$_REQUEST['to_date'];
				$date2=explode('-',$tdate);
				$tdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];
			}


			$result['fdate']=$fdate;
			$result['tdate']=$tdate;
			
			if(isset($_REQUEST['from_date']) and isset($_REQUEST['to_date']))
			{
				$where.=" and  A.po_date between '$fdate1' and '$tdate1'  ";
			}
			
			if(!empty($_REQUEST['product']))
			{
				$product=$_REQUEST['product'];
				$result['product']=$_REQUEST['product'];
				$where.=" and  A.product_id='$product'  ";
				
			}
			
		}
		
		if(isset($_REQUEST['search']))
		{
			$where.="   ORDER by A.po_date DESC  ";
		}
		else
		{
			$where.=" and A.po_date between '$last_month_from' and '$last_month_to'  ORDER by A.po_date DESC  ";
		}
		
		
		$query.=" $where";
		$result['res3']=$this->Mymodel->query1($query);	
		
		
		$where=" id='$supplier_id'   ";
		$result['supplier']=$this->Mymodel->select_where('supplier',$where);
		$this->load->view('supplier/supplier_ledger',$result);
		//$this->load->view('main/footer');
	  }








	public function suplier_ledger_invoice_wise()
	{
		if(isset($_REQUEST['id_no']))
		{
			$po_details_no=$_REQUEST['id_no'];
			$where=" poid='$po_details_no' and qc_check='0' ";
			$out=$this->Mymodel->select_where('product_invoice_entry_details',$where);
			?>
            <table width="100%" border="1">
            	<tr>
                	<th>Sno</th>
                    <th>Date</th>
                    <th>No</th>
                    <th>Invoice No</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Lotno</th>
                </tr>
                <?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['invoice_date']);
					$date1= date_format($test, 'd-m-Y');	
				?>
                <tr>
                	<td><?php echo $i;?></td>
                    <td><?php echo $date1?></td>
                    <td><?php echo $r['product_invoice_save_no']?></td>
                    <td><?php echo $r['invoice_no']?></td>
                    <td><span style=" float:right;"><?php echo $r['price']?></span></td>
                    <td><span style=" float:right;"><?php echo $t[]=$r['net']?></span></td>
                    <td><span style=" float:right;"><?php echo $r['lotno']?></span></td>
                </tr>
                <?php 
				$i++;
				}
				?>
                <tr>
                	<th>#</th>
                    <th colspan="3"></th>
                    <th><span style=" float:right; font-weight:bolder; font-size:15px;">Total</span></th>
                    <th><span style=" float:right; font-weight:bolder; font-size:15px;"> <?php if(!empty($t)){echo array_sum($t);}?></span></th>
                    <th></th>
                </tr>
            </table>
            <?php
		}
	}//function close
	 
	 
	 
	 
	  

	 public function product_ledger()

	 {

		

		

		$access1=$this->session->userdata('access');

		$access=explode(',',$access1);

		if(in_array('product',$access)){}else{redirect('control/');}

		//--------------------------------------------------access

		

		$product_id = $this->uri->segment(3);

		$product_grade_id = $this->uri->segment(4);

		$product_lotno_id = $this->uri->segment(5);

		

		//$where=" product_invoice_entry_id='$id' ";

		//$result['res2']=$this->Mymodel->select_where('product_invoice_entry',$where);

		

		$fdate=date("01-m-Y");

		$date2=explode('-',$fdate);

		$fdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];

		

		$tdate=date("d-m-Y");

		$date2=explode('-',$tdate);

		$tdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];

		

		$result['fdate']=$fdate;

		$result['tdate']=$tdate;

		

		//-----------------------------------------------name

		$where=" product_id='$product_id'   ";

		$result['product']=$this->Mymodel->select_where('product',$where);

		

		//----------------------------------------------- stock in current

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'    ";

		$result['product_stock']=$this->Mymodel->select_where('product_stock',$where);

		

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY import_export_date DESC  ";

		$result['store_his']=$this->Mymodel->select_where('product_recive_stock_level_his',$where);

		

		

		//--------------------------------------------------invoice history

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id' and details_save_date between '$fdate1' and '$tdate1'  ORDER BY details_save_date DESC  ";

		$result['res3']=$this->Mymodel->select_where('product_invoice_entry_details',$where);

		//print_r($result['res3']);

		

		

		

		

		//--------------------------------------------------Wip history

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY issue_date DESC  ";

		$result['wip']=$this->Mymodel->select_where('wip',$where);

		

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY issue_date DESC  ";

		$result['wip_his']=$this->Mymodel->select_where('wip_his',$where);

		







		

		$this->load->view('product/product_ledger',$result);

		//$this->load->view('main/footer');

	  }

	  

	  

	  

	  public function product_ledger_search()

	  {

		

		

		$access1=$this->session->userdata('access');

		$access=explode(',',$access1);

		if(in_array('product',$access)){}else{redirect('control/');}

		//--------------------------------------------------access

		


		$product_id = $_REQUEST['id'];

		$product_grade_id =  $_REQUEST['product_grade_id'];

		$product_lotno_id =  $_REQUEST['product_lotno_id'];

		

		//$where=" product_invoice_entry_id='$id' ";

		//$result['res2']=$this->Mymodel->select_where('product_invoice_entry',$where);

		

		$fdate=$_REQUEST['from_date'];

		$date2=explode('-',$fdate);

		$fdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];

		

		$tdate=$_REQUEST['to_date'];

		$date2=explode('-',$tdate);

		$tdate1=$date2[2].'-'.$date2[1].'-'.$date2[0];

		

		$result['fdate']=$fdate;

		$result['tdate']=$tdate;

		

		//-----------------------------------------------name

		$where=" product_id='$product_id'   ";

		$result['product']=$this->Mymodel->select_where('product',$where);

		

		//----------------------------------------------- stock in current

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'    ";

		$result['product_stock']=$this->Mymodel->select_where('product_stock',$where);

		

		

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id' and details_save_date between '$fdate1' and '$tdate1'  ORDER BY details_save_date DESC  ";

		$result['res3']=$this->Mymodel->select_where('product_invoice_entry_details',$where);

		//print_r($result['res3']);

		

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY import_export_date DESC  ";

		$result['store_his']=$this->Mymodel->select_where('product_recive_stock_level_his',$where);

		

		//--------------------------------------------------Wip history

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY issue_date DESC  ";

		$result['wip']=$this->Mymodel->select_where('wip',$where);

		

		$where=" product_id='$product_id' and  lotno='$product_lotno_id' and product_grade_id='$product_grade_id'  ORDER BY issue_date DESC  ";

		$result['wip_his']=$this->Mymodel->select_where('wip_his',$where);

		

		

		

		$this->load->view('product/product_ledger',$result);

		//$this->load->view('main/footer');

	  }

	  
	  
	  
	  
	  /*
	  //-------get grade
 	  function fun_auto_issue_product_grade()
	  {
		//$where=" 1=1 ";
		//$company=$this->Mymodel->select_where('company_setting',$where);
		//$wip_wire_cat1=$company[7]['setting_value'];if(strlen($wip_wire_cat1)>0){$wip_wire_cat=explode(',',$wip_wire_cat1);}else{$wip_wire_cat='';}
		//$wip_rope_cat1=$company[8]['setting_value'];if(strlen($wip_rope_cat1)>0){$wip_rope_cat=explode(',',$wip_rope_cat1);}else{$wip_rope_cat='';}
		
	
			if(isset($_REQUEST['product_id']))
			{
				$product_id = $_REQUEST['product_id'];
				
				$where=" product_id='$product_id'  ";
				$out=$this->Mymodel->select_where('product',$where);
				$cat_id=$out[0]['category_id'];
				$size=$out[0]['size'];
				
				?>
                <option value="">Select</option> 
                <option value="None">None</option> 
				<?php
				
				//-------------for grade
				  $query="
					  SELECT  lotno,product_grade_id
					  FROM product_stock 
					  WHERE product_id='$product_id' and recive_stock_level>'0'  GROUP BY product_grade_id
				  ";
				  $query_out=$this->Mymodel->query1($query);
				  foreach($query_out as $c)
				  {
					  if(strlen($c['product_grade_id'])>0)
					  {
						?>
						<option  value="<?php echo $c['product_grade_id'];?>">
							<?php echo $c['product_grade_id'];?>
						</option>
						<?php
					  }//length
				  }
					
			
			}//product id
	  }//function close
	  
	  
	   //-------get lotno
 	  function fun_auto_issue_product_lotno()
	  {
		/*
		$where=" 1=1 ";
		$company=$this->Mymodel->select_where('company_setting',$where);
		$wip_wire_cat1=$company[7]['setting_value'];if(strlen($wip_wire_cat1)>0){$wip_wire_cat=explode(',',$wip_wire_cat1);}else{$wip_wire_cat='';}
		$wip_rope_cat1=$company[8]['setting_value'];if(strlen($wip_rope_cat1)>0){$wip_rope_cat=explode(',',$wip_rope_cat1);}else{$wip_rope_cat='';}
		*-/
	
			if(isset($_REQUEST['product_id']))
			{
				$product_id = $_REQUEST['product_id'];
				
				$where=" product_id='$product_id'  ";
				$out=$this->Mymodel->select_where('product',$where);
				$cat_id=$out[0]['category_id'];
				$size=$out[0]['size'];
				
				?>
					<option value="">Select</option> 
					<option value="None">None</option> 
				<?php
				//---------for lotno
				$query="
							SELECT  A.lotno,A.product_grade_id,sum(recive_stock_level) as qty,S.name as sname,B.invoice_date
							FROM product_stock as A
							LEFT JOIN product_invoice_entry_details as B ON B.lotno = A.lotno
							LEFT JOIN supplier as S ON S.id = B.supplier_id
							WHERE A.product_id='$product_id' and A.recive_stock_level>'0' GROUP BY A.lotno ORDER BY B.invoice_date ASC
						";
				$query_out=$this->Mymodel->query1($query); 
				//print_r($query_out);
				$i=1;
				foreach($query_out as $c)
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
	 
	  
	  //-------get qty
 	  function fun_auto_issue_product_qty()
	  {
	
			if(isset($_REQUEST['product_id']))
			{
				$product_id = $_REQUEST['product_id'];
				$lotno_val = $_REQUEST['lotno_val'];
				$grade_val = $_REQUEST['grade_val'];
				
				if($lotno_val=='None' and $grade_val=='None')
				{
					$where=" product_id='$product_id'  ";
				}
				else
				{
					$where=" product_id='$product_id' and product_grade_id='$grade_val' and  lotno='$lotno_val'  ";
				}
				
				$res=$this->Mymodel->select_where('product_stock',$where);

				if(isset($res) and count($res)>0)
				{
					if(isset($res[0]['recive_stock_level']))
					{
						$qty=$res[0]['recive_stock_level'];
					}else{$qty='0.00';}
				}
				else
				{
					$qty='0.00';
				}
				
				echo $qty;
			
			}//product id
	  }//function close
	  
	  
	  
	    //-------get qty
 	  function total_qty_issue_for_emp()
	  {
	
			if(isset($_REQUEST['emp_id']))
			{
				$emp_id = $_REQUEST['emp_id'];
				$product_id = $_REQUEST['product_id'];
				$lotno_val = $_REQUEST['lotno_val'];
				$grade_val = $_REQUEST['grade_val'];
				
				//$where=" emp_code='$emp_id' and  product_id='$product_id' and product_grade_id='$grade_val' and  lotno='$lotno_val'  ";
				//$where="   product_id='$product_id' and product_grade_id='$grade_val' and  lotno='$lotno_val'  ";
				//$res=$this->Mymodel->select_where('product_issue',$where);
				
				
				
				if($lotno_val=='None' and $grade_val=='None')
				{
					$query="
						SELECT
						sum(issuequnt) as qty 
						
						FROM indent_store_req_details as B
	
						LEFT JOIN indent_store_req as A ON A.indent_store_req_id = B.indent_store_req_id
						
						WHERE  B.receivedby='$emp_id' and B.product_id='$product_id'  and A.stage='3'
					";
				}
				else
				{
					$query="
						SELECT
						sum(issuequnt) as qty 
						
						FROM indent_store_req_details as B
	
						LEFT JOIN indent_store_req as A ON A.indent_store_req_id = B.indent_store_req_id
						
						WHERE  B.receivedby='$emp_id' and B.product_id='$product_id' and B.grade='$grade_val' and  B.lotno='$lotno_val' and A.stage='3'
					";
					
					
				}
				
				//echo $query;
				$res=$this->Mymodel->query1($query);

				if(isset($res) and count($res)>0)
				{
					if(isset($res[0]['qty']))
					{
						$qty=$res[0]['qty'];
					}else{$qty='0.00';}
				}
				else
				{
					$qty='0.00';
				}
				
				echo round($qty,2);
			
			}//product id
	  }//function close
	  
	   */

	  

	  

	  //--------------------------------update stock
	  function fun_get_qty()
	  {
		//--------------------------------------get WIP Details
		$where=" 1=1 ";
		$company=$this->Mymodel->select_where('company_setting',$where);
		$wip_wire_cat1=$company[7]['setting_value'];if(strlen($wip_wire_cat1)>0){$wip_wire_cat=explode(',',$wip_wire_cat1);}else{$wip_wire_cat='';}
		$wip_rope_cat1=$company[8]['setting_value'];if(strlen($wip_rope_cat1)>0){$wip_rope_cat=explode(',',$wip_rope_cat1);}else{$wip_rope_cat='';}
		
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			
			$where=" product_id='$product_id'  ";
			$out=$this->Mymodel->select_where('product',$where);
			$cat_id=$out[0]['category_id'];
			$size=$out[0]['size'];
			
			if(in_array($cat_id,$wip_wire_cat))
			{
				$dis=1;
			}
			elseif(in_array($cat_id,$wip_rope_cat))
			{
				$dis=2;
			}
			else
			{
				$dis=0;
			}//else
			
			//--------------same logic WIP model me hai
			
			
			if($dis>0)
			{
				?>
                            <input type="hidden" value="1" id="with_lot">
                            <input type="hidden" id="size" value="<?php echo $size;?>" >

                                
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Grade</label>
                                           <select class="form-control" style="width: 100%" name="grade" id="grade" >
                                                <option   value="">Select</option>
                                                  <?Php 
												  //-------------for grade
													$query="
														SELECT  lotno,product_grade_id
														FROM product_stock 
														WHERE product_id='$product_id' and recive_stock_level>'0'  GROUP BY product_grade_id
													";
													$query_out=$this->Mymodel->query1($query);
                                                    foreach($query_out as $c)
                                                    {
                                                  ?>
                                                    <option  value="<?php echo $c['product_grade_id'];?>">
                                                        <?php echo $c['product_grade_id'];?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div> 
                                 
                                 
                                 <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Lot No</label>
                                           <select class="form-control" style="width: 100%"  name="lotno" id="lotno" onChange="fun_get_qty2()">
                                                <option   value="">Select</option>
                                                  <?Php
												  //---------for lotno
													$query="
														SELECT  lotno,product_grade_id
														FROM product_stock 
														WHERE product_id='$product_id' and recive_stock_level>'0' GROUP BY lotno
													";
													$query_out=$this->Mymodel->query1($query); 
                                                    foreach($query_out as $c)
                                                    {
														$lotno2=$c['lotno'];
														$where=" lotno='$lotno2' ";
														$invoice_details=$this->Mymodel->select_where('product_invoice_entry_details',$where);
														if(!empty($invoice_details))
														{
															$supplier_id=$invoice_details[0]['supplier_id'];
															$where=" id='$supplier_id' ";
															$supplier=$this->Mymodel->select_where('supplier',$where);
															$supplier_name=$supplier[0]['name'];
														}
														else
														{
															$supplier_name='';
														}
                                                  ?>
                                                    <option  value="<?php echo $c['lotno'];?>">
                                                        <?php echo $c['lotno'].' '.$supplier_name;?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div>
                                 
                        <div class="col-md-12" id="current_qty2">
                        
                        </div>
                                  
                <?php
			}
			else
			{
					?>
                    <input type="hidden" value="0" id="with_lot">
                    <input type="hidden" id="size" value="<?php echo $size;?>" >
                    <?php
					$this->fun_get_qty3($product_id,'','');
			}//else
		}//id
	  }//function close

		
		
		
		
		
		
		
		
		
		
		
		
		
		
	
	 
		
		
	 function fun_get_qty2()
	 {
	 	$product_id=$_REQUEST['product_id'];
		$lotno=$_REQUEST['lotno'];
		$grade=$_REQUEST['grade'];
		if(!empty($product_id))
		{
			$this->fun_get_qty3($product_id,$grade,$lotno);
		}
		
	 }//function close
		
		
	  //--------------------------------update stock
	  function fun_get_qty3($product_id,$grade,$lotno)
	  {
			$where=" product_id='$product_id' and product_grade_id='$grade' and  lotno='$lotno'  ";
			$res=$this->Mymodel->select_where('product_stock',$where);

			if(isset($res) and count($res)>0)
			{
				if(isset($res[0]['recive_stock_level'])){$qty=$res[0]['recive_stock_level'];}else{$qty='0.00';}
				if(isset($res[0]['unit_id']))
				{
					$unit_id=$res[0]['unit_id'];
					$where=" unit_id='$unit_id'   ";
					$res2=$this->Mymodel->select_where('unit',$where);
					if(isset($res2) and count($res2)>0){$unit=$res2[0]['name'];}else{$unit='';}
				}else{$unit_id='';$unit='';}
			}
			else{$qty='0.00';$unit_id='';$unit='';}
			$out=$qty.' '.$unit;
			?>
					<div class="form-group" style="margin-bottom:20px;" >
						  <h3>
						  Current in Stock: <span style="color:blue" id="current_div_val"><?php echo $out;?></span>
						  </h3>
					</div>
			<?php
	 }//function close
  

	
	
	
	
	
	
	
	//------------------------------------------------WIP Transfer
	  function fun_get_qty_from_transfer()
	  {
		
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			
			$where=" product_id='$product_id'  ";
			$out=$this->Mymodel->select_where('product',$where);
			$cat_id=$out[0]['category_id'];
			$size=$out[0]['size'];
			
			
			
				?>
                            <input type="hidden" value="1" id="with_lot">
                            <input type="hidden" id="size" value="<?php echo $size;?>" >

                                
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Grade</label>
                                           <select class="form-control" style="width: 100%" name="grade" id="grade" >
                                                <option   value="">Select</option>
                                                  <?Php 
												  	$query="
														SELECT  grade
														FROM wip_wire 
														WHERE product_id='$product_id' and qty>0 GROUP BY grade 
													";
													$query_out=$this->Mymodel->query1($query);
                                                    foreach($query_out as $c)
                                                    {
                                                  ?>
                                                    <option  value="<?php echo $c['grade'];?>">
                                                        <?php echo $c['grade'];?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div> 
                                 
                                 
                                 <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Lot No</label>
                                           <select class="form-control" style="width: 100%"  name="lotno" id="lotno" onChange="fun_get_qty_from_transfer2()">
                                                <option   value="">Select</option>
                                                  <?Php
												  $query="
														SELECT  lotno
														FROM wip_wire 
														WHERE product_id='$product_id' and qty>0 GROUP BY lotno 
													";
													$query_out=$this->Mymodel->query1($query); 
                                                    foreach($query_out as $c)
                                                    {
                                                  ?>
                                                    <option  value="<?php echo $c['lotno'];?>">
                                                        <?php echo $c['lotno'];?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div>
                                 
                        <div class="col-md-12" id="current_qty2">
                        
                        </div>
                                  
                <?php
			
		}//id
	  }//function close

	
	
	 //--------------------------------WIP Transfer
	  function fun_get_qty_from_transfer2()
	  {
			$product_id=$_REQUEST['product_id'];
			$lotno=$_REQUEST['lotno'];
			$grade=$_REQUEST['grade'];
		
			$where=" product_id='$product_id' and grade='$grade' and  lotno='$lotno'  ";
			$res=$this->Mymodel->select_where('wip_wire',$where);

			if(isset($res) and count($res)>0)
			{
				if(isset($res[0]['qty'])){$qty=$res[0]['qty'];}else{$qty='0.00';}
				
				$out=$qty;
			}
			else
			{
				$out='';
			}
			?>
					<div class="form-group" style="margin-bottom:20px;" >
						  <h3>
						  Current in Stock: <span style="color:blue" id="current_div_val"><?php echo $out;?></span>
						  </h3>
					</div>
			<?php
	 }//function close
	 
	 
	 //-------------------------------wip wire getting data from rope loss
	  function fun_get_qty_from_transfer3()
	  {
			$product_id=$_REQUEST['product_id'];
			$lotno=$_REQUEST['lotno'];
			$grade=$_REQUEST['grade'];
		
			if(!empty($product_id))
			{
				$where=" 1=1 ";
				$res=$this->Mymodel->select_where('wip_wire_loss',$where);
				if(isset($res[0]['qty'])){$qty=$res[0]['qty'];}else{$qty='0.00';}
				
				$out=$qty;
			}
			else
			{
				$out='';
			}
			?>
					<div class="form-group" style="margin-bottom:20px;" >
						  <h3>
						  Current in  Wire Loss Stock: <span style="color:blue" id="current_div_val"><?php echo $out;?></span>
						  </h3>
					</div>
			<?php
	 }//function close
	
	
	
	
	
	
	
	
	//------------------------------------------------WIP Transfer
	  function fun_get_qty_from_wip_rope()
	  {
		
		if(isset($_REQUEST['product_id']))
		{
			$product_id = $_REQUEST['product_id'];
			
			$where=" product_id='$product_id'  ";
			$out=$this->Mymodel->select_where('product',$where);
			$cat_id=$out[0]['category_id'];
			$size=$out[0]['size'];
			
			
				$query="
					SELECT  lotno,grade
					FROM wip_rope 
					WHERE product_id='$product_id' 
				";
				$query_out=$this->Mymodel->query1($query);
				?>
                            <input type="hidden" value="1" id="with_lot">
                            <input type="hidden" id="size" value="<?php echo $size;?>" >

                                
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Grade</label>
                                           <select class="form-control" style="width: 100%" name="grade" id="grade" >
                                                <option   value="">Select</option>
                                                  <?Php 
                                                    foreach($query_out as $c)
                                                    {
                                                  ?>
                                                    <option  value="<?php echo $c['grade'];?>">
                                                        <?php echo $c['grade'];?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div> 
                                 
                                 
                                 <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Select Lot No</label>
                                           <select class="form-control" style="width: 100%"  name="lotno" id="lotno" onChange="fun_get_qty_from_wip_rope2()">
                                                <option   value="">Select</option>
                                                  <?Php 
                                                    foreach($query_out as $c)
                                                    {
                                                  ?>
                                                    <option  value="<?php echo $c['lotno'];?>">
                                                        <?php echo $c['lotno'];?>
                                                    </option>
                                                  <?php
                                                    }
                                                  ?>		
                                           </select>
                                    </div>
                                 </div>
                                 
                        <div class="col-md-12" id="current_qty2">
                        
                        </div>
                                  
                <?php
			
		}//id
	  }//function close

	
	
	
	 //-------------------------------wip ropes
	  function fun_get_qty_from_wip_rope2()
	  {
			$product_id=$_REQUEST['product_id'];
			$lotno=$_REQUEST['lotno'];
			$grade=$_REQUEST['grade'];
		
			$where=" product_id='$product_id' and grade='$grade' and  lotno='$lotno'  ";
			$res=$this->Mymodel->select_where('wip_rope',$where);

			if(isset($res) and count($res)>0)
			{
				if(isset($res[0]['qty'])){$qty=$res[0]['qty'];}else{$qty='0.00';}
				
				$out=$qty;
			}
			else
			{
				$out='';
			}
			?>
					<div class="form-group" style="margin-bottom:20px;" >
						  <h3>
						  Current in Stock: <span style="color:blue" id="current_div_val"><?php echo $out;?></span>
						  </h3>
					</div>
			<?php
	 }//function close
	
	
	//-------------------------------wip ropes getting data from rope loss
	  function fun_get_qty_from_wip_rope3()
	  {
			$product_id=$_REQUEST['product_id'];
			$lotno=$_REQUEST['lotno'];
			$grade=$_REQUEST['grade'];
		
			if(!empty($product_id))
			{
				$where=" 1=1 ";
				$res=$this->Mymodel->select_where('wip_rope_loss',$where);

				
				$out=$res[0]['qty'];
			}
			else
			{
				$out='';
			}
			?>
					<div class="form-group" style="margin-bottom:20px;" >
						  <h3>
						  Current in Rope Wire Loss Stock: <span style="color:blue" id="current_div_val"><?php echo $out;?></span>
						  </h3>
					</div>
			<?php
	 }//function close
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	
	/*
	//--------------------------------invoice entry
	  function fun_gst_type()
	  {
		$where=" id='5'   ";
		$company_setting=$this->Mymodel->select_where('company_setting',$where);
		$our_state_code = $company_setting[0]['smpt_host'];
		
		if(isset($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
			$where=" id='$id'   ";
			$res=$this->Mymodel->select_where('supplier',$where);
			if(!empty($res))
			{
				$state_name=$res[0]['state'];
				$state_name1=explode('(',$state_name);
				//print_r($state_name1);
				$state_name2=explode(')',$state_name1[1]);
				//print_r($state_name2[0]);
				$code=$state_name2[0];
				if($code==$our_state_code)
				//if($code=='18')
				{
					?>   
						<input type="hidden" name="gst_type" id="gst_type" value="SGST & CGST">
					<?php
				}
				else
				{
					?>  
					 <input type="hidden" name="gst_type" value="IGST" id="gst_type">
					<?php
				}
			}//state code 
		}//get id
	  }//function close

	
	
	
	
	 function fun_get_product()
	  {
		if(isset($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];

			//gettind permission is enable or desable
			$user_email=$this->session->userdata('email');
			$today=date("Y-m-d");

			$where="  id=39  ";
			$company_setting=$this->Mymodel->select_where('company_setting',$where);
			$power = $company_setting[0]['setting_value'];
			
			//query
			$query="
						SELECT  A.product_id,B.name
						FROM po_entry_details as A 
						LEFT JOIN product B ON B.product_id=A.product_id
						LEFT JOIN po_entry P ON P.po_id=A.po_entry_id
						WHERE A.supplier_id='$id'  and A.stage='0' and P.stage='5' and P.invoice_entry_disable!=1
					";


			//condition
			if($user_email=$this->session->userdata('email')=='kingmanu12801@gmail.com' or $power=='Yes')
			{
				//Show ALL
			}//all po show
			else
			{
				$query = $query." and P.po_validity >= '$today' ";
			}// not show expire po

			$query = $query." GROUP BY A.product_id ORDER BY B.name ASC ";
			$out=$this->Mymodel->query1($query);
			
			?>
			<option value="">Select</option>
			<?php
			if(!empty($out))
			{
				foreach($out as $r)
				{
					
					?>
                    <option value="<?php echo $r['product_id'];?>"><?php echo $r['name'];?></option>
                    <?php
				}
			}//state code 
		}//get id
	  }//function close

	*/
	

	/*
	 
	function ddie_no_check()
	  {
		if(isset($_REQUEST['die_no']))
		{
			$die_no = $_REQUEST['die_no'];
			$where=" die_no='$die_no' ";
			$out=$this->Mymodel->select_where('ddie',$where);
			
			if(!empty($out) and count($out)>0)
			{
				$pallet= $out[0]['pallet_id'];
				$where=" id='$pallet'  ";
				$out2=$this->Mymodel->select_where('ddie_pallet',$where);
				$p= $out2[0]['pallet'].' ('.$out2[0]['code'].')';
				
				echo $die_no." Already Exists. Manufacturing: ".$out[0]['menu_no'].", Size:".$out[0]['size'].', Pallet:'.$p.', Location:'.$out[0]['location'];
			}//state code 
		}//get id
	  }//function close 


	function ddie_no_check2()
	  {
		if(isset($_REQUEST['die_no']))
		{
			$die_no = $_REQUEST['die_no'];
			$where=" die_no='$die_no' ";
			$out=$this->Mymodel->select_where('ddie',$where);
			
			if(!empty($out) and count($out)>0)
			{
				//--------------------------------------------get pallet
				$pallet= $out[0]['pallet_id'];
				$where=" id='$pallet'  ";
				$out2=$this->Mymodel->select_where('ddie_pallet',$where);
				$p= $out2[0]['pallet'].' ('.$out2[0]['code'].')';
				
				
				//----------------------------------------------geting mc no
				if($out[0]['wet_mc_no']>0)
				{
					$wet_mc_no= $out[0]['wet_mc_no'];
					$where=" wet_mc_id='$wet_mc_no'  ";
					$out2=$this->Mymodel->select_where('wet_mc',$where);
					$mc_name= $out2[0]['name'].' ('.$out2[0]['type'].')';
				}
				else
				{
					$mc_name='';
					$wet_mc_no='';
				}
				
				
				echo $out[0]['id'].'~'.$out[0]['menu_no'].'~'.$out[0]['size'].'~'.$p.'~'.$out[0]['location'].'~'.$mc_name.'~'.$wet_mc_no;
			}//state code 
			else
			{
				echo 0;
			}
		}//get id
	  }//function close 
	  */
	  
	  /*
	  //--------------------------------invoice entry
	  function supplier_details()
	  {
		if(!empty($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
			$where=" id='$id'   ";
			$res=$this->Mymodel->select_where('supplier',$where);
			echo $res[0]['address'].'~'.$res[0]['city'].' '.$res[0]['state'].' '.$res[0]['zip'].'~'.$res[0]['con_name1'].'~'.$res[0]['con_mob1'].'~'.$res[0]['con_email1'].'~'.$res[0]['id'].'~'.$res[0]['gst_no'].'~'.$res[0]['payment_terms'].'~'.$res[0]['del_place'].'~'.$res[0]['mod_of_dis'].'~'.$res[0]['logistrick'];
		}
	  }//function close
	  */

	   

	 





	   

	
/*
	//-----------------------------------------------from  po/po_list.php
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

				$this->load->view('po/po_print',$result);
		}
		else{redirect('control/');}
	}//function close
*/
	

	 //-----------------------------------------------from  po/po_list.php

	public function po_no_of_item_print()

	 {

		if(isset($_REQUEST['po_entry_id']))

		{

			$po_entry_id = $_REQUEST['po_entry_id'];

			$no_of_item = $_REQUEST['no_of_item'];

			

			//$where="po_id='$po_entry_id'  ";

			//$result['res2']=$this->Mymodel->select_where('po_entry',$where);

			

			$where=" po_entry_id='$po_entry_id' ";

			$row=$this->Mymodel->select_where('po_entry_details',$where);

			//if(isset($row))

			//{

			$total_row= count($row);//7

			$p1=$total_row/$no_of_item;//3.5

			

			$p2=explode('.',$p1);

			if(isset($p2[0])){$p3=$p2[0];}else{$p3=0;}//before point

			if(isset($p2[1])){

				$p4=$p2[1];

				$p=$p3+1;

			}//after point

			else

			{

				$p=$p3;

			}

			

			

			

			$no=0;

			for($i=1;$i<=$p;$i++)

			{

				

				if($i==$p)

				{

					$past_page=1;

				}

				else

				{

					$past_page='';

				}

				

				$link= base_url().'index.php/Ajex/po_print/'.$po_entry_id.'/'.$no.'/'.$no_of_item.'/'.$i.'/'.$past_page;

					?>

					<input type="hidden" id="page_id" name="page_id[]" class="page_id" value="<?php echo $link;?>">

				   <a href="<?php echo $link;?>" target="_blank" title="Print / View" class="waves-effect waves-button"  style="height:100px; width:100px;">

				  

				  <span class="menu-icon glyphicon glyphicon-print"></span>

				  Page <?php echo $i;?>

				  

				   </a>

				<?php

				$no=$no+$no_of_item;

			}//for 

		

		}//id

	}//function close

	

	

	 //-----------------------------------------------from  po/po_list.php

	public function po_save_print_no()

	 {

		if(isset($_REQUEST['po_entry_id'])){

		

			$po_entry_id = $_REQUEST['po_entry_id'];

			

			$where=" po_id='$po_entry_id' ";

			$row=$this->Mymodel->select_where('po_entry',$where);

			

			$p2=$row[0]['no_of_page'];

			$p3=explode('~',$p2);

			$i=1;

			foreach($p3 as $p)

			{

				$link= $p;

				?>

					<a href="<?php echo $link;?>" target="_blank" title="Print / View" class="waves-effect waves-button"  style="height:100px; width:100px;">

				  

				  <span class="menu-icon glyphicon glyphicon-print"></span>

				  Page <?php echo $i;?>

				  

				   </a>

				<?php

				$i++;

			}

		}//id

	 }//function close  

	  

	  

	 //-----------------------------------------------from  po/po_list.php

	public function po_print_forment_save()

	 {

		

		if(isset($_REQUEST['po_entry_id'])){

			$po_entry_id = $_REQUEST['po_entry_id'];

			$ex1 = $_REQUEST['ex1'];

			

			$data=array(

							'out_print_option_set'=>"1",

							'no_of_page'=>"$ex1",

							'update_by'=>"$today",

							'update_date'=>"$user_email",

						);

			

			$where=array('po_id'=>"$po_entry_id");   

			$this->Mymodel->update('po_entry',$data,$where);

		}

		

	 }//function close  

	  

	  

	  

	

	

	

	 

	 

	 

	 

	 

	 

	 
	/*
	public function po_approved_by_email()
	{
		$today_date=date("Y-m-d H:i:s");
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}
		if(isset($_REQUEST['newstage'])){$newstage=$_REQUEST['newstage'];}
		if(isset($_REQUEST['po_id'])){$po_id=$_REQUEST['po_id'];}
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}
		if(!empty($po_id) and !empty($email) and !empty($newstage))
		{
			$where5=" po_id='$po_id'  ";
			$out5=$this->Mymodel->select_where('po_entry',$where5);
			if(isset($out5) and count($out5)>0)
			{
				$current_stage2=$out5[0]['stage'];
				if($current_status!=$current_stage2)
				{
					echo "This Action is already taken";
				}
				else
				{
					$data2=array(
								  'stage'=>"$newstage",
								  'dept_aproved_by'=>"$email",
								  'dept_aproved_date'=>"$today_date",
								  'comment'=>"No comment update by email",
								  'update_by'=>"$email",
								  'update_date'=>"$today_date",
							  );
					$where2=array('po_id'=>"$po_id");   
					$this->Mymodel->update('po_entry',$data2,$where2);
					echo "Thank You. You are approved to this PO";
				}
			}//po id valid
		}//not empty
	}//function close

	

	

	

	public function po_reject_by_email()
	{
		$today_date=date("Y-m-d H:i:s");
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}
		if(isset($_REQUEST['newstage'])){$newstage=$_REQUEST['newstage'];}
		if(isset($_REQUEST['po_id'])){$po_id=$_REQUEST['po_id'];}
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}

		
		if(!empty($po_id) and !empty($email) and !empty($newstage))
		{
			$where5=" po_id='$po_id'  ";
			$out5=$this->Mymodel->select_where('po_entry',$where5);
			if(isset($out5) and count($out5)>0)
			{
				$current_stage2=$out5[0]['stage'];
				if($current_status!=$current_stage2)
				{
					echo "This Action is already taken";
				}
				else
				{
					$data2=array(
									  'stage'=>"$newstage",
									  'dept_aproved_by'=>"",
									  'dept_aproved_date'=>"",
									  'reject_by'=>"$email",
									  'reject_date'=>"$today_date",
									  'comment'=>"No comment update by email",
									  'update_by'=>"$email",
									  'update_date'=>"$today_date",
								  );
						$where2=array('po_id'=>"$po_id");   
						$this->Mymodel->update('po_entry',$data2,$where2);
					echo "Thank You. You are Rejected this PO";
				}
			}//po id valid
		}//not empty
	}//function close
*/
	

	

	
/*
	public function get_po_no()
	 {
		if(!empty($_REQUEST['product_id'])  and isset($_REQUEST['supplier_id']))
		{
			$product_id = $_REQUEST['product_id'];
			$supplier_id = $_REQUEST['supplier_id'];
			
			//gettind permission is enable or desable
            $user_email=$this->session->userdata('email');
            $today=date("Y-m-d");

            $where="  id=39  ";
            $company_setting=$this->Mymodel->select_where('company_setting',$where);
            $power = $company_setting[0]['setting_value'];
            
            //query
            $query="
                        SELECT  A.po_entry_details_id,P.po_no
                        FROM po_entry_details as A 
                        LEFT JOIN product B ON B.product_id=A.product_id
                        LEFT JOIN po_entry P ON P.po_id=A.po_entry_id
                        WHERE A.supplier_id='$supplier_id' and A.product_id='$product_id'  and A.stage='0' and P.stage='5' and P.invoice_entry_disable!=1
                    ";


            //condition
            if($user_email=$this->session->userdata('email')=='kingmanu12801@gmail.com' or $power=='Yes')
            {
                // Show ALL
            }//all po show
            else
            {
                $query = $query." and P.po_validity >= '$today' ";
            }// not show expire po

            $query = $query."  ORDER by A.po_no ASC ";
            $product=$this->Mymodel->query1($query);
			//print_r($product);
			
			//$where=" supplier_id='$supplier_id' and product_id='$product_id' and stage='0'  ORDER by po_no ASC ";
			//$product=$this->Mymodel->select_where('po_entry_details',$where);
			
			
			
			?>
            <option value="">Select</option>
			<?php
			foreach($product as $p)
			{
				/*
				$po_entry_id=$p['po_entry_id'];
				$where=" po_id='$po_entry_id' and   stage='5'  ";
				$out=$this->Mymodel->select_where('po_entry',$where);
				if(!empty($out))
				{
					*-/
			?>
				<option value="<?php echo $p['po_entry_details_id'];?>"><?php echo $p['po_no'];?></option>
			<?php
				//}
			}//foreach
		}
	 }//function close

	

	

	public function get_po_details()
	 {
		if(isset($_REQUEST['poid_details_id']))
		{
			if(strlen($_REQUEST['poid_details_id'])>0 and $_REQUEST['poid_details_id']!='Direct')
			{
				$poid_details_id = $_REQUEST['poid_details_id'];
				$where=" po_entry_details_id='$poid_details_id'  ";
				$product=$this->Mymodel->select_where('po_entry_details',$where);
				//print_r($product);
				$qty = (int)$product[0]['qunt'];
				$rec = (int)$product[0]['rev_qunt'];
				$rem = $qty-$rec;
				echo  $product[0]['qunt'].'~'.$product[0]['rev_qunt'].'~'.$rem.'~'.$product[0]['unitname_id'].'~'.$product[0]['hsn'].'~'.$product[0]['net'];
			}
		}
	 }//function close

*/






	/*
	public function po_goods_autocomplate()
	{
		$name =$_REQUEST['term'];
		
			$where=" name like '%$name%' ORDER by name ASC LIMIT 10 ";
			$result=$this->Mymodel->select_where('product',$where);
			$companies=array();
			foreach($result as $row)
			{
				//$names[]=array($row['category_id']=>$row['name']);
				
				$companies[] = array("value" =>$row['product_id'], "label" =>$row['name']);
			
			}
			
			echo  json_encode($companies);
			
			
	}
	*/


	//-----------------------------------------maintance breakdown
	public function maint_breakdown_autocomplate()
	{
			$name =$_REQUEST['term'];
		
			$where=" name like '%$name%' ORDER by name ASC LIMIT 10 ";
			$result=$this->Mymodel->select_where('product',$where);
			$companies=array();
			foreach($result as $row)
			{
				//$names[]=array($row['category_id']=>$row['name']);
				
				$companies[] = array("value" =>$row['product_id'], "label" =>$row['name']);
			
			}
			
			echo  json_encode($companies);
			
			///echo json_encode($names);
	}

	
	
	
	
	public function rgp_print()
	{
		
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
	
			$where=" rgp_id='$id' ";
			$result['res2']=$this->Mymodel->select_where('rgp',$where);
			
			
			$where=" rgp_id='$id' ";
			$result['res3']=$this->Mymodel->select_where('rgp_details',$where);
			
			$this->load->view('rgp/rgp_print',$result);
			
		}//if 3 exits
		else
		{
			redirect('control/');
		}
	}//function close



	public function nrgp_print()
	{
		
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
	
			$where=" nrgp_id='$id' ";
			$result['res2']=$this->Mymodel->select_where('nrgp',$where);
			
			
			$where=" nrgp_id='$id' ";
			$result['res3']=$this->Mymodel->select_where('nrgp_details',$where);
			
			$this->load->view('nrgp/nrgp_print',$result);
			
		}//if 3 exits
		else
		{
			redirect('control/');
		}
	}//function close
	
	
	
	
	public function fun_rej_supplier_details()
	 {
		if(isset($_REQUEST['supplier']))
		{
			$supplier = $_REQUEST['supplier'];
			$product_id = $_REQUEST['product_id'];

			$where=" product_id='$product_id'  ";
			$out=$this->Mymodel->select_where('product',$where);
			$pro_name=$out[0]['name'];
			
			$where=" supplier_id='$supplier' and product_id='$product_id' ORDER by invoice_no DESC ";
			$product=$this->Mymodel->select_where('product_invoice_entry_details',$where);
			?>
            <option value="">Select</option>
			<?php
			foreach($product as $p)
			{
				$dis=$pro_name.', Package - '.$p['package'].', Qty - '.$p['net'].'. Rate - '.$p['price'].', Amount - '.$p['amount'].', Lotno - '.$p['lotno'].', Grade - '.$p['product_grade_id'];
			?>
				<option value="<?php echo $p['details_id'];?>"><?php echo $dis;?></option>
			<?php
			}
		}
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 
	public function rope_config_finish_size()
	{
		$name =$_REQUEST['term'];
		
			$where=" name like '%$name%' ORDER by name ASC LIMIT 10 ";
			$result=$this->Mymodel->select_where('product',$where);
			$companies=array();
			foreach($result as $row)
			{
				//$names[]=array($row['category_id']=>$row['name']);
				
				$companies[] = array("value" =>$row['name']);
			
			}
			
			echo  json_encode($companies);
			
			///echo json_encode($names);
	}
	
	
	
	
	
	public function fun_check_qty_in_wip()
	{
		$in_item =$_REQUEST['in_item'];
		$lotno =$_REQUEST['lotno'];
		
		$where=" product_id='$in_item' and lotno='$lotno' ";
		$result=$this->Mymodel->select_where('wip_wire',$where);
		if(!empty($result))
		{
			echo $result[0]['qty'].' Kg';
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function rope_pro_entry_outword()
	 {
		if(isset($_REQUEST['name']))
		{
			$product_id = $_REQUEST['name'];
			
			$where="  finish_size='$product_id' ";
			$out1=$this->Mymodel->select_where('rope_config',$where);
			if(!empty($out1))
			{
				$make_wire=$out1[0]['make_wire'];
				$where=" product_id='$make_wire' ";
				$pro1=$this->Mymodel->select_where('product',$where);
				
				//---lotno
				$where=" product_id='$make_wire' ";
				$lotno=$this->Mymodel->select_where('wip_rope',$where);
			?>

              <input type="hidden" id="main_product_weight" value="<?php echo  $out1[0]['main_weight'];?>">
              
              <input type="hidden" id="in_product_id1" value="<?php echo $make_wire;?>">
              <input type="hidden" id="in_weight1" value="<?php echo $out1[0]['weight'];?>">
              
              
                <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Inward Material 1</label>
                          <input type="text" class="form-control" value="<?php echo $pro1[0]['name'];?>" readonly  autocomplete="off">
                        </div>
                 </div>

             
          		<div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">No of wire</label>
                          <input type="text" class="form-control" id="in_wire1" value="<?php echo $out1[0]['no_of_wire_size'];?>" readonly  autocomplete="off">
                        </div>
                 </div>    
                     
                 <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Qty</label>
                          <input type="text" class="form-control"   id="in_qty1" readonly  autocomplete="off">
                        </div>
                 </div>    
                         
               
                  <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Lotno</label>
                           <select class="form-control" id="in_lot1" >
                            <option value="">Select</option>
                            <?php 
                                foreach($lotno as $u)
                                {
                                    ?>
                                        <option value="<?php echo $u['lotno'];?>" ><?php echo $u['lotno'].' ('.$u['qty'].')';?></option>
                                    <?php
                                
                                }
                                ?>
                           </select>
                        </div>
                 </div>
                 
                     
             <?php 
			 //2nd line
			if(!empty($out1[1]['make_wire']))
			{
				$make_wire=$out1[1]['make_wire'];
				$where=" product_id='$make_wire' ";
				$pro1=$this->Mymodel->select_where('product',$where);
				
					//---lotno
				$where=" product_id='$make_wire'  ORDER BY lotno ";
				$lotno=$this->Mymodel->select_where('wip_rope',$where);
			?>
              <input type="hidden" id="in_product_id2" value="<?php echo $make_wire;?>">
              <input type="hidden" id="in_weight2" value="<?php echo $out1[1]['weight'];?>">
              
              
                <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Inward Material 2</label>
                          <input type="text" class="form-control" value="<?php echo $pro1[0]['name'];?>" readonly  autocomplete="off">
                        </div>
                 </div>

             
          		<div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">No of wire</label>
                          <input type="text" class="form-control" id="in_wire2" value="<?php echo $out1[1]['no_of_wire_size'];?>" readonly  autocomplete="off">
                        </div>
                 </div>    
                     
                 <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Qty </label>
                          <input type="text" class="form-control"   id="in_qty2" readonly  autocomplete="off">
                        </div>
                 </div>    
                         
                   <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Lotno</label>
                           <select class="form-control" id="in_lot2" >
                            <option value="">Select</option>
                            <?php 
                                foreach($lotno as $u)
                                {
                                    ?>
                                        <option value="<?php echo $u['lotno'];?>" ><?php echo $u['lotno'].' ('.$u['qty'].')';?></option>
                                    <?php
                                
                                }
                                ?>
                           </select>
                        </div>
                 </div>
			<?php
				}//2nd line

            
			 //3rd line
			if(!empty($out1[2]['make_wire']))
			{
				$make_wire=$out1[2]['make_wire'];
				$where=" product_id='$make_wire' ";
				$pro1=$this->Mymodel->select_where('product',$where);
				
					//---lotno
				$where=" product_id='$make_wire'  ORDER BY lotno ";
				$lotno=$this->Mymodel->select_where('wip_rope',$where);
			?>
              <input type="hidden" id="in_product_id3" value="<?php echo $make_wire;?>">
              <input type="hidden" id="in_weight3" value="<?php echo $out1[2]['weight'];?>">
              
              
                <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Inward Material 2</label>
                          <input type="text" class="form-control" value="<?php echo $pro1[0]['name'];?>" readonly  autocomplete="off">
                        </div>
                 </div>

             
          		<div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">No of wire</label>
                          <input type="text" class="form-control" id="in_wire3" value="<?php echo $out1[2]['no_of_wire_size'];?>" readonly  autocomplete="off">
                        </div>
                 </div>    
                     
                 <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Qty </label>
                          <input type="text" class="form-control"   id="in_qty3" readonly  autocomplete="off">
                        </div>
                 </div>    
                         
                   <div class="col-md-2"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Lotno</label>
                           <select class="form-control" id="in_lot3" >
                            <option value="">Select</option>
                            <?php 
                                foreach($lotno as $u)
                                {
                                    ?>
                                        <option value="<?php echo $u['lotno'];?>" ><?php echo $u['lotno'].' ('.$u['qty'].')';?></option>
                                    <?php
                                
                                }
                                ?>
                           </select>
                        </div>
                 </div>
			<?php
				}//3rd line
















			}
			else
			{
				echo "No Data Found";
			}
			
		}
		else
			{
				echo "No Data Found";
			}
	 }//function close
	












	public function rope_pro_entry_outword2()
	 {
		if(isset($_REQUEST['name']))
		{
			$product_id = $_REQUEST['name'];
			$total_qty_kg = $_REQUEST['total_qty_kg'];//weight
			
			
			
			$where="  finish_size='$product_id' ";
			$out1=$this->Mymodel->select_where('rope_config',$where);
			if(!empty($out1))
			{
				//---lotno
				$where=" product_id='$product_id' and qty>='$total_qty_kg'  GROUP BY lotno";
				$lotno=$this->Mymodel->select_where('wip_rope',$where);
				
				$where=" product_id='$product_id'  GROUP BY grade";
				$garde=$this->Mymodel->select_where('wip_rope',$where);
				
				//$qty_mtr=round($lotno[0]['qty']/$out1[0]['main_weight']);
				
				
			?>

              <input type="hidden" id="main_product_weight" value="<?php echo  $out1[0]['main_weight'];?>">
              
                 <div class="col-md-6"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Lotno</label>
                           <select class="form-control" id="lotno" >
                            <option value="">Select</option>
                            <?php 
                                foreach($lotno as $u)
                                {
                                    ?>
                                        <option value="<?php echo $u['lotno'];?>" ><?php echo $u['lotno'].' ('.$u['qty'] .')'.' ('.$u['grade'] .')';?></option>
                                    <?php
                                
                                }
                                ?>
                           </select>
                        </div>
                 </div>
              
                 
                 
                  <div class="col-md-6"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Grade</label>
                           <select class="form-control" id="grade" >
                            <option value="">Select</option>
                            <?php 
                                foreach($garde as $u)
                                {
                                    ?>
                                        <option ><?php echo $u['grade'];?></option>
                                    <?php
                                
                                }
                                ?>
                           </select>
                        </div>
                 </div>
                 
           <?php
			}
			else
			{
				echo "No Data Found";
			}
			
		}
		else
			{
				echo "No Data Found";
			}
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 /*
	 
	public function fun_set_pro_from_cust()
	 {
		
		?> <option value="">Select</option><?php
		if(isset($_REQUEST['str']))
		{
			$customer_id = $_REQUEST['str'];
			
			$where="  customer_id='$customer_id' ";
			$out1=$this->Mymodel->select_where('customer_rate',$where);
			if(!empty($out1))
			{
				foreach($out1 as $o)
				{
					$product_id=$o['product_id'];
					$where=" product_id='$product_id' ";
					$pro=$this->Mymodel->select_where('product',$where);
				?>
                	<option value="<?php echo $o['product_id'];?>"><?php echo $pro[0]['name'];?></option>
                <?php
				}
			}
		}
	 }//function close
	
	 
	 
	 
	 public function fun_get_rate_from_cust()
	 {
		
		if(isset($_REQUEST['goods_val']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$product_id = $_REQUEST['goods_val'];
			
			$where="  customer_id='$customer_id' and product_id='$product_id' ";
			$out1=$this->Mymodel->select_where('customer_rate',$where);
			if(!empty($out1))
			{
				echo $out1[0]['rate'];
			}
		}
	 }//function close
	  */
	 
	 
	 public function fun_get_rate_from_cust2()
	 {
		
		if(isset($_REQUEST['goods_val']) and strlen($_REQUEST['goods_val'])>6)
		{
			$customer_id = $_REQUEST['customer_id'];
			$product_id = $_REQUEST['goods_val'];
			
			$where="  product_code='$product_id' ";
			$out1=$this->Mymodel->select_where('product_rate_list',$where);
			if(!empty($out1))
			{
				echo $out1[0]['dis_56'];
			}
			
			
		}
	 }//function close
	 
	 
	  
	 public function fun_get_rate_from_cust3()
	 {
		if(isset($_REQUEST['goods_val']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$product_id = $_REQUEST['goods_val'];
			
			//product_name
			$where=" product_id='$product_id' ";
			$pro=$this->Mymodel->select_where('product',$where);
			$pro_name=$pro[0]['name'];
			
			
			$where="  product_code='$pro_name' ";
			$out1=$this->Mymodel->select_where('product_rate_list',$where);
			if(!empty($out1))
			{
				echo $out1[0]['dis_56'];
			}
			else
			{
				$where2="  customer_id='$customer_id' and product_id='$product_id' ";
				$out2=$this->Mymodel->select_where('customer_rate',$where2);
				if(!empty($out2))
				{
					echo $out2[0]['rate'];
				}
			}//if(!empty($out1))
		}
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 /*
	//-------------------------------------------------------Dispatch
	public function dispatch_get_po_no()
	 {
		
		
		if(isset($_REQUEST['str']))
		{
			$today_date1=date('Y-m-01');
			$today_date2=date('Y-m-31');
			
			$customer_id = $_REQUEST['str'];
			//$where="  customer_id='$customer_id' and stage='0' and status='Active' ";
			//$out1=$this->Mymodel->select_where('customer_schedule',$where);
			
			$query="
					SELECT 
					A.schedule_id,A.customer_po
					FROM customer_schedule as A 
					LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
					
					WHERE A.customer_id='$customer_id' and   A.stage='0' and A.status='Active'  and B.from_date between '$today_date1' and '$today_date2' GROUP BY A.schedule_no   ORDER by A.schedule_no DESC
				";
			$out1=$this->Mymodel->query1($query);
			
			if(!empty($out1))
			{
				?>
                        <div class="form-group" >
                          <label for="exampleInputEmail1">P.O List</label>
                         	<select class="form-control" id="po_no"    onChange="fun_get_product(this.value)" >
                            <option value="">Select</option>
							<?php
                            foreach($out1 as $o)
                            {
                               
                            ?>
                                <option value="<?php echo $o['schedule_id'];?>"><?php echo $o['customer_po'];?></option>
                            <?php
                            }
							?>
                     		</select>
                        </div>
                 
                <?php
			}
			else
			{
					?>
					
							<div class="form-group" >
							  <label for="exampleInputEmail1">P.O List</label>
								<select class="form-control" id="po_no" >
									<option value="">No Po Found</option>
								</select>
							</div>
					 
					<?php
			}
		}
		
	 }//function close
	 


	public function dispatch_get_cust_gst()
	{
		if(isset($_REQUEST['str']))
		{
			$customer_id = $_REQUEST['str'];
			
			$where="  id='$customer_id'  ";
			$out2 = $this->Mymodel->select_where('customer',$where);
			if(!empty($out2))
			{ 
				if($out2[0]['is_tcs'] == 1)
				{
					//getting tcs charge
					$where3="  id=41  ";
					$out3 = $this->Mymodel->select_where('company_setting',$where3);
					if(!empty($out3)){ $tcs_per = $out3[0]['smpt_user']; }else{$tcs_per=0;}
				}
				else
				{
					$tcs_per =0;
				}
			
			}
			else
			{ 
				$tcs_per = 0;
			}

			
			
			$where="  customer_id='$customer_id' ORDER BY entry_date DESC LIMIT 1 ";
			$out1=$this->Mymodel->select_where('dispatch',$where);
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
	



	
	public function dispatch_get_product()
	 {
		if(isset($_REQUEST['str']))
		{
			$today_date1=date('Y-m-01');
			$today_date2=date('Y-m-31');
			
			$schedule_id = $_REQUEST['str'];
			$customer_id= $_REQUEST['supplier_id'];
			$where="  schedule_id='$schedule_id' and stage='0' and from_date between '$today_date1' and '$today_date2' ";
			$out1=$this->Mymodel->select_where('customer_schedule_details',$where);
			if(!empty($out1))
			{
				?>
					<option value="">Select</option>
				<?php
				foreach($out1 as $o)
				{
					$product_id=$o['product_id'];
					$where=" product_id='$product_id' ";
					$pro=$this->Mymodel->select_where('product',$where);

					//---------getting product name by custome 
					$where=" product_id='$product_id' and customer_id='$customer_id' ";
					$rate=$this->Mymodel->select_where('customer_rate',$where);
					if(!empty($rate))
					{
						$custname= ' "'.$rate[0]['custname'].'"';
					}
					else
					{
						$custname='';
					}
				?>
					<option value="<?php echo $o['details_id'];?>">
						<?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
                    </option>
				<?php 
				}
				
			}
		}
	 }//function close

	 */
	 
	 
	 
	 
	 
	public function dispatch_get_product_without_po()
	 {
		if(isset($_REQUEST['supplier_id']))
		{
			$today_date1=date('Y-m-01');
			$today_date2=date('Y-m-31');
			
			$customer_id= $_REQUEST['supplier_id'];
			$where=" customer_id='$customer_id' ";
			$out1=$this->Mymodel->select_where('customer_rate',$where);
			if(!empty($out1))
			{
				?>
					<option value="">Select</option>
				<?php
				foreach($out1 as $o)
				{
					$product_id=$o['product_id'];
					$where=" product_id='$product_id' ";
					$pro=$this->Mymodel->select_where('product',$where);
					$custname= $o['custname'];
					
				?>
					<option value="<?php echo $o['product_id'];?>">
						<?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].')';?>
                    </option>
				<?php 
				}
				
			}
		}
	 }//function close
	 
	 
	 
	 /*
	 public function dispatch_get_product_details()
	 {
		$where=" id=10 ";
		$company_setting=$this->Mymodel->select_where('company_setting',$where);
		
		if(isset($_REQUEST['cust_sech_details_id']))
		{
		 	$cust_sech_details_id2 = $_REQUEST['cust_sech_details_id'];
			$customer_id = $_REQUEST['supplier_id'];
			$po_no = $_REQUEST['po_no'];
			$bill_type = $_REQUEST['bill_type'];
			$discount_offer = $_REQUEST['discount_offer'];
			
			if($bill_type==1)
			{
				$cust_sech_details_id=$cust_sech_details_id2;
			}
			elseif($bill_type==2)
			{
				$product_name=$cust_sech_details_id2;
				$where=" name='$product_name' ";
				$res2=$this->Mymodel->select_where('product',$where);
				$product_id_get=$res2[0]['product_id'];
				
				$where="  schedule_id='$po_no' and product_id='$product_id_get' and customer_id='$customer_id' ";
				$res3=$this->Mymodel->select_where('customer_schedule_details',$where);
				$cust_sech_details_id=$res3[0]['details_id'];
			}
			elseif($bill_type==3)
			{
				//mix
				$product_id_get=$cust_sech_details_id2;
				$where="  schedule_id='$po_no' and product_id='$product_id_get' and customer_id='$customer_id' ";
				$res3=$this->Mymodel->select_where('customer_schedule_details',$where);
				$cust_sech_details_id=$res3[0]['details_id'];
			}
			
			
			
			//bobbin assigned details
			$where="  sech_details_id='$cust_sech_details_id' and send_status='0' ";
			$out1=$this->Mymodel->select_where('customer_bobbin_assigned',$where);
			if(!empty($out1))
			{
				$customer_bobbin_assigned_id= $out1[0]['id'];
				$qty_selected=$out1[0]['qty_selected'];
				
				//-geting package
				$where="  bobbin_assigned_id='$customer_bobbin_assigned_id' ";
				$out2=$this->Mymodel->select_where('customer_bobbin_assigned_details',$where);
				if(!empty($out2))
				{
					$no_of_package=count($out2);
				}
				else
				{
					$no_of_package="1 No Bobbin assigned";
					exit;
				}
			}
			else
			{
				//echo "2 No Bobbin Assigned";
				//exit;
				$no_of_package='';
			}
			
			

			//geting customer oreder details
			$where="  details_id='$cust_sech_details_id' ";
			$out1=$this->Mymodel->select_where('customer_schedule_details',$where);
			if(!empty($out1))
			{
				$total_qty= $out1[0]['order_qty'];
				$send_qty=$out1[0]['send_qty'];
				$rate=$out1[0]['rate'];
				$product_id=$out1[0]['product_id'];
				
				if($no_of_package>0)
				{
					$total_amt=round($qty_selected*$rate,2);
				}
				else
				{
					$qty_selected='';
					$total_amt='';
				}
				
				
				//geting HSN Code
				$where9="  product_id='$product_id' and hsn!='' ORDER BY dispatch_details_id DESC LIMIT 1 ";
				$out9=$this->Mymodel->select_where('dispatch_details',$where9);
				if(!empty($out9))
				{
					$hsn_code=$out9[0]['hsn'];
					$unit_name=$out9[0]['unit_name'];
				}
				else
				{
					$hsn_code=0000;
					$unit_name='MTR';
				}

				//geting unit Name of this customer
				//$where9="  product_id='$product_id' and customer_id='$customer_id' ORDER BY dispatch_details_id DESC LIMIT 1 ";
				//$out9=$this->Mymodel->select_where('dispatch_details',$where9);
				$query2="
					SELECT 
					A.unit_name
					FROM dispatch_details as A 
					LEFT JOIN dispatch as B ON B.dispatch_id = A.dispatch_id
					WHERE A.unit_name!='' and A.product_id='$product_id' and B.customer_id='$customer_id' ORDER BY A.dispatch_details_id DESC LIMIT 1
				";
		
				$out9 = $this->Mymodel->query1($query2);
				if(!empty($out9))
				{
					$unit_name=$out9[0]['unit_name'];
				
				}
				else
				{
					$unit_name='MTR';
				}
				
			  //---------getting product rate by customer 
			  $where=" product_id='$product_id' and customer_id='$customer_id' ";
			  $out3=$this->Mymodel->select_where('customer_rate',$where);
			  if(!empty($out3))
			  {
				  $custname_rate= $out3[0]['rate'];
			  }
			  else
			  {
				  $custname_rate=$rate;
			  }
			  
			  
			  ///////applying rate discount
			  if($company_setting[0]['smpt_port']=='No' or $company_setting[0]['smpt_port']=='Mix')
				{
					$where="  product_code='$product_name' ";
					$out1=$this->Mymodel->select_where('product_rate_list',$where);
					if(!empty($out1))
					{
						$mrp= $out1[0]['rate'];
						$mrp_per_amt=round((($mrp*$discount_offer)/100),2);
						$mrp=$mrp-$mrp_per_amt;
					 	
					 	if($discount_offer>0)
					 	{
					 	    $custname_rate=$mrp;
					 	}
					 	else
					 	{
					 	    $custname_rate=$out1[0]['dis_56'];
					 	}
					 	
						//discount list
						$mrp2= $out1[0]['rate'];
						$mrp_dis_amt=round((($mrp2*56)/100),2);$mrp_56=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*62)/100),2);$mrp_62=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*63)/100),2);$mrp_63=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*63.5)/100),2);$mrp_635=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*64)/100),2);$mrp_64=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*65)/100),2);$mrp_65=$mrp2-$mrp_dis_amt;
						$mrp_dis_amt=round((($mrp2*66)/100),2);$mrp_66=$mrp2-$mrp_dis_amt;
						
						$discount_list="
											56% = 	<span style='color:blue;'>$mrp_56</span>, 
											62% = 	<span style='color:blue;'>$mrp_62</span>, 
											63% = 	<span style='color:blue;'>$mrp_63</span>, 
											63.5% = <span style='color:blue;'>$mrp_635</span>, 
											64% = 	<span style='color:blue;'>$mrp_64</span>, 
											65% = 	<span style='color:blue;'>$mrp_65</span>, 
											66% = 	<span style='color:blue;'>$mrp_66</span>, 
										";
						
					}
					else
					{
						$custname_rate=$custname_rate;
						$discount_list='';
					}
				}
				else
				{
					$custname_rate=$custname_rate;
					$discount_list='';
				}//if($company_setting[0]['smpt_port']=='No' and $discount_offer>0)
			  
			  
			
				
			
				
				echo $total_qty.'~'.$send_qty.'~'.$qty_selected.'~'.$no_of_package.'~'.$custname_rate.'~'.$total_amt.'~'.$hsn_code.'~'.$unit_name.'~'.$discount_list;
			}
			else
			{
				echo "No Customer Order Found";
				exit;
			}
			
			
			
		}
	 }//function close
	 
	*/
	
	
	
	 
	 
	 	 
	public function dispatch_fun_change_customer()
	 {
		if(isset($_REQUEST['str']))
		{
			$customer_id = $_REQUEST['str'];
			$where="  customer_id='$customer_id' and stage='0' and status='Active' ";
			$out1=$this->Mymodel->select_where('customer_schedule',$where);
			if(!empty($out1))
			{
				?>
                
                  <div class="col-md-12"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Schedule P.O List</label>
                         	<select class="form-control" id="schedule" onChange="fun_change_po(this.value)">
                            <option value="">Select</option>
							<?php
                            foreach($out1 as $o)
                            {
                               
                            ?>
                                <option value="<?php echo $o['schedule_id'];?>"><?php echo $o['customer_po'];?></option>
                            <?php
                            }
				?>
                     </select>
                        </div>
                 </div>
                 
                 
                  <div id="dis_po"  class="col-md-12" style=" margin-top:5px;"></div>
                <?php
			}
		}
	 }//function close
	 


	public function dispatch_fun_change_po()
	 {
		if(isset($_REQUEST['str']))
		{
			$schedule_id = $_REQUEST['str'];
			$where="  schedule_id='$schedule_id' and stage='0'  ";
			$out1=$this->Mymodel->select_where('customer_schedule_details',$where);
			if(!empty($out1))
			{
				?>
                
                  <div style="width:100%"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Product List</label>
                         	<select class="form-control" id="product" onChange="fun_change_product(this.value)">
                            <option value="">Select</option>
							<?php
                            foreach($out1 as $o)
                            {
                                $product_id=$o['product_id'];
                                $where=" product_id='$product_id' ";
                                $pro=$this->Mymodel->select_where('product',$where);
                            ?>
                                <option value="<?php echo $o['product_id'];?>"><?php echo $pro[0]['name'];?></option>
                            <?php
                            }
				?>
                     </select>
                        </div>
                 </div>
                 
                 
                  <div id="dis_product"  class="col-md-12" style=" margin-top:5px;"></div>
                <?php
			}
		}
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	public function dispatch_fun_change_product()
	 {
		//if(isset($_REQUEST['product_id']))
		//{
			$product_id = $_REQUEST['product_id'];
			$customer_id = $_REQUEST['customer_id'];
			$schedule_id = $_REQUEST['schedule_id'];
			
			$where4="  product_id='$product_id' and schedule_id='$schedule_id' and customer_id='$customer_id' ";
			$out4=$this->Mymodel->select_where('customer_schedule_details',$where4);
			if(!empty($out4)){
			$sech_details_id=$out4[0]['details_id'];
			$rem=$out4[0]['order_qty']-$out4[0]['send_qty'];
			
			
			
			//------------------Chicking already assigned or not
			$where4=array(
							  'customer_id'=>"$customer_id",
							  'schedule_id'=>"$schedule_id",
							  'product_id'=>"$product_id",
							  'sech_details_id'=>"$sech_details_id",
							  'send_status'=>"0",
							);
			$boobin_out=$this->Mymodel->select_where('customer_bobbin_assigned',$where4);
			if(!empty($boobin_out) and $boobin_out[0]['id']>0)
			{
				$bobbin_id2=$boobin_out[0]['id'];
				$assigned_qty=$boobin_out[0]['qty_selected'];
				
				$where=" bobbin_assigned_id='$bobbin_id2' ";
				$out5=$this->Mymodel->select_where('customer_bobbin_assigned_details',$where);
				$total_bobbin=count($out5);
				
				?>
                <h4 align="center">
                	Already Assigned Bobbin : <span style="color:red"><?php echo $total_bobbin;?></span>, 
                	Qty : <span style="color:red"><?php echo $assigned_qty;?></span>
                </h4>
				<?php
			}
			
			?>
                
                
                 <input type="hidden" class="form-control"   id="sech_details_id" required  autocomplete="off" readonly value="<?php echo $out4[0]['details_id'];?>">
                 
                  <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Order Qty(Mtr)</label>
                          <input type="text" class="form-control"   id="order_qty" required  autocomplete="off" readonly value="<?php echo $out4[0]['order_qty'];?>">
                        </div>
           			</div>
                  
                  
                    <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Send Qty(Mtr)</label>
                          <input type="text" class="form-control"   id="send_qty" required  autocomplete="off" readonly value="<?php echo $out4[0]['send_qty'];?>">
                        </div>
          			 </div>
                  
                  
                    <div class="col-md-4"> 
                        <div class="form-group" >
                          <label for="exampleInputEmail1">Remaining  Qty(Mtr)</label>
                          <input type="text" class="form-control"   id="rem_qty" required  autocomplete="off" readonly value="<?php echo $rem;?>">
                        </div>
          			 </div>
              <?php 
			}//not empty
			$where="  outward='$product_id' and assigned_status='0'  ";
			$out1=$this->Mymodel->select_where('fg_production',$where);
			if(!empty($out1))
			{
			?>    
                
                <div  style="width:100%; margin-top:40px;" >
                <h3 align="center">Select Bobbin No To Assign in this PO</h3> 
                	<table  class="table table-bordered">
                    	<thead>
                        	<tr>
                            	<th>Select</th>
                                <th>Bobbin No</th>
                                <th>Lotno</th>
                                <th>Grade</th>
                                <th>Qty (Mtr)</th>
                                <th>Qty (Kg)</th>
                                <th>Joint</th>
                                <th>O.P</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php 
							$k=1;
							foreach($out1 as $o)
							{
							?>
                            <tr>
                            	<td>
                       				<input type="checkbox" name="chk[]" class="chk" value="<?php echo $o['fg_production_id'].'~'.$o['total_qty_mtr'];?>" onClick="fun_cal_qty_selected()" >
                                </td>
                                <td><?php echo $o['bobbin_no'];?></td>
                                <td><?php echo $o['lotno'];?></td>
                                <td><?php echo $o['grade'];?></td>
                                <td><?php echo $o['total_qty_mtr'];?></td>
                                <td><?php echo $o['total_qty_kg'];?></td>
                                <td><?php echo $o['joint'];?></td>
                                <td><?php echo $o['op_name'];?></td>
                                <td>
									<?php 
										$test = new DateTime($o['entry_date']);
										echo $date1= date_format($test, 'd-m-y');
									?>
                                </td>
                            </tr>
                            <?php 
							$k++;
							}
							?>
                        </tbody>
                    </table>
                        
				</div>
                <?php
			}
		//}
	 }//function close
	 
	 
	 
	 
	 
	 public function chat_details()
	 {
		$login_id=$this->session->userdata('emp_id');

		if(isset($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
			$where="  form_emp='$id' and to_emp='$login_id' and status='0' ";
			//update
			$data=array(
						  'status'=>"1",
						);
			$this->Mymodel->update('chat',$data,$where);
			
			
			$where="  (form_emp='$login_id' and to_emp='$id' OR form_emp='$id' and to_emp='$login_id') ORDER BY save_date LIMIT 50";
			$out1=$this->Mymodel->select_where('chat',$where);
			if(!empty($out1))
			{
				foreach($out1 as $o)
				{
					$test = new DateTime($o['save_date']);
					$date1= date_format($test, 'd-m-Y h:i:s A');
					
					if($o['form_emp']==$id)
					{
						?>
							<div style=' min-height:10px; height:auto; min-width:80%;max-width:80%; width:auto;  margin-left:5px; margin-top:10px; padding:10px;  color:white; background-color:#063; float:left;border-radius:5px;'>
											<div style="min-height:10px; height:auto; min-width:100%;max-width:80%; width:auto; "><?php echo $o['msg']?></div>
											<div style="min-height:10px; height:auto; min-width:100%;max-width:80%; width:auto;  font-size:12px;"><?php echo $date1;?>   </div>
							   </div>	
						<?php
					}
					else
					{
						
						?>
						
						 <div style='min-height:10px; height:auto; min-width:80%; max-width:80%; width:auto; margin-right:5px;  margin-top:10px; padding:10px; color:black; background-color:#CCC;float:right; border-radius:5px; text-align:right;'>
						   <div style="min-height:10px; height:auto; min-width:80%;max-width:100%; width:auto; "><?php echo $o['msg']?> </div>
						   <div style="min-height:10px; height:auto; min-width:80%;max-width:100%; width:auto;  font-size:12px;"><?php echo $date1;?>
                           <?php if($o['status']!=1){?>  <span style="color:red;">Unseen</span> <?php }else{?> <span style="color:blue;">Seen</span><?php }?>
                           </div>
						  </div>  
						<?php
					}//id
				}//foreach
				
			}//out1
		}//id
	 }//function close
	 
	 public function chat_save()
	 {
		$login_id=$this->session->userdata('emp_id');
		$save_date=date('Y-m-d H:i:s');

		if(isset($_REQUEST['id']))
		{
			$id = $_REQUEST['id'];
			$msg = $_REQUEST['val'];
			
			//update
			$data=array(
						  'form_emp'=>"$login_id",
						  'to_emp'=>"$id",
						  'msg'=>"$msg",
						  'status'=>"0",
						  'save_date'=>"$save_date",
						);
			$this->Mymodel->insertdata('chat',$data);
		}//id
	 }//function close



	
	public function emp_list_in_chat_refresh()
	 {
		$login_id=$this->session->userdata('emp_id');
		$save_date=date('Y-m-d H:i:s');
		$company_info=$this->Mymodel->selectall('company_setting');
		
		if(isset($_REQUEST['id']))
		{
			//same line form Home/chat
			
			$where="1=1 and emp_id!='$login_id'  and active='Active'  ORDER BY name,last_name";
			$emp=$this->Mymodel->select_where('employee',$where);
			foreach($emp as $e)
			  {
				 $emp_id=$e['emp_id'];
				 $where=" form_emp='$emp_id' and to_emp='$login_id' and status='0' ";
				 $total_chat=$this->Mymodel->select_where('chat',$where);
				 if(!empty($total_chat))
				 {
					$chat_no=count($total_chat);
				 }
				 else
				 {
					$chat_no='';
				 }
			  ?> 
				<a href="#" onClick="fun_emp_details_on_chat(this.id)" id="<?php echo $e['emp_id'].'~'. $e['name'].' '.$e['last_name'];?>"  class="emp_list">
					<div class="inbox-item">
					 
						<div class="inbox-item-img">
							<img src="<?php  echo base_url().$company_info[0]['mail_type'];?>" class="img-circle" alt="">
						</div>
					 
						<p class="inbox-item-author"><?php echo $e['name'].' '.$e['last_name']?></p>
						<p class="inbox-item-text"><?php echo $e['mob']?> <span class="badge badge-danger pull-right" ><?php echo $chat_no;?></span></p>
						<p class="inbox-item-date"></p>
					</div>
				</a>
			  <?php 
				
			  }//foreach
		}//id
	 }//function close
































//---------------------------------------------------HEADER REFRESH START------------------------------------------
	public function header_refresh()
	 {
		$login_id=$this->session->userdata('emp_id');
		$user_email=$this->session->userdata('email');
		$today_date=date('Y-m-d');
		//$company_info=$this->Mymodel->selectall('company_setting');
    
        //-------------------------------------MOM Point
		//geting today meeting point 
		$where=" entry_date='$today_date'  ";
		$out2=$this->Mymodel->select_where('mom',$where);
		if(!empty($out2))
		{
		  $meetion_point= count($out2);
		}
		else
		{
			$meetion_point= '';
		}
		
		
		
	   //-------------------------------------Chat
	   $where="  to_emp='$login_id' and status='0' ";
	   $total_chat=$this->Mymodel->select_where('chat',$where);
	   if(!empty($total_chat))
	   {
		  $chat_no=count($total_chat);
	   }
	   else
	   {
		  $chat_no='';
	   }
		
	   //----------------------------------------------geting department id
	   $where=" emp_id='$login_id'  ";
	   $employee2=$this->Mymodel->select_where('employee',$where);
	   if(!empty($employee2))
		{
		   if($employee2[0]['department_id']==2)
		   {
			    //----indent req
				$where=" stage='1' ";
				$indent_req=$this->Mymodel->select_where('indent_req',$where);
				if(!empty($indent_req)){$indent_req=count($indent_req);}else{$indent_req='';}
			   

			    //----store request slip
			    $where=" stage='1' ";
				$count_indent=$this->Mymodel->select_where('indent_store_req',$where);
				if(!empty($count_indent)){$store_request=count($count_indent);}else{$store_request='';}
			   
		   }//dept
		   else
		   {
		   		$indent_req='';
				$store_request='';
		   }
		}//department id
		
		
	   //-------------------------------------Maintance
	   $where=" emp_id='$login_id'  ";
	   $employee2=$this->Mymodel->select_where('employee',$where);
	   if(!empty($employee2))
		{
		   if($employee2[0]['department_id']==10)
		   {
			  	 $where=" break_down_date='$today_date' and active='Pending' ";
				   $maint_problem=$this->Mymodel->select_where('maint_problem',$where);
				   if(!empty($maint_problem))
				   {
					  $maint_problem=count($maint_problem);
				   }
				   else
				   {
					  $maint_problem='';
				   }
		   }//department maintance
		   else
		   {
		   		$maint_problem='';
		   }
		}//department
		
		
		
	   //-------------------------------------Reminder
	   $dept_id=$employee2[0]['department_id'];
		
	    $query9="SELECT reminder_id  FROM reminder  WHERE   target_date<='$today_date' and event_date>='$today_date' and active='0' and (reminder_to='$dept_id' OR reminder_to='$user_email' OR reminder_to='All') ";
	    $out9=$this->Mymodel->query1($query9);
		if(!empty($out9)){$rem_no=count($out9);}else{$rem_no=0;}  
		
		/*
	   //Reminder for NPD
		$query9="SELECT audit_npd_1_id  FROM audit_npd_cftteam_2  WHERE   person_id='$login_id' and status=0 ";
		$out9=$this->Mymodel->query1($query9);
		//print_r($out9);
		if(!empty($out9)){$npd_no=count($out9);}else{$npd_no=0;}  
		

		//total reminder 
		$reminder = (int)$rem_no+(int)$npd_no;
	   if($reminder === 0){$reminder = '';}
	 */ 
	$reminder='';
	   
	   
	   //-------------------------------------ROpe M/c tool Life cycle
	   $where=" current_length>=lenght  ";
	   $rope_tool=$this->Mymodel->select_where('rope_mc_details',$where);
	   if(!empty($rope_tool))
	   {
		  $rope_tool=count($rope_tool);
	   }
	   else
	   {
		  $rope_tool='';
	   }
	   
		/*
		//-----------------------Weather Report
		$clima=$this->Mymodel->weather();
		//$temp_max=$clima->main->temp_max;
		$temp_min=$clima->main->temp_min;
		//$visibility=$clima->visibility.' mtr';
		//$wind=$clima->wind->speed.' mtr/s';
		$icon=$clima->weather[0]->icon.".png";
		$cityname = $clima->name;
		
		$src=" http://openweathermap.org/img/w/$icon ";
	  
	    $weather="
	    			<i class='dropdown style='font-size:13px;''><img height='32px' width='50px' src='$src' ;</i>
					<span style='font-size:13px;'>$temp_min &deg; C</span>
			 	";
		//<span style='font-size:13px;'>$temp_min &deg;C-$temp_max &deg;C</span> <span style='font-size:13px;'>Visibility $visibility Wind Speed $wind</span>  	*/
	
		//echo $meetion_point.'~'.$chat_no.'~'.$indent_req.'~'.$store_request.'~'.$maint_problem.'~'.$reminder.'~'.$rope_tool.'~'.$weather;
		echo $meetion_point.'~'.$chat_no.'~'.$indent_req.'~'.$store_request.'~'.$maint_problem.'~'.$reminder.'~'.$rope_tool;
		
		              
	 }//function close

	
	
	
	
	
	public function get_all_refresh_data()
	 {
		$user_email=$this->session->userdata('email');
		$login_id=$this->session->userdata('emp_id');
		$today_date=date('Y-m-d');
		$where=" emp_id='$login_id'  ";
	    
		$employee2=$this->Mymodel->select_where('employee',$where);
		$dept_id=$employee2[0]['department_id'];
		
		$name=$_REQUEST['name'];
				
				if(!empty($employee2) and $employee2[0]['department_id']==2)
				{
				   if($name=='indent')
					{
									$i=1;
									$where=" stage='1'";
									$out=$this->Mymodel->select_where('indent_req',$where);
									foreach($out as $r)
									{
										$id=$r['dept'];
										$where=" department_id='$id' ";
										$out3=$this->Mymodel->select_where('department',$where);
									?>
									  <li>
										  <a href="#"  onClick="showPage(this.id)" id="Indent/indent_edit/<?php echo $r['indent_store_req_id'];?>" >
											  <span class="badge badge-roundless badge-danger pull-right">New</span>
											  <p class="task-details"><?php echo $i.'. '.$out3[0]['name'];?> - <?php echo $r['request_by'];?></p>
										  </a>
									  </li>
										  <?php
									 $i++;
								   }//foreach
					}//indent
				   if($name=='store_req')
					{
									$i=1;
									$where=" stage='1'";
									$out=$this->Mymodel->select_where('indent_store_req',$where);
									foreach($out as $r)
									{
										$id=$r['dept'];
										$where=" department_id='$id' ";
										$out3=$this->Mymodel->select_where('department',$where);
									?>
									  <li>
										  <a href="#" onClick="showPage(this.id)" id="Indent/indent_store_edit/<?php echo $r['indent_store_req_id'];?>" >
											  <span class="badge badge-roundless badge-danger pull-right">New</span>
											  <p class="task-details"><?php echo $i.'. '.$out3[0]['name'];?> - <?php echo $r['request_by'];?></p>
										  </a>
									  </li>
										  <?php
									 $i++;
								   }//foreach
					}//indent
				   
				}//$employee2
				
				
				
		
				if($name=='reminder')
				{
						
						//----------------------------------------------------reminder   
						$where=" target_date<='$today_date' and event_date>='$today_date' and active='0' and (reminder_to='$dept_id' OR reminder_to='$user_email' OR reminder_to='All')  ";
						$reminder=$this->Mymodel->select_where('reminder',$where);
						if(!empty($reminder))
						{
							?> <li> <h4 align='center'>Reminder List</h4> </li> <?php
							foreach($reminder as $r)
							{
								$test = new DateTime($r['event_date']);
								$event_date= date_format($test, 'd-m-y');	
								?>
								<li>
									<a onClick="showPage(this.id)" id="Meeting/reminder_edit/<?php echo $r['reminder_id']?>">
										<div class="task-icon badge badge-info">R</div>
										<span class="badge badge-roundless badge-warning pull-right"><?php echo $event_date;?></span>
										<p class="task-details"><?php echo mb_substr($r['subject'], 0, 20);?>...</p>
									</a>
								</li>
								<?php
							}
						}
						/*
						//--------------------------------------------------------NPD
						$query="
									SELECT 
									A.req_send_date,A.audit_npd_1_id,C.name as cname
									FROM audit_npd_cftteam_2 as A 
									LEFT JOIN audit_npd_1 as B ON B.id = A.audit_npd_1_id
									LEFT JOIN customer as C ON C.id = B.customer
									WHERE   A.person_id='$login_id' and A.status=0
								";
						$out2=$this->Mymodel->query1($query);
						//print_r($out2);
						if(!empty($out2))
						{
							?> <li> <h4 align='center'>NPD List</h4> </li> <?php
							$j=1;
							foreach($out2 as $r)
							{
								$test = new DateTime($r['req_send_date']);
								$req_send_date= date_format($test, 'd-m-y');	
								?>
								<li>
									<a onClick="showPage(this.id)" id="Audit/npd_entry/<?php echo $r['audit_npd_1_id']?>/display">
										<span class="badge badge-roundless badge-warning pull-right"><?php echo $req_send_date;?></span>
										<p class="task-details">
											<?php echo $j.'. '.mb_substr($r['cname'], 0, 20);?>...
										</p>
										<br><br>
										<button  type="button" class="btn btn-primary " style="width:80px; margin-left:70%;">Info</button>
									</a>
								</li>
								<?php
							$j++;
							}
						}
						*/
						  
				}//reminder
				
		
		
		
	 }//function close
	

//---------------------------------------------------HEADER REFRESH END------------------------------------------



	
	public function sepecification_master_form_qc_test()
	{
		$product_id=$_REQUEST['id'];
	  //----------------getting wire master specification
	  $where=" product_id='$product_id' ";
	  $speci_master=$this->Mymodel->select_where('qc_specifi',$where);
	  //print_r($result['speci_master']);
	 
	  $a= 	$speci_master[0]['min_size'].' - '.$speci_master[0]['max_size'].'~'.
	  		
			$speci_master[0]['inhouse_min_brk'].'~'.
			$speci_master[0]['inhouse_max_brk'].'~'.
			$speci_master[0]['inhouse_min_brk'].' -  '.$speci_master[0]['inhouse_max_brk'].'~'.
			
			$speci_master[0]['customer_min_brk'].'~'.
			$speci_master[0]['customer_max_brk'].'~'.
			$speci_master[0]['customer_min_brk'].' - '.$speci_master[0]['customer_max_brk'].'~'.

			$speci_master[0]['inhouse_min_ts'].'~'.
			$speci_master[0]['inhouse_max_ts'].'~'.
			$speci_master[0]['inhouse_min_ts'].' - '.$speci_master[0]['inhouse_max_ts'].'~'.

			$speci_master[0]['customer_min_ts'].'~'.
			$speci_master[0]['customer_max_ts'].'~'.
			$speci_master[0]['customer_min_ts'].' - '.$speci_master[0]['customer_max_ts']

		;
		
		echo $a;
	
	}//function close
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function pcc_upload()
	 {
		$user_email=$this->session->userdata('email');
		if(isset($user_email))
		{
			//--------uploading image into PCC
			if(isset($_REQUEST['upload']))
			{
				$po_id=$_REQUEST['po_id'];
				
				
				$img = $_FILES['img'];
				$name = $img['name'];
				$tmp = $img['tmp_name'];
				$path = "pcc/$po_id/".$name;
				
				
				
				
				if(!empty($name))
				{
					
					//----------------------------------update				
					$data3=array('pcc_img_status'=>"1",'pcc_img'=>"$path");   
					$where3=array('po_id'=>"$po_id");   
					$this->Mymodel->update('po_entry',$data3,$where3);
					
					if(!file_exists("pcc/$po_id/"))
					{
						mkdir("pcc/$po_id/");
					}
					move_uploaded_file($tmp,$path);

					
				}
				
				redirect("Home/index?Po/po_action/$po_id");	
			}
		}
			
		
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 
	 ///disparch me schedule list -> show_table 
	 public function fun_save_schedule_remarks()
	 {
		if(isset($_REQUEST['id_no']))
		{
			$id_no=$_REQUEST['id_no'];
			$val=$_REQUEST['val'];
			
			$data3=array('plan_remarks'=>"$val");   
			$where3=array('schedule_id'=>"$id_no");   
			$this->Mymodel->update('customer_schedule',$data3,$where3);
			
		}//if
	 }//function close


	 ///disparch me schedule list -> show_table 
	 public function fun_save_schedule_remarks2()
	 {
		if(isset($_REQUEST['id_no']))
		{
			$id_no=$_REQUEST['id_no'];
			$val=$_REQUEST['val'];
			
			$data3=array('plan_remarks'=>"$val");   
			$where3=array('details_id'=>"$id_no");   
			$this->Mymodel->update('customer_schedule_details',$data3,$where3);
			
		}//if
	 }//function close




	///recvice_stock-> show_table_stock
	 public function fun_save_update_invoice_stroe_place()
	 {
		if(isset($_REQUEST['id_no']))
		{
			$id_no=$_REQUEST['id_no'];
			$val=$_REQUEST['val'];
			
			$data3=array('place'=>"$val");   
			$where3=array('details_id'=>"$id_no");   
			$this->Mymodel->update('product_invoice_entry_details',$data3,$where3);
			
		}//if
	 }//function close
	
	
	
	
	
	
	public function op_search()
	{
		
		$name =$_REQUEST['term'];
		
			$where=" name like '%$name%' and  active='Active' ORDER by name ASC LIMIT 10 ";
			$result=$this->Mymodel->select_where('employee',$where);
			$companies=array();
			foreach($result as $row)
			{
				//$names[]=array($row['category_id']=>$row['name']);
				
				$department_id=$row['department_id'];
				$where=" department_id='$department_id' ";
				$out=$this->Mymodel->select_where('department',$where);
				if(!empty($out))
				{
					$d_name=$out[0]['name'];
				}
				else
				{
					$d_name='';
				}
				
				$companies[] = array("value" =>$row['emp_code'], "label" =>$row['name'].' ('.$d_name.') "'.$row['emp_code'].'"');
			
			}
			
			echo  json_encode($companies);
			
			///echo json_encode($names);
	}

	public function get_emp_list()
	{
		
		$name =$_REQUEST['term'];
		
			$where=" name like '%$name%' and  active='Active' ORDER by name ASC LIMIT 10 ";
			$result=$this->Mymodel->select_where('employee',$where);
			$companies=array();
			foreach($result as $row)
			{
				//$names[]=array($row['category_id']=>$row['name']);
				
				$department_id=$row['department_id'];
				$where=" department_id='$department_id' ";
				$out=$this->Mymodel->select_where('department',$where);
				if(!empty($out))
				{
					$d_name=$out[0]['name'];
				}
				else
				{
					$d_name='';
				}
				
				$companies[] = array("value" =>$row['emp_id'], "label" =>$row['name'].' ('.$d_name.') "'.$row['emp_code'].'"');
			
			}
			
			echo  json_encode($companies);
			
			///echo json_encode($names);
	}//function close
	

	
	/*
	public function get_employee_attendance_date_wise()
	 {
		if(isset($_REQUEST['emp_id']))
		{
			$emp_id=$_REQUEST['emp_id'];
			$m=$_REQUEST['month_search'];
			$y=$_REQUEST['year_search'];

			//Employee details
			
			$query1="SELECT plant,company_role,name,last_name  FROM employee where  emp_code = '$emp_id'  ";
			$out1 = $this->Mymodel->query1($query1);
			
			?>
				<h2 align='center' style="color:red;font-weight:bold;"><?php if(isset($out1))echo $out1[0]['name'].' '.$out1[0]['last_name'];?></h2>
				<div class="col-md-12" style="margin-top:20px; margin-bottom:20px" >   
					<div class="col-md-6" > 
						<label for="exampleInputEmail1">Unit</label>
						<input type="text" class="form-control "  id="plant"   autocomplete="off" value="<?php if(isset($out1))echo $out1[0]['plant'];?>">
					</div>   
					<div class="col-md-6" > 
						<label for="exampleInputEmail1">Contract</label>
						<input type="text" class="form-control" id="company_role"    autocomplete="off" value="<?php if(isset($out1))echo $out1[0]['company_role'];?>">
					</div>                         
                                       
                </div>   
				
				<table border="1" width="50%" class="table-hover">
					<tr>
						<th>Date</th>
						<th>Attendance</th>
						<th>O.T.</th>
					</tr>
					<?php
					
					$test = new DateTime("$y-$m-01");
					$last_date= date_format($test, 't'); 
					
					for($i=1;$i<=$last_date;$i++)
                    {
                        $test = new DateTime("$i-$m-$y");
						$new_date= date_format($test, 'Y-m-d');
						$m1= date_format($test, 'm');
						$y1= date_format($test, 'Y');
						
						//attndance
						$column_atten = "d$i";
						$column_ot = "o$i";
						$query="SELECT $column_atten as emp_at_day,$column_ot as emp_ot_day FROM daily_attendance_monthly where  emp_code = '$emp_id' and att_year='$y1' and att_month='$m1' ";
						$out=$this->Mymodel->query1($query);
						if(!empty($out))
						{
							$emp_at_day1 = $out[0]['emp_at_day'];
							$emp_ot_day1 = $out[0]['emp_ot_day'];
							//print_r($out);
							if($emp_at_day1 == "P"){$bg_color="background-color:green;color:white;";}
							elseif($emp_at_day1 == "A"){$bg_color="background-color:red;color:white;";}
							elseif($emp_at_day1 == "S"){$bg_color="background-color:blue;color:white;";}
							elseif($emp_at_day1 == "H"){$bg_color="background-color:yellow;color:black;";}
							elseif($emp_at_day1 == "SL" or $emp_at_day1 == "CL" or $emp_at_day1 == "EL" or $emp_at_day1 == "OL"){$bg_color="background-color:purple;color:white;";}
							else{$bg_color="background-color:white;color:black;";}
						}
						
					?>
						<tr style="min-height:25px">
                         		<td><?php echo $i;?></td>
								<td ><input type="text" class="form-control emp_entry_at" id="dayentry_<?php echo $i;?>" onkeyup="checkvalidation(this.id)" max="2" maxlength="2" style="<?php if(isset($bg_color))echo $bg_color;?>"  name="d1[]"   autocomplete="off" value="<?php if(isset($emp_at_day1))echo $emp_at_day1;?>"></td>
								<td ><input type="text" class="form-control emp_entry_ot" id="otentry_<?php echo $i;?>" onkeyup="checkvalidation2(this.id)"  max="4" maxlength="4" style="<?php //if(isset($bg_color))echo $bg_color;?>"  name="o1[]"   autocomplete="off" value="<?php if(isset($emp_ot_day1))echo $emp_ot_day1;?>"></td>
						</tr>
					<?php 
					}
					?>
				</table>  

				
			<?php
		}//emp_id
	 }//function close
	 */




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
                    <th>Production</th>
                    <th>Total Dispatch to all customer</th>
                    <th>Dispatch to this customer</th>
					<th>Enter / View Plan</th>
                </tr>
           		
					<?php
                    for($i=1;$i<=31;$i++)
                    {
                        $test = new DateTime("$i-$m-$y");
                        $new_date= date_format($test, 'Y-m-d');
                         
						//total production
						$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where outward='$id_no' and  entry_date = '$new_date'  ";
                        $rope_qty=$this->Mymodel->query1($query);
                        $qty=round($rope_qty[0]['qty']);
						 
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
						
						 
						 ?>
                         <tr>
                         		<td><?php echo $i;?></td>
                                <td><?php echo $sum_qty1[]=$qty;?></td>
                                <td><?php echo $sum_qty2[]=$dis_total;?></td>
                                <td><?php echo $sum_qty3[]=$dis;?></td>
								<td><input type='tel' class="form-control plan_qty" style="height:20px" value="<?php if(!empty($plan_qty))echo $sum_qty4[]=$plan_qty;?>" ></td>
                         </tr>
                         <?php
                    }//for
					?>
                    
                    	 <tr>
                         		<td>Total</td>
                                <td><b><?php if(!empty($sum_qty1)){ echo array_sum($sum_qty1);}?></b></td>
                                <td><b><?php if(!empty($sum_qty2)){ echo array_sum($sum_qty2);}?></b></td>
                                <td><b><?php if(!empty($sum_qty3)){ echo array_sum($sum_qty3);}?></b></td>
								<td><b><?php if(!empty($sum_qty4)){ echo array_sum($sum_qty4);}?></b></td>
                         </tr>
                    
            </table>
			<div id="customer_schedule_dispatch_plan_button">
				<input type="button"  id="customer_schedule_dispatch_plan" class="btn btn-info" style=" margin-top:25px; float:right" onClick="customer_schedule_dispatch_plan()"  name="search" value="Save / Update Plan" >
            </div>
			
			<?php
		}//if
	 }//function close


	 
	public function customer_schedule_dispatch_plan_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('email');

		if(isset($_REQUEST['customer_schedule_details_id']))
		{
			$customer_schedule_details_id = $_REQUEST['customer_schedule_details_id'];
			$plan_qty = explode('~',$_REQUEST['plan_qty']);
			
			//checking entry already exits 
			$query="SELECT * FROM customer_schedule_dispatch_plan where  customer_schedule_details_id = '$customer_schedule_details_id' ";
            $out=$this->Mymodel->query1($query);
			if(!empty($out))
			{
				//already exits;
			}
			else
			{
				//new 
				$data=array(
					"customer_schedule_details_id"=>"$customer_schedule_details_id",
					'save_by'=>"$user_email",
					'save_date'=>"$today",
				);
				$this->Mymodel->insertdata('customer_schedule_dispatch_plan',$data);
			}//if(!empty($out))

			//update
			for($i=1;$i<=31;$i++)
			{
				$column_name = "p$i";
				if($plan_qty[$i] <1){$day_qty=0;}else{$day_qty = $plan_qty[$i];}
				//updating
				$data2=array("$column_name"=>"$day_qty",);
				$where2=array('customer_schedule_details_id'=>"$customer_schedule_details_id");   
				$this->Mymodel->update('customer_schedule_dispatch_plan',$data2,$where2);	
			}//for
			
			
		}//if
	}//function close





	 public function rope_pro_entry_2_prodcut_change()
	 {
		if(isset($_REQUEST['id']))
		{
			$outward1=$_REQUEST['id'];
			$mc_id=$_REQUEST['mc_id'];
			
			$where=" mc_id='$mc_id' and product_id='$outward1' ";
			$res_chk=$this->Mymodel->select_where('rope_mc_pro_details',$where);
			if(!empty($res_chk))
			{
				$por_24=$res_chk[0]['total_pro'];
				$target=$por_24/2;
			}else{$target='';}
			
			echo $target;
		}//if
	 }//function close
	 
	 
	 
	 
	 
	 
	 public function fun_get_nylon_lotno_next()
	 {
	 	   //same in qc new_list
		   $val=$_REQUEST['id'];
		
			$where=" lotno like '$val%' ORDER BY qc_id DESC LIMIT 1";
			$out=$this->Mymodel->select_where('qc',$where);
			if(!empty($out))
			{
				$old_lotno=$out[0]['lotno'];
				
				$var_a= $out[0]['lotno'][0].$out[0]['lotno'][1].$out[0]['lotno'][2];
				
				$i=intval($var_a);
				if("$i"=="$var_a")//number
				{
					$new_lot_no=$old_lotno+1;
					$result['new_lotno']=$new_lot_no;
				}//no
				else
				{
					$new_lot_no=str_replace($var_a,0,$old_lotno);
					$new_lot_no=$new_lot_no+1;
					$new_lot_no=$var_a.$new_lot_no;
					$result['new_lotno']=$new_lot_no;
				}//char
				
				
			}
			else
			{
				$result['new_lotno']=$val.'A1';
			}
			
			echo $result['new_lotno'];
		
		
	 }//function close
	 
	 
	 
	 
	 
	 
	 
	 
	 //qc/qc_elongation_get_details
	 public function qc_elongation_get_details()
		{
				if(isset($_REQUEST['id_no']))
				{
					$id=$_REQUEST['id_no'];
				
					$where=" id='$id' ";
					$out=$this->Mymodel->select_where('product_elongation',$where);
					if(isset($out))
					{
						if($out[0]['elog_date']=='0000-00-00')
						{
							$date1='';
						}
						else
						{
							$search_date22=explode('-',$out[0]['elog_date']);
							$date1=$search_date22[2].'-'.$search_date22[1].'-'.$search_date22[0];
						}
						
						if($out[0]['elog_month']<10){$month= '0'.$out[0]['elog_month'];}
						
						echo $out[0]['elog_month'].'~'.$date1.'~'.$out[0]['g1'].'~'.$out[0]['g2'].'~'.$out[0]['g3'].'~'.$out[0]['s1'].'~'.$out[0]['o1'].'~'.$out[0]['r1'].'~'.$out[0]['s2'].'~'.$out[0]['o2'].'~'.$out[0]['r2'].'~'.$out[0]['s3'].'~'.$out[0]['o3'].'~'.$out[0]['r3'];
					}
				}
		}//delete





	 
	 //koyo/entry
	 public function fun_get_koyo_model()
		{
				if(isset($_REQUEST['val']))
				{
					$short_name=$_REQUEST['val'];
				
					$where=" koyo_short_name='$short_name' and status='Active'  ORDER by model_name ASC ";
					$out=$this->Mymodel->select_where('koyo_cable_customer_model',$where);
					?><option value="">Select</option><?php
					foreach($out as $c)
					{
						?>
                        	<option value="<?php echo $c['id2'];?>"><?php echo $c['model_name'].' ('.$c['id2'].')';?></option>
                        <?php 
					}
				}
		}//function close
		
		
	 public function fun_get_koyo_part_name()
		{
				if(isset($_REQUEST['type']) and isset($_REQUEST['customer']) and isset($_REQUEST['model']) and isset($_REQUEST['cable']))
				{
					$type=$_REQUEST['type'];
					$customer=$_REQUEST['customer'];
					$model=$_REQUEST['model'];
					$cable=$_REQUEST['cable'];
					
					
					/*
					//----------------------product name 2 
					//company code
					$where=" short_name='$type' ";
					$out1=$this->Mymodel->select_where('koyo_cable_company_name',$where);
					$company_code2=$out1[0]['id2'];
					
					//customer code
					$where=" short_name='$customer' ";
					$out2=$this->Mymodel->select_where('koyo_cable_customer',$where);
					$customer_code2=$out2[0]['id2'];
					
					//customer code
					$where=" koyo_short_name='$customer' and short_name='$model' ";
					$out3=$this->Mymodel->select_where('koyo_cable_customer_model',$where);
					$model_code2=$out3[0]['id2'];
					
					
					$product_name2=$company_code2.$customer_code2.$model.$cable; 
					*/
					
					$product_name=$type.$customer.$model.$cable; 
					$where=" name='$product_name' ";
					$product=$this->Mymodel->select_where('product',$where);
					
					
					$where=" product_code='$product_name' ";
					$out2=$this->Mymodel->select_where('product_rate_list',$where);
					if(!empty($out2))
					{
						$cost=$out2[0]['dis_56'];
						$mrp=$out2[0]['rate'];
					}
					else
					{
						$cost=0;
						$mrp=0;
					}
					
					?>
                     <table  width="70%" align="center" style="font-size:14px;" >
                    		<tr>
                            	<td>#</td>
                                <td>Type</td>
                                <td>Customer</td>
                                <td>Model</td>
                                <td>Code</td>
                            </tr>
                             <tr height="40">
                            	<th>Product Code</th>
                                <th><?php echo $type;?></th>
                            	<th><?php echo $customer;?></th>
                            	<th><?php echo $model;?></th>
                            	<th><?php echo $cable;?></th>
                            </tr>
                    </table>
                    
                    <br>
                    
                  <?php 
				  	if(!empty($product) and $product[0]['product_id']>0)
					{
						//found
						//echo "green";
						?>
                        <table align="center" width="80%" style="font-size:18px; font-weight:bold">
                        	<tr height="50">
                            	<td>Part No</td>
                                <td>
                                	<span align="center" style="color:green" title="RED: Not Save Yet, GREEN: Already Saved"><?php echo $product_name;?></span>
                        		</td>
                            </tr>
                            
                            <tr height="30">
                            	
                                <td>MRP (Sticker)</td>
                                <td>
                                	<input type="number" class="form-control"  id="mrp" value="<?php echo $mrp;?>" onKeyUp="fun_get_rate_from_mrp(this.value)">
                        		</td>
                                
                                 <td> Billing Rate Default % - (56%)</td>
                                <td>
                                	<input type="number" class="form-control"  id="cost" value="<?php echo $cost;?>">
                        		</td>
                            </tr>
                        </table>
                        <?php
					}
					else
					{
						//not found
						//echo "red";
						?>
                       <table align="center" width="80%" style="font-size:18px; font-weight:bold">
                        	<tr height="50">
                            	<td>Part No</td>
                                <td>
                                	<span align="center" style="color:red" title="RED: Not Save Yet, GREEN: Already Saved"><?php echo $product_name;?></span>
                        		</td>
                            </tr>
                            <tr height="30">
                            	
                                
                                <td>MRP (Sticker)</td>
                                <td>
                                	<input type="number" class="form-control"  id="mrp" value="<?php echo $mrp;?>" onKeyUp="fun_get_rate_from_mrp(this.value)">
                        		</td>
                                
                                <td> Billing Rate Default (56%)</td>
                                <td>
                                	<input type="number" class="form-control"  id="cost" value="<?php echo $cost;?>">
                        		</td>
                            </tr>
                        </table>
                        <?php
					}
				  ?>
                    
                   
               
                   
                  <?php
				 	//get part name generate with compoanet or not
					$where=" id=40 ";
					$company_setting2 = $this->Mymodel->select_where('company_setting',$where); 
					$setting_value = $company_setting2[0]['setting_value'];
					if($setting_value == 'Yes')
					{
						if($company_setting2[0]['mail_type'] == 1)
						{
							//*
							$where=" status='Active'  ORDER by parent_group ASC limit 10";
							//$where=" status='Active'  ORDER by parent_group ASC ";
							$list=$this->Mymodel->select_where('koyo_part_name',$where);
							?>
							<br>
							<h3>Part Name Configuration (BOM)</h3>
							<table  width="100%" align="center" border="1" style="font-size:14px; margin-top:10px;">
									<tr>
										<th>#</th>
										<th>Parent_group</th>
										<th>Part Code</th>
										<th>Desc</th>
										<th>UOM</th>
										<th>Select</th>
									</tr>
									<?php 
									$i=1;
									foreach($list as $l)
									{
										$config_item_code=$l['id2'];
										$where=" koyo_part_code='$product_name' and config_item_code='$config_item_code' ";
										$out2=$this->Mymodel->select_where('koyo_part_name_config',$where);
										//print_r($out2);
									?>
									<tr>
										<td style="width:50px; font-size:12px;"><?php echo $i;?></td>
										

										<td style="width:100px;">
											<?php echo $l['parent_group'];?> 
											<input type="hidden" name="list[]" class="list"value="<?php echo $l['id2'];?>">
										</td>
										
										<td style="width:100px; font-size:12px;"><?php echo $l['id2'];?></td>
										<td style="width:300px; font-size:12px;"><?php echo $l['des'];?></td>
										<td style="width:50px; font-size:12px;"><?php echo $l['uom'];?></td>
										<td style="width:50px; font-size:12px;"><input type="checkbox"  name="chk[]" class="form-control chk" <?php if(!empty($out2)){echo "checked";}?>></td>
										
									</tr>
									<?php
									$i++; 
									}
									?>
							</table>
								<!--not in use-->
								<input type="hidden" name="comppart[]" class="comppart" >
								<input type="hidden" name="qty[]" class="qty" >
							<?php
						}
						elseif($company_setting2[0]['mail_type'] == 2)
						{
							?>
								<br>
								<h3>Part Name Configuration (BOM)</h3>
								<table  width="100%" align="center" border="1" style="font-size:14px; margin-top:10px;">
										<tr>
											<th style='width:20px'>#</th>
											<th style='width:200px'>Component Part Code</th>
											<th>Details</th>
											<th style='width:100px'>Qty</th>
										</tr>
										<?php 
										//for update entry
										$where=" koyo_part_code='$product_name' ";
										$out2=$this->Mymodel->select_where('koyo_part_name_config',$where);
										
										$j=1;
										foreach($out2 as $q)
										{
											?>
											<tr>
												<td><?php echo $j;?></td>
												<td><input type="text" style='width:100%' name="comppart[]" class="comppart" value="<?php echo $q['config_item_code'];?>"></td>
												<td><?php //echo $l['id2'];?></td>
												<td><input type="number" style='width:100%' name="qty[]" class="qty" value="<?php echo $q['qty'];?>"></td>
											</tr>
											<?php
											$j++;
										}//foreach
										
										
										//for new entry
										for($i=$j;$i<=$company_setting2[0]['smpt_port'];$i++)
										{
											?>
											<tr>
												<td><?php echo $i;?></td>
												<td><input type="text" style='width:100%' name="comppart[]" class="comppart" value=""></td>
												<td></td>
												<td><input type="number" style='width:100%' name="qty[]" class="qty" value=""></td>
											</tr>
											<?php
										}
										?>
								</table>
								<!--not in use-->
								<input type="hidden" name="list[]" class="list" >
								<input type="hidden" name="chk[]" class="chk" >
								
							<?php
						}//	elseif($company_setting2[0]['mail_type'] == 2)
						//*/
					}//if($setting_value == 'Yes')




					
				}//if
		}//function close
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		///stock_update_by_monthly_inventory_min_level   dashbord stock
		 public function stock_update_by_monthly_inventory_min_level()
		 {
			if(isset($_REQUEST['id_no']))
			{
				$product_id=$_REQUEST['id_no'];
				$val=$_REQUEST['val'];
				
				$data3=array('reorder'=>"$val");   
				$where3=array('product_id'=>"$product_id");   
				$this->Mymodel->update('product',$data3,$where3);
				
			}//if
		 }//function close


		///stock_update_by_monthly_inventory_min_level   dashbord stock
		 public function stock_update_by_monthly_inventory_max_level()
		 {
			if(isset($_REQUEST['id_no']))
			{
				$product_id=$_REQUEST['id_no'];
				$val=$_REQUEST['val'];
				
				$data3=array('max_level'=>"$val");   
				$where3=array('product_id'=>"$product_id");   
				$this->Mymodel->update('product',$data3,$where3);
				
			}//if
		 }//function close


		///stock_update_by_monthly_inventory_min_level   dashbord stock
		 public function stock_update_by_monthly_inventory_stock_level()
		 {
			if(isset($_REQUEST['id_no']))
			{
				$product_id=$_REQUEST['id_no'];
				$val=$_REQUEST['val'];
				
				$data3=array('recive_stock_level'=>"$val");   
				$where3=array('product_stock_id'=>"$product_id");   
				$this->Mymodel->update('product_stock',$data3,$where3);
				
			}//if
		 }//function close


		///stock_update_by_monthly_inventory_min_level   dashbord stock
		 public function stock_update_by_monthly_inventory_cost_level()
		 {
			if(isset($_REQUEST['id_no']))
			{
				$product_id=$_REQUEST['id_no'];
				$val=$_REQUEST['val'];
				
				$data3=array('recive_stock_level_cost'=>"$val");   
				$where3=array('product_stock_id'=>"$product_id");   
				$this->Mymodel->update('product_stock',$data3,$where3);
				
			}//if
		 }//function close
		 
		 
		 
		 
		 
		 
		 
		 
		public function koyo_fun_get_price_from_production()
		{
				if(isset($_REQUEST['val']) and strlen($_REQUEST['val'])>6  )
				{
					$product_code=$_REQUEST['val'];
				
					$where=" product_code='$product_code' ";
					$out=$this->Mymodel->select_where('product_rate_list',$where);
					if(!empty($out))
					{
						echo $out[0]['rate'];
					}
					else
					{
						echo 0.00;
					}
				}
				else
				{
					echo 0.00;
				}
		}//funtion close
		
		
		
		
		
		
		public function get_product_rate_list()
		{
				if(isset($_REQUEST['product_id']))
				{
					$product_id=$_REQUEST['product_id'];
					$where=" product_id='$product_id' ";
					$res2=$this->Mymodel->select_where('product',$where);
					$product_code=$res2[0]['name'];
				
					$where=" product_code='$product_code' ";
					$out=$this->Mymodel->select_where('product_rate_list',$where);
					if(!empty($out))
					{
						echo $out[0]['dis_56'];
					}
					else
					{
						echo 0.00;
					}
				}
				else
				{
					echo 0.00;
				}
		}//funtion close
		
		
		
		
		
		
		
		
		
		
		
		
		public function popup_customer_profile_fun()
		{
				if(isset($_REQUEST['id_no']))
				{
					$id=$_REQUEST['id_no'];
					$where=" id='$id' ";
					$res2=$this->Mymodel->select_where('customer',$where);
					//$product_code=$res2[0]['name'];
					
					?>
                    	<table width="100%" border="1" >
                        	<tr>
                            	<th>Code</th>
                                <td><?php echo $res2[0]['vender_code']?></td>
                            </tr>
                            <tr>
                            	<th>Type</th>
                                <td><?php echo $res2[0]['type']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Name</th>
                                <td><?php echo $res2[0]['name']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Mob</th>
                                <td><?php echo $res2[0]['telphone']?></td>
                            </tr>
                            
                            
                             <tr>
                            	<th>Email</th>
                                <td><?php echo $res2[0]['email']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Address</th>
                                <td><?php echo $res2[0]['address']?></td>
                            </tr>
                            
                              <tr>
                            	<th>City</th>
                                <td><?php echo $res2[0]['city']?></td>
                            </tr>
                            
                              <tr>
                            	<th>State</th>
                                <td><?php echo $res2[0]['state']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Pincode</th>
                                <td><?php echo $res2[0]['zip']?></td>
                            </tr>
                            
                             <tr>
                            	<th>GST</th>
                                <td><?php echo $res2[0]['gst_no']?></td>
                            </tr>
                         </table>
                         
                         
                         
                         <table width="100%" border="1" style=" margin-top:20px;" >
                        	<tr>
                            	<th>Person Name</th>
                                <th>Mob</th>
                                <th>Email</th>
                                <th>Designation</th>
                            </tr>
                            <tr>
                            	<td><?php echo $res2[0]['con_name1']?></td>
                                <td><?php echo $res2[0]['con_mob1']?></td>
                                <td><?php echo $res2[0]['con_email1']?></td>
                                <td><?php echo $res2[0]['designation1']?></td>
                            </tr>
                             <tr>
                            	<td><?php echo $res2[0]['con_name2']?></td>
                                <td><?php echo $res2[0]['con_mob2']?></td>
                                <td><?php echo $res2[0]['con_email2']?></td>
                                <td><?php echo $res2[0]['designation2']?></td>
                            </tr>
                         </table>
					<?php
				}//isset
		}//funtion close




		public function popup_supplier_profile_fun()
		{
				if(isset($_REQUEST['id_no']))
				{
					$id=$_REQUEST['id_no'];
					$where=" id='$id' ";
					$res2=$this->Mymodel->select_where('supplier',$where);
					//$product_code=$res2[0]['name'];
					
					?>
                    	<table width="100%" border="1" >
                        	<tr>
                            	<th>Type</th>
                                <td><?php echo $res2[0]['type']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Name</th>
                                <td><?php echo $res2[0]['name']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Mob</th>
                                <td><?php echo $res2[0]['telphone']?></td>
                            </tr>
                            
                            
                             <tr>
                            	<th>Email</th>
                                <td><?php echo $res2[0]['email']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Address</th>
                                <td><?php echo $res2[0]['address']?></td>
                            </tr>
                            
                              <tr>
                            	<th>City</th>
                                <td><?php echo $res2[0]['city']?></td>
                            </tr>
                            
                              <tr>
                            	<th>State</th>
                                <td><?php echo $res2[0]['state']?></td>
                            </tr>
                            
                             <tr>
                            	<th>Pincode</th>
                                <td><?php echo $res2[0]['zip']?></td>
                            </tr>
                            
                             <tr>
                            	<th>GST</th>
                                <td><?php echo $res2[0]['gst_no']?></td>
                            </tr>
                         </table>
                         
                         
                         
                         <table width="100%" border="1" style=" margin-top:20px;" >
                        	<tr>
                            	<th>Person Name</th>
                                <th>Mob</th>
                                <th>Email</th>
                                <th>Designation</th>
                            </tr>
                            <tr>
                            	<td><?php echo $res2[0]['con_name1']?></td>
                                <td><?php echo $res2[0]['con_mob1']?></td>
                                <td><?php echo $res2[0]['con_email1']?></td>
                                <td><?php echo $res2[0]['designation1']?></td>
                            </tr>
                             <tr>
                            	<td><?php echo $res2[0]['con_name2']?></td>
                                <td><?php echo $res2[0]['con_mob2']?></td>
                                <td><?php echo $res2[0]['con_email2']?></td>
                                <td><?php echo $res2[0]['designation2']?></td>
                            </tr>
                         </table>
					<?php
				}//isset
		}//funtion close
		
		
		
		
		
		
			
		
		public function popup_bom_fun()
		{
				if(isset($_REQUEST['id_no']))
				{
					$data=$_REQUEST['id_no'];
					
					$data2=explode('~',$data);
					$product_id=$data2[0];
					$qty=$data2[1];
					
					
					$where=" product_id='$product_id' ";
					$res2=$this->Mymodel->select_where('product',$where);
					$product_name=$res2[0]['name'];
					
					
					$out1=array();
					
					$where=" koyo_part_code='$product_name' ";
					$out1=$this->Mymodel->select_where('koyo_part_name_config',$where);
					
					
					?>
                    <h4>Total Qty <?php echo $qty;?> </h4>
                    
                    <table width="100%" border="1" >
                        <tr style=" background-color:#F2F2F2;">
                            <th>#</th>
                            <th>Component id</th>
                            <th>Details</th>
                            <th><div align="right">Qty</div></th>
                            <th><div align="right">Total Qty</div></th>
                            <th><div align="right">Unit</div></th>
                        </tr>
                        <?php 
                            $j=1;
                            foreach($out1 as $o)
                            {
                               	if($o['qty']>0)
								{
									
									 $config_item_code=$o['config_item_code'];
								
									$where=" name='$config_item_code' ";
									$res3=$this->Mymodel->select_where('product',$where);
									if(!empty($res3))
									{
										$code_details=$res3[0]['details'];
										$code_unit=$res3[0]['unit_id'];
										$where=" unit_id='$code_unit' ";
										$unit=$this->Mymodel->select_where('unit',$where);
										$code_unit=$unit[0]['name'];
									}
									else
									{
										$code_details='';
										$code_unit='';
									}
									
									
								?>
                                <tr>
                                    <td><?php echo $j;?></td>
                                    <td><?php echo $o['config_item_code'];?></td>
                                    <td><?php echo $code_details;?></td>
                                    <td><div align="right"><?php echo $o['qty'];?></div></td>
                                    <td><div align="right"><?php echo $total=round($o['qty']*$qty);?></div></td>
                                    <td><div align="right"><?php echo $code_unit;?></div></td>
                                </tr>
                                <?php
								$j++;
								}
                                
                            }
                        ?>
                    </table>
					<?php
				}//isset
		}//funtion close
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		public function fun_get_schedule_rem_product()
		{
			
			if(isset($_REQUEST['str']))
			{
				$customer_id=$_REQUEST['str'];
				
				if(isset($_REQUEST['year_search'])){
					$year_search= $_REQUEST['year_search'];
				 }//from 
				 
				 if(isset($_REQUEST['month_search'])){
					$month_search= $_REQUEST['month_search'];
				 }//TO date
				
				$this_month_from=date("$year_search-$month_search-01");
				$this_month_to=date("$year_search-$month_search-31");
				
				
				
				$query="
					SELECT 
					
					A.product_id,
					sum(A.order_qty) as total_qty,
					sum(A.send_qty) as total_send_qty, 
					P.name as pname,
					P.details as pdetails,
					C.name as cname
					
						
					FROM customer_schedule_details as A
					
					LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
					LEFT JOIN product P ON P.product_id=A.product_id
					LEFT JOIN customer C ON C.id=B.customer_id
					
					
					WHERE 
				";
				
				
				
				//if customer no send
				if($customer_id!='All')
				{
					
					$where=" A.customer_id='$customer_id' and  B.type_of_bill='Tax Invoice' and A.from_date between '$this_month_from' and '$this_month_to'  GROUP BY A.product_id  ORDER by P.name ASC ";
				}
				else
				{
					$where=" B.type_of_bill='Tax Invoice' and A.from_date between '$this_month_from' and '$this_month_to'  GROUP BY A.product_id  ORDER by P.name ASC ";
				}
				
				$query.=" $where";
				$res=$this->Mymodel->query1($query);
				?>
				 <h4><?php echo $res[0]['cname'];?></h4>
                 <table width="50%" border="1" style=" background-color:white; ">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Details</th>
                        <td align="right" style="padding-right:5px; font-weight:bold">Order</td>
                        <td align="right" style="padding-right:5px; font-weight:bold">Dispatch</td>
                        <td align="right" style="padding-right:5px; font-weight:bold">Rem.</td>
                    </tr>
                    
                    <?php 
					$j=1;
					foreach($res as $r)
					{
						
						$bal2=$r['total_qty']-$r['total_send_qty'];
						if($bal2>0)
						{
					?>
                    	<tr>
                        	<td><?php echo $j;?></td>
                            <td><?php echo $r['pname'];?></td>
                            <td>
								<?php 
									if(!empty($r['pdetails']))
									{
										echo $r['pdetails'];
									}
									else
									{
										//koyo
										echo $this->get_koyo_part_details($r['pname']);
									}
								?>
                            </td>
                            <td align="right" style="padding-right:5px;"><?php echo $r['total_qty'];?></td>
                            <td align="right" style="padding-right:5px;"><?php echo $r['total_send_qty'];?></td>
                            <td align="right" style="padding-right:5px;"><?php echo $bal[]=$bal2;?></td>
                        </tr>
                    <?php 
							$j++;
						}
						
					}
					?>
                    <tr>
                    	<td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right" style="padding-right:5px; font-weight:bold;"><?php if(!empty($bal))echo array_sum($bal);?></td>
                    </tr>
                    
                 </table>
				<?php
			
			}//IF
		}//funtion close



		public function fun_get_schedule_send_product()
		{
			
			if(isset($_REQUEST['str']))
			{
				if(isset($_REQUEST['date_wise_dispatch'])){ $date_wise_dispatch = $_REQUEST['date_wise_dispatch'];}else{$date_wise_dispatch ='';}
				
				if(isset($_REQUEST['from_page']) and $_REQUEST['from_page']=='dispatch')
				{
					$customer_id2=explode('_',$_REQUEST['str']);
					$customer_id = $customer_id2[1];
					
					//form dispatch->dispatch_list
					if(isset($_REQUEST['search_date1'])){
						$search_date1= $_REQUEST['search_date1'];
						$this_month_from = date("Y-m-01", strtotime($search_date1));
					 }//from 
					 else
					 {
						$this_month_from = date('Y-m-01');
					 }
					 
					 if(isset($_REQUEST['search_date2'])){
						$search_date2= $_REQUEST['search_date2'];
						$this_month_to = date("Y-m-t", strtotime($search_date2));
						$last_date = date("t", strtotime($this_month_to));
						$year_search = date("Y", strtotime($this_month_to));
						$month_search = date("m", strtotime($this_month_to));
					 }//TO date
					 else
					 {
						$this_month_to = date('Y-m-t');
						$last_date = date("t", strtotime($this_month_to));
						$year_search = date("Y", strtotime($this_month_to));
						$month_search = date("m", strtotime($this_month_to));
					 }
					
				}
				else
				{
					//form dispatch->order_list
					
					$customer_id=$_REQUEST['str'];
					
					if(isset($_REQUEST['year_search'])){
						$year_search= $_REQUEST['year_search'];
					 }//from
					 else
					 {
						$year_search=date('Y');	 
					 } 
					 
					 if(isset($_REQUEST['month_search'])){
						$month_search= $_REQUEST['month_search'];
					 }//TO date
					 else
					 {
						$year_search=date('m');	 
					 } 
					 
					$a_date = "$year_search-$month_search-01";
					$last_date = date("t", strtotime($a_date));
					
					$this_month_from=date("$year_search-$month_search-01");
					$this_month_to=date("$year_search-$month_search-$last_date");
				}
				

				
				
				//getting all product list
				$query=" SELECT B.product_id, 
								P.name as pname,
								C.name as cname,
								G.name as gname
						 FROM dispatch as A
						 LEFT JOIN dispatch_details as B ON B.dispatch_id = A.dispatch_id 
						 LEFT JOIN product as P ON P.product_id = B.product_id
						 LEFT JOIN category as G ON G.category_id = P.category_id
						 LEFT JOIN customer as C ON C.id = A.customer_id 
						 WHERE  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0 and  A.customer_id='$customer_id' and A.entry_date between '$this_month_from' and '$this_month_to' 
						 GROUP BY B.product_id ORDER BY G.category_id,B.product_id ";
				$product_list=$this->Mymodel->query1($query);
				
				
				?>
				 <h4><?php echo $product_list[0]['cname'];?></h4>
				 <h5>Date Wise Qty Dispatch. <?php echo $this_month_from;?> To <?php echo $this_month_to;?> </h5>
                 <table width="98%" border="1" style=" background-color:white; ">
				 
				<tr>
				 		<th>#</th>
						<th>Category</th>
						<th>Our Product Name</th>
						<th>Customer Product Name</th>
						<td align="right">Schedule</td>
						<?php 
						$j=1;
						for($i=1;$i<=$last_date;$i++)
						{
							?>
								<td align="right"><b><?php echo $i;?></b></td>
							<?php
						}
						?>
						<td align="right"><b>Dispatch</b></td>
						<td align="right"><b>Balance</b></td>
						<td align="right"><b>%</b></td>
						<td align="right"><b>Per Day (<?php echo $rem_day = $last_date-date('d');?>)</b></td>
				</tr>



				<?php 
				$j=1;
				foreach($product_list as $p)
				{
					$product_id = $p['product_id'];

					//getting schedule
					$query=" SELECT sum(order_qty) as order_qty
						 FROM  customer_schedule_details as A
						 WHERE   A.customer_id='$customer_id' and A.product_id ='$product_id' and A.from_date between '$this_month_from' and '$this_month_to' 
						 GROUP BY A.product_id  ";
					$sch=$this->Mymodel->query1($query);
					if(!empty($sch))
					{
						$sch_qty = round($sch[0]['order_qty']);
					}
					else
					{
						$sch_qty = 0;
					}
					
				?>

					<!------------------------------------------PLAN-------------->
					<tr style="background-color:#faece1; height:25px">
							<td colspan=5>Plan</td>
							<?php 
							$j=1;
							$plan_qty2 = array();
							for($i=1;$i<=$last_date;$i++)
							{
								$column_name = "p$i";
								//$query="SELECT $column_name as plan FROM customer_schedule_dispatch_plan where  customer_schedule_details_id = '$details_id' ";
								$query=" SELECT $column_name as plan
										FROM  customer_schedule_dispatch_plan as B
										LEFT JOIN customer_schedule_details as A ON A.details_id = B.customer_schedule_details_id
										WHERE   A.customer_id='$customer_id' and A.product_id ='$product_id' and A.from_date between '$this_month_from' and '$this_month_to' 
										";
								$rope_qty=$this->Mymodel->query1($query);
								if(!empty($rope_qty))
								{
									$plan_qty=round($rope_qty[0]['plan']);
								}
								else
								{
									$plan_qty=0;
								}
								?>
									<td align="right"><?php echo $plan_qty2[] = $plan_qty;?></td>
								<?php
							}
							?>
							<td align="right"><b><?php if(!empty($plan_qty2)){echo $total = array_sum($plan_qty2); }else{ echo $total=0;} $plan_qty3[]= $total;?></b></td>
							<td colspan=3></td>
					</tr>
					
					
					<!------------------------------------------Dispatch-------------->
					<tr>
				 		<td><?php echo $j;?></td>
						<td><?php echo $p['gname'];?></td>
						<td><?php echo $p['pname'];?></td>
						<td>
							<?php 
								//Getting customer product name
								echo $this->Mymodel->get_customer_product_name($customer_id,$product_id);
							?>
						</td>
						<td align="right"><b><?php echo $sch_qty3[]= $sch_qty;?></b></td>
						<?php 
						$send_qty2 = array();
						for($i=1;$i<=$last_date;$i++)
						{
							$test = new DateTime("$i-$month_search-$year_search");
							$new_date= date_format($test, 'Y-m-d');

							//getting qty via date
							$query2=" SELECT 
									sum(B.qty) as qty
									FROM dispatch as A
									LEFT JOIN dispatch_details as B ON B.dispatch_id = A.dispatch_id 
									LEFT JOIN product as P ON P.product_id = B.product_id 
									WHERE  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0 and  A.customer_id='$customer_id' and B.product_id='$product_id' and A.entry_date = '$new_date'  GROUP BY B.product_id ";
							$res2=$this->Mymodel->query1($query2);
							if(!empty($res2))
							{
								$send_qty = $res2[0]['qty'];
							}
							else
							{
								$send_qty = 0;
							}

							$send_qty2[] = $send_qty;
							?>
								<td align="right"><?php echo $send_qty;?></td>
							<?php
						}
						?>

						<td align="right"><b><?php if(!empty($send_qty2)){echo $total = array_sum($send_qty2); }else{ echo $total=0;} $send_qty3[]= $total;?></b></td>
						<td align="right"><b><?php echo $rem2 =  $sch_qty-$total; $rem3[]= $rem2;  ?></b></td>
						<td align="right">
							<b><?php   
									if($sch_qty > 0)
									{
										echo $per = round(($total*100)/$sch_qty);
										echo "%";
									}
							?></b>
						</td>

						<td align="right"><b><?php if($rem2>0){echo round($rem2/$rem_day);}  ?></b></td>
					</tr>

					
					
					
					<!------------------------------------------PLAN-------------->
					<tr style="background-color:#e6e1dc; height:25px">
							<td colspan=5>Plan - Dispatch = Rem</td>
							<?php 
							$j=1;
							for($i=1;$i<=$last_date;$i++)
							{
								?>
									<td align="right"><?php echo round($send_qty2[$i-1] - $plan_qty2[$i-1]);?></td>
								<?php
							}
							?>
							<td colspan=4></td>
					</tr>


					<tr style="background-color:#e6e1dc; height:25px">
							<td colspan=5>%</td>
							<?php 
							$j=1;
							for($i=1;$i<=$last_date;$i++)
							{
								?>
									<td align="right"><?php $x = $send_qty2[$i-1];  $y = $plan_qty2[$i-1]; if($y >0 and $x>0 ){echo  round(($x*100)/$y);echo "%";}  ?> </td>
								<?php
							}
							?>
							<td colspan=4></td>
					</tr>
					<!------------------------------------------PLAN-------------->

					<tr style="background-color:white; height:30px">
						<td colspan=40></td>
					</tr>

				<?php 
				$j++;
				 }
				?>
					
					<tr>
                    	<td></td>
                        <td></td>
						<td></td>
						<td></td>
						<td align="right" style=" font-weight:bold;"><?php if(!empty($sch_qty3)){echo $a= array_sum($sch_qty3);}else{$a=0;}?></td>
                        <?php 
						$j=1;
						for($i=1;$i<=$last_date;$i++)
						{
							?>
								<td></td>
							<?php
						}
						?>
                        <td align="right" style=" font-weight:bold;"><?php if(!empty($send_qty3)){echo $b= array_sum($send_qty3);}else{$b=0;}?></td>
						<td align="right" style=" font-weight:bold;"><?php if(!empty($rem3)){echo $c= array_sum($rem3);}else{$c=0;}?></td>
						<td align="right" style=" font-weight:bold;">
							<?php 
								echo $per = round(($b*100)/$a);
								echo "%";
							?>
						</td>
						<td></td>
                    </tr>
                    
                 </table>
				<?php
				
			}//IF
		}//funtion close
		
		
		
		
		
		
		
		
		
		
		
		
		
		//use in dispatch->customer_dispatch_item_wise and sonewhere else
		public function get_koyo_part_details($part_name)
		{
		
				if(strlen($part_name)==8 or strlen($part_name)==7)
				{	 
					  $customer=$part_name[1].$part_name[2];
					  $model=$part_name[3].$part_name[4];
					  
					  if(strlen($part_name)<8)
					  {
					  	$cable=$part_name[5].$part_name[6];
					  }
					  else
					  {
					  	$cable=$part_name[5].$part_name[6].$part_name[7];
					  }
						
					  //customer code
					  $where=" short_name='$customer' ";
					  $out2=$this->Mymodel->select_where('koyo_cable_customer',$where);
					  if(!empty($out2)){$customer_name=$out2[0]['name'];}else{$customer_name='';}
					   
					  //customer code
					  $where=" koyo_short_name='$customer' and id2='$model' ";
					  $out3=$this->Mymodel->select_where('koyo_cable_customer_model',$where);
					  if(!empty($out3))
					  {
					  	$model_name=$out3[0]['model_name'];
					  }
					  else
					  {
					  	$model_name='';
					  }
					  
					 
					  //customer code
					  $where="  id2='$cable' ";
					  $out3=$this->Mymodel->select_where('koyo_cable_name',$where);
					  if(!empty($out3))
					  {
					  	$cable_name=$out3[0]['name'];
					  }
					  else
					  {
					  	$cable_name='';
					  }
					
					  if(strlen($customer_name)>1 and strlen($model_name)>1 and strlen($cable_name)>1)
					  {
							return $product_name2=$customer_name.' / '.$model_name.' / '.$cable_name;
					  }
					  else
					  {
							return '';
					  }
					  
				}
				else
				{
					return '';
				} 
					  
		
		}//funtion close
		
		
		
		
		
		
		
		
		
		
		
		
		
		//--------------Dispatch / bill_delete1 page
		public function get_dispatch_bill_info()
		{
		
			if(isset($_REQUEST['dispatch_id']))
			{
				$dispatch_id=$_REQUEST['dispatch_id'];
				
				//dispatch details
				$query="
						SELECT 
						D.entry_date,D.dispatch_no,D.fin_year,D.type_of_bill,
						D.transport_mode,D.vehicle_no,D.place_of_supply,D.total,D.grandtotal,
						C.name as cname
						FROM dispatch as D
						LEFT JOIN customer C ON C.id=D.customer_id
						
						WHERE D.dispatch_id='$dispatch_id'
				";
				$res1=$this->Mymodel->query1($query);
				
				if(!empty($res1))
				{
				
					$query="
						SELECT 
						A.dispatch_details_id,A.product_id,A.qty,A.unit_name,A.hsn,A.package_no,A.rate,A.total_amt,
						P.name as pname,
						P.details as pdetails
						FROM dispatch_details as A
						LEFT JOIN product P ON P.product_id=A.product_id
						WHERE  A.dispatch_id='$dispatch_id'
					";
					$res2=$this->Mymodel->query1($query);
					
					$test = new DateTime($res1[0]['entry_date']);
					$date1= date_format($test, 'd-m-Y');
					
					?>
						<table style="width:100%;" border="1">
							<tr>
								<td>Invoice No : <b><?php echo str_pad($res1[0]['dispatch_no'], 4, "0", STR_PAD_LEFT);?></b></td>
								<td>Bill Year : <b><?php echo $res1[0]['fin_year'];?></b></td>
								<td>Date : <b><?php echo $date1;?></b></td>
								<td>Type : <b><?php echo $res1[0]['type_of_bill'];?></b></td>
								<td></td>
							</tr>
							<tr>
								<td><b><?php echo $res1[0]['cname'];?></b></td>
								<td><?php echo $res1[0]['transport_mode'];?></td>
								<td><?php echo $res1[0]['vehicle_no'];?></td>
								<td><?php echo $res1[0]['place_of_supply'];?></td>
							</tr>
						</table>
						
						<table style="width:100%; margin-top:30px;" border="1">
							<tr>
								<td>#</td>
								<td>Product</td>
								<td>Qty</td>
								<td>Unit</td>
								<td>HSN</td>
								<td>Package</td>
								<td>Rate</td>
								<td>Amt</td>
							</tr>
						   <?php
						   $j=1;
						   foreach($res2 as $r)
						   { 
						   ?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $r['pname'];?></td>
								<td><?php echo $r['qty'];?></td>
								<td><?php echo $r['unit_name'];?></td>
								<td><?php echo $r['hsn'];?></td>
								<td><?php echo $r['package_no'];?></td>
								<td><?php echo $r['rate'];?></td>
								<td><?php echo $r['total_amt'];?></td>
							</tr>
							<?php 
							$j++;
						   }//foreach
						   ?>
						</table>
						
						<table style="width:30%; margin-top:30px;" border="1" align="right">
							<tr>
								<td>Grand Total</td>
								<td> <b><?php echo $res1[0]['grandtotal'];?></b></td>
							</tr>
						</table>
					<?php
					}//!empty
					else
					{
						echo " Invoice id not found.";
					}
				
			}//dispatch_id
		
		}//funtion close
		
		
		
		//----------------------------------Deleting invoice bill
		public function dispatch_delete1()
		{
		
			if(isset($_REQUEST['dispatch_id']) and isset($_REQUEST['action_type']))
			{
				$action_type=$_REQUEST['action_type'];
				$dispatch_id=$_REQUEST['dispatch_id'];
				$query=" SELECT customer_schedule_details_id,qty,total_amt,product_id FROM dispatch_details WHERE  dispatch_id='$dispatch_id' ";
				$res2=$this->Mymodel->query1($query);
				if(!empty($res2))
				{ 
					foreach($res2 as $r)
					{
						$customer_schedule_details_id = $r['customer_schedule_details_id'];
						$qty = $r['qty'];
						$total_amt = $r['total_amt'];
						$product_id = $r['product_id'];
						
						//----------min in customer_schedule_details 
						$query=" SELECT send_qty,send_amt,stage,order_qty FROM customer_schedule_details WHERE  details_id='$customer_schedule_details_id' ";
						$out=$this->Mymodel->query1($query);
						if(!empty($out))
						{
							//qty min
							$total_qty_send = $out[0]['send_qty'];
							$current_qty = round($total_qty_send-$qty,2);
							
							//amt min
							$total_amt_send = $out[0]['send_amt'];
							$current_amt = round($total_amt_send-$total_amt,2);
							
							//stage 
							if($current_qty >= $out[0]['order_qty'])
							{
								$stage=1;
							}
							else
							{
								$stage=0;
							}
							
							
							//update customer_schedule_details
							$data=array(
										  'send_qty'=>"$current_qty",
										  'send_amt'=>"$current_amt",
										  'stage'=>"$stage",
										);
							 $where=array('details_id'=>"$customer_schedule_details_id");   
							 $this->Mymodel->update('customer_schedule_details',$data,$where);	

							//---update stock and balance
							$this->Stock->stock_form_invoice($product_id,$qty,$total_amt,'Dispatch bill delete','',date('Y-m-d'),'','');
							 
						}
						else
						{
							echo "No Schedule Found";
						}//if(!empty($out))
						
						
					}//foreach
					
					
					
					
					if($action_type == "Cancel")
					{
						//cancel
						$data=array('is_it_cancel'=>"1");
						$where=array('dispatch_id'=>"$dispatch_id");   
						$this->Mymodel->update('dispatch',$data,$where);	
					}
					else
					{
						//delete
						//-------deteting bill
						$where9=" dispatch_id='$dispatch_id' ";
						$this->Mymodel->deletedata('dispatch',$where9);
						
						$where9=" dispatch_id='$dispatch_id' ";
						$this->Mymodel->deletedata('dispatch_details',$where9);
					}//action_type
					

					// api sending data to ware house
					$dispatch_id=$_REQUEST['dispatch_id'];
					$query=" SELECT customer_id FROM dispatch WHERE  dispatch_id='$dispatch_id' ";
					$res2=$this->Mymodel->query1($query);
					$customer_id = $res2[0]['customer_id'];
					$this->Mymodel->dispatch_data_send_api($customer_id,$dispatch_id,'delete');
					
					echo "Save";
				}//if(!empty($res2))
				else
				{
					echo " Invoice id not found.";
				}
				
			}//dispatch_id
			else
			{
				echo " Enter Dispatch Id.";
			}
		
		}//function close
		
		
		
		
		
		
		//--------------Dispatch /  product bill_delete2 page
		public function get_dispatch_bill_info2()
		{
			if(isset($_REQUEST['dispatch_id']))
			{
				$dispatch_id=$_REQUEST['dispatch_id'];
				
				//dispatch details
				$query="
						SELECT 
						D.entry_date,D.dispatch_no,D.fin_year,D.type_of_bill,
						D.transport_mode,D.vehicle_no,D.place_of_supply,D.total,D.grandtotal,
						C.name as cname
						FROM dispatch as D
						LEFT JOIN customer C ON C.id=D.customer_id
						
						WHERE D.dispatch_id='$dispatch_id'
				";
				$res1=$this->Mymodel->query1($query);
				
				if(!empty($res1))
				{
				
					$query="
						SELECT 
						A.dispatch_details_id,A.product_id,A.qty,A.unit_name,A.hsn,A.package_no,A.rate,A.total_amt,
						P.name as pname,
						P.details as pdetails
						FROM dispatch_details as A
						LEFT JOIN product P ON P.product_id=A.product_id
						WHERE  A.dispatch_id='$dispatch_id'
					";
					$res2=$this->Mymodel->query1($query);
					
					$test = new DateTime($res1[0]['entry_date']);
					$date1= date_format($test, 'd-m-Y');
					
					?>
						<table style="width:100%;" border="1">
							<tr>
								<td>Invoice No : <b><?php echo str_pad($res1[0]['dispatch_no'], 4, "0", STR_PAD_LEFT);?></b></td>
								<td>Bill Year : <b><?php echo $res1[0]['fin_year'];?></b></td>
								<td>Date : <b><?php echo $date1;?></b></td>
								<td>Type : <b><?php echo $res1[0]['type_of_bill'];?></b></td>
								<td></td>
							</tr>
							<tr>
								<td><b><?php echo $res1[0]['cname'];?></b></td>
								<td><?php echo $res1[0]['transport_mode'];?></td>
								<td><?php echo $res1[0]['vehicle_no'];?></td>
								<td><?php echo $res1[0]['place_of_supply'];?></td>
							</tr>
						</table>
						
						<table style="width:100%; margin-top:30px;" border="1">
							<tr>
								<td>Select</td>
                                <td>#</td>
								<td>Product</td>
								<td>Qty</td>
								<td>Unit</td>
								<td>HSN</td>
								<td>Package</td>
								<td>Rate</td>
								<td>Amt</td>
							</tr>
						   <?php
						   $j=1;
						   foreach($res2 as $r)
						   { 
						   ?>
							<tr>
								<td><input type="checkbox" value="<?php echo $r['dispatch_details_id'];?>" id="details_list" class="details_list"></td>
                                <td><?php echo $j;?></td>
								<td><?php echo $r['pname'];?></td>
								<td><?php echo $r['qty'];?></td>
								<td><?php echo $r['unit_name'];?></td>
								<td><?php echo $r['hsn'];?></td>
								<td><?php echo $r['package_no'];?></td>
								<td><?php echo $r['rate'];?></td>
								<td><?php echo $r['total_amt'];?></td>
							</tr>
							<?php 
							$j++;
						   }//foreach
						   ?>
						</table>
						
						<table style="width:30%; margin-top:30px;" border="1" align="right">
							<tr>
								<td>Grand Total</td>
								<td> <b><?php echo $res1[0]['grandtotal'];?></b></td>
							</tr>
						</table>
					<?php
					}//!empty
					else
					{
						echo " Invoice id not found.";
					}
				
			}//dispatch_id
		
		}//funtion close
		
		
		
		//----------------------------------Deleting invoice bill
		public function dispatch_delete2()
		{
			if(isset($_REQUEST['dispatch_id']) and isset($_REQUEST['list2']))
			{
				$dispatch_details_id = $_REQUEST['list2'];
				$dispatch_details_id2 = explode('~',$dispatch_details_id);
				//print_r($dispatch_details_id2);
				foreach($dispatch_details_id2 as $d)
				{
					if(!empty($d))
					{
						$dispatch_details_id3 = $d;
						//-------------------------
						$query=" SELECT customer_schedule_details_id,qty,total_amt,dispatch_id,product_id FROM dispatch_details WHERE  dispatch_details_id='$dispatch_details_id3' ";
						$res2=$this->Mymodel->query1($query);
						$dispatch_id = $res2[0]['dispatch_id'];
						$customer_schedule_details_id = $res2[0]['customer_schedule_details_id'];
						$qty = $res2[0]['qty'];
						$total_amt = $res2[0]['total_amt'];
						$product_id = $res2[0]['product_id'];
						
								
						//----------min in customer_schedule_details 
						$query=" SELECT send_qty,send_amt,stage,order_qty FROM customer_schedule_details WHERE  details_id='$customer_schedule_details_id' ";
						$out=$this->Mymodel->query1($query);
						if(!empty($out))
						{
							//qty min
							$total_qty_send = $out[0]['send_qty'];
							$current_qty = round($total_qty_send-$qty,2);
							
							//amt min
							$total_amt_send = $out[0]['send_amt'];
							$current_amt = round($total_amt_send-$total_amt,2);
							
							//stage 
							if($current_qty >= $out[0]['order_qty'])
							{
								$stage=1;
							}
							else
							{
								$stage=0;
							}
							
							//update customer_schedule_details
							$data=array(
										  'send_qty'=>"$current_qty",
										  'send_amt'=>"$current_amt",
										  'stage'=>"$stage",
										);
							 $where=array('details_id'=>"$customer_schedule_details_id");   
							 $this->Mymodel->update('customer_schedule_details',$data,$where);
							 
							//---update stock and balance
							$this->Stock->stock_form_invoice($product_id,$qty,$total_amt,'Dispatch bill delete','',date('Y-m-d'),'','');
							 
						}
						else
						{
							echo "No Schedule Found";
						}//if(!empty($out))
						
						
						
					 //-------deteting bill
					 $where9=" dispatch_details_id='$dispatch_details_id3' ";
					 $this->Mymodel->deletedata('dispatch_details',$where9);
							
					
					  //-----------------------------		
					}//if(!empty($d))
				}//foreach
				
				
				
						
				 //---------------------------Updateing total amt in dispatch	(selected item is deleted above and below code use to sum of rem item qty)
				 $query7=" SELECT sum(total_amt) as product_total_amt FROM dispatch_details WHERE  dispatch_id='$dispatch_id' ";
				 $out7=$this->Mymodel->query1($query7);
				 if(!empty($out7))
				 {
					 $current_product_total = $out7[0]['product_total_amt'];
					 
					 $query8=" SELECT * FROM dispatch WHERE  dispatch_id='$dispatch_id' ";
					 $out8=$this->Mymodel->query1($query8);
					
					 $old_total_before_dis = $out8[0]['total_before_dis'];
					 
					 $old_ther_discount_per = $out8[0]['other_discount_per'];
					 $old_discount = $out8[0]['discount'];
					 
					 $old_total = $out8[0]['total'];
					
					 $old_ffc_amt = $out8[0]['ffc_amt'];
					 $old_laber_charge = $out8[0]['laber_charge'];
					
					 $old_sgst_per = $out8[0]['sgst_per'];
					 $old_sgst_val = $out8[0]['sgst_val'];
					
					 $old_cgst_per = $out8[0]['cgst_per'];
					 $old_cgst_val = $out8[0]['cgst_val'];
	  
					 $old_igst_per = $out8[0]['igst_per'];
					 $old_igst_val = $out8[0]['igst_val'];
	  
					 $old_roundoff = $out8[0]['roundoff'];
					 $old_grandtotal = $out8[0]['grandtotal'];

					 $old_tds_per = $out8[0]['tds_per'];
					 $old_tds_val = $out8[0]['tds_val'];
					 $old_grandtotal2 = $out8[0]['grandtotal2'];
					 
					
					 
					 // 1% discount Calculation
					 if(!empty($old_ther_discount_per))
					 {
						$other_discount_offer = round(($old_ther_discount_per*$current_product_total)/100,2);
						$total_taxbale_amt = ($current_product_total-$other_discount_offer);
					 }
					 else
					 {
						$other_discount_offer='';
						$total_taxbale_amt = $current_product_total;
					 }
					 
					 // FFC and Labour charge
					 $total_taxbale_amt = ($total_taxbale_amt+$old_ffc_amt+$old_laber_charge);
						
					
					//SGST
					if(!empty($old_sgst_per)){ $new_sgst_amt = round(($old_sgst_per*$total_taxbale_amt)/100,2);}else{ $new_sgst_amt =0; }
	  
					//CGST
					if(!empty($old_cgst_per)){ $new_cgst_amt = round(($old_cgst_per*$total_taxbale_amt)/100,2);}else{ $new_cgst_amt =0; }
	  
					//IGST
					if(!empty($old_igst_per)){ $new_igst_amt = round(($old_igst_per*$total_taxbale_amt)/100,2);}else{ $new_igst_amt =0; }
					
						
					//Grand Total
					$new_grand_total = round($total_taxbale_amt+$new_sgst_amt+$new_cgst_amt+$new_igst_amt);

					//TCS
					if(!empty($old_tds_per) and $old_tds_per>0){ $new_tds_val = round(($old_tds_per*$new_grand_total)/100); $new_grandtotal2 = ($new_grand_total+$new_tds_val); }else{ $new_tds_val =0; $new_grandtotal2 = $new_grand_total; }
					 
					//update Dispatch
					$data9=array(
								  'total_before_dis'=>"$current_product_total",
								  'discount'=>"$other_discount_offer",
								  'total'=>"$total_taxbale_amt",
								  
								  'sgst_val'=>"$new_sgst_amt",
								  'cgst_val'=>"$new_cgst_amt",
								  'igst_val'=>"$new_igst_amt",
								  'tds_val'=>"$new_tds_val",
	  
								  'grandtotal'=>"$new_grand_total",
								  'grandtotal2'=>"$new_grandtotal2",
								);
					$where9=array('dispatch_id'=>"$dispatch_id");   
					$this->Mymodel->update('dispatch',$data9,$where9);	
					 
					 
					 //---------------------------Updateing total amt in dispatch	

					// api sending data to ware house
					$dispatch_id=$_REQUEST['dispatch_id'];
					$query=" SELECT customer_id FROM dispatch WHERE  dispatch_id='$dispatch_id' ";
					$res2=$this->Mymodel->query1($query);
					$customer_id = $res2[0]['customer_id'];
					//deleting
					$this->Mymodel->dispatch_data_send_api($customer_id,$dispatch_id,'delete');
					//new entry
					$this->Mymodel->dispatch_data_send_api($customer_id,$dispatch_id,'entry');
							
					 echo "Save";
				 
				 }//if(!empty($out7))
				 else
				 {
				 	echo "No Dispatch Details Found.";
				 }//if(!empty($out7))
							
				
				
				
			}//dispatch_id
			else
			{
				echo " Enter Dispatch Id.";
			}
		}//funtion close



		//----------------------------------------------------------------------------------------------------------------invoice/ bill_delete1 page
		public function get_invoice_bill_info()
		{
			if(isset($_REQUEST['dispatch_id']))
			{
				$invoice_id=$_REQUEST['dispatch_id'];
				
				//invoice details
				$query="
						SELECT 
						D.product_invoice_save_date,D.product_invoice_save_no,
						D.invoice_no,D.total,D.grandtotal,
						C.name as cname
						FROM product_invoice_entry as D
						LEFT JOIN supplier C ON C.id=D.supplier_id
						
						WHERE D.product_invoice_entry_id='$invoice_id'
				";
				$res1=$this->Mymodel->query1($query);
				if(!empty($res1))
				{
					//invoice item
					$query="
						SELECT 
						A.details_id,A.product_id,A.net,A.price,A.amount,
						P.name as pname,
						P.details as pdetails
						FROM product_invoice_entry_details as A
						LEFT JOIN product P ON P.product_id=A.product_id
						WHERE  A.product_invoice_entry_id='$invoice_id'
					";
					$res2=$this->Mymodel->query1($query);
					
					$test = new DateTime($res1[0]['product_invoice_save_date']);
					$date1= date_format($test, 'd-m-Y');
					
					?>
						<table style="width:100%;" border="1">
							<tr>
								<td>Invoice No : <b><?php echo $res1[0]['product_invoice_save_no'];?></b></td>
								<td>Date : <b><?php echo $date1;?></b></td>
								<td>Customer Invoice no : <b><?php echo $res1[0]['invoice_no'];?></b></td>
								<td></td>
							</tr>
							<tr>
								<td><b><?php echo $res1[0]['cname'];?></b></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
						
						<table style="width:100%; margin-top:30px;" border="1">
							<tr>
								<td>#</td>
								<td>Product</td>
								<td>Qty</td>
								<td>Rate</td>
								<td>Amt</td>
							</tr>
						<?php
						$j=1;
						foreach($res2 as $r)
						{ 
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $r['pname'];?></td>
								<td><?php echo $r['net'];?></td>
								<td><?php echo $r['price'];?></td>
								<td><?php echo $r['amount'];?></td>
							</tr>
							<?php 
							$j++;
						}//foreach
						?>
						</table>
						
						<table style="width:30%; margin-top:30px;" border="1" align="right">
							<tr>
								<td>Total</td>
								<td> <b><?php echo $res1[0]['total'];?></b></td>
							</tr>
							<tr>
								<td>Grand Total</td>
								<td> <b><?php echo $res1[0]['grandtotal'];?></b></td>
							</tr>
						</table>
					<?php
					}//!empty
					else
					{
						echo " Invoice id not found.";
					}
				
			}//dispatch_id

		}//funtion close


		//----------------------------------Deleting invoice bill
		public function invoice_delete1()
		{
			
			if(isset($_REQUEST['dispatch_id']))
			{
				$product_invoice_entry_id=$_REQUEST['dispatch_id'];
				$query=" SELECT poid,net,amount FROM product_invoice_entry_details WHERE  product_invoice_entry_id='$product_invoice_entry_id' ";
				$res2=$this->Mymodel->query1($query);
				if(!empty($res2))
				{
					foreach($res2 as $r)
					{
						$customer_schedule_details_id = $r['poid'];
						$qty = $r['net'];
						$total_amt = $r['amount'];
						
						//----------min in po_entry_details 
						$query=" SELECT rev_qunt,rev_amount,stage, qunt as order_qty FROM po_entry_details WHERE  po_entry_details_id='$customer_schedule_details_id' ";
						$out=$this->Mymodel->query1($query);
						if(!empty($out))
						{
							//qty min
							$total_qty_send = $out[0]['rev_qunt'];
							$current_qty = round($total_qty_send-$qty,2);
							
							//amt min
							$total_amt_send = $out[0]['rev_amount'];
							$current_amt = round($total_amt_send-$total_amt,2);
							
							//stage 
							if($current_qty >= $out[0]['order_qty'])
							{
								$stage=1;
							}
							else
							{
								$stage=0;
							}
							
							
							//update customer_schedule_details
							$data=array(
										'rev_qunt'=>"$current_qty",
										'rev_amount'=>"$current_amt",
										'stage'=>"$stage",
										);
							$where=array('po_entry_details_id'=>"$customer_schedule_details_id");   
							$this->Mymodel->update('po_entry_details',$data,$where);	
							
						}
						else
						{
							echo "No Schedule Found";
						}//if(!empty($out))
						
						
					}//foreach
					
					
					
					//-------deteting invoice
					$where9=" product_invoice_entry_id='$product_invoice_entry_id' ";
					$this->Mymodel->deletedata('product_invoice_entry',$where9);
					
					$where9=" product_invoice_entry_id='$product_invoice_entry_id' ";
					$this->Mymodel->deletedata('product_invoice_entry_details',$where9);
					
					echo "Save";
					
					
				}//if(!empty($res2))
				else
				{
					echo " Invoice id not found.";
				}
				
			}//dispatch_id
			else
			{
				echo " Enter invoice Id.";
			}

		}//function close



		//--------------Dispatch /  product bill_delete2 page
		public function get_invoice_bill_info2()
		{
			if(isset($_REQUEST['dispatch_id']))
			{
				$invoice_id=$_REQUEST['dispatch_id'];
				
				//invoice details
				$query="
						SELECT 
						D.product_invoice_save_date,D.product_invoice_save_no,
						D.invoice_no,D.total,D.grandtotal,
						C.name as cname
						FROM product_invoice_entry as D
						LEFT JOIN supplier C ON C.id=D.supplier_id
						
						WHERE D.product_invoice_entry_id='$invoice_id'
				";
				$res1=$this->Mymodel->query1($query);
				if(!empty($res1))
				{
					//invoice item
					$query="
						SELECT 
						A.details_id,A.product_id,A.net,A.price,A.amount,
						P.name as pname,
						P.details as pdetails
						FROM product_invoice_entry_details as A
						LEFT JOIN product P ON P.product_id=A.product_id
						WHERE  A.product_invoice_entry_id='$invoice_id'
					";
					$res2=$this->Mymodel->query1($query);
					
					$test = new DateTime($res1[0]['product_invoice_save_date']);
					$date1= date_format($test, 'd-m-Y');
					
					?>
						<table style="width:100%;" border="1">
							<tr>
								<td>Invoice No : <b><?php echo $res1[0]['product_invoice_save_no'];?></b></td>
								<td>Date : <b><?php echo $date1;?></b></td>
								<td>Customer Invoice no : <b><?php echo $res1[0]['invoice_no'];?></b></td>
								<td></td>
							</tr>
							<tr>
								<td><b><?php echo $res1[0]['cname'];?></b></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</table>
						
						<table style="width:100%; margin-top:30px;" border="1">
							<tr>
								<td>Select</td>
								<td>#</td>
								<td>Product</td>
								<td>Qty</td>
								<td>Rate</td>
								<td>Amt</td>
							</tr>
						   <?php
						   $j=1;
						   foreach($res2 as $r)
						   { 
						   ?>
							<tr>
								<td><input type="checkbox" value="<?php echo $r['details_id'];?>" id="details_list" class="details_list"></td>
                                <td><?php echo $j;?></td>
								<td><?php echo $r['pname'];?></td>
								<td><?php echo $r['net'];?></td>
								<td><?php echo $r['price'];?></td>
								<td><?php echo $r['amount'];?></td>
							</tr>
							<?php 
							$j++;
						   }//foreach
						   ?>
						</table>
						
						<table style="width:30%; margin-top:30px;" border="1" align="right">
							<tr>
								<td>Total</td>
								<td> <b><?php echo $res1[0]['total'];?></b></td>
							</tr>
							<tr>
								<td>Grand Total</td>
								<td> <b><?php echo $res1[0]['grandtotal'];?></b></td>
							</tr>
						</table>
					<?php
					}//!empty
					else
					{
						echo " Invoice id not found.";
					}
				
			}//dispatch_id
		
		}//funtion close



		//----------------------------------Deleting invoice bill
		public function invoice_delete2()
		{
			if(isset($_REQUEST['dispatch_id']) and isset($_REQUEST['list2']))
			{
				$dispatch_details_id = $_REQUEST['list2'];
				$dispatch_details_id2 = explode('~',$dispatch_details_id);
				//print_r($dispatch_details_id2);
				foreach($dispatch_details_id2 as $d)
				{
					if(!empty($d))
					{
						$dispatch_details_id3 = $d;
						//-------------------------
						$query=" SELECT poid,net,amount,product_invoice_entry_id FROM product_invoice_entry_details WHERE  details_id='$dispatch_details_id3' ";
						$res2=$this->Mymodel->query1($query);
						$product_invoice_entry_id = $res2[0]['product_invoice_entry_id'];
						$poid = $res2[0]['poid'];
						$qty = $res2[0]['net'];
						$total_amt = $res2[0]['amount'];
						
								
						//----------min in customer_schedule_details 
						$query=" SELECT rev_qunt,rev_amount,stage, qunt as order_qty FROM po_entry_details WHERE  po_entry_details_id='$poid' ";
						$out=$this->Mymodel->query1($query);
						if(!empty($out))
						{
							//qty min
							$total_qty_send = $out[0]['rev_qunt'];
							$current_qty = round($total_qty_send-$qty,2);
							
							//amt min
							$total_amt_send = $out[0]['rev_amount'];
							$current_amt = round($total_amt_send-$total_amt,2);
							
							//stage 
							if($current_qty >= $out[0]['order_qty'])
							{
								$stage=1;
							}
							else
							{
								$stage=0;
							}
							
							//update customer_schedule_details
							$data=array(
										  'rev_qunt'=>"$current_qty",
										  'rev_amount'=>"$current_amt",
										  'stage'=>"$stage",
										);
							 $where=array('po_entry_details_id'=>"$poid");   
							 $this->Mymodel->update('po_entry_details',$data,$where);	
							 
						}
						else
						{
							echo "No Schedule Found";
						}//if(!empty($out))
						
						
						
					 //-------deteting bill
					 $where9=" details_id='$dispatch_details_id3' ";
					 $this->Mymodel->deletedata('product_invoice_entry_details',$where9);
							
					
					  //-----------------------------		
					}//if(!empty($d))
				}//foreach
				
				
				
						
				 //---------------------------Updateing total amt in invoice entry	
				 $query7=" SELECT sum(amount) as product_total_amt,sum(itemgstrs) as itemgstrs FROM product_invoice_entry_details WHERE  product_invoice_entry_id='$product_invoice_entry_id' ";
				 $out7=$this->Mymodel->query1($query7);
				 if(!empty($out7))
				 {
					$current_product_total = (int)$out7[0]['product_total_amt'];
					$itemgstrs = round((int)$out7[0]['itemgstrs']);
					
					$query8=" SELECT * FROM product_invoice_entry WHERE  product_invoice_entry_id='$product_invoice_entry_id' ";
					$out8=$this->Mymodel->query1($query8);
					
					 
					 $old_total = (int)$out8[0]['total'];

					 $old_dis_per = (int)$out8[0]['dis_per'];
					 $old_dis_amt = (int)$out8[0]['dis_amt'];
					
					
					 $old_ffc_amt = $out8[0]['ffc_amt'];
					
					
	  
					 $old_roundoff = (int)$out8[0]['roundoff'];
					 $old_grandtotal = (int)$out8[0]['grandtotal'];
					 
					
					//discount per
					if(!empty($old_dis_per) and $old_dis_per>0){ $new_dis_amt = round(($old_dis_per*$current_product_total)/100,2);}else{ $new_dis_amt =0; }
					$total_taxbale_amt = ($current_product_total-$new_dis_amt);
					 
					
					//Grand Total
					$new_grand_total = round((int)$total_taxbale_amt + (int)$old_ffc_amt + (int)$itemgstrs);
					 

					
					//update Dispatch
					$data9=array(
								  'total_old'=>"$current_product_total",
								  'dis_amt'=>"$new_dis_amt",
								  'total'=>"$total_taxbale_amt",
								  'gstcharge'=>"$itemgstrs",
								  'grandtotal'=>"$new_grand_total",
								);
					$where9=array('product_invoice_entry_id'=>"$product_invoice_entry_id");   
					$this->Mymodel->update('product_invoice_entry',$data9,$where9);	
					 
					 
					 //---------------------------Updateing total amt in dispatch	
							
					 echo "Save";
				 
				 }//if(!empty($out7))
				 else
				 {
				 	echo "No Dispatch Details Found.";
				 }//if(!empty($out7))
							
				
				
				
			}//dispatch_id
			else
			{
				echo " Enter Dispatch Id.";
			}
		}//funtion close
































		public function get_list_for_rgp_nrgp()
		{
			if(isset($_REQUEST['val'])){$val = $_REQUEST['val'];}else{$val = '';}
			
			if($val=='Supplier')
			{
				//-----supplier
				?><option value="" >Select From Supplier</option><?php
				
				$where=" status='Active' ORDER BY name ASC ";
				$out2=$this->Mymodel->select_where('supplier',$where);
				foreach($out2 as $r)
				{
					?><option value="<?php echo $r['id'];?>" ><?php echo $r['name'];?></option><?php
				}
			}
			elseif($val=='Customer')
			{
				//-----customer
				?><option value="" >Select From Customer</option><?php

				$where=" status='Active' ORDER BY name ASC ";
				$out2=$this->Mymodel->select_where('customer',$where);
				foreach($out2 as $r)
				{
					?><option value="<?php echo $r['id'];?>" ><?php echo $r['name'];?></option><?php
				}
			}
			else
			{
				//no data selected
			}

		}//funtion close







		public function fun_extra_discount_percent()
		{
			//------------------getting extra discount option is enable or deable
			$where=" id=37 OR id=38 ";
			$company_setting_extra_discount_option=$this->Mymodel->select_where('company_setting',$where);
			$extra_discount_option_date_option = $company_setting_extra_discount_option[0]['setting_value'];
			$extra_discount_option_max_date = $company_setting_extra_discount_option[0]['smpt_host'];
			
			$extra_discount_option_qty_option = $company_setting_extra_discount_option[1]['setting_value'];
			
			
			if(isset($_REQUEST['po_no']) and $extra_discount_option_date_option == 1 and $extra_discount_option_qty_option == 1)
			{
				$po_no = $_REQUEST['po_no'];
				$where = " schedule_id='$po_no' ";
				$out = $this->Mymodel->select_where('customer_schedule',$where);
				$schedule_save_date = $out[0]['schedule_save_date'];

				//$schedule_save_date  
				//$billing_date1 = $_REQUEST['entry_date2'];
				$test = new DateTime($schedule_save_date);
				$schedule_save_date= date_format($test, 'Y-m-d');	
				$m= date_format($test, 'm');	
				$y= date_format($test, 'Y');	

				// discount max date
				$discount_max_date = date("$y-$m-$extra_discount_option_max_date");

				
				
				
				//qty discount
				$query = " SELECT sum(order_qty) as total_qty FROM customer_schedule_details WHERE schedule_id='$po_no' ";
				$out2 = $this->Mymodel->query1($query);
				$total_qty = $out2[0]['total_qty'];
				if($total_qty >= 2500)
				{
					$per = 5;
				}
				elseif($total_qty < 2500 and $total_qty >= 2000)
				{
					$per = 3;
				}
				elseif($total_qty < 2000 and $total_qty >= 1500)
				{
					$per = 2;
				}
				else
				{
					$per =0;	
				}




				
				//date discount
				if($schedule_save_date <= $discount_max_date and $per>0)//remove $per 0 if 1% extra date add supertly
				{
					$per2 = $per + 1;
				}//bill date 
				else
				{
					$per2 = 0;
				}


				echo $per2;
			
			}//po_no
			
			
		
		}//funtion close







		
	/*
		public function fun_hr_reports_reports_search()
		{
			if(!empty($_REQUEST['type_search']) and !empty($_REQUEST['year_search']) and !empty($_REQUEST['month_search']))
			{
				$type_search = $_REQUEST['type_search'];
			
				if(isset($_REQUEST['year_search'])){$year_search = $_REQUEST['year_search'];}else{$year_search = '';}
				if(isset($_REQUEST['month_search'])){$month_search = $_REQUEST['month_search'];}else{$month_search = '';}	

				$link1 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&search=Search ";
				$link2 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&day_search=11&type2_search=Canteen&search=Search ";
				$link3 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&day_search=11&type2_search=Breakfast&search=Search ";
				$link4 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&search=Search ";
				?>
					<div class="col-md-4" style="margin-top:5px;"><a  target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_entry_manual<?php echo $link1;?>"  class="btn btn-success" style="width:100%;" >Attendance & O.T Reports</a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_other_exp_list<?php echo $link2;?>"  class="btn btn-primary" style="width:100%;" >Canteen Exp. Reports</a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_other_exp_list<?php echo $link3;?>"  class="btn btn-primary" style="width:100%;" >Break Fast Exp. Reports</a></div> 
					
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/master/<?php echo $link4;?>"  class="btn btn-info" style="width:100%;" >Master Salary Report </a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/without_ot/<?php echo $link4;?>&format_type=without_ot"  class="btn btn-info" style="width:100%;" >Salary Report </a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/incentive/<?php echo $link4;?>&format_type=incentive"  class="btn btn-info" style="width:100%;" >Incentive Report </a></div> 
				
					<div class="col-md-12" style="height:100px;">  </div>
					
					<div class="col-md-12"> <hr>Generate Salary </div>
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_generate_entry<?php echo $link4;?>"  class="btn btn-danger" style="width:100%;" >Salary Generated</a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_entry_manual<?php echo $link4;?>"  class="btn btn-warning" style="width:100%;" >Salary permanent Save</a></div> 
					<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1<?php echo $link4;?>"  class="btn btn-info" style="width:100%;" >Master Salary Report </a></div> 
				
				<?php
				
			}//if(isset($_REQUEST['type_search']))
			else
			{
				?> <div class="col-md-4" style="margin-top:5px;"> <?php echo "Please Select Type, Year, Month.";?></div> <?php
			}
		
		
		
		}//function close
		*/


		/*
		public function get_emp_details_in_hr_gatepass()
		{
				$emp_code=$_REQUEST['str'];
			
				$where=" emp_code='$emp_code' ";
				$res=$this->Mymodel->select_where('employee',$where);
				if(!empty($res))
				{
					$name  = $res[0]['name'].' '.$res[0]['last_name'];
					$department_id  = $res[0]['department_id'];
					
					$role_in_department  = $res[0]['role_in_department'];

					//dept
					$where=" department_id='$department_id' ";
					$res2=$this->Mymodel->select_where('department',$where);
					if(!empty($res2))
					{
						$department_name  = $res2[0]['name'];
					}
					else
					{
						$department_name  = '';
					}
					
					//dept role
					$where=" role_id='$role_in_department' ";
					$res2=$this->Mymodel->select_where('department_role',$where);
					if(!empty($res2))
					{
						$role_name  = $res2[0]['name'];
					}
					else
					{
						$role_name  = '';
					}


					echo $name.'~'.$department_name.'~'.$role_name;

				}
		}//function close
		*/




		//same on audit/npd_entry
		public function fun_get_project_name_form_custome_id()
		{
			?> <option value=''>Select</option> <?php
				
				$customer_id=$_REQUEST['val'];
				
				$where=" customer='$customer_id' and status='0' ORDER BY project ASC ";
				$res=$this->Mymodel->select_where('customer_enq',$where);
				if(!empty($res))
				{
					foreach($res as $r)
					{
					?>
						<option value='<?php echo $r['project'];?>'><?php echo $r['project'];?></option>
					<?php
					}
				}
		}//function close
		
		
		
		
		
		
		
		
		
		
		public function component_entry_get_new_partno()
		{
			$val = $_REQUEST['val'];

			$firt_code = 'CC';

			$where = " category_id='$val' ";
			$res = $this->Mymodel->select_where('category',$where);
			if(!empty($res))
			{
				$short_name = $res[0]['short_name'];
				$half_code = $firt_code.'-'.$short_name.'-';
				if(strlen($res[0]['short_name'])>0)
				{
					//getting last partcode
					$where = " name like '$half_code%' ORDER BY name DESC LIMIT 1 ";
					$pro = $this->Mymodel->select_where('product',$where);
					if(!empty($pro) and strlen($pro[0]['name'])>1)
					{
						$product_name = $pro[0]['name'];
						$product_name2 = explode('-',$product_name);
						$last_no =  str_pad($product_name2[2]+1, 3, "0", STR_PAD_LEFT );
						echo $next_part_code = $half_code.$last_no;
					}
					else
					{
						echo $next_part_code = $half_code.'001';
					}
					
				}//if(strlen($res[0]['short_name'])>0)
				else
				{
					echo "Category short name not found";
				}
			}
			else
			{
				echo "No Category Found";
			}
		
		}//function close




		
		public function get_all_clo_display()
		{
			$category_id = $_REQUEST['val'];
			$where = " category_id='$category_id' ";
			$res91 = $this->Mymodel->select_where('category',$where);
			if(!empty($res91))
			{
				
				$component_enrty_columns = explode(',',$res91[0]['component_enrty_columns']);

							if(in_array('M',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Thead (M) </label>
                                  <input type="text" class="form-control"  id="thead"   autocomplete="off" value="<?php if(isset($res2[0]['thread_data']))echo $res2[0]['thread_data'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="thead"   autocomplete="off" value="<?php if(isset($res2[0]['thread_data']))echo $res2[0]['thread_data'];?>" >
                              <?php
                            }

                            

                            if(in_array('D1',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 1 for D1</label>
                                  <input type="text" class="form-control"  id="outer_dia_1"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_1']))echo $res2[0]['outer_dia_1'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_1"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_1']))echo $res2[0]['outer_dia_1'];?>" >
                              <?php
                            }


                            if(in_array('D2',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 2 for D2</label>
                                  <input type="text" class="form-control"  id="outer_dia_2"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_2']))echo $res2[0]['outer_dia_2'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_2"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_2']))echo $res2[0]['outer_dia_2'];?>" >
                              <?php
                            }

                            if(in_array('D3',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 3 for D3</label>
                                  <input type="text" class="form-control"  id="outer_dia_3"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_3']))echo $res2[0]['outer_dia_3'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_3"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_3']))echo $res2[0]['outer_dia_3'];?>" >
                              <?php
                            }

                            if(in_array('D4',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 4 for D4</label>
                                  <input type="text" class="form-control"  id="outer_dia_4"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_4']))echo $res2[0]['outer_dia_4'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_4"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_4']))echo $res2[0]['outer_dia_4'];?>" >
                              <?php
                            }

                            if(in_array('D5',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 5 for D5</label>
                                  <input type="text" class="form-control"  id="outer_dia_5"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_5']))echo $res2[0]['outer_dia_5'];?>" >
                                  </div>
                                </div>

                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_5"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_5']))echo $res2[0]['outer_dia_5'];?>" >
                              <?php
                            }


                            if(in_array('D6',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Outer Dia 6 for D6</label>
                                  <input type="text" class="form-control"  id="outer_dia_6"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_6']))echo $res2[0]['outer_dia_6'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_dia_6"   autocomplete="off" value="<?php if(isset($res2[0]['outer_dia_6']))echo $res2[0]['outer_dia_6'];?>" >
                              <?php
                            }

                            
                            if(in_array('L1',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Length / Thread-Length (L1)</label>
                                  <input type="text" class="form-control"  id="thead_length"   autocomplete="off" value="<?php if(isset($res2[0]['thread_length']))echo $res2[0]['thread_length'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="thead_length"   autocomplete="off" value="<?php if(isset($res2[0]['thread_length']))echo $res2[0]['thread_length'];?>" >
                              <?php
                            }

                            if(in_array('L2',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Complete Lenght (L2) </label>
                                  <input type="text" class="form-control"  id="outer_length"   autocomplete="off" value="<?php if(isset($res2[0]['comp_length']))echo $res2[0]['comp_length'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="outer_length"   autocomplete="off" value="<?php if(isset($res2[0]['comp_length']))echo $res2[0]['comp_length'];?>" >
                              <?php
                            }

                            if(in_array('ID',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Inner Dia (ID) </label>
                                  <input type="text" class="form-control"  id="inner_dia_1"   autocomplete="off" value="<?php if(isset($res2[0]['inner_dia_1']))echo $res2[0]['inner_dia_1'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="inner_dia_1"   autocomplete="off" value="<?php if(isset($res2[0]['inner_dia_1']))echo $res2[0]['inner_dia_1'];?>" >
                              <?php
                            }

                            

                            if(in_array('A/F',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Across Flat (A/F) </label>
                                  <input type="text" class="form-control"  id="across"   autocomplete="off" value="<?php if(isset($res2[0]['across_flat']))echo $res2[0]['across_flat'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="across"   autocomplete="off" value="<?php if(isset($res2[0]['across_flat']))echo $res2[0]['across_flat'];?>" >
                              <?php
                            }

                            if(in_array('T',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Thikness (T) </label>
                                  <input type="text" class="form-control"  id="thikness"   autocomplete="off" value="<?php if(isset($res2[0]['thinkness_data']))echo $res2[0]['thinkness_data'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="thikness"   autocomplete="off" value="<?php if(isset($res2[0]['thinkness_data']))echo $res2[0]['thinkness_data'];?>" >
                              <?php
                            }

                            if(in_array('C',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">No of Coil (C) </label>
                                  <input type="text" class="form-control"  id="no_of_coil"   autocomplete="off" value="<?php if(isset($res2[0]['no_of_coil']))echo $res2[0]['no_of_coil'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              <input type="hidden" class="form-control"  id="no_of_coil"   autocomplete="off" value="<?php if(isset($res2[0]['no_of_coil']))echo $res2[0]['no_of_coil'];?>" >
                              <?php
							}
							
							if(in_array('ASSYCOMP',$component_enrty_columns))
                            {
                              ?>
                                <div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Component Partno 1 </label>
                                  	<input type="text" class="form-control"  id="comp_part1"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part1']))echo $res2[0]['comp_part1'];?>" >
                                  </div>
                                </div>

								<div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Component Partno 2 </label>
                                  	<input type="text" class="form-control"  id="comp_part2"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part2']))echo $res2[0]['comp_part2'];?>" >
                                  </div>
                                </div>

								<div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Component Partno 3 </label>
                                  	<input type="text" class="form-control"  id="comp_part3"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part3']))echo $res2[0]['comp_part3'];?>" >
                                  </div>
                                </div>

								<div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Component Partno 4 </label>
                                  	<input type="text" class="form-control"  id="comp_part4"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part4']))echo $res2[0]['comp_part4'];?>" >
                                  </div>
                                </div>

								<div class="col-md-2">
                                  <div class="form-group" >
                                  <label for="exampleInputEmail1">Component Partno 5 </label>
                                  	<input type="text" class="form-control"  id="comp_part5"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part5']))echo $res2[0]['comp_part5'];?>" >
                                  </div>
                                </div>
                              <?php
                            }
                            else
                            {
                              ?>
                              	<input type="hidden" class="form-control"  id="comp_part1"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part1']))echo $res2[0]['comp_part1'];?>" >
								<input type="hidden" class="form-control"  id="comp_part2"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part2']))echo $res2[0]['comp_part2'];?>" >
								<input type="hidden" class="form-control"  id="comp_part3"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part3']))echo $res2[0]['comp_part3'];?>" >
								<input type="hidden" class="form-control"  id="comp_part4"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part4']))echo $res2[0]['comp_part4'];?>" >
								<input type="hidden" class="form-control"  id="comp_part5"   autocomplete="off" value="<?php if(isset($res2[0]['comp_part5']))echo $res2[0]['comp_part5'];?>" >
                              <?php
                            }

							


				
			}//not entry
		}//function close








		//Delete rope pro entry
		public function rope_pro_entry_delete()
	 	{
			if(strlen($this->uri->segment(3)>0))
			{
				$id = $this->uri->segment(3);
				$where9=" rope_production_id='$id' ";
				$this->Mymodel->deletedata('rope_mc_production',$where9);
				echo "<span style='color:red'>Data Deleted.</span> Reload your page";
			}
			else
			{
				echo "No id found";
			}
		}//function close

		
		//Delete wet pro entry
		public function wet_pro_entry_delete()
	 	{
			if(strlen($this->uri->segment(3)>0))
			{
				$id = $this->uri->segment(3);
				$where9=" wet_mc_production_id='$id' ";
				$this->Mymodel->deletedata('wet_mc_production',$where9);
				echo "<span style='color:red'>Wet block Data Deleted.</span> Reload your page";
			}
			else
			{
				echo "No id found";
			}
		}//function close
		

		//Delete spooling pro entry
		public function spooling_pro_entry_delete()
	 	{
			if(strlen($this->uri->segment(3)>0))
			{
				$id = $this->uri->segment(3);
				$where9=" spooling_id='$id' ";
				$this->Mymodel->deletedata('spooling',$where9);
				echo "<span style='color:red'>Spooling Data Deleted.</span> Reload your page";
			}
			else
			{
				echo "No id found";
			}
		}//function close
		


		//Delete fg pro entry
		public function fg_pro_entry_delete()
	 	{
			if(strlen($this->uri->segment(3)>0))
			{
				$id = $this->uri->segment(3);
				$where9=" fg_production_id='$id' ";
				$this->Mymodel->deletedata('fg_production',$where9);
				echo "<span style='color:red'>Fg  Data Deleted.</span> Reload your page";
			}
			else
			{
				echo "No id found";
			}
	    }//function close
		

	  
		
		//Product update
		public function product_update()
	 	{
			$where = " 1=1 ";
			$res = $this->Mymodel->select_where('temp1',$where);

			foreach($res as $r)
			{
				$product_id = $r['c1'];
				$category_id = $r['c2'];

				$where2=array('product_id'=>$product_id);
				$data2=array('category_id'=>$category_id);
				
				$this->Mymodel->update('product',$data2,$where2);
				$this->Mymodel->update('product_issue',$data2,$where2);
				$this->Mymodel->update('product_stock',$data2,$where2);
				$this->Mymodel->update('product_recive_stock_level_his',$data2,$where2);
			}
			echo "done";
			
		}//function close





		
		//fun_get_monthly_production
		public function fun_get_monthly_production()
	 	{
			if( isset($_REQUEST['str']))
			{
				$str2 = explode(',',$_REQUEST['str']);
				$dept = $str2[0];
				$fdate = $str2[1];
				$tdate = $str2[2];
				
				
				$this->Mymodel->get_production_dept(2,$dept,$fdate,$tdate); 
			}
			else
			{
				echo "No Dept., From Date, To Date Found.";
			}
		}//function close


		//fun_get_monthly_production
		public function fun_get_monthly_production_date()
	 	{
			if( isset($_REQUEST['str']))
			{
				$str2 = explode(',',$_REQUEST['str']);
				$dept = $str2[0];
				$fdate = $str2[1];
				$tdate = $str2[2];
				
				//$where = '';
				$this->Mymodel->get_production_dept(3,$dept,$fdate,$tdate); 
			}
			else
			{
				echo "No Dept., From Date, To Date Found.";
			}
		}//function close




		//fun_get_dispatch_product_customer_date_wise
		public function fun_get_dispatch_product_customer_date_wise()
	 	{
			if( isset($_REQUEST['str']))
			{
				$str2 = explode(',',$_REQUEST['str']);
				$product_id = $str2[0];
				$fdate = $str2[1];
				$tdate = $str2[2];
				
				
				$this->Mymodel->fun_get_dispatch_product_customer_date_wise(2,$product_id,$fdate,$tdate); 
				$this->Mymodel->fun_get_production_product_customer_date_wise(2,$product_id,$fdate,$tdate); 
			}
			else
			{
				echo "No Dept., From Date, To Date Found.";
			}
		}//function close







			//dashbord_tab1_ 
			public function new_task_from()
			{
				$box_length = $_REQUEST['box_length'];
				if(isset($_REQUEST['id_no']))
				{
					$id_no = $_REQUEST['id_no'];
					$query3 = " SELECT * FROM task_planning WHERE  id='$id_no' ";
					$res2 = $this->Mymodel->query1($query3);
				}
			
				if(isset($res2[0]['entry_date']))
				{
					$test = new DateTime($res2[0]['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');	
				}
				else
				{
					$entry_date = date('d-m-Y');
				}
	
				if(isset($res2[0]['due_date']))
				{
					$test = new DateTime($res2[0]['due_date']);
					$due_date = date_format($test, 'd-m-Y');	
				}
				else
				{
					$Date = date('Y-m-d');
					$due_date = date('d-m-Y', strtotime($Date. ' + 1 days'));;
				}

				if(isset($res2[0]['comp_date']) and $res2[0]['comp_date']!= '0000-00-00')
				{
					$test = new DateTime($res2[0]['comp_date']);
					$comp_date = date_format($test, 'd-m-Y');	
				}
				else
				{
					$comp_date = '';
					
				}
				
				
				?>

					<div class="col-md-<?php echo $box_length;?>" >
						<div class="panel panel-white" style=" color:black; ">
							<div class="panel-heading clearfix">
								<h4 align="center" >New Task</h4>
							</div>
							
							<div class="panel-body">
								<input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
								<input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
								


								<div class="col-md-12" >
									<div class="form-group" >
									<label for="exampleInputEmail1">Project</label>
									<select class="form-control select2" id="project" onchange="show_other_project_name(this.value)" style="width:100%;">
										<option  <?php if(isset($res2[0]['project'])){if($res2[0]['project']==''){echo "selected";}}?>  value="">Select</option>
										<?php 
										$query3 = " SELECT project FROM task_planning WHERE  1=1  GROUP BY project ORDER BY project  ";
										$out3 = $this->Mymodel->query1($query3);
										foreach($out3 as $o)
										{
											?>
												<option  <?php if(isset($res2[0]['project'])){if($res2[0]['project']==$o['project']){echo "selected";}}?> ><?php echo $o['project'];?></option>
											<?php
										}
										?>
										<option  <?php if(isset($res2[0]['project'])){if($res2[0]['project']==''){echo "selected";}}?>  value="">Other</option>
									</select>
									</div>
								</div> 

								<script>
								function show_other_project_name(val)
								{
									if(val == '')
									{
										$('#show_other_project_name_dis').show();
									}
									else
									{
										$('#other_project_name').val('');
										$('#show_other_project_name_dis').hide('display:block');
									}
								}
								</script>
	
								<div id="show_other_project_name_dis" style="display:none;">			
									<div class="col-md-12"  >
										<div class="form-group" >
										<label for="exampleInputEmail1" style="color:blue;">Other Project Name</label>
										<input type="text" class="form-control"    id="other_project_name" required  autocomplete="off" value="<?php if(isset($res2[0]['other_project_name']))echo $res2[0]['other_project_name'];?>">
										</div>
									</div>
								</div>  


								<div class="col-md-12">
									<div class="form-group" >
									<label for="exampleInputEmail1">Task Name</label>
									<input type="text" class="form-control"    id="tittle_name" required  autocomplete="off" value="<?php if(isset($res2[0]['tittle_name']))echo $res2[0]['tittle_name'];?>">
									</div>
								</div>
	
								<div class="col-md-4">
									<div class="form-group" >
									<label for="exampleInputEmail1">Start Date</label>
									<input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
									</div>
								</div>
	
								<div class="col-md-4">
									<div class="form-group" >
									<label for="exampleInputEmail1">Due Date</label>
									<input type="text" class="form-control"  id="due_date" required  autocomplete="off" value="<?php if(isset($due_date))echo $due_date;?>" >
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group" >
									<label for="exampleInputEmail1">Priority</label>
									<select class="form-control select2" id="priority" style="width:100%">
										<option  <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='High'){echo "selected";}}?>  value="High">High</option>
										<option  <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Medium'){echo "selected";}}?>  value="Medium">Medium</option>
										<option  <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Low'){echo "selected";}}?> value="Low">Low</option>
									</select>
									</div>
								</div>
	
							
	
								<div class="col-md-12" style="margin-top:30px;">	
									<div class="form-group" >
										<label for="exampleInputEmail1"><b>Type To Select Resp. Person Name</b></label>
										
										<!---heading-->
										<div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;"></div>


										<?php 
											if(isset($res2[0]['id']))
											{
												$resp = explode("~",$res2[0]['resp']);
												$l = 1000;
												foreach($resp as $rp)
												{
													if(!empty($rp))
													{
														$emp_details = $this->Mymodel->get_emp_name_form_emp_id($rp);
														?>
															<!---1st row-->
															<div id="readrootjr101" style="display:;  margin-bottom:2px; margin-top:2px;background-color:red;">
																	<a style="margin-top:0px;" class="btn btn-danger closebutton pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_<?php echo $l;?>">
																		<span class="fa fa-trash"></span>
																	</a>
																	
																	<input type="text" style=" float:left; height:33px;   width:40%; margin-left:5px; " class="form-control op" id="op_<?php echo $l;?>" value="<?php  echo $emp_details[0]['emp_code'];?>" onKeyUp="op_search(this.id)"  autocomplete="off"  >
																	<p  style="float:left; height:25px;   width:46%; margin-left:5px; pedding:10px " >
																	<?php  echo  $emp_name = $emp_details[0]['name'].' '.$emp_details[0]['last_name'];?>
																	</p>
																	
															</div> 
														<?php
													$l++;
													}//if(!empty($rp))
												}//foreach
											}//if(isset($res2[0]['id']))
											else
											{
												?>
													<!---1st row-->
													<div id="readrootjr101" style="display:;  margin-bottom:2px; margin-top:2px;background-color:red;">
															<a style="margin-top:0px;" class="btn btn-danger closebutton pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
																<span class="fa fa-trash"></span>
															</a>
															
															<input type="text" style=" float:left; height:33px;   width:40%; margin-left:5px; " class="form-control op" id="op_" onKeyUp="op_search(this.id)"  autocomplete="off"  >
															<p  style="float:left; height:25px;   width:46%; margin-left:5px; pedding:10px " readonly></p>
															
													</div> 
												<?php
											}//if(isset($res2[0]['id']))
										?>	
										
										
	
										<!---add more-->
										<div class="form-group">
												<span id="writerootjr"></span>
												<input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:100px;margin-bottom:10px; margin-top:10px;" onclick="javascript:moreFields1();" value="Add Person" /> 
										</div> 
	
										<!---hidden Div-->
										<div id="readrootjr" style="display:none;  margin-bottom:3px; margin-top:3px;">
												<a style="margin-top:0px;" class="btn btn-danger closebutton pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
													<span class="fa fa-trash"></span>
												</a>
												<input type="text" style=" float:left; height:33px;   width:40%; margin-left:5px; " class="form-control op" id="op_" onKeyUp="op_search(this.id)"  autocomplete="off"  >
												<p  style="float:left; height:25px;   width:46%; margin-left:5px; pedding:10px " readonly></p>
										</div> 
									</div>
								</div>    
	
	
	
								
								<div class="col-md-12" style="margin-top:30px;">
									<div class="form-group" >
									<label for="exampleInputEmail1">Description</label>
										<textarea  class="form-control"  id="descr" required  autocomplete="off"><?php if(isset($res2[0]['descr']))echo $res2[0]['descr'];?></textarea>
									</div>
								</div>

								<div class="col-md-4" >
									<div class="form-group" >
									<label for="exampleInputEmail1">Status</label>
									<select class="form-control select2" id="status" style="width:100%;">
										<option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']==1){echo "selected";}}?> value='1' >Not Started (New)</option>
										<option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']==2){echo "selected";}}?> value='2'>In Progress</option>
										<option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']==3){echo "selected";}}?> value='3'>Complete</option>
										<option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']==4){echo "selected";}}?> value='4'>Cancel</option>
									</select>
									</div>
								</div> 
	
								<div class="col-md-4">
									<div class="form-group" >
									<label for="exampleInputEmail1">Comp Date</label>
									<input type="text" class="form-control"  id="comp_date" required  autocomplete="off" value="<?php if(isset($comp_date))echo $comp_date;?>" >
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group" >
									<label for="exampleInputEmail1">Comp Remarks</label>
									<input type="text" class="form-control"    id="comp_remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['comp_remarks']))echo $res2[0]['comp_remarks'];?>">
									</div>
								</div> 
			
													
								<div class="col-md-12">                            
									<div class="box-footer">
										<div class="col-md-12" align="center" ><span id="wait" style="color:orange; display:none;">Please Wait...</span>
											<button type="button" class="btn btn-success" id="save_new_task">Save</button>
											<button  type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
										</div>
									</div>
								</div>   
							
							</div>
						</div>
					</div>
	

	
					<script>

						function delete_item(){}
						
						$(function () {
							$( "#entry_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
							$( "#due_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
							$( "#comp_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
						});
	
	
						var counterjr = 0;
						function moreFields1() 
						{
							counterjr++;
							var newFields = document.getElementById('readrootjr').cloneNode(true);
							newFields.id = 'jr'+counterjr;
							newFields.style.display = 'block';
							var newField = newFields.childNodes;
							for (var i=0;i<newField.length;i++) 
							{
								
								var theId = newField[i].id;
								
								if (theId)
								{
									newField[i].id = theId + counterjr;
								}
							}
							
							var insertHere = document.getElementById('writerootjr');
							insertHere.parentNode.insertBefore(newFields,insertHere);
	
						}//function close
						
	
	
						//saving
						$('#save_new_task').click(function(){
								var con=doesConnectionExist();if(con==0){ error('No Internet Connection.');return false;}/*check connection from home page*/
								var id=$('#id').val();
								var tittle_name=$('#tittle_name').val();if(tittle_name==''){$('#tittle_name').focus();form_validation('Enter tittle_name');return false;}
								var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();form_validation('Select Start Date');return false;}
								var due_date=$('#due_date').val();if(due_date==''){$('#due_date').focus();form_validation('Select Due Date');return false;}
								var project=$('#project').val();
								var other_project_name=$('#other_project_name').val();
								var priority=$('#priority').val();
								var descr=$('#descr').val();
								var status=$('#status').val();
								
								var comp_date=$('#comp_date').val();
								var comp_remarks=$('#comp_remarks').val();

								var op="";
								$(".op").each(function(){		op=op.concat('~').concat($(this).val());			});
								
								//-------------------------------getting gst type
								$('.loader').show();
								setTimeout(function() {
										jQuery.post("<?php echo base_url().'index.php/Ajex/new_task_from_save';?>", 
												{
													id:id,
													tittle_name:tittle_name,
													entry_date:entry_date,
													due_date:due_date,
													project:project,
													other_project_name:other_project_name,
													priority:priority,
													descr:descr,
													op:op,
													comp_date:comp_date,
													comp_remarks:comp_remarks,
													status:status,
												}, 
												
												function(data, textStatus)
												{	
													//alert(data);
													//$('#table_show').html(data);
													if(data=='Save')
													{
														fun_message("Save Successfully");
														//showPage(url);
														$( "#tittle_name" ).val('');
														$( "#descr" ).val('');
														$( "#comp_date" ).val('');
														$( "#comp_remarks" ).val('');
														var n = $( ".closebutton" ).length;
														var i =1;
														$( ".closebutton" ).each(function() {
															if(i<n)
															{
																this.parentNode.parentNode.removeChild(this.parentNode);
															}
															i++;
														});
														
													}//if(data=='Save')
													else if(data=='Update')
													{
														fun_message("Updated Successfully");
														showPage(url);
													}
													else
													{
														error(data);
													}
													$('.loader').hide();
												});
								});
									
							
						});//search close
					</script>
			<?php
			}//function close
	
	
			function new_task_from_save()
			{
				$today_date_time=date("Y-m-d H:i:s a");
				$emp_id=$this->session->userdata('emp_id');

				if(isset($_REQUEST['id'])){ $id = trim($_REQUEST['id']); }else{$id = '';}

				if(isset($_REQUEST['tittle_name'])){ $tittle_name = trim($_REQUEST['tittle_name']); }else{$tittle_name = '';}
				if(isset($_REQUEST['entry_date']))
				{ 
					$test = new DateTime(trim($_REQUEST['entry_date']));
					$entry_date= date_format($test, 'Y-m-d'); 
				}
				else{$entry_date = date('Y-m-d');}

				if(isset($_REQUEST['due_date']))
				{ 
					$test = new DateTime(trim($_REQUEST['due_date']));
					$due_date= date_format($test, 'Y-m-d'); 
				}
				else{$due_date = date('Y-m-t');}
				
				if(isset($_REQUEST['priority'])){ $priority = trim($_REQUEST['priority']); }else{$priority = '';}
				if(isset($_REQUEST['descr'])){ $descr = trim($_REQUEST['descr']); }else{$descr = '';}
				
				
				if(isset($_REQUEST['op']))
				{ 
					$op2 = trim($_REQUEST['op']); 
					$resp = explode("~",$op2);
					$emp_id_list[] = "";
					foreach($resp as $rp)
					{
						if(!empty($rp))
						{
							$emp_details = $this->Mymodel->get_emp_name_form_emp_code($rp); 
							$emp_id_list[] = $emp_details[0]['emp_id'];
						}
					}
					$emp_id_list[] = "";
					$op = implode('~',$emp_id_list);
				}else{$op = '';}
				

				
				if(isset($_REQUEST['status'])){ $status = trim($_REQUEST['status']); }else{$status = 1;}

				if(isset($_REQUEST['comp_date']))
				{ 
					$test = new DateTime(trim($_REQUEST['comp_date']));
					$comp_date= date_format($test, 'Y-m-d'); 
				}else{$comp_date = date('0000-00-00');}

				if(isset($_REQUEST['status']) and $_REQUEST['status'] != 3)
				{
					$comp_date = date('0000-00-00');
				}
				
				
				if(isset($_REQUEST['comp_remarks'])){ $comp_remarks = trim($_REQUEST['comp_remarks']); }else{$comp_remarks = '';}
				
				if(!empty($_REQUEST['project']))
				{
					$project = trim($_REQUEST['project']); 
				}
				else
				{
					if(isset($_REQUEST['other_project_name'])){ $project = trim($_REQUEST['other_project_name']); }else{$project = '';}
				}
				
				

				if(empty($_REQUEST['id']) and !empty($_REQUEST['tittle_name']))
				{
					//save
					$data = array(
									'tittle_name'=>"$tittle_name",
									'entry_date'=>"$entry_date",
									'due_date'=>"$due_date",
									'project'=>"$project",
									'priority'=>"$priority",
									'descr'=>"$descr",
									'comp_date'=>"$comp_date",
									'comp_remarks'=>"$comp_remarks",
									'resp'=>"$op",
									'status'=>"$status",
									'save_by'=>"$emp_id",
									'save_date'=>"$today_date_time",
								  );
					$this->Mymodel->insertdata_withid('task_planning',$data);
					echo "Save";
				}
				elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['tittle_name']))
				{
					//update
					$data = array(
						'tittle_name'=>"$tittle_name",
						'entry_date'=>"$entry_date",
						'due_date'=>"$due_date",
						'project'=>"$project",
						'priority'=>"$priority",
						'descr'=>"$descr",
						'comp_date'=>"$comp_date",
						'comp_remarks'=>"$comp_remarks",
						'resp'=>"$op",
						'status'=>"$status",
						'update_by'=>"$emp_id",
						'update_date'=>"$today_date_time",
					  );
					$where=" id='$id' ";
					$this->Mymodel->update('task_planning',$data,$where);
					echo "Update";
				}//id
			
				
			}//function close



			//dashbord calender view
			function calender_view()
			{
				$box_length1 = $_REQUEST['box_length1'];
				$box_length2 = $_REQUEST['box_length2'];
				$no_of_div = $_REQUEST['no_of_div'];

				$this->Dashbord->calender_view($box_length1,$box_length2,$no_of_div,'');
				
			}//function close


			//dashbord calender view
			function task_project_list()
			{
				$box_length = $_REQUEST['box_length'];
				$this->Dashbord->task_project_list($box_length,'');
				
			}//function close


			//dashbord calender view
			function my_task_list()
			{
				$box_length = $_REQUEST['box_length'];
				$this->Dashbord->my_task_list('');
				
			}//function close


			

		
		
		
		
		
	


}// close class

?>