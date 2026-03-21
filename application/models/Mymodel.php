<?php
class Mymodel extends CI_Model
{
	
	
	function get_emp_name_form_emp_id($id)
	{
		$query = " SELECT name,last_name,emp_code FROM employee WHERE  emp_id='$id'  ";
		return $out = $this->Mymodel->query1($query);
	}//function close

	function get_emp_name_form_emp_code($emp_code)
	{
		$query = " SELECT name,last_name,emp_id FROM employee WHERE  emp_code='$emp_code'  ";
		return $out = $this->Mymodel->query1($query);
	}//function close
	
	//----------------------------getting finance year from date and to date 
	public function finance_year_month_from_to_date($year,$month)
	{
		if($month < 04)
		{
			//for jan feb march month
			$now_year = $year+1;
		}
		else
		{
			$now_year = $year;
		}

		//month name
		$from_date = date("$now_year-$month-01");
		$test = new DateTime($from_date);
		$last_date = date_format($test, 'Y-m-t');
		
		$data['first_date_of_month'] = $from_date;
		$data['last_date_of_month'] = $last_date;
		return $data;
		
	}//function close

	public function getSundays($y, $m)
	{
		return new DatePeriod(
			new DateTime("first sunday of $y-$m"),
			DateInterval::createFromDateString('next sunday'),
			new DateTime("last day of $y-$m 23:59:59")
		);
	}

	public function getSundays2($y, $m)
	{
		foreach ($this->getSundays($y, $m) as $sunday) {
			$no_of_sunday_array2= $sunday->format("d,\n");
			$no_of_sunday_array[] = "$no_of_sunday_array2";
		}
		
		return $no_of_sunday_array;
	}//function close


	//update_login_ip
	function update_login_ip($emp_id,$ip,$in_out,$status)
	{
		$today_date_time = date("Y-m-d H:i:s");

		if($in_out == 'in')
		{
			$data2 = array('last_online'=>"$today_date_time",'login_ip'=>"$ip");
		}
		elseif($in_out == 'out')
		{
			$data2 = array('last_logout'=>"$today_date_time",'logout_ip'=>"$ip");
		}
		
		//updating login table
		$where2=array('emp_id'=>"$emp_id");   
		$this->Mymodel->update('login',$data2,$where2);

		//insert into history
		$data3  = array('emp_id'=>"$emp_id",'last_online'=>"$today_date_time",'login_ip'=>"$ip",'in_out'=>"$in_out",'status'=>"$status");
		$this->Mymodel->insertdata('login_his',$data3);

	}//function close

	
	
		
	//direct query
	function error($no)
		{
			if($no==1)
			{
				$result['dis']="New Update Save";
				$result['color']="success";
			}
			if($no==2)
			{
				$result['dis']="Not Saved. Allready Exits";
				$result['color']="warning";
			}
			if($no==3)
			{
				$result['dis']="Invalid Id";
				$result['color']="warning";
			}
			
			return $result;
		}//function 


	function access($controler,$function)
	{
		$emp_id=$this->session->userdata('emp_id');
		
		$where3=" sub_controler_name='$controler' and sub_function='$function' ";
		$sub_menu=$this->Mymodel->select_where('sub_menu_list',$where3);
		if(isset($sub_menu) and count($sub_menu)>0)
		{
			$sub_menu_id=$sub_menu[0]['sub_menu_id'];
			$where=" emp_id='$emp_id' and sub_menu_id='$sub_menu_id'  ";
			$emp_sub_menu_access=$this->Mymodel->select_where('emp_sub_menu_access',$where);
			if(isset($emp_sub_menu_access) and count($emp_sub_menu_access)>0)
			{
				//access
			}
			else
			{
				redirect('control/');
			}
		}
		else
		{
			redirect('control/');
		}
		
	}//function close
	
	
	
	//direct query
		function query1($sql)
		{
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		
		//direct query
	function query2($sql)
		{
			$query = $this->db->query($sql);
			//return $query->result_array();
		}
		
		
	
	
	//     insert
	function insertdata($table,$data)
		{
			$this->db->insert($table,$data);
		}

	
	
	
	//	batch insert
	function batch_insert($table,$data)
		{
			$this->db->insert_batch($table, $data);		
		}




	
	
	//     insert with ID
	function insertdata_withid($table,$data)
		{
			$this->db->insert($table,$data);
			$insert_id = $this->db->insert_id();
			return  $insert_id;
		}


	
		
		
		
		
	
	//     Select All
	function selectall($table)
		{
			$qry = $this->db->get($table);
			return $qry->result_array();
		}



	
	
	
	
	//     Select All with Group
	function selectall_group($table,$group)
	{
		$qry = $this->db
              ->select('*')
              ->group_by($group)
              ->get($table);
		return $qry->result_array();
	}
	



				



	
	
	
	
	//     Select Where
	function select_where($table,$id,$orderby = '')
		{
			if($orderby != ''){
				
			}else{
			$qry = $this->db->order_by($orderby,'ASC')->get_where($table,$id);
			return $qry->result_array();
			}
		}


	
	//		Select where wih group
	function select_where_group($table,$id,$group)
		{
			$qry = $this->db
				  ->select('*')
				  ->where($id)
				  ->group_by($group)
				  ->get($table);
		return $qry->result_array();
		}
	


//		Select where wih group & order
	function selectall_group_order($sel,$id,$table,$group,$order_by1,$order_by2)
	{
		$qry = $this->db
              ->select($sel)
			  ->where($id)
              ->group_by($group)
			  ->order_by($order_by1,$order_by2)
              ->get($table);
		return $qry->result_array();
	}
	




	//     Delete
	function deletedata($table,$id)
		{
			$this->db->delete($table,$id);
		
		}
	









	//		Update
	function update($table,$data,$id)
		{
			$this->db->update($table,$data,$id);
		
		}
	









	//		Login
	function login($table,$data)
		{
			$a = $this->db->get_where($table,$data);
			return $a->result_array();
		}
	














	

	//		Select Join 1 tabel with order
	function client_left_join_table($col,$form,$join1_table,$join1_con,$join_type,$where,$order_by1,$order_by2)
			{
				/*
					eg:
			$col="A.r_date,A.pros,B.name as bedr,C.name as min_budget,D.name as max_budget,E.fname as lname_fname,F.fname as enq_fname";
			$form='r_enquiry AS A';
			
			$join1_table='bedroom as B';
			$join1_con='A.row3 = B.value';
			$join_type='left';

			$join2_table='budget_rs as C';
			$join2_con='A.budget1 = C.val';

			$join3_table='budget_rs as D';
			$join3_con='A.budget2 = D.val';

			$join4_table='login as E';
			$join4_con='A.lfrom = E.email';

			$join5_table='login as F';
			$join5_con='A.enquiry_id = F.email';
			
			$where =" (orgid='chander@star.com' OR enquiry_id='chander@star.com') and A.stage='Open'
					   and A.active='1' and A.r_date between '2016-10-17 00:00:00' and '2016-10-27 23:59:00'";

			$order_by1="A.r_date";
			$order_by2="DESC";				*/
				
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->where($where);
				$this->db->order_by($order_by1,$order_by2);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}

	
	
	
	
	
	
	//		Select Join 1 tabel with order & group
	function client_left_join_table2($col,$form,$join1_table,$join1_con,$join_type,$where,$order_by1,$order_by2,$group)
			{
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->where($where);
				$this->db->group_by($group);
				$this->db->order_by($order_by1,$order_by2);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}
			

	
	
	//		Select Join 2 tabel with order & group
	function client_left_join_table_two($col,$form,
										$join1_table,$join1_con,
									    $join2_table,$join2_con,
										$join_type,$where,$order_by1,$order_by2,$group)
			{
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->join($join2_table,$join2_con,$join_type);
				$this->db->where($where);
				$this->db->order_by($order_by1,$order_by2);
				$this->db->group_by($group);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}
	








	//		Select Join 3 tabel with Order and Group
	function client_left_join_table_three($col,$form,
										  $join1_table,$join1_con,
										  $join2_table,$join2_con,
										  $join3_table,$join3_con,
										  $join_type,$where,$order_by1,$order_by2,$group)
			{
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->join($join2_table,$join2_con,$join_type);
				$this->db->join($join3_table,$join3_con,$join_type);
				$this->db->where($where);
				$this->db->order_by($order_by1,$order_by2);
				$this->db->group_by($group);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}









	


	//		Select Join 4 tabel with Order and Group
	function client_left_join_table3($col,$form,
									 $join1_table,$join1_con,
									 $join2_table,$join2_con,
									 $join3_table,$join3_con,
									 $join4_table,$join4_con,
									 $join_type,$where,$order_by1,$order_by2,$group)
			{
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->join($join2_table,$join2_con,$join_type);
				$this->db->join($join3_table,$join3_con,$join_type);
				$this->db->join($join4_table,$join4_con,$join_type);
				$this->db->where($where);
				$this->db->order_by($order_by1,$order_by2);
				$this->db->group_by($group);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}








	//		Select Join 5 tabel with Order  and Group
	function client_left_join_table5($col,$form,$join1_table,$join1_con,
									  $join2_table,$join2_con,
									  $join3_table,$join3_con,
									  $join4_table,$join4_con,
									  $join5_table,$join5_con,
									  $join_type,$where,$order_by1,$order_by2,$group)
			{
				$this->db->select($col);
				$this->db->from($form); 
				$this->db->join($join1_table,$join1_con,$join_type);
				$this->db->join($join2_table,$join2_con,$join_type);
				$this->db->join($join3_table,$join3_con,$join_type);
				$this->db->join($join4_table,$join4_con,$join_type);
				$this->db->join($join5_table,$join5_con,$join_type);
				$this->db->where($where);
				$this->db->order_by($order_by1,$order_by2);
				$this->db->group_by($group);
				$query = $this->db->get(); 
				if($query->num_rows() != 0)
				{
					return $query->result_array();
				}
				else
				{
					return false;
				}	
			}


	
	
	
	
	
	function convert_number_to_words($number) 
	{
		
	   
		//$number = 190908100.25;
		   $no = round($number);
		   $point = round($number - $no, 2) * 100;
		   $hundred = null;
		   $digits_1 = strlen($no);
		   $i = 0;
		   $str = array();
		   $words = array('0' => '', '1' => 'One', '2' => 'Two',
			'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
			'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
			'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
			'13' => 'Thirteen', '14' => 'fourteen',
			'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
			'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
			'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
			'60' => 'Sixty', '70' => 'Seventy',
			'80' => 'Eighty', '90' => 'Ninety');
		   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
		   while ($i < $digits_1) {
			 $divider = ($i == 2) ? 10 : 100;
			 $number = floor($no % $divider);
			 $no = floor($no / $divider);
			 $i += ($divider == 10) ? 1 : 2;
			 if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number] .
					" " . $digits[$counter] . $plural . " " . $hundred
					:
					$words[floor($number / 10) * 10]
					. " " . $words[$number % 10] . " "
					. $digits[$counter] . $plural . " " . $hundred;
			 } else $str[] = null;
		  }
		  $str = array_reverse($str);
		  $result = implode('', $str);
		  $points = ($point) ?
			"." . $words[$point / 10] . " " . 
				  $words[$point = $point % 10] : '';
		 return "Rupees ".$result.'Only';
    }//function close




	function ip_location($ip) {
		$ch = curl_init('http://ip-api.com/php/'.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$query1 = curl_exec($ch);
		$query=@unserialize($query1);
		return $query;
    }//function close
	
	
	
	function weather() {
		$url = "http://api.openweathermap.org/data/2.5/weather?q=BHIWADI,india&units=metric&appid=619d96362a3681ae7152e49e62ded289";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		$clima=json_decode($contents);
		return $clima;
	}//function close
	
	public function get_data($url)
	{
		//$url = "http://localhost/class/wire3/index.php/Api/purchase_today_api";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		//$clima=json_decode($contents);
		//return $clima;
		//print_r($contents);
		return $contents;
	}//function close

	//from dispatch billing time
	public function dispatch_data_send_api($cust_id,$dispatch_id,$action)
	{
		$where=" id='$cust_id'  ";
		$cust_api = $this->Mymodel->select_where('customer',$where);
		if($cust_api[0]['is_api'] == 1)
		{
			$url = explode('~',$cust_api[0]['api_details']);
			//print_r($url);
			if(isset($url[0])){ $url1 = $url[0];}else{$url1='';}
			if(isset($url[1])){$url2 = $url[1];}else{$url2='';}
			//$url2 = "https://rwrerp.com/unit4/index.php/Api/dispatch_data_rec_save_api?dispatch_id=10";//bhiwadi
			if($action == 'delete')
			{
				$url3 = "$url2?dispatch_id=$dispatch_id";//delete
			}
			else
			{
				 $url3 = "$url1?dispatch_id=$dispatch_id";//new
			}
			
			$ch = curl_init($url3);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$contents = curl_exec($ch);
			//echo  $contents;
		}//if($cust_api[0]['is_api'] == 1)
		
	}//function close
	

	//save new product name
	public function get_part_id_from_part_name($part_name,$cat,$unit)
	{
		if(!empty($cat)){$product_cat = $cat;}else{$product_cat = 8;}
		if(!empty($unit))
		{
			if($unit == 'MTR' or $unit == 'mtr' or $unit == 'Mtr')
			{
				$unit_name = 3;
			}
			elseif($unit == 'KG' or $unit == 'Kg' or $unit == 'kg' or $unit == 'KG.' or $unit == 'Kg.' or $unit == 'kg.')
			{
				$unit_name = 1;
			}
			elseif($unit == 'NOS' or $unit == 'Nos' or $unit == 'nos' or $unit == 'NOS.' or $unit == 'Nos.' or $unit == 'nos.')
			{
				$unit_name = 2;
			}
			else
			{
				$unit_name = 3;
			}
		}
		else
		{
			$unit_name = '3';
		}
		
		
		//inserting into product table
		$where=" category_id='$product_cat' and name='$part_name' ";
		$res_chk=$this->Mymodel->select_where('product',$where);
		if(isset($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['product_id'];}
		if(isset($id2))
		{
			//echo "$name Product Already Available";
			return $res_chk[0]['product_id'];
		}
		else
		{
			//new insert
			$data=array(
							'category_id'=>"$product_cat",
							'name'=>"$part_name",
							'details'=>"",
							'unit_id'=>"$unit_name",
							
							'no_of_days'=>"2",
							'reorder'=>"1000",
							'economic'=>"2000",
							'max_level'=>"3000",
							'size'=>"",
							'repeated'=>"0",
							'row_mat_puc'=>"0",
							'status'=>"Active",
						);
			return  $this->Mymodel->insertdata_withid('product',$data);
		}//if(isset($id2))
	}//function close
	
	
	
	
	
	//---from dashbord
	function get_schedule_vs_supply($month_no)
	{
		$y=date("Y");
		$month_day_one=date("$y-$month_no-01");
		$month_day_last=date("$y-$month_no-31");
		//---- month 1 april
		
		 $sql="
					SELECT 
					A.schedule_id
					FROM customer_schedule as A 

					LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
					
					WHERE  A.type_of_bill='Tax Invoice' and  A.supply='0' and B.from_date between '$month_day_one' and '$month_day_last' GROUP BY A.schedule_no   ORDER by A.schedule_no DESC
				";
		
		//$out2=$this->Mymodel->query1($query);
		$query = $this->db->query($sql);
		$out2=$query->result_array();
			
		$order_qty=array();
		$send_qty=array();
		foreach($out2 as $o)
		{
			$schedule_id=$o['schedule_id'];
			$sql2=" SELECT sum(order_qty) as order_qty,sum(send_qty) as send_qty, sum(amt) as order_amt, sum(send_amt) as send_amt FROM customer_schedule_details WHERE schedule_id='$schedule_id' ";
			//$out=$this->Mymodel->query1($query);
			$query = $this->db->query($sql2);
			$out=$query->result_array();
			$order_qty[]=$out[0]['order_qty'];
			$send_qty[]=$out[0]['send_qty'];
			
			$order_amt[]=$out[0]['order_amt'];
			$send_amt[]=$out[0]['send_amt'];
		}
	  
	  	if(!empty($order_qty)){$result['order_qty']= array_sum($order_qty);}
		if(!empty($send_qty)){$result['send_qty']= array_sum($send_qty);}
		
		if(!empty($order_amt)){$result['order_amt']= round(array_sum($order_amt));}
	  	if(!empty($send_amt)){$result['send_amt']= round(array_sum($send_amt));}
		$result['data']='yes';
		return $result;
	}
	
	
	
	
	
	
	//---from Qc dashbord home controler
	function accept_reject_lotno($month_no,$field_name)
	{
		
		$y=date("Y");
		$month_day_one=date("$y-$month_no-01");
		$month_day_last=date("$y-$month_no-31");
		//---- month 1 april
		
		if($field_name=='accept')
		{
			$sql=" SELECT qc_id FROM qc WHERE accept>0 and entry_date between '$month_day_one' and '$month_day_last' ";
		}
		elseif($field_name=='reject')
		{
			$sql=" SELECT qc_id FROM qc WHERE reject>0 and entry_date between '$month_day_one' and '$month_day_last' ";
		}
		elseif($field_name=='deviation')
		{
			$sql=" SELECT qc_id FROM qc WHERE deviation>0 and entry_date between '$month_day_one' and '$month_day_last' ";
		}
		elseif($field_name=='accept_div')
		{
			$sql=" SELECT qc_id FROM qc WHERE (accept>0 OR deviation>0) and entry_date between '$month_day_one' and '$month_day_last' ";
		}
		
		
		
		
		$query = $this->db->query($sql);
		$out2=$query->result_array();
			
		$result['val']=count($out2);
		$result['data']='yes';
		return $result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
		
	
	//----------------------------------------------------------dashbord rope daily production
	public function today_production($d)
	{
		$today_date1=date('Y-m-01');
		$today_date2=date('Y-m-d');
		
		$m=date('m');
		$y=date('Y');	
		
		$test = new DateTime("$d-$m-$y");
		$new_date= date_format($test, 'Y-m-d');
		
		$sql="SELECT sum(total_qty_mtr) as qty,outward  FROM rope_mc_production where  entry_date = '$new_date'  and stage='C' GROUP BY outward ";
		//$out=$this->Mymodel->query1($query);
		
		$query = $this->db->query($sql);
		$out=$query->result_array();
		$rs=array();
		foreach($out as $o)
		{
			$outward=$o['outward'];
			$qty=$o['qty'];
			
			$sql2="SELECT avg(rate) as rate  FROM customer_schedule_details where  product_id='$outward' and from_date between '$today_date1' and '$today_date2' ";
			//$out2=$this->Mymodel->query1($query2);
			
			$query2 = $this->db->query($sql2);
			$out2=$query2->result_array();
			if(!empty($out2))
			{
				$rate=$out2[0]['rate'];
			}
			else
			{
				$sql3="SELECT avg(rate) as rate  FROM customer_schedule_details where  product_id='$outward'  ";
				//$out2=$this->Mymodel->query1($query2);
				$query3 = $this->db->query($sql3);
				$out3=$query3->result_array();
				$rate=$out3[0]['rate'];
			}
			
		
			$rs[]= round($qty*$rate);
		
		
		}//foreach
		
		return array_sum($rs);
		
	}//function close


	

	
	
	
	function compress_image($source_file, $target_file, $nwidth, $nheight, $quality) 
	{
		  //Return an array consisting of image type, height, widh and mime type.
		  $image_info = getimagesize($source_file);
		  if(!($nwidth > 0)) $nwidth = $image_info[0];
		  if(!($nheight > 0)) $nheight = $image_info[1];
		  
		  if(!empty($image_info)) {
			switch($image_info['mime']) {
			  case 'image/jpeg' :
				if($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefromjpeg($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				//Output image to the browser or file.
				return imagejpeg($thumb, $target_file, $quality); 
				
				break;
			  
			  case 'image/png' :
				if($quality == '' || $quality < 0 || $quality > 9) $quality = 6; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefrompng($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				// Output image to the browser or file.
				return imagepng($thumb, $target_file, $quality);
				break;
				
			  case 'image/gif' :
				if($quality == '' || $quality < 0 || $quality > 100) $quality = 75; //Default quality
				// Create a new image from the file or the url.
				$image = imagecreatefromgif($source_file);
				$thumb = imagecreatetruecolor($nwidth, $nheight);
				//Resize the $thumb image
				imagecopyresized($thumb, $image, 0, 0, 0, 0, $nwidth, $nheight, $image_info[0], $image_info[1]);
				// Output image to the browser or file.
				return imagegif($thumb, $target_file, $quality); //$success = true;
				break;
				
			  default:
				echo "<h4>File type not supported!</h4>";
				break;
			}
		  }
		}
	
	
	
	
	
	
	
	
	
	
	
	
	//----------------------------------------------------------QR CODE
	public function qr_code_for_sticker($item_id,$data)
	{
		$sql3="SELECT setting_value,smpt_pass  FROM company_setting where  id=1  ";
		$query3 = $this->db->query($sql3);
		$out3=$query3->result_array();
		$name1=explode(" ",$out3[0]['setting_value']);
		$company_code=$name1[0];

		$site_url=$out3[0]['smpt_pass'];
		
		$url=$site_url."phpqrcode/index3.php";

		
		//$company_code='koyo';
		//$item_id=20;
		$level1='L';
		$size1=2;
		
		//$id1=$company_code.'.'.$item_id;
		$id1=$item_id;
		$data1=urlencode ($data);
		
		$url2=$url."?id1=$id1&data1=$data1&level1=$level1&size1=$size1";
		
		$ch = curl_init($url2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$query1 = curl_exec($ch);
		//$img_name=$id1.'.png';


	}//close funtion
	
	
	
	
	//----------------------------------------------------------bar CODE
	public function bar_code_for_sticker($item_id,$data)
	{

		$sql3="SELECT setting_value,smpt_pass  FROM company_setting where  id=1  ";
		$query3 = $this->db->query($sql3);
		$out3=$query3->result_array();
		$name1=explode(" ",$out3[0]['setting_value']);
		$company_code=$name1[0];

		$site_url=$out3[0]['smpt_pass'];
		
		$url=$site_url."bar/index2.php";

		
		$id1=$company_code.'.'.$item_id;
		$data1=urlencode ($data);
		
		$url2=$url."?id1=$id1&data1=$data1";
		
		$ch = curl_init($url2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$query1 = curl_exec($ch);
		return $img_name = " data:image/png;base64, $query1 ";

	
	}//close funtion
	
	
	
	
	
	
	
	
	
	
	
	//----------------------------------------------------------Dispatch schedule cost plan
	public function schedule_cost_plan_get_rate($main_product_id,$size,$category_id)
	{
		$size2=explode('.',$size);
		
		
		//------------------------------------if product is not aviable in product_invoice_entry_details the getting rate from schedule_cost_plan
		$sql3="
					SELECT 
					row_part_id_temp_cost1
					FROM schedule_cost_plan 
					WHERE fg_product_id='$main_product_id' and  row_part_id1='$size' ORDER BY id DESC LIMIT 1
				";
		$query3 = $this->db->query($sql3);
		$out3=$query3->result_array();
		if(!empty($out3))
		{
			$col=$out3[0]['row_part_id_temp_cost1'];
			$last_rate = round($col,2);
		}
		else
		{
			$sql4="
						SELECT 
						row_part_id_temp_cost2
						FROM schedule_cost_plan 
						WHERE fg_product_id='$main_product_id' and  row_part_id2='$size' ORDER BY id DESC LIMIT 1
					";
			$query4 = $this->db->query($sql4);
			$out4=$query4->result_array();
			if(!empty($out4))
			{
				$col=$out4[0]['row_part_id_temp_cost2'];
				$last_rate = round($col,2);
			}
			else
			{
						//----------------------------------------check in invoice
						if(isset($size2[1]))
						{
							//wire size
							$product_size = $size;
							$sql3="
												SELECT 
												A.details_id,
												A.price
												FROM product_invoice_entry_details as A 
												
												LEFT JOIN product P ON P.product_id=A.product_id
												
												WHERE P.size='$size' and P.category_id='$category_id' ORDER BY A.details_id DESC LIMIT 1
											";
							  $query3 = $this->db->query($sql3);
							  $out3=$query3->result_array();
							  if(!empty($out3))
							  {
								  $last_rate = round($out3[0]['price'],2);
							  }
							  else
							  {
								  $last_rate = 0;
							  }//if(!empty($out3))
						
					  }//if(!empty($size2[1]))
					  else
					  {
						  //product id
						  $product_id = $size2[0];
						  $sql3="
									  SELECT 
									  A.details_id,
									  A.price
									  FROM product_invoice_entry_details as A 
									  WHERE A.product_id='$product_id' ORDER BY A.details_id DESC LIMIT 1
								  ";
						  $query3 = $this->db->query($sql3);
						  $out3=$query3->result_array();
						  if(!empty($out3))
						  {
							  $last_rate = round($out3[0]['price'],2);
						  }
						  else
						  {
							  $last_rate = 0;
						  }//if(!empty($out3))
					}//if(!empty($size2[1]))
					//----------------------------------------check in invoice
				
			}//$sql4
		}//$sql3
				
		
		
			
			
	 	
		return round($last_rate,2);
	}//close funtion
	
	
	
	
	//----------------------------------------------------------Dispatch schedule cost product name
	public function schedule_cost_plan_get_name($size,$category_id)
	{
		
		$size2=explode('.',$size);

		if(isset($size2[1]))
		{
			//wire size
			$product_name = $size;
			/*
			$product_size = $size;
			$sql3=" SELECT name FROM product WHERE size='$size' and category_id='$category_id' ";
			$query3 = $this->db->query($sql3);
			$out3=$query3->result_array();
			if(!empty($out3))
			{
				$product_name = round($out3[0]['name'],2);
			}
			else
			{
				$product_name = '';
			}//if(!empty($out3))
			*/
			
		}//if(!empty($size2[1]))
		else
		{
			//product id 
			$product_id = $size2[0];
			$sql3=" SELECT name FROM product WHERE product_id='$product_id'  ";
			$query3 = $this->db->query($sql3);
			$out3=$query3->result_array();
			if(!empty($out3))
			{
				$product_name = $out3[0]['name'];
			}
			else
			{
				$product_name = '';
			}//if(!empty($out3))
		}//if(!empty($size2[1]))
		
			
	 	
		return $product_name;
	}//close funtion









	//use in dispatch->customer_dispatch_item_wise 
	public function get_product_details_from_product_id($product_id)
	{
	
		$where=" product_id='$product_id' ";
		$pro=$this->Mymodel->select_where('product',$where);
		$part_name = $pro[0]['name'];
		$product_details1 = $pro[0]['details'];
		
		//getting koyo name	
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
						$part_details2 = $product_name2=$customer_name.' / '.$model_name.' / '.$cable_name;
				  }
				  else
				  {
						$part_details2 = '';
				  }
				  
			}
		else
			{
				$part_details2 = '';
			} 
			
			
		if(strlen($part_details2)>2)
		{
			return $part_details2;
		}
		else
		{
			return $product_details1;
		}
		
	
	}//funtion close














	//----------------------------------------------------------Dispatch schedule cost product name
	public function get_employee_attendance_date_wise($year,$month)
	{
		//---------------not in use
		//product id 
		$product_id = $size2[0];
		$sql3=" SELECT name FROM product WHERE product_id='$product_id'  ";
		$query3 = $this->db->query($sql3);
		$out3=$query3->result_array();
		if(!empty($out3))
		{
			$product_name = $out3[0]['name'];
		}
		else
		{
			$product_name = '';
		}//if(!empty($out3))
		
		return $product_name;
	}//close funtion






/*
	//hr 
	public function get_all_emp_list_for_attendane_type($type_search)
	{
		$query=" SELECT emp_id,pay_code,name,last_name FROM employee where company_role='$type_search' and active='Active'  and attendance_entry='0'  ORDER by pay_code ASC   ";
		return $res=$this->Mymodel->query1($query);
	}//function close
	
	//hr all reports
	public function get_all_emp_list_for_attendane_type_salary_reports($type_search,$year_search,$month_search)
	{
		//$query=" SELECT emp_id,pay_code,name,last_name FROM employee where company_role='$type_search' and active='Active'  and attendance_entry='0'  ORDER by pay_code ASC   ";
		$query=" SELECT  B.emp_id,B.pay_code,B.name,B.last_name  FROM daily_attendance_monthly  as A
				 LEFT JOIN employee as B ON B.emp_code = A.emp_code
				 WHERE   A.company_role_id='$type_search' and  A.att_year='$year_search' and A.att_month='$month_search' and  B.emp_code !=''  GROUP BY A.emp_code
				";
		return $res=$this->Mymodel->query1($query);
	}//function close
	*/
	
	

	
/*
	//hr 
	public function add_total_present_absent_attendance_monthly($id)
	{
		
		//----------
		$query=" SELECT DISTINCT d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31
				 FROM daily_attendance_monthly where att_monthly_id='$id' ";
		$out=$this->Mymodel->query1($query);
		
		$ar = array_replace($out[0],array_fill_keys(array_keys($out[0], null),''));
		$vals = array_count_values($ar);
		//echo 'No. of NON Duplicate Items: '.count($vals).'<br><br>';
		//print_r($vals);
		if(isset($vals['P'])){$total_persent = $vals['P'];}else{$total_persent = 0;}
		if(isset($vals['A'])){$total_absent = $vals['A'];}else{$total_absent = 0;}
		if(isset($vals['S'])){$total_sunday = $vals['S'];}else{$total_sunday = 0;}
		if(isset($vals['H'])){$total_holiday = $vals['H'];}else{$total_holiday = 0;}
		
		if(isset($vals['SL'])){$total_leave_sl = $vals['SL'];}else{$total_leave_sl = 0;}
		if(isset($vals['CL'])){$total_leave_cl = $vals['CL'];}else{$total_leave_cl = 0;}
		if(isset($vals['EL'])){$total_leave_el = $vals['EL'];}else{$total_leave_el = 0;}
		if(isset($vals['OL'])){$total_leave_ol = $vals['OL'];}else{$total_leave_ol = 0;}
		
		$total_p = $total_persent;
		$total_holiday = $total_holiday;
		$total_absent = $total_absent;
		
		$total_sl = $total_leave_sl;
		$total_cl = $total_leave_cl;
		$total_el = $total_leave_el;
		$total_ol = $total_leave_ol;
		
		
		$total_persent_with_all = $total_persent+$total_sunday+$total_holiday+$total_leave_sl+$total_leave_cl+$total_leave_el+$total_leave_ol;


		//---------- getting total ot in this month
		$query=" SELECT  sum(o1+o2+o3+o4+o5+o6+o7+o8+o9+o10+o11+o12+o13+o14+o15+o16+o17+o18+o19+o20+o21+o22+o23+o24+o25+o26+o27+o28+o29+o30+o31) as total_ot
				 FROM daily_attendance_monthly where att_monthly_id='$id' ";
		$out=$this->Mymodel->query1($query);
		$total_ot = $out[0]['total_ot'];
		

		//-----------updateing table
		$data=array(
			'total_p'=>"$total_persent",
			'total_holiday'=>"$total_holiday",
			'total_absent'=>"$total_absent",
			
			'total_sl'=>"$total_leave_sl",
			'total_cl'=>"$total_leave_cl",
			'total_el'=>"$total_leave_el",
			'total_ol'=>"$total_leave_ol",

			'total_present'=>"$total_persent_with_all",
			
			'total_ot'=>"$total_ot",
		);
  		$where=array('att_monthly_id'=>"$id");   
 		$this->Mymodel->update('daily_attendance_monthly',$data,$where);
		//return $product_name;


		//----updating salary
		$this->Mymodel->get_all_employee_generating_salary($id);

	}//close funtion



	//hr    canteen and breakfast
	public function add_total_present_absent_attendance_monthly_other($id)
	{
		//---------- getting total ot in this month
		$query=" SELECT  sum(d1+d2+d3+d4+d5+d6+d7+d8+d9+d10+d11+d12+d13+d14+d15+d16+d17+d18+d19+d20+d21+d22+d23+d24+d25+d26+d27+d28+d29+d30+d31) as total_ot,company_role_id,emp_code,att_year,att_month
				 FROM daily_attendance_monthly_emp_exp where att_monthly_id='$id' ";
		$out=$this->Mymodel->query1($query);
		$total_ot = $out[0]['total_ot'];
		
		$company_role_id = $out[0]['company_role_id'];
		$emp_code = $out[0]['emp_code'];
		$att_year = $out[0]['att_year'];
		$att_month = $out[0]['att_month'];
		
		//-----------updateing table
		$data=array('total_rs'=>"$total_ot");
  		$where=array('att_monthly_id'=>"$id");   
 		$this->Mymodel->update('daily_attendance_monthly_emp_exp',$data,$where);
		//return $product_name;

		
		
		//----updating salary
		$where2=array('emp_code'=>"$emp_code",'company_role_id'=>"$company_role_id",'att_year'=>"$att_year",'att_month'=>"$att_month");   
		$res2=$this->Mymodel->select_where('daily_attendance_monthly',$where2);
	    if(!empty($res2))
	    {
		   //----updating salary
		   $this->Mymodel->get_all_employee_generating_salary($res2[0]['att_monthly_id']);
	    }//if(!empty($res2))
		

	}//close funtion







	//update salary 
	public function get_all_emp_list_for_attendane_type_salary_details($pay_code,$type_search,$year_search,$month_search)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('email');
		
		$query=" SELECT pay_code, 
						current_ctc,
						basic_salary,hra,conv,city_comp,other_allow,
						spl_pay,medi_rem,fuel_reimb,esic,epf,bonus,
						get_el_encashment,get_cl_encashment,get_attendance_all,get_other1,
						get_other2,get_other3,get_other4,lost_canteen,lost_breakfast,lost_bus,
						lost_1,lost_2,lost_3,lost_4,lost_advance,ex_gratia,current_total_ctc
				 FROM employee where pay_code='$pay_code'   ";
		$res=$this->Mymodel->query1($query);

				
		 $current_ctc = $res[0]['current_ctc'];
		 $basic_salary = $res[0]['basic_salary'];

		 $hra = $res[0]['hra'];
		 $conv =$res[0]['conv'];
		 $city_comp = $res[0]['city_comp'];

		 $other_allow = $res[0]['other_allow'];
		 $spl_pay = $res[0]['spl_pay'];
		 $medi_rem = $res[0]['medi_rem'];

		 $fuel_reimb = $res[0]['fuel_reimb'];
		 $esic = $res[0]['esic'];
		 $epf = $res[0]['epf'];

		 $bonus = $res[0]['bonus'];
		 $get_el_encashment = $res[0]['get_el_encashment'];
		 $get_cl_encashment = $res[0]['get_cl_encashment'];

		 $get_attendance_all = $res[0]['get_attendance_all'];
		 $get_other1 = $res[0]['get_other1'];
		 $get_other2 = $res[0]['get_other2'];

		 $get_other3 = $res[0]['get_other3'];
		 $get_other4 = $res[0]['get_other4'];
		 $lost_canteen = $res[0]['lost_canteen'];

		 $lost_breakfast = $res[0]['lost_breakfast'];
		 $lost_bus = $res[0]['lost_bus'];
		 $lost_1 = $res[0]['lost_1'];
		 
		 $lost_2 = $res[0]['lost_2'];
		 $lost_3 = $res[0]['lost_3'];
		 $lost_4 = $res[0]['lost_4'];

		 $advance_this_month = $res[0]['lost_advance'];

		 $ex_gratia = $res[0]['ex_gratia'];
		 $current_total_ctc = $res[0]['current_total_ctc'];
		 
		 $data2=array(
						 'current_ctc'=>"$current_ctc",
						 'basic_salary'=>"$basic_salary",
						 
						 'hra'=>"$hra",
						 'conv'=>"$conv",
						 'city_comp'=>"$city_comp",
						 
						 'other_allow'=>"$other_allow",
						 'spl_pay'=>"$spl_pay",
						 'medi_rem'=>"$medi_rem",
						 
						 'fuel_reimb'=>"$fuel_reimb",
						 'esic'=>"$esic",
						 'epf'=>"$epf",
						 
						 'bonus'=>"$bonus",
						 'get_el_encashment'=>"$get_el_encashment",
						 'get_cl_encashment'=>"$get_cl_encashment",
						 
						 'get_attendance_all'=>"$get_attendance_all",
						 'get_other1'=>"$get_other1",
						 'get_other2'=>"$get_other2",
						 
						 'get_other3'=>"$get_other3",
						 'get_other4'=>"$get_other4",
						 'lost_canteen'=>"$lost_canteen",
						 
						 'lost_breakfast'=>"$lost_breakfast",
						 'lost_bus'=>"$lost_bus",
						 'lost_1'=>"$lost_1",

						 'lost_2'=>"$lost_2",
						 'lost_3'=>"$lost_3",
						 'lost_4'=>"$lost_4",

						 'advance_this_month'=>"$advance_this_month",

						 'ex_gratia'=>"$ex_gratia",
						 'current_total_ctc'=>"$current_total_ctc",
						 
						 'update_by'=>"$user_email",
						 'update_date'=>"$today",
					 );
		 $where2=array('emp_code'=>"$pay_code",'company_role_id'=>"$type_search",'att_year'=>"$year_search",'att_month'=>"$month_search");   
		 $this->Mymodel->update('daily_attendance_monthly',$data2,$where2);

		//getting id of this row
		$res2=$this->Mymodel->select_where('daily_attendance_monthly',$where2);
		if(!empty($res2))
		{
			//----updating salary
			$this->Mymodel->get_all_employee_generating_salary($res2[0]['att_monthly_id']);
		}//if(!empty($res2))
		
		
		

	}//function close


	//generating salary 
	public function get_all_employee_generating_salary($id)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('email');

		$where=array('att_monthly_id'=>"$id");
		$res=$this->Mymodel->select_where('daily_attendance_monthly',$where);  
		
		$company_role_id = $res[0]['company_role_id'];
		$emp_code = $res[0]['emp_code'];
		$att_year = $res[0]['att_year'];
		$att_month = $res[0]['att_month'];
		
		
		
		
		//-----------------------------------------------total attendance and ot
		$total_day_in_month = $res[0]['total_day_in_month'];
		$total_present = $res[0]['total_present'];
		$total_ot = $res[0]['total_ot'];
		
		
		//-----------------------------------------------creating current month salary
		$current_ctc = $res[0]['current_ctc'];		
		
		$basic_salary = $res[0]['basic_salary'];		$basic_salary_payable = round(($basic_salary/$total_day_in_month)*$total_present) ;
		$hra = $res[0]['hra'];							$hra_payable = round(($hra/$total_day_in_month)*$total_present) ;
		$conv =$res[0]['conv'];							$conv_payable = round(($conv/$total_day_in_month)*$total_present) ;
		$city_comp = $res[0]['city_comp'];				$city_comp_payable = round(($city_comp/$total_day_in_month)*$total_present) ;
		$other_allow = $res[0]['other_allow'];			$other_allow_payable = round(($other_allow/$total_day_in_month)*$total_present) ;
		$spl_pay = $res[0]['spl_pay'];					$spl_pay_payable = round(($spl_pay/$total_day_in_month)*$total_present) ;
		$medi_rem = $res[0]['medi_rem'];				$medi_rem_payable = round(($medi_rem/$total_day_in_month)*$total_present) ;

		
		
		//--direct payable
		$fuel_reimb_payable = $res[0]['fuel_reimb'];			
		$bonus_payable = $res[0]['bonus'];
		$get_el_encashment_payable = $res[0]['get_el_encashment'];
		$get_cl_encashment_payable = $res[0]['get_cl_encashment'];

		$get_attendance_all_payable = $res[0]['get_attendance_all'];
		$get_other1_payable = $res[0]['get_other1'];
		$get_other2_payable = $res[0]['get_other2'];

		$get_other3_payable = $res[0]['get_other3'];
		$get_other4_payable = $res[0]['get_other4'];
		
		
		$grand_total1 = round($basic_salary_payable+$hra_payable+$conv_payable+$city_comp_payable+$other_allow_payable+$spl_pay_payable+$medi_rem_payable+$fuel_reimb_payable+$bonus_payable+$get_el_encashment_payable+$get_cl_encashment_payable+$get_attendance_all_payable+$get_other1_payable+$get_other2_payable+$get_other3_payable +$get_other4_payable);
		$total_ot_rs =  round((($current_ctc/$total_day_in_month)/8)*$total_ot) ;
		$grand_total2 = round($grand_total1+$total_ot_rs);
		$current_ctc_payable = $grand_total2;

		 ///PF
		 $epf = $res[0]['epf'];
		 if($epf>0)
		 {
			$epf_payable = round(($basic_salary_payable*$epf)/100);
		 }
		 else
		 {
			$epf_payable = $epf;
		 }
		 
 
		 //getting esic
		 $esic = $res[0]['esic']; 
		 if($esic>0)
		 {
			$esic_payable = round(($grand_total2*$esic)/100); 
		 }
		 else
		 {
			$esic_payable = $esic;
		 }
		
		 
		 
		
		//gettting data
		$lost_canteen_payable = $this->Mymodel->get_employee_canteen_bill_from_id($company_role_id,$emp_code,$att_year,$att_month);
		$lost_breakfast_payable = $this->Mymodel->get_employee_breakfast_bill_from_id($company_role_id,$emp_code,$att_year,$att_month);
		
		$lost_bus_payable = $res[0]['lost_bus'];
		$lost_1_payable = $res[0]['lost_1'];
		$lost_2_payable = $res[0]['lost_2'];
		$lost_3_payable = $res[0]['lost_3'];
		$lost_4_payable = $res[0]['lost_4'];
		$advance_this_month_payable = $res[0]['advance_this_month'];
		$ex_gratia_payable = $res[0]['ex_gratia'];////not doning aothing
		

		$total_deduction = round((int)$esic_payable + (int)$epf_payable + (int)$lost_canteen_payable + (int)$lost_breakfast_payable + (int)$lost_bus_payable + (int)$lost_1_payable + (int)$lost_2_payable + (int)$lost_3_payable + (int)$lost_4_payable + (int)$advance_this_month_payable);
		
		//---greant total payable amt
		$current_total_ctc_payable = round($grand_total2-$total_deduction);
		
		//updateing into table

		$data2=array(
						'current_ctc_payable'=>"$current_ctc_payable",
						'basic_salary_payable'=>"$basic_salary_payable",
						
						'hra_payable'=>"$hra_payable",
						'conv_payable'=>"$conv_payable",
						'city_comp_payable'=>"$city_comp_payable",
						
						'other_allow_payable'=>"$other_allow_payable",
						'spl_pay_payable'=>"$spl_pay_payable",
						'medi_rem_payable'=>"$medi_rem_payable",
						
						'fuel_reimb_payable'=>"$fuel_reimb_payable",
						'esic_payable'=>"$esic_payable",
						'epf_payable'=>"$epf_payable",
						
						'bonus_payable'=>"$bonus_payable",
						'get_el_encashment_payable'=>"$get_el_encashment_payable",
						'get_cl_encashment_payable'=>"$get_cl_encashment_payable",
						
						'get_attendance_all_payable'=>"$get_attendance_all_payable",
						'get_other1_payable'=>"$get_other1_payable",
						'get_other2_payable'=>"$get_other2_payable",
						
						'get_other3_payable'=>"$get_other3_payable",
						'get_other4_payable'=>"$get_other4_payable",
						'lost_canteen_payable'=>"$lost_canteen_payable",

						'total_ot_rs'=>"$total_ot_rs",
						
						'lost_breakfast_payable'=>"$lost_breakfast_payable",
						'lost_bus_payable'=>"$lost_bus_payable",
						'lost_1_payable'=>"$lost_1_payable",
						'lost_2_payable'=>"$lost_2_payable",
						'lost_3_payable'=>"$lost_3_payable",
						'lost_4_payable'=>"$lost_4_payable",
						'advance_this_month_payable'=>"$advance_this_month_payable",
						'total_deduction'=>"$total_deduction",
						'current_total_ctc_payable'=>"$current_total_ctc_payable",
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
			$where2=array('att_monthly_id'=>"$id");   
			$this->Mymodel->update('daily_attendance_monthly',$data2,$where2);
		
	}//function close




	//generating canteen 
	public function get_employee_canteen_bill_from_id($company_role_id,$emp_code,$att_year,$att_month)
	{
		$query=" SELECT  total_rs
				 FROM daily_attendance_monthly_emp_exp where  company_role_id='$company_role_id' and emp_code='$emp_code' and att_year='$att_year' and att_month='$att_month' and type2='Canteen' ";
		$out=$this->Mymodel->query1($query);
		if(!empty($out))
		{
			return $out[0]['total_rs'];
		}
		else
		{
			return 0;
		}
		
	}//function close

	//generating breakfast 
	public function get_employee_breakfast_bill_from_id($company_role_id,$emp_code,$att_year,$att_month)
	{
		$query=" SELECT  total_rs
				 FROM daily_attendance_monthly_emp_exp where  company_role_id='$company_role_id' and emp_code='$emp_code' and att_year='$att_year' and att_month='$att_month' and type2='Breakfast' ";
		$out=$this->Mymodel->query1($query);
		if(!empty($out))
		{
			return $out[0]['total_rs'];
		}
		else
		{
			return 0;
		}
		
	}//function close
*/


	
	
	
	
	//create_history
	//-----------------------------from table,,,from_data_id,,,column name,,,history table, ,,,,,,new data
	public function create_history($main_table,$id_column,$id_no,$check_column,$check_name,$history_table,$data,$main_table_id,$id_no2)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('email');

		//SELECT  emp_name FROM employee where id=10
		$query=" SELECT  $check_column FROM $main_table where $id_column =  $id_no ";
		$out=$this->Mymodel->query1($query);
		if(!empty($out))
		{
			if($out[0][$check_column] != $data)
			{
				//if new current data and data save into table is not match
				$olddata = $out[0][$check_column];
				$his = " $check_name $olddata updated to $data";
				
				if($olddata != '0000-00-00' and $data!= '0000-00-00')
				{
					$data4=array(
						"$main_table_id"=>"$id_no2",
						'his'=>"$his",
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
					$this->Mymodel->insertdata($history_table,$data4);
				}//if($olddata != '0000-00-00')
			}
			
		}//if(!empty($out))
		
		
		
	}//function close



	
	//-----------------------------getting customer name of product
	public function get_customer_product_name($customer_id,$product_id)
	{
		$query = " SELECT  custname FROM customer_rate where customer_id='$customer_id' and product_id='$product_id' ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out))
		{
			$product_name_by_cust = $out[0]['custname'];
		}
		else
		{
			$product_name_by_cust = '';
		}

		return $product_name_by_cust;
	}//function close





	

	
	


	function get_production_dept($report_type,$dept,$fdate2,$tdate2)
	{
		$where = '';
		if($report_type == 1)
		{
			//get yearly total production
			if($dept == 'Wet Block'){  $out = $this->Mymodel->get_monthly_production_qty_wet_block($fdate2,$tdate2,$where);}
			elseif($dept == 'Spooling'){ $out = $this->Mymodel->get_monthly_production_qty_spooling($fdate2,$tdate2,$where);}
			elseif($dept == 'Core'){ $out = $this->Mymodel->get_monthly_production_qty_core($fdate2,$tdate2,$where);}
			elseif($dept == 'Standing'){ $out = $this->Mymodel->get_monthly_production_qty_standing($fdate2,$tdate2,$where);}
			elseif($dept == 'Auto Winder'){ $out = $this->Mymodel->get_monthly_production_qty_auto_winder($fdate2,$tdate2,$where);}
			elseif($dept == 'Planetary Machine'){ $out = $this->Mymodel->get_monthly_production_qty_pm($fdate2,$tdate2,$where);}
			elseif($dept == 'Speedo'){ $out = $this->Mymodel->get_monthly_production_qty_speedo($fdate2,$tdate2,$where);}
			elseif($dept == 'Extruder'){ $out = $this->Mymodel->get_monthly_production_qty_extruder($fdate2,$tdate2,$where);}
			elseif($dept == 'Rewinding'){ $out = $this->Mymodel->get_monthly_production_qty_rewinding($fdate2,$tdate2,$where);}
			else{ $out = "";}
			return $out;
		}
		elseif($report_type == 2)
		{
			//get monthly machine wise prodction
			if($dept == 'Wet Block'){$this->Mymodel->get_monthly_production_qty_wet_block2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Spooling'){ $this->Mymodel->get_monthly_production_qty_spooling2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Core'){ $this->Mymodel->get_monthly_production_qty_core2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Standing'){ $this->Mymodel->get_monthly_production_qty_standing2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Auto Winder'){ $this->Mymodel->get_monthly_production_qty_auto_winder2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Planetary Machine'){ $this->Mymodel->get_monthly_production_qty_pm2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Speedo'){ $this->Mymodel->get_monthly_production_qty_speedo2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Extruder'){ $this->Mymodel->get_monthly_production_qty_extruder2($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Rewinding'){ $this->Mymodel->get_monthly_production_qty_rewinding2($dept,$fdate2,$tdate2,$where);}
			else{ $out = "";}
		}
		elseif($report_type == 3)
		{
			//get date machine wise prodction
			if($dept == 'Wet Block'){$this->Mymodel->get_monthly_production_qty_wet_block3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Spooling'){ $this->Mymodel->get_monthly_production_qty_spooling3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Core'){ $this->Mymodel->get_monthly_production_qty_core3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Standing'){ $this->Mymodel->get_monthly_production_qty_standing3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Auto Winder'){ $this->Mymodel->get_monthly_production_qty_auto_winder3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Planetary Machine'){ $this->Mymodel->get_monthly_production_qty_pm3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Speedo'){ $this->Mymodel->get_monthly_production_qty_speedo3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Extruder'){ $this->Mymodel->get_monthly_production_qty_extruder3($dept,$fdate2,$tdate2,$where);}
			elseif($dept == 'Rewinding'){ $this->Mymodel->get_monthly_production_qty_rewinding3($dept,$fdate2,$tdate2,$where);}
			else{ $out = "";}
		}
		else
		{
			$out =0;
			return $out;
		}
		
		
	}//function close




	//----------------------------------------------------------------------------------------------------Production start-----------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//getting production wet block
	function get_monthly_production_qty_wet_block($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(qty) as qty FROM wet_mc_production where 1=1 $where and  entry_date between '$fdate2' and '$tdate2' ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_wet_block2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Wet Block Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  A.wet_mc_id,A.type,A.name FROM wet_mc as A where A.status='Working'  GROUP BY A.wet_mc_id ORDER BY A.type,A.wet_mc_id ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['wet_mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(qty) as qty FROM wet_mc_production where 1=1 $where and entry_date = '$today_date' and mc_id='$mc_id'  GROUP BY entry_date ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
				
			</table>
		<?php
		/*
		$query = " SELECT  entry_date,mc_id,sum(qty) as qty FROM wet_mc_production where 1=1 $where and entry_date between '$fdate2' and '$tdate2' GROUP BY entry_date ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Wet Block Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
		<?php
		$query = " SELECT  sum(qty) as qty,entry_date,out_product_size FROM wet_mc_production where 1=1 $where and entry_date between '$fdate2' and '$tdate2' GROUP BY out_product_size ORDER BY out_product_size ";
		$out = $this->Mymodel->query1($query);
		$total = array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['out_product_size'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_wet_block3($dept,$fdate2,$tdate2,$where)
	{
		//$query = " SELECT  * FROM wet_mc_production where 1=1 $where and entry_date = '$fdate2'  ";
		$query="
					SELECT  A.wet_mc_production_id,A.entry_date,A.mc_id,A.in_product_size,A.out_product_size,A.out_product_lotno,A.qty,
							A.unit_id,A.mc_speed,A.no_of_spool,A.good_spool,A.bad_spool,A.down_total_time,
							A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.down_type,A.down_reason,
							B.name as mc_name,
							B.type as mc_type,
							C.name as uname,
							E.name as ename,
							E.last_name as elname
					
					FROM wet_mc_production as A 
					
					LEFT JOIN wet_mc B ON B.wet_mc_id=A.mc_id
					LEFT JOIN unit as C ON C.unit_id = A.unit_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name
					
					WHERE 1=1 $where and A.entry_date = '$fdate2'
				";
					
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Wet Block Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th style="width:100px;">Date</th>
					<th>M/C</th>
					<th>In Item</th>
					<th>Out Item</th>
					<th>Lotno</th>
					<th>Total Spool</th>
					<th>Good</th>
					<th>Defective</th>
					<th>Down Type</th>
					<th>Down Time</th>
					<th>Run Time</th>
					<th>Speed</th>
					<th style="color:#06F">Target</th>
					<th>Qty</th>
					<th>Unit</th>
					<th>Effi</th>
					<th>Shift</th>
					<th>O.P</th>
				</tr>
				<?php 
					$i=1;
					foreach($out as $r)
					{
						$test = new DateTime($r['entry_date']);
						$entry_date= date_format($test, 'd-m-Y');	
					?>
					<tr>
						<td><?php echo $i;?>.</td>
						<td style="width:100px;"><?php echo $entry_date;?></td>
						<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
						<td><?php echo $r['in_product_size'];?></td>
						<td><?php echo $r['out_product_size'];?></td>
						<td><?php echo $r['out_product_lotno'];?></td>
						<td><?php echo $total_spool[]=$r['no_of_spool'];?></td>
						<td><?php echo $good_spool[]=$r['good_spool'];?></td>
						<td><?php echo $bad_spool[]= $r['bad_spool'];?></td>
						<td title="<?php echo $r['down_reason'];?>"><?php echo $r['down_type'];?></td>
						<td><?php echo $total_down_time[]=$r['down_total_time']; ?></td>
						<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
						<td><?php echo $r['mc_speed'];?></td>
						<td style="color:#06F">
							<?php 
							$mc_no=$r['mc_id'];
							$out_item=$r['out_product_size'];
							$query="SELECT wireweight  FROM wet_mc_wire_details where wet_mc_id='$mc_no' and wiresize='$out_item'  ";
							$res_chk=$this->Mymodel->query1($query);
							if(!empty($res_chk))
							{
								$por_24=$res_chk[0]['wireweight'];
								$target=round($por_24/2);
							}
							else
							{
									$target='';
							}
							echo $target1[]=$target;
							?>
						</td>
						<td><?php echo $qty[]=$r['qty'];?></td>
						<td><?php echo $r['uname'];?></td>
						<td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
						<td><?php echo $r['shift'];?></td>
						<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
					</tr>
					<?php
					$i++; 
					}
					?>
				<tr>
				<td>#</td>
				<td colspan="5"></td>
				<td><strong><?php if(!empty($total_spool)){echo array_sum($total_spool);}?></strong></td>
				<td><strong><?php if(!empty($good_spool)){echo array_sum($good_spool);}?></strong></td>
				<td><strong><?php if(!empty($bad_spool)){echo array_sum($bad_spool);}?></strong></td>
				<td ></td>
				<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?> Hours</strong></td>
				<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?> Hours</strong></td>
				<td ></td>
				<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
				<td><strong><?php if(!empty($qty)){echo array_sum($qty);}?></strong></td>
				<td ></td>
				<td>
					<strong>
						<?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>
						%
					</strong>
				</td>
				<td></td>
				<td></td>
				</tr>
			</table>
		<?php
	}//function close










	//getting production spooling
	function get_monthly_production_qty_spooling($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(qty_kg) as qty FROM spooling where  1=1 $where and  entry_date between '$fdate2' and '$tdate2' ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_spooling2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Spooling Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  mc_no FROM spooling where 1=1  GROUP BY mc_no ORDER BY mc_no ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_no'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['mc_no'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(qty_kg) as qty FROM spooling where 1=1 $where and entry_date = '$today_date' and mc_no='$mc_id'  GROUP BY entry_date ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(qty_kg) as qty,entry_date FROM spooling where 1=1 $where and  entry_date between '$fdate2' and '$tdate2' GROUP BY entry_date ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Spooling Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
		<?php
		$query = " SELECT  sum(qty_kg) as qty,entry_date,size FROM spooling where 1=1 $where and  entry_date between '$fdate2' and '$tdate2' GROUP BY size  ORDER BY size";
		$out = $this->Mymodel->query1($query);
		$total = array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['size'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_spooling3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  
					A.spooling_id,A.entry_date,A.mc_no,A.shift1,A.size,A.lotno,A.qty_kg,A.no_of_spool,A.op_name,A.down_type,A.down_reason,A.down_time,
					B.grade,
					E.name as ename,
					E.last_name as elname
					
					FROM spooling as A 
					
					LEFT JOIN qc B ON B.lotno=A.lotno
					LEFT JOIN employee as E ON E.emp_code = A.op_name
					
					WHERE 1=1 $where and  A.entry_date = '$fdate2'
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Spooling Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
				<th>#</th>
				<th>Entry Date</th>
				<th>M/C No</th>
				<th>Size</th>
				<th>Grade</th>
				<th>Lotno</th>
				<th>Qty</th>
				<th>No Of Spool</th>
				<th>Down Type</th>
				<th>Down Time (Hours)</th>
				<th>Down Reason</th>
				<th>Operator</th>
				<th>Shift</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
						$test = new DateTime($r['entry_date']);
						$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
							<td><?php echo $i;?>.</td>
							<td><?php echo $entry_date;?></td>
							<td><?php if(isset($r['mc_no']))echo $r['mc_no'];?></td>
							<td><?php if(isset($r['size']))echo $r['size'];?></td>
							<td><?php if(isset($r['grade']))echo $r['grade'];?></td>
							<td><?php if(isset($r['lotno']))echo $r['lotno'];?></td>
							<td><?php if(isset($r['qty_kg']))echo $qty_kg[]=$r['qty_kg'];?></td>
							<td><?php if(isset($r['no_of_spool']))echo $no_of_spool[]=$r['no_of_spool'];?></td>
							<td><?php if(isset($r['down_type']))echo $r['down_type'];?></td>
							<td><?php if(isset($r['down_time']))echo $down_time[]=$r['down_time'];?></td>
							<td><?php if(isset($r['down_reason']))echo $r['down_reason'];?></td>
							<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
							<td><?php if(isset($r['shift1']))echo $r['shift1'];?></td>
				</tr>                                          
				<?php
				$i++; 
				}
				?>
				<tr>
				<td colspan="6"></td>
				<td ><b><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></b></td>
				<td ><b><?php if(!empty($no_of_spool)){echo array_sum($no_of_spool);}?></b></td>
				<td></td>
				<td ><b><?php if(!empty($down_time)){echo array_sum($down_time);}?></b></td>
				<td colspan="3"></td>
			</tr>
			</table>
		<?php
	}//function close









	//getting production core
	function get_monthly_production_qty_core($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where   1=1 $where and  A.stage != 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing')    ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_core2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Core Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					//$query = " SELECT  A.name, A.type,A.mc_id FROM rope_mc  as A where (A.type = 'All' OR A.type ='Final Standing' OR A.type='Core / Outer Standing')  GROUP BY A.mc_id ORDER BY A.name ";
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage != 'C' and  A.entry_date between '$fdate2' and '$tdate2'  and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									//$query2 = " SELECT  sum(qty_kg) as qty FROM spooling where 1=1 $where and entry_date = '$today_date' and mc_no='$mc_id'  GROUP BY entry_date ";
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage != 'C' and  A.entry_date = '$today_date' and   A.mc_id='$mc_id' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage != 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Core Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $fdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
		<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,p.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where and  A.stage != 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
			<?php
			*/
	}//function close

	function get_monthly_production_qty_core3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where and  A.stage != 'C' and  A.entry_date = '$fdate2'  and  (M.type = 'All' OR M.type ='Final Standing' OR M.type='Core / Outer Standing')
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Core Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close












	//getting production standing
	function get_monthly_production_qty_standing($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage = 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing')    ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_standing2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Standing Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					//$query = " SELECT  A.name, A.type,A.mc_id FROM rope_mc  as A where (A.type = 'All' OR A.type ='Final Standing' OR A.type='Core / Outer Standing')  GROUP BY A.mc_id ORDER BY A.name ";
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage = 'C' and  A.entry_date between '$fdate2' and '$tdate2'  and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									//$query2 = " SELECT  sum(qty_kg) as qty FROM spooling where 1=1 $where and entry_date = '$today_date' and mc_no='$mc_id'  GROUP BY entry_date ";
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage = 'C' and  A.entry_date = '$today_date' and   A.mc_id='$mc_id' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.stage = 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Standing Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $fdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,p.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where and  A.stage = 'C' and  A.entry_date between '$fdate2' and '$tdate2' and  (B.type = 'All' OR B.type ='Final Standing' OR B.type='Core / Outer Standing') GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_standing3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where and  A.stage = 'C' and  A.entry_date = '$fdate2'  and  (M.type = 'All' OR M.type ='Final Standing' OR M.type='Core / Outer Standing')
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Standing Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close








	
	//getting production auto winder
	function get_monthly_production_qty_auto_winder($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Auto Winder'     ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_auto_winder2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Auto Winder Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2'  and    B.type = 'Auto Winder' GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where  and  A.entry_date = '$today_date' and   A.mc_id='$mc_id'   and  B.type = 'Auto Winder' GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and   A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Auto Winder'  GROUP BY A.entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Auto Winder Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,P.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and B.type = 'Auto Winder'  GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_auto_winder3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where  and  A.entry_date = '$fdate2'  and  M.type = 'Auto Winder'
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Auto Winder Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close
	









	//getting production Planetary Machine
	function get_monthly_production_qty_pm($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Planetary Machine'     ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_pm2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Planetary Machine Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2'  and    B.type = 'Planetary Machine' GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where  and  A.entry_date = '$today_date' and   A.mc_id='$mc_id'   and  B.type = 'Planetary Machine' GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Planetary Machine'  GROUP BY A.entry_date    ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Planetary Machine Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,P.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where  and  A.entry_date between '$fdate2' and '$tdate2' and B.type = 'Planetary Machine'  GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_pm3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where  and  A.entry_date = '$fdate2'  and  M.type = 'Planetary Machine'
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Planetary Machine Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close







	//getting production speedo
	function get_monthly_production_qty_speedo($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Speedo'     ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_speedo2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Speedo Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2'  and    B.type = 'Speedo' GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where  and  A.entry_date = '$today_date' and   A.mc_id='$mc_id'   and  B.type = 'Speedo' GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Speedo'  GROUP BY A.entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Speedo Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,P.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where  and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Speedo' GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_speedo3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where and  A.stage = 'C' and  A.entry_date = '$fdate2'  and  M.type = 'Speedo'
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Speedo Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close






	//getting production Extruder
	function get_monthly_production_qty_extruder($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Extruder'     ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_extruder2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Extruder Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Type</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  B.mc_id,B.name,B.type FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2'  and    B.type = 'Extruder' GROUP BY A.mc_id   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_id'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['type'];?></td>
								<td><?php echo $o['name'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(A.total_qty_mtr) as qty FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where  and  A.entry_date = '$today_date' and   A.mc_id='$mc_id'   and  B.type = 'Extruder' GROUP BY A.entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id where  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2' and  B.type = 'Extruder'  GROUP BY A.entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Extruder Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
		$query = " SELECT  sum(A.total_qty_mtr) as qty,A.entry_date,P.name as pname FROM rope_mc_production AS A LEFT JOIN rope_mc AS B ON B.mc_id = A.mc_id LEFT JOIN product AS P ON P.product_id = A.outward where  1=1 $where  and  A.entry_date between '$fdate2' and '$tdate2' and B.type ='Extruder' GROUP BY A.outward ORDER BY P.name   ";
		$out = $this->Mymodel->query1($query);
		$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_extruder3($dept,$fdate2,$tdate2,$where)
	{
		$query="
					SELECT  A.rope_production_id,A.entry_date,A.mc_id,A.outward,A.lotno,A.grade,A.total_qty_mtr,A.total_qty_weight,
							A.down_type,A.down_total_time,A.total_mc_run_time,A.mc_eff,A.shift,A.op_name,A.stage,
							
							M.type as mc_type,
							M.name as mc_name,
							P.name as out_pro,
							E.name as ename,
							E.last_name as elname
							
					
					FROM rope_mc_production as A 
					
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as M ON M.mc_id = A.mc_id
					LEFT JOIN employee as E ON E.emp_code = A.op_name

					WHERE 1=1 $where and  A.stage = 'C' and  A.entry_date = '$fdate2'  and  M.type = 'Extruder'
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Extruder Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th>Stage</th>
						<th style="width:100px;">Date</th>
						<th>M/C</th>
						<th>Partname</th>
						<th>Lotno</th>
						<th>Grade</th>
						<th>Down Type</th>
						<th>Down Time (Hours)</th>
						<th>Run Time (Hours)</th>
						<th style="color:#06F">Target (Mtr)</th>
						<th>Qty (Mtr)</th>
						<th>Qty (Kg)</th>
						<th>Effi</th>
						<th>Shift</th>
						<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
                    <td>
						<?php  if(isset($r['stage'])){if($r['stage']=='C'){?><span class="label label-info">C</span> <?php }}?>
						<?php  if(isset($r['stage'])){if($r['stage']=='B'){?><span class="label label-danger">B</span> <?php }}?>
					</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td style="width:100px;"><?php echo $r['mc_type'].'-'.$r['mc_name'];?></td>
					<td><?php echo $r['out_pro'];?></td>
					<td><?php echo $r['lotno'];?></td>
                    <td><?php echo $r['grade'];?></td>
					<td><?php echo $r['down_type'];?></td>
					<td><?php echo $total_down_time[]=$r['down_total_time'];?></td>
					<td><?php echo $total_run_time[]=$r['total_mc_run_time'];?></td>
                    <td style="color:#06F">
					<?php 
						$mc_id=$r['mc_id'];
						$outward=$r['outward'];
						$query="SELECT total_pro  FROM rope_mc_pro_details where mc_id='$mc_id' and product_id='$outward' ";
						$res_chk=$this->Mymodel->query1($query);
						if(!empty($res_chk))
						{
							$por_24=$res_chk[0]['total_pro'];
							$target=round($por_24/2);
						}
						else
						{
								$target='';
						}
						echo $target1[]=$target;
						?>
                    </td>
                    <td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
                    <td><?php echo $qty_kg[]=$r['total_qty_weight'];?></td>
                    <td style="width:70px;"><?php echo $eff[]=$r['mc_eff']; echo " %";?></td>
                    <td><?php echo $r['shift'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
														  
				<?php
				$i++; 
				}
				?>
				<tr>
					<td>#</td>
					<td colspan="5"></td>
					<td></td>
					<td></td>
					<td><strong><?php if(!empty($total_down_time)){echo array_sum($total_down_time);}?></strong></td>
					<td><strong><?php if(!empty($total_run_time)){echo array_sum($total_run_time);}?></strong></td>
					<td style="color:#06F"><strong><?php if(!empty($target1)){echo array_sum($target1);}?></strong></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($eff)){$eff2= array_sum($eff);$j=$i-1;echo round($eff2/$j);}?>%</strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close









	//getting production Rewinding
	function get_monthly_production_qty_rewinding($fdate2,$tdate2,$where)
	{
		$query = " SELECT  sum(total_qty_kg) as qty FROM fg_production  WHERE  1=1 $where and  entry_date between '$fdate2' and '$tdate2'     ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out)){ $data = $out[0]['qty'];}else{ $data = 0;}
		return round($data);
	}//function close
	function get_monthly_production_qty_rewinding2($dept,$fdate2,$tdate2,$where)
	{
		$test = new DateTime($fdate2);
		$m = date_format($test, 'm');   
		$month = date_format($test, 'M');   
		$y = date_format($test, 'Y');   
		?>
			<h3 align='center'>Rewinding Production (<?php echo $month.','.$y;?>)</h3>
			<table border='1' width="100%" class="table-striped"  >
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Machine</td>
					<?php 
					for($i=1;$i<=31;$i++)
					{
						?>
							<td style="font-weight:bold" align='right'><?php echo $i;?></td>
						<?php 
					}
					?>
					<td align='right' style="font-weight:bold">Total Qty</td>
					<td align='right' style="font-weight:bold">Avg</td>
				</tr>
				<?php 
					//getting all machine list
					$query = " SELECT  mc_no FROM fg_production  where  1=1   GROUP BY mc_no   ";
					$out = $this->Mymodel->query1($query);
					$j=1;
					foreach($out as $o)
					{
						$mc_id = $o['mc_no'];
						?>
							<tr>
								<td><?php echo $j;?></td>
								<td><?php echo $o['mc_no'];?></td>
								<?php 
								//date
								$total_qty = array();
								for($i=1;$i<=31;$i++)
								{
									//getting date wise production
									$test = new DateTime("$y-$m-$i");
									$today_date= date_format($test, 'Y-m-d');   
									$query2 = " SELECT  sum(total_qty_kg) as qty FROM fg_production where  1=1 $where  and  entry_date = '$today_date' and   mc_no='$mc_id'  GROUP BY entry_date   ";
									$out2 = $this->Mymodel->query1($query2);
									?>
										<td align='right'>
											<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$today_date.",".$today_date."'"; ?>)">
											<?php if(!empty($out2)){echo $total_qty[] = round($out2[0]['qty']);} ?>
											</a>
										</td>
									<?php 
								}
								?>
								<td align='right'><?php if(!empty($total_qty)){ echo $a = round(array_sum($total_qty));}?></td>
								<td align='right'><?php if(!empty($total_qty)){ echo round($a/count($total_qty));}?></td>
							</tr>
						<?php 
					$j++;
					}//foreach
				?>
			</table>
		<?php
		/*
		$query = " SELECT  sum(total_qty_kg) as qty,entry_date FROM fg_production  WHERE  1=1 $where and  entry_date between '$fdate2' and '$tdate2'  GROUP BY entry_date   ";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Rewinding Production</h3>
			<h4 align='center'>From <?php echo $fdate2;?> To <?php echo $tdate2;?>  </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Date</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $entry_date;?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Avg</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total)/count($total));?></td>
				</tr>
			</table>
			<?php
			$query = " SELECT  sum(A.total_qty_kg) as qty,A.entry_date,P.name as pname FROM fg_production as A LEFT JOIN product AS P ON P.product_id = A.outward  WHERE  1=1 $where and  A.entry_date between '$fdate2' and '$tdate2'  GROUP BY A.entry_date ORDER BY P.name   ";
			$out = $this->Mymodel->query1($query);
			$total= array();
		?>
			<h4 align='center'>Product Wise</h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Product</td>
					<td align='right' style="font-weight:bold">Qty</td>
				</tr>
				<?php
				$i=1;
				foreach($out as $o)
				{ 
					$test = new DateTime($o['entry_date']);
					$entry_date = date_format($test, 'd-m-Y');   
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $o['pname'];?></td>
							<td align='right'>
								<a href="#display_out" onClick="fun_get_monthly_production_date(<?php echo "'".$dept.",".$o['entry_date'].",".$o['entry_date']."'"; ?>)">
									<?php echo $total[] = round($o['qty']);?>
								</a>
							</td>
						</tr>
					<?php
					$i++;
				}//if(!empty($out))
				?>
				<tr>
					<td style="font-weight:bold">#</td>
					<td style="font-weight:bold">Total</td>
					<td align='right' style="font-weight:bold"><?php echo round(array_sum($total));?></td>
				</tr>
			
			</table>
		<?php
		*/
	}//function close
	function get_monthly_production_qty_rewinding3($dept,$fdate2,$tdate2,$where)
	{
		//$query = " SELECT  total_qty_kg,entry_date FROM fg_production  WHERE  1=1 $where and  entry_date = '$fdate2'   ";
		$query="
					SELECT 
					
					F.fg_production_id,F.entry_date,F.entry_no,F.bobbin_no,F.outward,F.lotno,F.grade,F.total_qty_mtr,F.total_qty_kg,F.joint,F.op_name,F.mc_no,F.shift1,
					P.name as pname,
					E.name as ename,
					E.last_name as elname
					
					FROM fg_production as F
					LEFT JOIN product P ON P.product_id=F.outward
					LEFT JOIN employee as E ON E.emp_code = F.op_name
					
					WHERE 1=1 $where and  F.entry_date = '$fdate2' and F.assigned_status='0' 
				";
		$out = $this->Mymodel->query1($query);
		?>
			<h3 align='center'>Rewinding Production</h3>
			<h4 align='center'>On <?php echo $fdate2;?> </h4>
			<table border='1' width="100%" class="table-striped">
				<tr>
					<th>#</th>
					<th style="width:100px;">Date</th>
					<th>M/C No</th>
					<th>Bobbin No</th>
					<th>Part Name</th>
					<th>Lotno</th>
					<th>Grade</th>
					<th>Qty (Mtr)</th>
					<th>Qty (Kg)</th>
					<th>joint</th>
					<th>Shift</th>
					<th>O.P</th>
				</tr>
				<?php 
				$i=1;
				foreach($out as $r)
				{
					$test = new DateTime($r['entry_date']);
					$entry_date= date_format($test, 'd-m-Y');	
				?>
				<tr>
					<td><?php echo $i;?>.</td>
					<td style="width:100px;"><?php echo $entry_date;?></td>
					<td><?php if(isset($r['mc_no']))echo $r['mc_no'];?></td>
					<td><?php echo $r['bobbin_no'];?></td>
					<td><?php echo $r['pname'];?></td>
					<td><?php echo $r['lotno'];?></td>
					<td><?php echo $r['grade'];?></td>
					<td><?php echo $qty_mtr[]=$r['total_qty_mtr'];?></td>
					<td><?php echo $qty_kg[]=$r['total_qty_kg'];?></td>
					<td><?php echo $joint[]=$r['joint'];?></td>
					<td><?php if(isset($r['shift1'])) echo $r['shift1'];?></td>
					<td><?php if(strlen($r['ename'])>0){echo $r['ename'];}else{echo $r['op_name'];}?></td>
				</tr>
				<?php
				$i++; 
				}
				?>
				<tr>
					<td colspan="7"></td>
					<td><strong><?php if(!empty($qty_mtr)){echo array_sum($qty_mtr);}?></strong></td>
					<td><strong><?php if(!empty($qty_kg)){echo array_sum($qty_kg);}?></strong></td>
					<td><strong><?php if(!empty($joint)){echo array_sum($joint);}?></strong></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php
	}//function close




	function fun_get_dispatch_product_customer_date_wise($no,$product_id,$this_month_from,$this_month_to)
	{
		
		$last_date = date("t", strtotime($this_month_to));
		$year_search = date("Y", strtotime($this_month_to));
		$month_search = date("m", strtotime($this_month_to));

		$query=" SELECT 	A.customer_id,C.name as cname,P.name as pname
								FROM dispatch as A
								LEFT JOIN dispatch_details as B ON B.dispatch_id = A.dispatch_id 
								LEFT JOIN product as P ON P.product_id = B.product_id
								LEFT JOIN customer as C ON C.id = A.customer_id 
								WHERE  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0 and  B.product_id='$product_id' and A.entry_date between '$this_month_from' and '$this_month_to' 
								GROUP BY A.customer_id ORDER BY C.name ";
		$customer_list = $this->Mymodel->query1($query);
		
		?>
			<!----------------Dispatch Details---------->
			<h3 align='center'><?php echo $customer_list[0]['pname'];?></h3>
			<h4 align='center'>Dispatch Date Wise in qty <?php echo $this_month_from;?> To <?php echo $this_month_to;?> </h4>
			<table width="99%" border="1" style=" background-color:white; ">
				<tr>
				 		<th>#</th>
						<th>Customer</th>
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
						<td align="right"><b>% Dispatch</b></td>
				</tr>
				<?php 
				$j=1;
				foreach($customer_list as $p)
				{
					$customer_id = $p['customer_id'];

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
				<tr>
					<td><?php echo $j;?></td>
					<td><?php echo $p['cname'];?></td>
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
				</tr>
				<?php
				$j++; 
				}
				?>
				<tr>
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
                        <td align="right" style=" font-weight:bold; background-color:yellow"><?php if(!empty($send_qty3)){echo $b= array_sum($send_qty3);}else{$b=0;}?></td>
						<td align="right" style=" font-weight:bold;"><?php if(!empty($rem3)){echo $c= array_sum($rem3);}else{$c=0;}?></td>
						<td align="right" style=" font-weight:bold;">
							<?php 
								echo $per = round(($b*100)/$a);
								echo "%";
							?>
						</td>
				</tr>
            </table>
			
		<?php
	}//function close






	function fun_get_production_product_customer_date_wise($no,$product_id,$this_month_from,$this_month_to)
	{
		
		$last_date = date("t", strtotime($this_month_to));
		$year_search = date("Y", strtotime($this_month_to));
		$month_search = date("m", strtotime($this_month_to));
		
		// getting machine list pro rope production table
		$query = " 	SELECT product_id,name FROM product WHERE   product_id='$product_id' ";
		$product = $this->Mymodel->query1($query);

		$query = " 	SELECT 
					R.mc_id,R.name as rname
					FROM rope_mc_production as A
					LEFT JOIN product as P ON P.product_id = A.outward
					LEFT JOIN rope_mc as R ON R.mc_id = A.mc_id
					WHERE A.outward='$product_id' and  A.entry_date between '$this_month_from' and '$this_month_to'  GROUP BY A.mc_id ORDER BY R.name ";
		$mc_list = $this->Mymodel->query1($query);
		//print_r($mc_list);
		?>
			<!----------------Production Details---------->
			<h3 align='center'><?php echo $product[0]['name'];?></h3>
			<h4 align='center'>Production Date Wise in qty <?php echo $this_month_from;?> To <?php echo $this_month_to;?> </h4>
			<table width="99%" border="1" style=" background-color:white; ">
				<tr>
				 		<th>#</th>
						<th>Machine No.</th>
						<td align="right">Target</td>
						<?php 
						$j=1;
						for($i=1;$i<=$last_date;$i++)
						{
							?>
								<td align="right"><b><?php echo $i;?></b></td>
							<?php
						}
						?>
						<td align="right"><b>Total Production</b></td>
				</tr>
				<?php 
				$j=1;
				foreach($mc_list as $p)
				{
					$mc_id = $p['mc_id'];
					$query = " 	SELECT ((total_pro)/2) as target_qty FROM rope_mc_pro_details WHERE  mc_id='$mc_id' and  product_id='$product_id' ";
					$out3 = $this->Mymodel->query1($query);
					//print_r($out3);
					if(!empty($out3))
					{
						$target_qty = $out3[0]['target_qty'];
					}
					else
					{
						$target_qty = 0;
					}
					//getting target
					?>
					<tr>
						<td><?php echo $j;?></td>
						<td><?php echo $p['rname'];?></td>
						<td align="right"><?php echo round($target_qty);?></td>
						<?php 
						$pro_qty2 = array();
						for($i=1;$i<=$last_date;$i++)
						{
							$test = new DateTime("$i-$month_search-$year_search");
							$new_date= date_format($test, 'Y-m-d');

							//getting qty via date
							$query = " 	SELECT 
										sum(total_qty_mtr) as qty
										FROM rope_mc_production 
										WHERE  outward='$product_id' and mc_id='$mc_id' and entry_date = '$new_date'   ";
							$res2 = $this->Mymodel->query1($query);
							if(!empty($res2))
							{
								$pro_qty = $res2[0]['qty'];
							}
							else
							{
								$pro_qty = 0;
							}

							$pro_qty2[] = $pro_qty;
							?>
								<td align="right"><?php echo $pro_qty;?></td>
							<?php
						}
						?>
						<td align="right"><b><?php if(!empty($pro_qty2)){echo $total = array_sum($pro_qty2); }else{ echo $total=0;} $send_qty3[]= $total;?></b></td>
					<tr>
					<?php
				}
				?>
				<tr>
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
				</tr>
			</table>
		<?php
	}//function close
	//----------------------------------------------------------------------------------------------------Production End-----------------------------------------------------------------
	








	//---------------------------------------------------------------------------------------Employee code update----------------------------------------------------------------------------------------
	public function update_emp_code($emp_id,$new_emp_code,$new_company_role,$new_plant)
	{
		//getting old emp_code
		$query = " 	SELECT emp_code,plant,company_role FROM employee WHERE emp_id='$emp_id' ";
		$out = $this->Mymodel->query1($query);
		if(!empty($out))
		{
			$old_plant = $out[0]['plant'];
			$old_company_role  = $out[0]['company_role'];
			$old_emp_code = $out[0]['emp_code'];


			//changeing plant name
			if(!empty($new_plant) and strlen($new_plant) > 1)
			{
				if($old_plant != $new_plant)
				{
					$field_name = "company_unit";	$where=array('emp_code'=>"$old_emp_code");			$data=array($field_name=>"$new_plant");			$this->Mymodel->update('daily_attendance_monthly',$data,$where);
					$field_name = "company_unit";	$where=array('emp_code'=>"$old_emp_code");			$data=array($field_name=>"$new_plant");			$this->Mymodel->update('daily_attendance_monthly_emp_exp',$data,$where);
					$field_name = "plant";			$where=array('emp_code'=>"$old_emp_code");			$data=array($field_name=>"$new_plant");			$this->Mymodel->update('employee',$data,$where);
				}//if($old_plant != $new_plant)
			}//f(!empty($new_company_rol) and strlen($new_company_rol) > 1)




			//changeing company role or contractor names
			if(!empty($new_company_role) and strlen($new_company_role) > 1)
			{
				if($old_company_role != $new_company_role)
				{
					$field_name = "company_role_id";	$where=array('emp_code'=>"$old_emp_code");			$data=array($field_name=>"$new_company_role");			$this->Mymodel->update('daily_attendance_monthly',$data,$where);
					$field_name = "company_role_id";	$where=array('emp_code'=>"$old_emp_code");			$data=array($field_name=>"$new_company_role");			$this->Mymodel->update('daily_attendance_monthly_emp_exp',$data,$where);
					$field_name = "company_role";			$where=array('emp_code'=>"$old_emp_code");		$data=array($field_name=>"$new_company_role");			$this->Mymodel->update('employee',$data,$where);
				}//if($old_company_role != $new_company_role)
			}//f(!empty($new_company_rol) and strlen($new_company_rol) > 1)
			


			
			//changeing company role or contractor names
			if(!empty($new_emp_code) and strlen($new_emp_code) > 1)
			{
				if($old_emp_code != $new_emp_code)
				{
					//updating all table

					$field_name = "emp_code";	$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('daily_attendance',$data,$where);
					$field_name = "emp_code";	$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('daily_attendance_monthly',$data,$where);//company_role_id company_unit
					$field_name = "emp_code";	$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('daily_attendance_monthly_emp_exp',$data,$where);//company_role_id

					$field_name = "emp_code";	$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('employee',$data,$where);//company_role_id
					$field_name = "pay_code";	$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('employee',$data,$where);
					
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_accident',$data,$where);
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_advance',$data,$where);

					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_complaint',$data,$where);
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_fine',$data,$where);
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_gatepass',$data,$where);

					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_kaizen',$data,$where);
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_leave',$data,$where);
					$field_name = "emp_id";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('emp_suggestion',$data,$where);

					$field_name = "indentor";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('indent_store_req',$data,$where);
					$field_name = "request_by";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('indent_store_req',$data,$where);
					$field_name = "receivedby";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('indent_store_req_details',$data,$where);

					$field_name = "prepared_by";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('product_elongation',$data,$where);
					$field_name = "approved_by";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('product_elongation',$data,$where);
					
					$field_name = "op_name";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('rope_mc_production',$data,$where);
					$field_name = "op_name";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('spooling',$data,$where);
					$field_name = "op_name";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('wet_mc_production',$data,$where);
					$field_name = "op_name";		$where=array($field_name=>"$old_emp_code");			$data=array($field_name=>"$new_emp_code");			$this->Mymodel->update('fg_production',$data,$where);
					
				}//if($old_emp_code != $new_emp_code)
			}//f(!empty($new_company_rol) and strlen($new_company_rol) > 1)


		}//if(!empty($out))
	}//function close
	//---------------------------------------------------------------------------------------Employee code update end----------------------------------------------------------------------------------------
		





	
	
	
	
	
	
	
	
	
}//class close



?>