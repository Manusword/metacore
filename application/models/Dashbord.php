<?php
class Dashbord extends CI_Model
{
	
	function default_dashbord()
	{
		
		$user_email=$this->session->userdata('email');
		$username=$this->session->userdata('username');
		$emp_id=$this->session->userdata('emp_id');
		
		//$query=" SELECT emp_code,department_id,attendance_entry FROM employee WHERE emp_id='$emp_id' ";
		//$res=$this->Mymodel->query1($query);
		//$emp_code=$res[0]['emp_code'];

		$first_day=date('Y-m-01');
		$today=date('Y-m-d');

		$logout_date=$this->Dashbord->user_logout_date($user_email);
		$device = $this->Dashbord->device_type();//1 web
		$good_morning = $this->Dashbord->good_morning();//good morning
		$div_color = $this->Dashbord->box_font_color();//box_font_color



		$var = $this->Dashbord->dashbord_view_type_unit();
		$dipatch_target2 = $this->Dashbord->dashbord_sale_target();
		$product_target2 = $this->Dashbord->dashbord_production_target();
		$joint_target12 = $this->Dashbord->dashbord_joint_target();

		$dipatch_target = $dipatch_target2[0]['setting_value'];
		$product_target = $product_target2[0]['setting_value'];
		$joint_target1 = $joint_target12[0]['setting_value'];
		$joint_target2 = $joint_target12[0]['mail_type'];




		?>


				<div class="page-inner">
						<div class="page-title">
						<h3><?php echo $good_morning;?> <span style="color:#22BAA0;font-weight:bold;"><?php echo $username;?></span></h3>
							<div class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="active">
										Last Logout On <span style="color:black; font-weight:bold"><?php echo $logout_date;?></span>
									</li>
								</ol>
							</div>
							<!----------Reminder-----------News------------------>
							<div style="float:right; width:100%; " >
							<!-----onMouseOut="this.start()" onMouseOver="this.stop()"---->
											<marquee behavior="scroll" direction="left"  scrolldelay="1s" style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace"  >
															<i>
															<?php
																//birth day
																$this->Dashbord->get_birthday_today('No','','');
																//reminder for me 
																$this->Dashbord->get_self_reminder_today('No','','');
																//mom points
																$this->Dashbord->get_mom_today('No','','');
															?>
															</i>
											</marquee>
								
							</div>
							<!----------Reminder-----------News------------------>
						</div>
							
					<div class="row" style=" margin-left:15px; margin-top:10px;">
						<?php 
							$this->Dashbord->other_li_list();
							$this->Dashbord->mobile_button_list($device);
						?>
					</div>

					
						
			
		<!------------------------------------------------------------Default Dashbord End------------------------------------------------------------------------->
		<?php

	}//function close
		















	
	function user_logout_date($email)
	{
		$where=" email='$email'   ";
		$qry = $this->db->select('*')->where($where)->get('login');
		$out= $qry->result_array();
		if(!empty($out))
		{
			$test = new DateTime($out[0]['last_logout']);
			$logout_date= date_format($test, 'd-m-Y h:i:s a');
		}
		else
		{
			$logout_date='';
		}

		return $logout_date;
	}//function close




	function dashbord_view_type()
	{
		$where=" id=28   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(!empty($out))
		{
			$res=$out[0]['setting_value'];
		}
		else
		{
			$res='';
		}

		return $res;
	}//function close


	function dashbord_view_type_unit()
	{
		$where=" id=28   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(!empty($out))
		{
			if($out[0]['setting_value'] == 1)
			{
				$res='(in mtr)';
			}
			else
			{
				$res='(in Nos)';
			}
		}
		else
		{
			$res='';
		}

		return $res;
	}//function close



	function dashbord_sale_target()
	{
		$where=" id=29   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(!empty($out))
		{
			return $out;
		}
	}//function close


	function dashbord_production_target()
	{
		$where=" id=30   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(!empty($out))
		{
			return $out;
		}
	}//function close


	function dashbord_joint_target()
	{
		$where=" id=31   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(!empty($out))
		{
			return $out;
		}
	}//function close



	function dashbord_color()
	{
		$where=" id=1   ";
		$qry = $this->db->select('*')->where($where)->get('company_setting');
		$out= $qry->result_array();
		if(isset($out[0]['setting_value']))
		{
			if($out[0]['setting_value']=='Rahul Wire Ropes')
			{
				$color="#22BAA0";
			}
			elseif($out[0]['setting_value']=='Rahul Die Castings')
			{
				$color="#337ab7";
			}
			else
			{
				$color="#f25656";
			}
		}
		else
		{
			$color="#337ab7";
		}

		return $color;
	}//function close


	function login_user_data($login_email)
	{
		$sql="
					SELECT 
					A.name,A.last_name,A.pay_code,A.profile_pic,
					B.name as bname,
					C.name as cname
					
					FROM employee as A

					LEFT JOIN department B ON A.department_id=B.department_id
					LEFT JOIN department_role C ON A.role_in_department=C.role_id
					WHERE A.email='$login_email'
			";
		//$where=" email='$email'   ";
		$qry = $this->db->query($sql);
		return $qry->result_array();
	}//function close

	
	function login_user_data2($login_email)
	{
		$where=" email='$login_email' ";
		$qry = $this->db->select('*')->where($where)->get('login');
		$out= $qry->result_array();
		if(!empty($out))
		{
			return $out;
		}
		else 
		{
			return $out='';
		}
	}//function close






	function device_type()
	{
		//-------------------------------------------------------geting device details
		$tablet_browser = 0;
		$mobile_browser = 0;
		
		if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$tablet_browser++;
		}
		
		if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
			$mobile_browser++;
		}
		
		if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
			$mobile_browser++;
		}
		
		$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
		$mobile_agents = array(
			'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
			'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
			'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
			'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
			'newt','noki','palm','pana','pant','phil','play','port','prox',
			'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
			'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
			'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
			'wapr','webc','winw','winw','xda ','xda-');
		
		if (in_array($mobile_ua,$mobile_agents)) {
			$mobile_browser++;
		}
		
		if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
			$mobile_browser++;
			//Check for tablets on opera mini alternative headers
			$stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
			if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
			$tablet_browser++;
			}
		}
		
		if ($tablet_browser > 0) {
			// do something for tablet devices
			$device= '3';
		}
		else if ($mobile_browser > 0) {
			// do something for mobile devices
			$device= '2';
		}
		else {
			// do something for everything else
			$device= '1';
		} 
		
		return $device;
	
	}//function close




	function get_percentage($t,$y)
	{
		if($t>$y)
		{
			$now=$t-$y;
			$per=round(($now*100)/$t);
			//$arrow='up';
		}
		elseif($t<$y)
		{
			$now=$y-$t;
			$per=round(($now*100)/$y);
			//$arrow='down';
		}
		else
		{
			$per=0;
			//$arrow='';
		}
		return $per;
	}//function close



	function get_percentage_arrow($t,$y)
	{
		if($t>$y)
		{
			$arrow='up';
		}
		elseif($t<$y)
		{
			$arrow='down';
		}
		else
		{
			$arrow='';
		}
		return $arrow;
	}//function close



	function good_morning()
	{
		$current_time=date('H');
		if($current_time >=4 and $current_time <12)
		{
			$good_morning=" Good Morning";
		}
		elseif($current_time >=12 and $current_time <15)
		{
			$good_morning=" Good Afternoon";
		}
		elseif($current_time >=15 and $current_time <19)
		{
			$good_morning=" Good Evening";
		}
		elseif($current_time >=19 and $current_time <24)
		{
			$good_morning=" Good Night";
		}
		else
		{
			$good_morning=" Hello";
		}

		return $good_morning;
	}//function close



	function box_font_color()
	{
		return "white";
	}//function close



	



	function get_birthday_today($return,$form_date,$to_date)
	{
		
		if($return=='Yes')
		{
			//return value
			$sql=" SELECT first_name,last_name,emp_code,id,dob,MONTH(dob) as dob_m, DAY(dob) as dob_d FROM employee  WHERE status='Active' ";
			$qry = $this->db->query($sql);
			return $qry->result_array();
		}
		else
		{
			//for dashbord
			$sql="
				SELECT 
						A.name,A.last_name,A.pay_code,
						B.name as bname
						
				FROM employee as A
				
				LEFT JOIN department B ON A.department_id=B.department_id
				WHERE active='Active' and STR_TO_DATE( CONCAT(YEAR(CURDATE()), '-', MONTH(A.dob), '-', DAY(A.dob) ), '%Y-%m-%d' ) = DATE_ADD(CURDATE(), INTERVAL 0 DAY)
				";
			//$where=" email='$email'   ";
			$qry = $this->db->query($sql);
			$get_news= $qry->result_array();
			$i=1;
			foreach($get_news as $r)
			{
				?>
					<i>
						<b style="color:red"> Happy Birthday To: </b>
						<b>
						<?php echo $r['name'].' '.$r['last_name'].' ('.$r['bname'].','.$r['pay_code'].'), ';?> 
						</b>
					</i>
				<?php
				$i++;
			}//foreach
		}//if($return=='Yes')
	}//function close





	function get_self_reminder_today($return,$form_date,$to_date)
	{
		$user_email=$this->session->userdata('email');
		$today=date('Y-m-d');

		$where=" email='$user_email'  ";
		$qry = $this->db->select('*')->where($where)->get('employee');
		$out2= $qry->result_array();
		$dept_id = $out2[0]['department_id'];

		
		if($return=='Yes')
		{
			//return value
			$sql="
				SELECT * FROM reminder
				WHERE target_date between '$form_date' and '$to_date' and active='0' and (reminder_to='$dept_id' OR reminder_to='$user_email' OR reminder_to='All') ORDER BY target_date
			";
			$qry = $this->db->query($sql);
			$reminder= $qry->result_array();
			return $reminder;
		}
		else
		{
			$sql="
				SELECT * FROM reminder
				WHERE target_date<='$today' and event_date>='$today' and active='0' and (reminder_to='$dept_id' OR reminder_to='$user_email' OR reminder_to='All') 
			";
			$qry = $this->db->query($sql);
			$reminder= $qry->result_array();
			if(!empty($reminder))
			{
				?><b style="color:blue"> News:</b><?php
			}
			$i=1;
			foreach($reminder as $r)
			{
				if($r['priority']=='2')
				{
					$priority_color='red';
				}
				else if($r['priority']=='1')
				{
					$priority_color='blue';
				}
				else
				{
					$priority_color='black';
				}
				?>
					<b style="color:<?php echo $priority_color;?>">
					<span style="color:blue"><?php echo $i;?>.</span>
					<?php echo $r['subject'];?> </b>
				<?php
				$i++;
			}//if(!empty($reminder))
		}//if($return=='Yes')
		
		
		
		
	}//function close


	

	function get_mom_today($return,$form_date,$to_date)
	{
		$user_email=$this->session->userdata('email');
		$today=date('Y-m-d');

		$where=" email='$user_email'  ";
		$qry = $this->db->select('*')->where($where)->get('employee');
		$out2= $qry->result_array();
		$dept_id = $out2[0]['department_id'];

		if($return=='Yes')
		{
			//return value
			$sql="SELECT review,status,resp,target_date,priority FROM mom where  target_date between '$form_date' and '$to_date'   ORDER by entry_date DESC";
			$qry = $this->db->query($sql);
			return $res= $qry->result_array();
		}
		else
		{
			$sql="SELECT review,status,resp,target_date,priority FROM mom where  target_date='$today'   ORDER by entry_date DESC";
			$qry = $this->db->query($sql);
			$res= $qry->result_array();
		
			$i=1;
			if(!empty($res))
			{
				?><b style="color:blue"> MOM Points:</b><?php
				
				
				foreach($res as $r)
				{
					if($r['status']=='Pending'){$color3="red";}
					if($r['status']=='Under Progress'){$color3="orange";}
					if($r['status']=='Completed'){$color3="green";}
					
					$test = new DateTime($r['target_date']);
					$target_date= date_format($test, 'd-m-Y');
					
					if($r['priority']=='2')
					{
						$priority_color='red';
					}
					else if($r['priority']=='1')
					{
						$priority_color='blue';
					}
					else
					{
						$priority_color='';
					}
					?>
					<b style="color:<?php echo $priority_color;?>">
								<span style="color:blue"><?php echo $i;?>. </span>
								<?php echo $r['review'];?> 
								(<span style="color:<?php echo $color3;?>"><?php echo $r['status'];?></span>) 
								By <span style="color:<?php echo $color3;?>"><?php echo $r['resp'];?></span>
								Target Date <?php echo $target_date;?>
					</b>
					<?php
					$i++;
				}//foreach
			}//if(!empty($res))
		}//if($return=='Yes')


	}//function close






	
	function other_li_list()
	{
		$user_email=$this->session->userdata('email');
		$sql="SELECT * FROM dashbord_report where  status='1' ORDER by name ASC";
		$qry = $this->db->query($sql);
		$res= $qry->result_array();
		foreach($res as $r)
		{
			if($r['display_id']=='All')
			{
				?>
						<!--<li > -->
							<a    target="_blank" href="<?php echo base_url();?>index.php/<?php echo $r['link'];?>" style=" font-weight:bold; float:left; margin-left:5px;" >
								<button type="button" class="btn btn-default">
									<span style="color:black; font-weight:bold"><?php echo $r['name'];?> </span>
								</button>
							</a>
						<!--</li>-->
				<?php
			}
			else
			{
				$list = explode(',',$r['display_id']);
				if(in_array($user_email,$list))
				{
					?>
					<!--<li > -->
						<a    target="_blank" href="<?php echo base_url();?>index.php/<?php echo $r['link'];?>" style=" font-weight:bold; float:left;margin-left:5px;" >
							<button type="button" class="btn btn-default">
								<span style="color:black; font-weight:bold"><?php echo $r['name'];?> </span>
							</button>
						</a>
					<!--</li>-->
				<?php
				}
			}
		}	//foreach	


	}//function close








	function mobile_button_list($device)
	{
		if($device!=1){?>
			<div class="col-lg-12 col-md-12"  style=" margin-bottom:30px;">
				 <button type="button" class="btn btn-warning" onClick="showPage(this.id)" id="Meeting/show" style="width:100px;">
					MOM List
				 </button>
				 
				<!--
					 <button type="button" class="btn btn-success" onClick="showPage(this.id)" id="Home/chat" style="width:100px;">
					Chat
				 </button>
				-->

				 <button type="button" class="btn btn-info" onClick="showPage(this.id)" id="Meeting/maint_show" style="width:150px;">
					Maintenance List
				 </button>
				 
				 
				 <button type="button" class="btn btn-primary" onClick="showPage(this.id)" id="Meeting/reminder_list" style="width:150px;">
					Reminder List
				 </button>
				 
				
			</div>
		<?php }
	}//function close

	
	
	
	
	//----------------------------------------------Graph Start------------------------------------------------
	function purchase_from_gate_today_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$query="SELECT sum(total_amt) as rs FROM product_invoice_entry_from_gate where gate_entry_date='$today'  ";
		$purchase_today=$this->Mymodel->query1($query);
		$query="SELECT sum(total_amt) as rs FROM product_invoice_entry_from_gate where gate_entry_date='$yesterday'  ";
		$purchase_yesterday=$this->Mymodel->query1($query);
		
		$a= round($purchase_today[0]['rs']); 
		$b=round($purchase_yesterday[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
							<div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
								<div class="panel-body">
									<div class="info-box-stats">
									<p style="color:<?php echo $div_color;?>;">₹ <span class="counter"><?php echo $a?></span></p>
										<span class="info-box-title" style="color:<?php echo $div_color;?>;">Purchase Today (Gate)</span>
									</div>
									<div class="info-box-icon">
										<span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
									</div>
									<div class="info-box-progress">
										<div class="progress progress-xs progress-squared bs-n">
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
											</div>
										</div>
										<br>
										<span  style="float:left; color:<?php echo $div_color;?>;">Yesterday: ₹<?php echo $b;?></span>
									</div>
							
								</div>
							</div>
						</div>
		<?php
	}//function close


	function purchase_from_gate_this_month_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$query="SELECT sum(total_amt) as rs FROM product_invoice_entry_from_gate where gate_entry_date between '$this_month_from' and '$this_month_to'  ";
		$purchase_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(total_amt) as rs FROM product_invoice_entry_from_gate where gate_entry_date between '$last_month_from' and '$last_month_to'  ";
		$purchase_last_month=$this->Mymodel->query1($query);
		
		$a= round($purchase_this_month[0]['rs']); 
		$b=round($purchase_last_month[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Purchase This Month (Gate)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹<?php echo $b;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close





	//----------------------------------------------Graph Start------------------------------------------------
	function purchase_today_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date='$today'  ";
		$purchase_today=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date='$yesterday'  ";
		$purchase_yesterday=$this->Mymodel->query1($query);
		
		$a= round($purchase_today[0]['rs']); 
		$b=round($purchase_yesterday[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Purchase Today (Store)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>;">Yesterday: ₹<?php echo $b;?></span>
                                    </div>
                               
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	function purchase_this_month_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date between '$this_month_from' and '$this_month_to'  ";
		$purchase_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date between '$last_month_from' and '$last_month_to'  ";
		$purchase_last_month=$this->Mymodel->query1($query);
		
		$a= round($purchase_this_month[0]['rs']); 
		$b=round($purchase_last_month[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Purchase This Month (Store)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹<?php echo $b;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close
	
	
	//used in dispatch->report->report_1_1 function name customer_dispatch_list_yearly
	function get_dispatch_amt_monthly($customer_id,$fin_year,$month,$tax)
	{
		$from_date=date("$fin_year-$month-01");
		$to_date=date("$fin_year-$month-t");

		if($tax==1)
		{
			$query="SELECT sum(grandtotal) as rs FROM dispatch where customer_id='$customer_id' and fin_year='$fin_year' and  type_of_bill='Tax Invoice' and is_it_cancel=0  and entry_date between '$from_date' and '$to_date' ";
		}
		else
		{
			$query="SELECT sum(total) as rs FROM dispatch where customer_id='$customer_id' and fin_year='$fin_year' and type_of_bill='Tax Invoice' and is_it_cancel=0  and entry_date between '$from_date' and '$to_date' ";
		}
		//echo $query;
		$out=$this->Mymodel->query1($query);
		return round($out[0]['rs']);
	}//function close

	//dashbord dispatch qty wise
	function get_all_dispatch_category($fdate,$tdate)
	{
		//getting category
		$query = "
			SELECT P.category_id,C.name FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			LEFT JOIN category as C ON C.category_id = P.category_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and  A.entry_date between '$fdate' and '$tdate' GROUP BY P.category_id ORDER BY P.category_id,P.product_id
		";
		return $this->Mymodel->query1($query);
	}//function close

	//group by p.name
	function get_all_dispatch_product($fdate,$tdate)
	{
		//getting product
		$query = "
			SELECT P.category_id,C.name,P.product_id,P.name as pname FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			LEFT JOIN category as C ON C.category_id = P.category_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and  A.entry_date between '$fdate' and '$tdate' GROUP BY P.product_id ORDER BY P.category_id,P.product_id
		";
		return $this->Mymodel->query1($query);
	}//function close

	//group by p.name
	function get_all_dispatch_product_category_wise($category_id,$fdate,$tdate)
	{
		//getting product
		$query = "
			SELECT P.category_id,C.name,P.product_id,P.name as pname FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			LEFT JOIN category as C ON C.category_id = P.category_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and P.category_id='$category_id' and  A.entry_date between '$fdate' and '$tdate' GROUP BY P.product_id ORDER BY P.category_id,P.product_id
		";
		return $this->Mymodel->query1($query);
	}//function close

	//get_qty_dispatch_category_wise wise
	function get_qty_dispatch_category_wise($category_id,$fdate2,$tdate2)
	{
		//getting qty 
		$query2 = "
			SELECT sum(B.qty) as qty FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and P.category_id='$category_id' and  A.entry_date between '$fdate2' and '$tdate2' GROUP BY P.category_id 
		";
		$out2=$this->Mymodel->query1($query2);
		if(!empty($out2))
		{
			$qty = round($out2[0]['qty']);
		}
		else
		{
			$qty = 0;
		}

		return $qty;
		
	}//function close

	//get_qty_dispatch_category_wise wise
	function get_qty_dispatch_product_wise($product_id,$fdate2,$tdate2)
	{
		//getting qty 
		 $query2 = "
			SELECT sum(B.qty) as qty FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and P.product_id='$product_id' and  A.entry_date between '$fdate2' and '$tdate2' GROUP BY P.product_id 
		";
		$out2=$this->Mymodel->query1($query2);
		if(!empty($out2))
		{
			$qty = round($out2[0]['qty']);
		}
		else
		{
			$qty = 0;
		}

		return $qty;
		
	}//function close

	//get_total_amt_dispatch_category_wise wise
	function get_amt_dispatch_product_wise($product_id,$fdate2,$tdate2)
	{
		//getting total_amt 
		$query2 = "
			SELECT sum(B.total_amt) as total_amt FROM dispatch_details as B 
			LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
			LEFT JOIN product as P ON P.product_id = B.product_id 
			WHERE  A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and P.product_id='$product_id' and  A.entry_date between '$fdate2' and '$tdate2' GROUP BY P.product_id 
		";
		$out2=$this->Mymodel->query1($query2);
		if(!empty($out2))
		{
			$total_amt = round($out2[0]['total_amt']);
		}
		else
		{
			$total_amt = 0;
		}

		return $total_amt;
		
	}//function close




	
	
	
	function sale_today_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$query="SELECT sum(grandtotal) as rs FROM dispatch where entry_date='$today' and type_of_bill='Tax Invoice' and is_it_cancel=0  ";
		$sale_today=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where entry_date='$yesterday' and type_of_bill='Tax Invoice' and is_it_cancel=0   ";
		$sale_yesterday=$this->Mymodel->query1($query);
		
		$a= round($sale_today[0]['rs']); 
		$b=round($sale_yesterday[0]['rs']);
		$per=$this->get_percentage($a,$b);
		$arrow2=$this->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Sale Today (Dispatch)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Yesterday: ₹<?php echo $b;?></span>
                                    </div>
                                </div>
                            </div>
            </div>
		<?php
	}//function close



	function sale_this_month_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		

		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$sale_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$last_month_from' and '$last_month_to' and is_it_cancel=0   ";
		$sale_last_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$last_month_from' and '$last_month_to_till_date' and is_it_cancel=0   ";
		$sale_last_month_till_date=$this->Mymodel->query1($query);
		
		$sale_last_month_till_date= round($sale_last_month_till_date[0]['rs']); 
		$a= round($sale_this_month[0]['rs']); 
		$b=round($sale_last_month[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Sale This Month (Dispatch)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                        <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹ <?php echo $b;?> / Till Date <?php echo $sale_last_month_till_date;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	function sale_this_month_other_unit_nos()
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
        //total sale this / last month
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$sale_this_month=$this->Mymodel->query1($query);
		$a= round($sale_this_month[0]['rs']); 
		
		//our unit sale this month
		$query="SELECT sum(A.grandtotal) as rs FROM dispatch as A LEFT JOIN customer as C on C.id = A.customer_id where C.our_unit = 1 and A.type_of_bill='Tax Invoice' and A.entry_date between '$this_month_from' and '$this_month_to' and A.is_it_cancel=0  ";
		$sale_this_month2=$this->Mymodel->query1($query);
		$our_unit_sales_this_month = round($sale_this_month2[0]['rs']); 
		echo $this_unit_total_sales_this_month = round($a-$our_unit_sales_this_month);

    }//function close
	
	function sale_last_month_other_unit_nos()
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
        //total sale  last month
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$last_month_from' and '$last_month_to' and is_it_cancel=0   ";
		$sale_last_month=$this->Mymodel->query1($query);
		$b=round($sale_last_month[0]['rs']);
		
        //our unit sale last month
		$query="SELECT sum(A.grandtotal) as rs FROM dispatch as A LEFT JOIN customer as C on C.id = A.customer_id where C.our_unit = 1 and A.type_of_bill='Tax Invoice' and A.entry_date between '$last_month_from' and '$last_month_to' and A.is_it_cancel=0  ";
		$sale_this_month3=$this->Mymodel->query1($query);
		$our_unit_sales_last_month = round($sale_this_month3[0]['rs']); 
		echo $this_unit_total_sales_last_month = round($b-$our_unit_sales_last_month);
	
	}//function close



	function sale_this_month_other_unit_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		

		//total sale this / last month
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$sale_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$last_month_from' and '$last_month_to' and is_it_cancel=0   ";
		$sale_last_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$last_month_from' and '$last_month_to_till_date' and is_it_cancel=0   ";
		$sale_last_month_till_date=$this->Mymodel->query1($query);
		$sale_last_month_till_date= round($sale_last_month_till_date[0]['rs']); 
		$a = round($sale_this_month[0]['rs']); 
		$b = round($sale_last_month[0]['rs']);
		

		//our unit sale this month
		$query="SELECT sum(A.grandtotal) as rs FROM dispatch as A LEFT JOIN customer as C on C.id = A.customer_id where C.our_unit = 1 and A.type_of_bill='Tax Invoice' and A.entry_date between '$this_month_from' and '$this_month_to' and A.is_it_cancel=0  ";
		$sale_this_month2=$this->Mymodel->query1($query);
		$our_unit_sales_this_month = round($sale_this_month2[0]['rs']); 
		$this_unit_total_sales_this_month = round($a-$our_unit_sales_this_month);

		//our unit sale last month
		$query="SELECT sum(A.grandtotal) as rs FROM dispatch as A LEFT JOIN customer as C on C.id = A.customer_id where C.our_unit = 1 and A.type_of_bill='Tax Invoice' and A.entry_date between '$last_month_from' and '$last_month_to' and A.is_it_cancel=0  ";
		$sale_this_month3=$this->Mymodel->query1($query);
		$our_unit_sales_last_month = round($sale_this_month3[0]['rs']); 
		$this_unit_total_sales_last_month = round($b-$our_unit_sales_last_month);
		
		$per=$this->Dashbord->get_percentage($our_unit_sales_this_month,$our_unit_sales_last_month);
		$arrow2=$this->Dashbord->get_percentage_arrow($our_unit_sales_this_month,$our_unit_sales_last_month);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		
		?>
						<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $our_unit_sales_this_month.' / '.$this_unit_total_sales_this_month;?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Other Unit Sale /  (This Month Sale - Other Unit Sale)  </span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                        <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹ <?php echo $our_unit_sales_last_month.' / '.$this_unit_total_sales_last_month;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close







	//--------------Row 2
	function suplier_rej_this_month_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Rejection Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$supplier_reject_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Rejection Invoice' and entry_date between '$last_month_from' and '$last_month_to' and is_it_cancel=0   ";
		$supplier_reject_last_month=$this->Mymodel->query1($query);

		
		$a= round($supplier_reject_this_month[0]['rs']); 
		$b=round($supplier_reject_last_month[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
		
						<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Supplier Rejection This Month (GST) </span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                        <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹ <?php echo $b;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close



	function cust_rej_this_month_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$query="SELECT sum(grandtotal) as rs FROM rejection where  entry_date between '$this_month_from' and '$this_month_to'  ";
		$customer_reject_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM rejection where  entry_date between '$last_month_from' and '$last_month_to'   ";
		$customer_reject_last_month=$this->Mymodel->query1($query);

		
		$a= round($customer_reject_this_month[0]['rs']); 
		$b=round($customer_reject_last_month[0]['rs']);
		$per=$this->Dashbord->get_percentage($a,$b);
		$arrow2=$this->Dashbord->get_percentage_arrow($a,$b);
		if($arrow2=='up'){$color2='green';}else{$color2='red';}$color2='white';
		?>
		
						<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>">₹ <span class="counter"><?php echo $a?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Customer Rejection This Month (GST) </span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php echo $per;?>%</span>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
                                        </div>
                                        <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>">Last Month: ₹ <?php echo $b;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	function suplier_rej_this_month_box_graph($div_length,$div_background_color,$div_color,$g_color1,$g_color2)
	{
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		//Same in above function
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date between '$this_month_from' and '$this_month_to'  ";
		$purchase_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Rejection Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$supplier_reject_this_month=$this->Mymodel->query1($query);
		
		
		?>
						<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success"  style=" color:<?php echo $div_color;?>;">
                                <div class="panel-body" style="background-color:<?php echo $div_background_color;?>">
                                     <div style="float:right">
                                     		<div style="height:5px; width:20px; background-color:<?php echo $g_color1;?>;"></div>Purchase
                                            <div style="height:5px; width:20px; background-color:<?php echo $g_color2;?>;"></div>Rejection
                                     </div>
                                     <div style="width:100%; float:left; margin-top:-60px">
                                     		<div>                                   
                                              <canvas id="chart1" height="100%"></canvas>
                                              <p align="center"></p>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<script>
								var ctx1 = document.getElementById("chart1").getContext("2d");
								var data1 = [
												{
													value: <?php if(round($purchase_this_month[0]['rs'])>0){echo round($purchase_this_month[0]['rs']);}else{echo 100;}?>,
													color: "#12AFCB",
													highlight: "#12AFCB",
													label: "Total Purchase This Month"
												},
												{
													value: <?php if(round($supplier_reject_this_month[0]['rs'])>0){echo round($supplier_reject_this_month[0]['rs']);}else{echo 0;}?>,
													color: "orange",
													highlight: "orange",
													label: "Supplier Rejection this Month"
												}
											];

								var myPieChart = new Chart(ctx1).Doughnut(data1,{
									segmentShowStroke : true,
									segmentStrokeColor : "#fff",
									segmentStrokeWidth : 2,
									animationSteps : 100,
									animationEasing : "easeOutBounce",
									animateRotate : true,
									animateScale : false,
									responsive: true
								});
						</script>
		<?php
	}//function close


	function customer_rej_this_month_box_graph($div_length,$div_background_color,$div_color,$g_color1,$g_color2)
	{
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		//Same in above function
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$this_month_from' and '$this_month_to' and is_it_cancel=0  ";
		$sale_this_month=$this->Mymodel->query1($query);
		$query="SELECT sum(grandtotal) as rs FROM rejection where  entry_date between '$this_month_from' and '$this_month_to'  ";
		$customer_reject_this_month=$this->Mymodel->query1($query);
		
		
		
		?>
						<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success"  style=" color:<?php echo $div_color;?>;">
                                <div class="panel-body" style="background-color:<?php echo $div_background_color;?>">
                                     <div style="float:right">
                                     		<div style="height:5px; width:20px; background-color:<?php echo $g_color1;?>;"></div>Sale
                                            <div style="height:5px; width:20px; background-color:<?php echo $g_color2;?>;"></div>Rejection
                                     </div>
                                     <div style="width:100%; float:left; margin-top:-60px">
                                     		<div>                                   
                                              <canvas id="chart2" height="100%"></canvas>
                                              <p align="center"></p>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<script>
								var ctx2 = document.getElementById("chart2").getContext("2d");
								var data2 = [
												{
													value: <?php if(round($sale_this_month[0]['rs'])>0){echo round($sale_this_month[0]['rs']);}else{echo 100;}?>,
													color: "#f25656",
													highlight: "#f25656",
													label: "Total Sale This Month"
												},
												{
													value: <?php if(round($customer_reject_this_month[0]['rs'])>0){echo round($customer_reject_this_month[0]['rs']);}else{echo 0;}?>,
													color: "orange",
													highlight: "orange",
													label: "Customer Rejection this Month"
												}
											];

								var myPieChart = new Chart(ctx2).Doughnut(data2,{
									segmentShowStroke : true,
									segmentStrokeColor : "#fff",
									segmentStrokeWidth : 2,
									animationSteps : 100,
									animationEasing : "easeOutBounce",
									animateRotate : true,
									animateScale : false,
									responsive: true
								});
						</script>
		<?php
	}//function close



	
	




	//row 3
	function schedule_vs_supply_graph($div_background_color,$bar_color,$height)
	{
		$unit = $this->Dashbord->dashbord_view_type_unit();
		
		
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		//----current month   same as index2 function in this page
		$query="
					SELECT 
					A.schedule_id
					FROM customer_schedule as A 
					LEFT JOIN customer_schedule_details as B ON B.schedule_id = A.schedule_id
					WHERE  A.type_of_bill='Tax Invoice' and  A.supply='0' and B.from_date between '$this_month_from' and '$this_month_to' GROUP BY A.schedule_no   ORDER by A.schedule_no DESC
				";
		
		$out2=$this->Mymodel->query1($query);
		$order_qty=array();
		$send_qty=array();
		foreach($out2 as $o)
		{
			$schedule_id=$o['schedule_id'];
			$query=" SELECT sum(order_qty) as order_qty,sum(send_qty) as send_qty FROM customer_schedule_details WHERE schedule_id='$schedule_id' ";
			$out=$this->Mymodel->query1($query);
			$order_qty[]=$out[0]['order_qty'];
			$send_qty[]=$out[0]['send_qty'];
		}
	  
	  	if(!empty($order_qty)){$order_qty= array_sum($order_qty);}else{$order_qty=1;}
	  	if(!empty($send_qty)){$send_qty= array_sum($send_qty);}else{$send_qty=1;}
		

		
		?>
						<div class="row">  
							<div class="col-lg-12 col-md-12"> 
								<div class="panel panel-<?php echo $div_background_color;?>"  style=" height:<?php echo $height;?>;">
										<div class="panel-heading clearfix">
											<h4 class="panel-title">Schedule VS Supply Of Current Month (Supplementary PO or bill not include)</h4>
										</div>
										<div class="panel-body">
										<?php 
											if(!empty($order_qty))
											{
												$per=round(($send_qty/$order_qty)*100);
												?>
												<p>Total Schedule Qty <code><?php echo $order_qty.' '.$unit;?> </code> VS Total Supply <code><?php echo $send_qty.' '.$unit;?> </code>.</p>
												<div class="progress">
													<div class="progress-bar progress-bar-<?php echo $bar_color;?>" role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%;">
														<?php echo $per;?>%
													</div>
												</div>
											<?php }?>
										</div>
											
										
									</div>
							</div>
                		</div><!-- Row -->

						<script>
								
						</script>
		<?php
	}//function close









	//row 4
	function daily_sale_in_rs_graph($div_background_color,$height,$width)
	{
		$var = $this->Dashbord->dashbord_view_type_unit();
		$dipatch_target2 = $this->Dashbord->dashbord_sale_target();
		$product_target2 = $this->Dashbord->dashbord_production_target();
		$joint_target12 = $this->Dashbord->dashbord_joint_target();

		$dipatch_target = $dipatch_target2[0]['setting_value'];
		//converting to short name
		$getting_div_digit = strlen($dipatch_target);
		if($getting_div_digit == 7){$getting_div_digit=6;}elseif($getting_div_digit >= 9){$getting_div_digit=8;}
		$getting_div_val = str_pad(1, $getting_div_digit, '0', STR_PAD_RIGHT);
		//$product_target = $product_target2[0]['setting_value'];
		$joint_target1 = $joint_target12[0]['setting_value'];
		$joint_target2 = $joint_target12[0]['mail_type'];
		?>
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														<?php echo date('M-Y');?> Sales In Rs.  (Target / without GST / with GST)
													</h3>
												</div>
												
												<div class="panel-body">
													<div>
														<canvas id="chart3" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												
													<script>
														var ctx3 = document.getElementById("chart3").getContext("2d");
														var data3 = {
															labels: [ 
																		<?php 
																		$m=date('m');
																		$y=date('Y');
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'd');
																			
																			if($i==31)
																			{
																				?>"<?php echo $new_date;?>"<?php
																			}
																			else
																			{
																				?>"<?php echo $new_date;?>",<?php
																			}
																			
																		}
																		?>
																	],
														
														
														
															datasets: [
															
																		{
																			fillColor: "rgba(18,175,203,0.2)",
																			strokeColor: "rgba(18,175,203,1)",
																			pointColor: "rgba(18,175,203,1)",
																			data: [
																					<?php 
																					for($i=1;$i<=31;$i++)
																					{
																						$dipatch_target2 = round($dipatch_target/$getting_div_val,1);
																						if($i==31)
																						{
																							echo $dipatch_target2;
																						}
																						else
																						{
																							echo "$dipatch_target2,";
																						}
																					}
																					?>
																					
															
																				]
																		},
																	
																		{
																			fillColor: "rgba(34,186,160,0.5)",
																			strokeColor: "rgba(34,186,160,0.8)",
																			highlightFill: "rgba(34,186,160,0.75)",
																			highlightStroke: "rgba(34,186,160,1)",
																			data: [
																					<?php 
																										$m=date('m');
																										$y=date('Y');
																										for($i=1;$i<=31;$i++)
																										{
																											//creating date
																											$test = new DateTime("$i-$m-$y");
																											$new_date= date_format($test, 'Y-m-d');
																											
																											$query="SELECT sum(total) as rs FROM `dispatch` WHERE `entry_date`='$new_date' and type_of_bill = 'Tax Invoice'  and is_it_cancel=0 ";
																											$out=$this->Mymodel->query1($query);
																											
																											if($i==31)
																											{
																												?>"<?php echo round($out[0]['rs']/$getting_div_val);$total[] = round($out[0]['rs']);?>"<?php
																											}
																											else
																											{
																												?>"<?php echo  round($out[0]['rs']/$getting_div_val); $total[] = round($out[0]['rs']);?>",<?php
																											}
																										}
																										?>				 	  
																				]
																		},
																		{
																			fillColor: "rgba(255,0,0,0.5)",
																			strokeColor: "rgba(220,220,220,0.8)",
																			highlightFill: "rgba(220,220,220,0.75)",
																			highlightStroke: "rgba(220,220,220,1)",
																			data: [
																					<?php 
																										$m=date('m');
																										$y=date('Y');
																										for($i=1;$i<=31;$i++)
																										{
																											//creating date
																											$test = new DateTime("$i-$m-$y");
																											$new_date= date_format($test, 'Y-m-d');
																											
																											$query="SELECT sum(grandtotal) as rs FROM `dispatch` WHERE `entry_date`='$new_date' and type_of_bill = 'Tax Invoice'  and is_it_cancel=0 ";
																											$out=$this->Mymodel->query1($query);
																											
																											if($i==31)
																											{
																												?>"<?php echo round($out[0]['rs']/$getting_div_val);$total_grand[] = round($out[0]['rs']);?>"<?php
																											}
																											else
																											{
																												?>"<?php echo  round($out[0]['rs']/$getting_div_val); $total_grand[] = round($out[0]['rs']);?>",<?php
																											}
																										}
																										?>				 	  
																				]
																		}
															
																
																
															]
															
															
														};
														var myBar = new Chart(ctx3).Bar(data3, {
														showTooltips: false,
														onAnimationComplete: function () {
													
															var ctx = this.chart.ctx;
															ctx.font = this.scale.font;
															ctx.fillStyle = this.scale.textColor
															ctx.textAlign = "center";
															ctx.textBaseline = "bottom";
													
															this.datasets.forEach(function (dataset) {
																dataset.bars.forEach(function (bar) {
																	ctx.fillText(bar.value, bar.x, bar.y - 5);
																});
															})
														}
													});
													</script>
													<?php 
														if(!empty($total))
														{
															echo "Total : ".$total_sale_this_month =  round(array_sum($total)); 
															$total_sale_this_month = round($total_sale_this_month/date('d'));
															echo ', Avg : '.$total_sale_this_month ;

															echo "<b>";
															echo ", Total with GST : ".$total_sale_this_month =  round(array_sum($total_grand)); 
															$total_sale_this_month = round($total_sale_this_month/date('d'));
															echo ', Avg  : '.$total_sale_this_month ;
															echo "</b>";
														}
														echo "<br> Divide By : ";
														echo $getting_div_rs = $this->Mymodel->convert_number_to_words($getting_div_val);
													?>
												</div> <!---<div class="panel-body">-->
											</div> <!--<div class="panel panel-->
								</div><!--<div class="col-md-12">-->
						</div>    
						<!-- Row -->

		<?php
	}//function close













	//row 5
	function daily_production_in_rs_graph($div_background_color,$height,$width)
	{
		
		$var = $this->Dashbord->dashbord_view_type_unit();
		$dipatch_target2 = $this->Dashbord->dashbord_sale_target();
		$product_target2 = $this->Dashbord->dashbord_production_target();
		$joint_target12 = $this->Dashbord->dashbord_joint_target();

		$dipatch_target = $dipatch_target2[0]['setting_value'];
		$product_target = $product_target2[0]['setting_value'];
		$joint_target1 = $joint_target12[0]['setting_value'];
		$joint_target2 = $joint_target12[0]['mail_type'];


		?>
						
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														<?php echo date('M-Y');?> Production Day wise Rs
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart4" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						</div>    
 
						<!-- Row -->

						<script>
						var ctx4 = document.getElementById("chart4").getContext("2d");
						var data4 = {
							labels: [ 
										<?php 
										$m=date('m');
										$y=date('Y');
										for($i=1;$i<=31;$i++)
										{
											//creating date
											$test = new DateTime("$i-$m-$y");
											$new_date= date_format($test, 'd');
											
											if($i==31)
											{
												?>"<?php echo $new_date;?>"<?php
											}
											else
											{
												?>"<?php echo $new_date;?>",<?php
											}
											
										}
										?>
									],
						
						
						
							datasets: [
										{
											label: "My First dataset",
											fillColor: "rgba(220,220,220,0.2)",
											strokeColor: "rgba(220,220,220,1)",
											pointColor: "rgba(220,220,220,1)",
											data: [
													<?php 
													for($i=1;$i<=31;$i++)
													{
														if($i==31)
														{
															echo $product_target;
														}
														else
														{
															echo "$product_target,";
														}
													}
													?>
													
							
												]
										},
										
										{
											label: "My Second dataset",
											fillColor: "rgba(18,175,203,0.2)",
											strokeColor: "rgba(18,175,203,1)",
											pointColor: "rgba(18,175,203,1)",
											data: [
													<?php 
																		$m=date('m');
																		$y=date('Y');
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'Y-m-d');
																			
																			///selecting dashbord
																			if($this->Dashbord->dashbord_view_type()==1)
																			{
																				$query="SELECT sum(cost) as qty FROM `rope_mc_production` WHERE `entry_date`='$new_date' and stage='C'  ";
																			}
																			elseif($this->Dashbord->dashbord_view_type()==2)
																			{
																				$query="SELECT sum(contents) as qty FROM `koyo_production` WHERE `manu_date`='$new_date'   ";
																			}
																			else
																			{
																				$query="SELECT sum(cost) as qty FROM `rope_mc_production` WHERE `entry_date`='$new_date' and stage='C'  ";
																			}
																			
																			$out=$this->Mymodel->query1($query);
																			
																			if($i==31)
																			{
																				?>"<?php echo round($out[0]['qty']);?>"<?php
																			}
																			else
																			{
																				?>"<?php echo round($out[0]['qty']);?>",<?php
																			}
																			
																		}
																		?>				 	  
												]
										}
							
								
								
							]
							
							
						};
						var chart4 = new Chart(ctx4).Line(data4, {
							scaleShowGridLines : true,
							scaleGridLineColor : "rgba(0,0,0,.05)",
							scaleGridLineWidth : 1,
							scaleShowHorizontalLines: true,
							scaleShowVerticalLines: true,
							bezierCurve : true,
							bezierCurveTension : 0.4,
							pointDot : true,
							pointDotRadius : 4,
							pointDotStrokeWidth : 1,
							pointHitDetectionRadius : 20,
							datasetStroke : true,
							datasetStrokeWidth : 2,
							datasetFill : true,
							responsive: true
						});

						</script>
		<?php
	}//function close






	//row 6
	function schedule_vs_supply_montly_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		?>
						
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													<span style="color:<?php echo $g_color1;?>;">Schedule</span> VS <span style="color:<?php echo $g_color2;?>;">Supply</span> Mothly Chart in qty
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart5" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						</div>    
 
						<!-- Row -->

						<script>
						<?php
						$schedule_m1= $this->Mymodel->get_schedule_vs_supply("01");
						$schedule_m2= $this->Mymodel->get_schedule_vs_supply("02");
						$schedule_m3= $this->Mymodel->get_schedule_vs_supply("03");
						$schedule_m4= $this->Mymodel->get_schedule_vs_supply("04");
						$schedule_m5= $this->Mymodel->get_schedule_vs_supply("05");
						$schedule_m6= $this->Mymodel->get_schedule_vs_supply("06");
						$schedule_m7= $this->Mymodel->get_schedule_vs_supply("07");
						$schedule_m8= $this->Mymodel->get_schedule_vs_supply("08");
						$schedule_m9= $this->Mymodel->get_schedule_vs_supply("09");
						$schedule_m10= $this->Mymodel->get_schedule_vs_supply("10");
						$schedule_m11= $this->Mymodel->get_schedule_vs_supply("11");
						$schedule_m12= $this->Mymodel->get_schedule_vs_supply("12");
						?>          
						<?php if(isset($schedule_m1['order_qty'])){ $per_1=round(($schedule_m1['send_qty']/$schedule_m1['order_qty'])*100);}?>
						<?php if(isset($schedule_m2['order_qty'])){ $per_2=round(($schedule_m2['send_qty']/$schedule_m2['order_qty'])*100);}?>
						<?php if(isset($schedule_m3['order_qty'])){ $per_3=round(($schedule_m3['send_qty']/$schedule_m3['order_qty'])*100);}?>
						<?php if(isset($schedule_m4['order_qty'])){ $per_4=round(($schedule_m4['send_qty']/$schedule_m4['order_qty'])*100);}?>
						<?php if(isset($schedule_m5['order_qty'])){ $per_5=round(($schedule_m5['send_qty']/$schedule_m5['order_qty'])*100);}?>
						<?php if(isset($schedule_m6['order_qty'])){ $per_6=round(($schedule_m6['send_qty']/$schedule_m6['order_qty'])*100);}?>
						<?php if(isset($schedule_m7['order_qty'])){ $per_7=round(($schedule_m7['send_qty']/$schedule_m7['order_qty'])*100);}?>
						<?php if(isset($schedule_m8['order_qty'])){ $per_8=round(($schedule_m8['send_qty']/$schedule_m8['order_qty'])*100);}?>
						<?php if(isset($schedule_m9['order_qty'])){ $per_9=round(($schedule_m9['send_qty']/$schedule_m9['order_qty'])*100);}?>
						<?php if(isset($schedule_m10['order_qty'])){ $per_10=round(($schedule_m10['send_qty']/$schedule_m10['order_qty'])*100);}?>
						<?php if(isset($schedule_m11['order_qty'])){ $per_11=round(($schedule_m11['send_qty']/$schedule_m11['order_qty'])*100);}?>
						<?php if(isset($schedule_m12['order_qty'])){ $per_12=round(($schedule_m12['send_qty']/$schedule_m12['order_qty'])*100);}?>
						

						var ctx5 = document.getElementById("chart5").getContext("2d");
							var data5 = {
								labels: [ 
											"January<?php if(!empty($per_1)){echo " ($per_1 %)";}?>", 
											"February<?php if(!empty($per_2)){echo " ($per_2 %)";}?>", 
											"March<?php if(!empty($per_3)){echo " ($per_3 %)";}?>", 
											"April<?php if(!empty($per_4)){echo " ($per_4 %)";}?>", 
											"May<?php if(!empty($per_5)){echo " ($per_5 %)";}?>", 
											"June<?php if(!empty($per_6)){echo " ($per_6 %)";}?>", 
											"July<?php if(!empty($per_7)){echo " ($per_7 %)";}?>", 
											"August<?php if(!empty($per_8)){echo " ($per_8 %)";}?>", 
											"September<?php if(!empty($per_9)){echo " ($per_9 %)";}?>", 
											"October<?php if(!empty($per_10)){echo " ($per_10 %)";}?>", 
											"November<?php if(!empty($per_11)){echo " ($per_11 %)";}?>", 
											"December<?php if(!empty($per_12)){echo " ($per_12 %)";}?>"  
										],
								datasets: [
									{
										

										label: "My Second dataset",
										fillColor: "rgba(34,186,160,0.5)",
										strokeColor: "rgba(34,186,160,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
													<?php if(isset($schedule_m1['order_qty'])){echo $schedule_m1['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m2['order_qty'])){echo $schedule_m2['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m3['order_qty'])){echo $schedule_m3['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m4['order_qty'])){echo $schedule_m4['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m5['order_qty'])){echo $schedule_m5['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m6['order_qty'])){echo $schedule_m6['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m7['order_qty'])){echo $schedule_m7['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m8['order_qty'])){echo $schedule_m8['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m9['order_qty'])){echo $schedule_m9['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m10['order_qty'])){echo $schedule_m10['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m11['order_qty'])){echo $schedule_m11['order_qty'];}else{echo 0;}?>,
													<?php if(isset($schedule_m12['order_qty'])){echo $schedule_m12['order_qty'];}else{echo 0;}?>
											]
									},
									{
										label: "My First dataset",
										fillColor: "rgba(255,0,0,0.5)",
										strokeColor: "rgba(220,220,220,0.8)",
										highlightFill: "rgba(220,220,220,0.75)",
										highlightStroke: "rgba(220,220,220,1)",
										data: [
												<?php if(isset($schedule_m1['send_qty'])){echo $schedule_m1['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m2['send_qty'])){echo $schedule_m2['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m3['send_qty'])){echo $schedule_m3['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m4['send_qty'])){echo $schedule_m4['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m5['send_qty'])){echo $schedule_m5['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m6['send_qty'])){echo $schedule_m6['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m7['send_qty'])){echo $schedule_m7['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m8['send_qty'])){echo $schedule_m8['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m9['send_qty'])){echo $schedule_m9['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m10['send_qty'])){echo $schedule_m10['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m11['send_qty'])){echo $schedule_m11['send_qty'];}else{echo 0;}?>,
												<?php if(isset($schedule_m12['send_qty'])){echo $schedule_m12['send_qty'];}else{echo 0;}?>

											]
									}
								]
							};
							
						var myBar = new Chart(ctx5).Bar(data5, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close


	//row 6
	function schedule_vs_supply_montly_graph_rs($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		?>
						
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													<span style="color:<?php echo $g_color1;?>;">Schedule</span> VS <span style="color:<?php echo $g_color2;?>;">Supply</span> Mothly Chart in Rs
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart555xm" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						</div>    
 
						<!-- Row -->

						<script>
						<?php
						$schedule_m1= $this->Mymodel->get_schedule_vs_supply("01");
						$schedule_m2= $this->Mymodel->get_schedule_vs_supply("02");
						$schedule_m3= $this->Mymodel->get_schedule_vs_supply("03");
						$schedule_m4= $this->Mymodel->get_schedule_vs_supply("04");
						$schedule_m5= $this->Mymodel->get_schedule_vs_supply("05");
						$schedule_m6= $this->Mymodel->get_schedule_vs_supply("06");
						$schedule_m7= $this->Mymodel->get_schedule_vs_supply("07");
						$schedule_m8= $this->Mymodel->get_schedule_vs_supply("08");
						$schedule_m9= $this->Mymodel->get_schedule_vs_supply("09");
						$schedule_m10= $this->Mymodel->get_schedule_vs_supply("10");
						$schedule_m11= $this->Mymodel->get_schedule_vs_supply("11");
						$schedule_m12= $this->Mymodel->get_schedule_vs_supply("12");
						?>          
						<?php if(isset($schedule_m1['order_amt'])){ $per_1=round(($schedule_m1['send_amt']/$schedule_m1['order_amt'])*100);}?>
						<?php if(isset($schedule_m2['order_amt'])){ $per_2=round(($schedule_m2['send_amt']/$schedule_m2['order_amt'])*100);}?>
						<?php if(isset($schedule_m3['order_amt'])){ $per_3=round(($schedule_m3['send_amt']/$schedule_m3['order_amt'])*100);}?>
						<?php if(isset($schedule_m4['order_amt'])){ $per_4=round(($schedule_m4['send_amt']/$schedule_m4['order_amt'])*100);}?>
						<?php if(isset($schedule_m5['order_amt'])){ $per_5=round(($schedule_m5['send_amt']/$schedule_m5['order_amt'])*100);}?>
						<?php if(isset($schedule_m6['order_amt'])){ $per_6=round(($schedule_m6['send_amt']/$schedule_m6['order_amt'])*100);}?>
						<?php if(isset($schedule_m7['order_amt'])){ $per_7=round(($schedule_m7['send_amt']/$schedule_m7['order_amt'])*100);}?>
						<?php if(isset($schedule_m8['order_amt'])){ $per_8=round(($schedule_m8['send_amt']/$schedule_m8['order_amt'])*100);}?>
						<?php if(isset($schedule_m9['order_amt'])){ $per_9=round(($schedule_m9['send_amt']/$schedule_m9['order_amt'])*100);}?>
						<?php if(isset($schedule_m10['order_amt'])){ $per_10=round(($schedule_m10['send_amt']/$schedule_m10['order_amt'])*100);}?>
						<?php if(isset($schedule_m11['order_amt'])){ $per_11=round(($schedule_m11['send_amt']/$schedule_m11['order_amt'])*100);}?>
						<?php if(isset($schedule_m12['order_amt'])){ $per_12=round(($schedule_m12['send_qsend_amtty']/$schedule_m12['order_amt'])*100);}?>
						

						var ctx555xm = document.getElementById("chart555xm").getContext("2d");
							var data555xm = {
								labels: [ 
											"January<?php if(!empty($per_1)){echo " ($per_1 %)";}?>", 
											"February<?php if(!empty($per_2)){echo " ($per_2 %)";}?>", 
											"March<?php if(!empty($per_3)){echo " ($per_3 %)";}?>", 
											"April<?php if(!empty($per_4)){echo " ($per_4 %)";}?>", 
											"May<?php if(!empty($per_5)){echo " ($per_5 %)";}?>", 
											"June<?php if(!empty($per_6)){echo " ($per_6 %)";}?>", 
											"July<?php if(!empty($per_7)){echo " ($per_7 %)";}?>", 
											"August<?php if(!empty($per_8)){echo " ($per_8 %)";}?>", 
											"September<?php if(!empty($per_9)){echo " ($per_9 %)";}?>", 
											"October<?php if(!empty($per_10)){echo " ($per_10 %)";}?>", 
											"November<?php if(!empty($per_11)){echo " ($per_11 %)";}?>", 
											"December<?php if(!empty($per_12)){echo " ($per_12 %)";}?>"  
										],
								datasets: [
									{
										label: "My Second dataset",
										fillColor: "rgba(34,186,160,0.5)",
										strokeColor: "rgba(34,186,160,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
													<?php if(isset($schedule_m1['order_amt'])){echo $schedule_m1['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m2['order_amt'])){echo $schedule_m2['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m3['order_amt'])){echo $schedule_m3['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m4['order_amt'])){echo $schedule_m4['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m5['order_amt'])){echo $schedule_m5['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m6['order_amt'])){echo $schedule_m6['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m7['order_amt'])){echo $schedule_m7['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m8['order_amt'])){echo $schedule_m8['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m9['order_amt'])){echo $schedule_m9['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m10['order_amt'])){echo $schedule_m10['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m11['order_amt'])){echo $schedule_m11['order_amt'];}else{echo 0;}?>,
													<?php if(isset($schedule_m12['order_amt'])){echo $schedule_m12['order_amt'];}else{echo 0;}?>
											]
									},
									{
										label: "My First dataset",
										fillColor: "rgba(255,0,0,0.5)",
										strokeColor: "rgba(220,220,220,0.8)",
										highlightFill: "rgba(220,220,220,0.75)",
										highlightStroke: "rgba(220,220,220,1)",
										data: [
												<?php if(isset($schedule_m1['send_amt'])){echo $schedule_m1['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m2['send_amt'])){echo $schedule_m2['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m3['send_amt'])){echo $schedule_m3['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m4['send_amt'])){echo $schedule_m4['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m5['send_amt'])){echo $schedule_m5['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m6['send_amt'])){echo $schedule_m6['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m7['send_amt'])){echo $schedule_m7['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m8['send_amt'])){echo $schedule_m8['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m9['send_amt'])){echo $schedule_m9['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m10['send_amt'])){echo $schedule_m10['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m11['send_amt'])){echo $schedule_m11['send_amt'];}else{echo 0;}?>,
												<?php if(isset($schedule_m12['send_amt'])){echo $schedule_m12['send_amt'];}else{echo 0;}?>

											]
									}
								]
							};
							
						var myBar = new Chart(ctx555xm).Bar(data555xm, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close








	//row 7
	function get_total_purchase_formdate_todate($from_date,$to_date)
	{
		//same function above
		$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date between '$from_date' and '$to_date'  ";
		$res = $this->Mymodel->query1($query);
		if(isset($res[0]['rs'])){$rs = round($res[0]['rs']);}else{$rs = 0;}
		return $rs;
	}//function close

	function get_total_sale_formdate_todate($from_date,$to_date)
	{
		//same function above
		$query="SELECT sum(grandtotal) as rs FROM dispatch where type_of_bill='Tax Invoice' and entry_date between '$from_date' and '$to_date' and is_it_cancel=0  ";
		$res=$this->Mymodel->query1($query);
		if(isset($res[0]['rs'])){$rs = round($res[0]['rs']);}else{$rs = 0;}
		return $rs;
	}//function close


	function purchase_vs_sale_montly_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		
		?>
				
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													<span style="color:<?php echo $g_color1;?>;">Purchase</span> VS <span style="color:<?php echo $g_color2;?>;">Sale</span> Mothly Chart in Rs with GST
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart6" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						</div> 


						<?php  $p_rs1 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-01-01'),date('Y-01-31'));?>
						<?php  $p_rs2 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-02-01'),date('Y-02-31'));?>
						<?php  $p_rs3 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-03-01'),date('Y-03-31'));?>
						<?php  $p_rs4 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-04-01'),date('Y-04-31'));?>
						<?php  $p_rs5 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-05-01'),date('Y-05-31'));?>
						<?php  $p_rs6 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-06-01'),date('Y-06-31'));?>
						<?php  $p_rs7 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-07-01'),date('Y-07-31'));?>
						<?php  $p_rs8 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-08-01'),date('Y-08-31'));?>
						<?php  $p_rs9 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-09-01'),date('Y-09-31'));?>
						<?php  $p_rs10 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-10-01'),date('Y-10-31'));?>
						<?php  $p_rs11 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-11-01'),date('Y-11-31'));?>
						<?php  $p_rs12 = $this->Dashbord->get_total_purchase_formdate_todate(date('Y-12-01'),date('Y-12-31'));?>

						<?php  $s_rs1 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-01-01'),date('Y-01-31'));?>
						<?php  $s_rs2 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-02-01'),date('Y-02-31'));?>
						<?php  $s_rs3 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-03-01'),date('Y-03-31'));?>
						<?php  $s_rs4 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-04-01'),date('Y-04-31'));?>
						<?php  $s_rs5 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-05-01'),date('Y-05-31'));?>
						<?php  $s_rs6 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-06-01'),date('Y-06-31'));?>
						<?php  $s_rs7 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-07-01'),date('Y-07-31'));?>
						<?php  $s_rs8 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-08-01'),date('Y-08-31'));?>
						<?php  $s_rs9 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-09-01'),date('Y-09-31'));?>
						<?php  $s_rs10 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-10-01'),date('Y-10-31'));?>
						<?php  $s_rs11 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-11-01'),date('Y-11-31'));?>
						<?php  $s_rs12 = $this->Dashbord->get_total_sale_formdate_todate(date('Y-12-01'),date('Y-12-31'));?>

						<?php 
							if(isset($s_rs1) and isset($p_rs1)){ $per_1=round(($p_rs1/$s_rs1)*100);}
							if(isset($s_rs2) and isset($p_rs2)){ $per_2=round(($p_rs2/$s_rs2)*100);}
							if(isset($s_rs3) and isset($p_rs3)){ $per_3=round(($p_rs3/$s_rs3)*100);}
							if(isset($s_rs4) and isset($p_rs4)){ $per_4=round(($p_rs4/$s_rs4)*100);}
							if(isset($s_rs5) and isset($p_rs5)){ $per_5=round(($p_rs5/$s_rs5)*100);}
							if(isset($s_rs6) and isset($p_rs6)){ $per_6=round(($p_rs6/$s_rs6)*100);}
							if(isset($s_rs7) and isset($p_rs7)){ $per_7=round(($p_rs7/$s_rs7)*100);}
							if(isset($s_rs8) and isset($p_rs8)){ $per_8=round(($p_rs8/$s_rs8)*100);}
							if(isset($s_rs9) and isset($p_rs9)){ $per_9=round(($p_rs9/$s_rs9)*100);}
							if(isset($s_rs10) and isset($p_rs10)){ $per_10=round(($p_rs10/$s_rs10)*100);}
							if(isset($s_rs11) and isset($p_rs11)){ $per_11=round(($p_rs11/$s_rs11)*100);}
							if(isset($s_rs12) and isset($p_rs12)){ $per_12=round(($p_rs12/$s_rs12)*100);}
						?>
						<!-- Row -->

						<script>
						
							var ctx6 = document.getElementById("chart6").getContext("2d");
								var data6 = {
									labels: [ 
												"January<?php if(!empty($per_1)){echo " ($per_1 %)";}?>", 
												"February<?php if(!empty($per_2)){echo " ($per_2 %)";}?>", 
												"March<?php if(!empty($per_3)){echo " ($per_3 %)";}?>", 
												"April<?php if(!empty($per_4)){echo " ($per_4 %)";}?>", 
												"May<?php if(!empty($per_5)){echo " ($per_5 %)";}?>", 
												"June<?php if(!empty($per_6)){echo " ($per_6 %)";}?>", 
												"July<?php if(!empty($per_7)){echo " ($per_7 %)";}?>", 
												"August<?php if(!empty($per_8)){echo " ($per_8 %)";}?>", 
												"September<?php if(!empty($per_9)){echo " ($per_9 %)";}?>", 
												"October<?php if(!empty($per_10)){echo " ($per_10 %)";}?>", 
												"November<?php if(!empty($per_11)){echo " ($per_11 %)";}?>", 
												"December<?php if(!empty($per_12)){echo " ($per_12 %)";}?>" 
											],
									datasets: [
										{
											label: "Purchase",
											fillColor: "#12AFCB",
											highlightFill: "#12AFCB",
											
											data: [
													<?php if(isset($p_rs1)){echo $p_rs1;}else{echo 0;}?>,
													<?php if(isset($p_rs2)){echo $p_rs2;}else{echo 0;}?>,
													<?php if(isset($p_rs3)){echo $p_rs3;}else{echo 0;}?>,
													<?php if(isset($p_rs4)){echo $p_rs4;}else{echo 0;}?>,
													<?php if(isset($p_rs5)){echo $p_rs5;}else{echo 0;}?>,
													<?php if(isset($p_rs6)){echo $p_rs6;}else{echo 0;}?>,
													<?php if(isset($p_rs7)){echo $p_rs7;}else{echo 0;}?>,
													<?php if(isset($p_rs8)){echo $p_rs8;}else{echo 0;}?>,
													<?php if(isset($p_rs9)){echo $p_rs9;}else{echo 0;}?>,
													<?php if(isset($p_rs10)){echo $p_rs10;}else{echo 0;}?>,
													<?php if(isset($p_rs11)){echo $p_rs11;}else{echo 0;}?>,
													<?php if(isset($p_rs12)){echo $p_rs12;}else{echo 0;}?>
												]
										},
										{
											label: "Sale",
											fillColor: "rgba(255,0,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php if(isset($s_rs1)){echo $s_rs1;}else{echo 0;}?>,
														<?php if(isset($s_rs2)){echo $s_rs2;}else{echo 0;}?>,
														<?php if(isset($s_rs3)){echo $s_rs3;}else{echo 0;}?>,
														<?php if(isset($s_rs4)){echo $s_rs4;}else{echo 0;}?>,
														<?php if(isset($s_rs5)){echo $s_rs5;}else{echo 0;}?>,
														<?php if(isset($s_rs6)){echo $s_rs6;}else{echo 0;}?>,
														<?php if(isset($s_rs7)){echo $s_rs7;}else{echo 0;}?>,
														<?php if(isset($s_rs8)){echo $s_rs8;}else{echo 0;}?>,
														<?php if(isset($s_rs9)){echo $s_rs9;}else{echo 0;}?>,
														<?php if(isset($s_rs10)){echo $s_rs10;}else{echo 0;}?>,
														<?php if(isset($s_rs11)){echo $s_rs11;}else{echo 0;}?>,
														<?php if(isset($s_rs12)){echo $s_rs12;}else{echo 0;}?>
														
												]
										}
									]
								};
								
								var myBar = new Chart(ctx6).Bar(data6, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});
						</script>
		<?php
	}//function close








	//row 8
	function daily_joint_graph($div_background_color,$height,$width)
	{
		
		$var = $this->Dashbord->dashbord_view_type_unit();
		$dipatch_target2 = $this->Dashbord->dashbord_sale_target();
		$product_target2 = $this->Dashbord->dashbord_production_target();
		$joint_target12 = $this->Dashbord->dashbord_joint_target();

		$dipatch_target = $dipatch_target2[0]['setting_value'];
		$product_target = $product_target2[0]['setting_value'];
		$joint_target1 = $joint_target12[0]['setting_value'];
		$joint_target2 = $joint_target12[0]['mail_type'];

		?>
						
						<div class="row" >
								<div class="col-md-12">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
												<h3 class="panel-title">
													<?php echo date('M-Y');?> Joint Chart
												</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart7" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						</div> 

						<!-- Row -->
						
						<script>
						var ctx7 = document.getElementById("chart7").getContext("2d");
						var data7 = {
							labels: [ 
										<?php 
										$m=date('m');
										$y=date('Y');
										for($i=1;$i<=31;$i++)
										{
											//creating date
											$test = new DateTime("$i-$m-$y");
											$new_date= date_format($test, 'd');
											
											if($i==31)
											{
												?>"<?php echo $new_date;?>"<?php
											}
											else
											{
												?>"<?php echo $new_date;?>",<?php
											}
											
										}
										?>
									],
						
						
						
							datasets: [
										{
											label: "My First dataset",
											fillColor: "rgba(220,220,220,0.2)",
											strokeColor: "rgba(220,220,220,1)",
											pointColor: "rgba(220,220,220,1)",
											data: [
													<?php 
													for($i=1;$i<=31;$i++)
													{
														if($i==31)
														{
															echo $joint_target1;
														}
														else
														{
															echo "$joint_target1,";
														}
													}
													?>
													
							
												]
										},
										
										
										{
											label: "My First dataset",
											fillColor: "rgba(220,220,220,0.2)",
											strokeColor: "rgba(220,220,220,1)",
											pointColor: "rgba(220,220,220,1)",
											data: [
													<?php 
													for($i=1;$i<=31;$i++)
													{
														if($i==31)
														{
															echo $joint_target2;
														}
														else
														{
															echo "$joint_target2,";
														}
													}
													?>
													
							
												]
										},
							
										{
											label: "My Second dataset",
											fillColor: "rgba(122,111,190,0.2)",
											strokeColor: "rgba(122,111,190,1)",
											pointColor: "rgba(122,111,190,1)",
											data: [
													<?php 
															$m=date('m');
															$y=date('Y');
															for($i=1;$i<=31;$i++)
															{
																//creating date
																$test = new DateTime("$i-$m-$y");
																$new_date= date_format($test, 'Y-m-d');
																
																$query="SELECT sum(joint) as joint,sum(bobbin) as bobbin FROM `daily_joint` WHERE `entry_date`='$new_date'  ";
																$out=$this->Mymodel->query1($query);
																if(!empty($out)){$joint=$out[0]['joint'];$bobbin=$out[0]['bobbin'];}else{$joint=''; $bobbin='';}
																
																if($i==31)
																{
																	//without comma
																	if($joint>1 and $bobbin>1)
																	{
																		?>"<?php echo round(($out[0]['joint']/$out[0]['bobbin']),1);?>"<?php
																	}
																	else
																	{
																		?>"0"<?php
																	}
																}
																else
																{
																	//with comma
																	if($joint>1 and $bobbin>1)
																	{
																		?>"<?php echo round(($out[0]['joint']/$out[0]['bobbin']),1);?>",<?php
																	}
																	else
																	{
																		?>"0",<?php
																	}
																}//31
																
															}
													?>				 	  
												]
										}
							
								
								
							]
							
							
						};
						var chart7 = new Chart(ctx7).Line(data7, {
							scaleShowGridLines : true,
							scaleGridLineColor : "rgba(0,0,0,.05)",
							scaleGridLineWidth : 1,
							scaleShowHorizontalLines: true,
							scaleShowVerticalLines: true,
							bezierCurve : true,
							bezierCurveTension : 0.4,
							pointDot : true,
							pointDotRadius : 4,
							pointDotStrokeWidth : 1,
							pointHitDetectionRadius : 20,
							datasetStroke : true,
							datasetStrokeWidth : 2,
							datasetFill : true,
							responsive: true
						});


						
						</script>
		<?php
	}//function close






	//-----------------------------------------------------------------------------------------Quality
	//-------------------------------------------------row 1
	function quality_lot_accept_reject_graph($div_length,$div_background_color,$height,$width)
	{
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		
		//-------qc get accept lotno no 
		
		$ac_lotno_m1= $this->Mymodel->accept_reject_lotno("01",'accept');
		$ac_lotno_m2= $this->Mymodel->accept_reject_lotno("02",'accept');
		$ac_lotno_m3= $this->Mymodel->accept_reject_lotno("03",'accept');
		$ac_lotno_m4= $this->Mymodel->accept_reject_lotno("04",'accept');
		$ac_lotno_m5= $this->Mymodel->accept_reject_lotno("05",'accept');
		$ac_lotno_m6= $this->Mymodel->accept_reject_lotno("06",'accept');
		$ac_lotno_m7= $this->Mymodel->accept_reject_lotno("07",'accept');
		$ac_lotno_m8= $this->Mymodel->accept_reject_lotno("08",'accept');
		$ac_lotno_m9= $this->Mymodel->accept_reject_lotno("09",'accept');
		$ac_lotno_m10= $this->Mymodel->accept_reject_lotno("010",'accept');
		$ac_lotno_m11= $this->Mymodel->accept_reject_lotno("011",'accept');
		$ac_lotno_m12= $this->Mymodel->accept_reject_lotno("012",'accept');
		
		
		/*
		//-------qc get accept lotno no 
		$result['ac_lotno_m1']= $this->Mymodel->accept_reject_lotno("01",'accept_div');
		$result['ac_lotno_m2']= $this->Mymodel->accept_reject_lotno("02",'accept_div');
		$result['ac_lotno_m3']= $this->Mymodel->accept_reject_lotno("03",'accept_div');
		$result['ac_lotno_m4']= $this->Mymodel->accept_reject_lotno("04",'accept_div');
		$result['ac_lotno_m5']= $this->Mymodel->accept_reject_lotno("05",'accept_div');
		$result['ac_lotno_m6']= $this->Mymodel->accept_reject_lotno("06",'accept_div');
		$result['ac_lotno_m7']= $this->Mymodel->accept_reject_lotno("07",'accept_div');
		$result['ac_lotno_m8']= $this->Mymodel->accept_reject_lotno("08",'accept_div');
		$result['ac_lotno_m9']= $this->Mymodel->accept_reject_lotno("09",'accept_div');
		$result['ac_lotno_m10']= $this->Mymodel->accept_reject_lotno("010",'accept_div');
		$result['ac_lotno_m11']= $this->Mymodel->accept_reject_lotno("011",'accept_div');
		$result['ac_lotno_m12']= $this->Mymodel->accept_reject_lotno("012",'accept_div');
		*/
		
		
		//-------qc get reject lotno no 
		$rj_lotno_m1= $this->Mymodel->accept_reject_lotno("01",'reject');
		$rj_lotno_m2= $this->Mymodel->accept_reject_lotno("02",'reject');
		$rj_lotno_m3= $this->Mymodel->accept_reject_lotno("03",'reject');
		$rj_lotno_m4= $this->Mymodel->accept_reject_lotno("04",'reject');
		$rj_lotno_m5= $this->Mymodel->accept_reject_lotno("05",'reject');
		$rj_lotno_m6= $this->Mymodel->accept_reject_lotno("06",'reject');
		$rj_lotno_m7= $this->Mymodel->accept_reject_lotno("07",'reject');
		$rj_lotno_m8= $this->Mymodel->accept_reject_lotno("08",'reject');
		$rj_lotno_m9= $this->Mymodel->accept_reject_lotno("09",'reject');
		$rj_lotno_m10= $this->Mymodel->accept_reject_lotno("010",'reject');
		$rj_lotno_m11= $this->Mymodel->accept_reject_lotno("011",'reject');
		$rj_lotno_m12= $this->Mymodel->accept_reject_lotno("012",'reject');


		
		//-------qc get accept deviation no 
		$dv_lotno_m1= $this->Mymodel->accept_reject_lotno("01",'deviation');
		$dv_lotno_m2= $this->Mymodel->accept_reject_lotno("02",'deviation');
		$dv_lotno_m3= $this->Mymodel->accept_reject_lotno("03",'deviation');
		$dv_lotno_m4= $this->Mymodel->accept_reject_lotno("04",'deviation');
		$dv_lotno_m5= $this->Mymodel->accept_reject_lotno("05",'deviation');
		$dv_lotno_m6= $this->Mymodel->accept_reject_lotno("06",'deviation');
		$dv_lotno_m7= $this->Mymodel->accept_reject_lotno("07",'deviation');
		$dv_lotno_m8= $this->Mymodel->accept_reject_lotno("08",'deviation');
		$dv_lotno_m9= $this->Mymodel->accept_reject_lotno("09",'deviation');
		$dv_lotno_m10= $this->Mymodel->accept_reject_lotno("010",'deviation');
		$dv_lotno_m11= $this->Mymodel->accept_reject_lotno("011",'deviation');
		$dv_lotno_m12= $this->Mymodel->accept_reject_lotno("012",'deviation');

		?>
						
						
								<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
												<h3 class="panel-title">
													Supplier 
													<span style="color:green;">Accept No OF Lotno</span> VS 
													<span style="color:red">Reject No OF Lotno</span> VS
													<span style="color:#FC0">Deviation No OF Lotno</span>	
												</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart8" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

					
						
						<script>
						
							var ctx8 = document.getElementById("chart8").getContext("2d");
								var data8 = {
									labels: [ 
												"January", 
												"February", 
												"March", 
												"April", 
												"May", 
												"June", 
												"July", 
												"August", 
												"September", 
												"October", 
												"November", 
												"December"  
											],
									datasets: [
										{
											label: "My First dataset",
											fillColor: "rgba(34,186,160,0.5)",
											strokeColor: "rgba(34,186,160,0.8)",
											highlightFill: "rgba(34,186,160,0.75)",
											highlightStroke: "rgba(34,186,160,1)",
											data: [
														<?php if(isset($ac_lotno_m1['val'])){echo $ac_lotno_m1['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m2['val'])){echo $ac_lotno_m2['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m3['val'])){echo $ac_lotno_m3['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m4['val'])){echo $ac_lotno_m4['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m5['val'])){echo $ac_lotno_m5['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m6['val'])){echo $ac_lotno_m6['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m7['val'])){echo $ac_lotno_m7['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m8['val'])){echo $ac_lotno_m8['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m9['val'])){echo $ac_lotno_m9['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m10['val'])){echo $ac_lotno_m10['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m11['val'])){echo $ac_lotno_m11['val'];}else{echo 0;}?>,
														<?php if(isset($ac_lotno_m12['val'])){echo $ac_lotno_m12['val'];}else{echo 0;}?>,
												]
										},
										{
											label: "My Second dataset",
											fillColor: "rgba(255,0,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php if(isset($rj_lotno_m1['val'])){echo $rj_lotno_m1['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m2['val'])){echo $rj_lotno_m2['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m3['val'])){echo $rj_lotno_m3['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m4['val'])){echo $rj_lotno_m4['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m5['val'])){echo $rj_lotno_m5['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m6['val'])){echo $rj_lotno_m6['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m7['val'])){echo $rj_lotno_m7['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m8['val'])){echo $rj_lotno_m8['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m9['val'])){echo $rj_lotno_m9['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m10['val'])){echo $rj_lotno_m10['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m11['val'])){echo $rj_lotno_m11['val'];}else{echo 0;}?>,
														<?php if(isset($rj_lotno_m12['val'])){echo $rj_lotno_m12['val'];}else{echo 0;}?>,
												]
										},
										{
											label: "My Second dataset",
											fillColor: "rgba(255,255,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php if(isset($dv_lotno_m1['val'])){echo $dv_lotno_m1['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m2['val'])){echo $dv_lotno_m2['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m3['val'])){echo $dv_lotno_m3['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m4['val'])){echo $dv_lotno_m4['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m5['val'])){echo $dv_lotno_m5['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m6['val'])){echo $dv_lotno_m6['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m7['val'])){echo $dv_lotno_m7['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m8['val'])){echo $dv_lotno_m8['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m9['val'])){echo $dv_lotno_m9['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m10['val'])){echo $dv_lotno_m10['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m11['val'])){echo $dv_lotno_m11['val'];}else{echo 0;}?>,
														<?php if(isset($dv_lotno_m12['val'])){echo $dv_lotno_m12['val'];}else{echo 0;}?>,

												]
										}
									]
								};
								
							var myBar = new Chart(ctx8).Bar(data8, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});

						
						</script>
		<?php
	}//function close









	//row 2
	function total_pro_scrap_lastmonth_graph($div_length,$div_background_color,$height,$width)
	{
		
		?>
						
						
								<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Total Production & Total Scrap in % of Last Month
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart9" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						
								
						
						<script>
						var ctx9 = document.getElementById("chart9").getContext("2d");
						var data9 = {
							labels: [ 
										<?php 
										$m=date('m');
										$y=date('Y');
										for($i=1;$i<=31;$i++)
										{
											//creating date
											$test = new DateTime("$i-$m-$y");
											$new_date= date_format($test, 'd');
											
											if($i==31)
											{
												?>"<?php echo $new_date;?>"<?php
											}
											else
											{
												?>"<?php echo $new_date;?>",<?php
											}
											
										}
										?>
									],
						
						
						
							datasets: [
							
										{
											label: "My First dataset",
											fillColor: "rgba(255,0,0,0.2)",
											strokeColor: "rgba(255,0,0,1)",
											pointColor: "rgba(255,0,0,1)",
											data: [
													<?php 
																		$m=date("m",strtotime("-1 month"));
																		$y=date('Y');
																		
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'Y-m-d');
																			
																			$query="SELECT sum(total_qty_weight) as qty FROM `rope_mc_production` WHERE `entry_date`='$new_date' and stage='C'   ";
																			$out=$this->Mymodel->query1($query);
																			if(isset($out[0]['qty']) and $out[0]['qty']>0)
																			{
																				$weight=round($out[0]['qty']);
																			}
																			else
																			{
																				$weight=0;
																			}
																			
																			
																			//---geting scrap
																			$query2="SELECT (sum(qty_a)+sum(qty_b)+sum(qty_c)) as qty FROM `daily_scrap` WHERE `entry_date`='$new_date' and section='7'  ";
																			$out2=$this->Mymodel->query1($query2);
																			if(isset($out2[0]['qty']) and $out2[0]['qty']>0)
																			{
																				$scrap_weight=round($out2[0]['qty']);
																			}
																			else
																			{
																				$scrap_weight=0;
																			}
																			
																			if($weight>0 and $scrap_weight>0)
																			{
																				$scrap_per=round($scrap_weight*100);
																				$scrap_per=round($scrap_per/$weight);
																			}
																			else
																			{
																				$scrap_per=0;
																			}
																			
																			
																			if($i==31)
																			{
																				?>"<?php echo $scrap_per;?>"<?php
																			}
																			else
																			{
																				?>"<?php echo $scrap_per;?>",<?php
																			}
																			
																			
																		}
																		?>	
												]
										}
							
							
										
								
								
							]
							
							
						};
						var chart9 = new Chart(ctx9).Line(data9, {
							scaleShowGridLines : true,
							scaleGridLineColor : "rgba(0,0,0,.05)",
							scaleGridLineWidth : 1,
							scaleShowHorizontalLines: true,
							scaleShowVerticalLines: true,
							bezierCurve : true,
							bezierCurveTension : 0.4,
							pointDot : true,
							pointDotRadius : 4,
							pointDotStrokeWidth : 1,
							pointHitDetectionRadius : 20,
							datasetStroke : true,
							datasetStrokeWidth : 2,
							datasetFill : true,
							responsive: true
						});
					
					
						
						
						</script>
		<?php
	}//function close








	//row 3
	function total_pro_scrap_thismonth_graph($div_length,$div_background_color,$height,$width)
	{
		
		?>
						
						
								<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Total Production & Total Scrap in % of This Month
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart10" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						
								
						
						<script>
						var ctx10 = document.getElementById("chart10").getContext("2d");
						var data10 = {
							labels: [ 
										<?php 
										$m=date('m');
										$y=date('Y');
										for($i=1;$i<=31;$i++)
										{
											//creating date
											$test = new DateTime("$i-$m-$y");
											$new_date= date_format($test, 'd');
											
											if($i==31)
											{
												?>"<?php echo $new_date;?>"<?php
											}
											else
											{
												?>"<?php echo $new_date;?>",<?php
											}
											
										}
										?>
									],
						
						
						
							datasets: [
							
										
							
										{
											label: "My Second dataset",
											fillColor: "rgba(18,175,203,0.2)",
											strokeColor: "rgba(18,175,203,1)",
											pointColor: "rgba(18,175,203,1)",
											data: [
													<?php 
																		$m=date('m');
																		$y=date('Y');
																		
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'Y-m-d');
																			
																			$query="SELECT sum(total_qty_weight) as qty FROM `rope_mc_production` WHERE `entry_date`='$new_date' and stage='C'   ";
																			$out=$this->Mymodel->query1($query);
																			if(isset($out[0]['qty']) and $out[0]['qty']>0)
																			{
																				$weight=round($out[0]['qty']);
																			}
																			else
																			{
																				$weight=0;
																			}
																			
																			
																			//---geting scrap
																			$query2="SELECT (sum(qty_a)+sum(qty_b)+sum(qty_c)) as qty FROM `daily_scrap` WHERE `entry_date`='$new_date' and section='7'  ";
																			$out2=$this->Mymodel->query1($query2);
																			if(isset($out2[0]['qty']) and $out2[0]['qty']>0)
																			{
																				$scrap_weight=round($out2[0]['qty']);
																			}
																			else
																			{
																				$scrap_weight=0;
																			}
																			
																			if($weight>0 and $scrap_weight>0)
																			{
																				$scrap_per=round($scrap_weight*100);
																				$scrap_per=round($scrap_per/$weight);
																			}
																			else
																			{
																				$scrap_per=0;
																			}
																			
																			
																			if($i==31)
																			{
																				?>"<?php echo $scrap_per;?>"<?php
																			}
																			else
																			{
																				?>"<?php echo $scrap_per;?>",<?php
																			}
																			
																			
																		}
																		?>				 	  
												]
										}
							
								
								
							]
							
							
						};
							var chart10 = new Chart(ctx10).Line(data10, {
							scaleShowGridLines : true,
							scaleGridLineColor : "rgba(0,0,0,.05)",
							scaleGridLineWidth : 1,
							scaleShowHorizontalLines: true,
							scaleShowVerticalLines: true,
							bezierCurve : true,
							bezierCurveTension : 0.4,
							pointDot : true,
							pointDotRadius : 4,
							pointDotStrokeWidth : 1,
							pointHitDetectionRadius : 20,
							datasetStroke : true,
							datasetStrokeWidth : 2,
							datasetFill : true,
							responsive: true
						});
					
					
						
						
						</script>
		<?php
	}//function close



	//-------------------------------------------------4
	function customer_comp_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT 
					comp_id	
					FROM customer_comp as A 
					WHERE   recp_date between '$from_date' and '$to_date'
				";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Customer Complain This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close




	//-------------------------------------------------5
	function customer_comp_this_year_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-01-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT 
					comp_id	
					FROM customer_comp as A 
					WHERE   recp_date between '$from_date' and '$to_date'
				";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Customer Complain This Year</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------6
	function customer_enq_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT 
					id	
					FROM customer_enq as A 
					WHERE   recp_date between '$from_date' and '$to_date'
				";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Customer Enquires This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	

	//-------------------------------------------------6
	function customer_enq_this_year_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-01-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT 
					id	
					FROM customer_enq as A 
					WHERE   recp_date between '$from_date' and '$to_date'
				";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Customer Enquires This Year</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                        <!--
											<div class="progress progress-xs progress-squared bs-n">
											
												<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
												</div>
											</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close























	//-----------------------------------------------------------------------------------------Wet block
	//-------------------------------------------------row 1
	function wetblock_pro_daily_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
        //total production
        $query="SELECT sum(qty) as qty FROM wet_mc_production where entry_date between '$firstday' and '$lastday2' ";
		$wet_pro_total=$this->Mymodel->query1($query);
		
		// scrap
		$query="SELECT (sum(qty_a)+sum(qty_b)+sum(qty_c)) as qty FROM daily_scrap where  section='1'  and entry_date between '$firstday' and '$lastday2' GROUP BY daily_scrap_id";
		$wet_pro1_scrap=$this->Mymodel->query1($query);

        for($i=01;$i<=$lastday;$i++)
		 {
			$day=date("Y-$m-$i");
			$day_list1[]=$day;
			
			$query="SELECT sum(qty) as qty FROM wet_mc_production where entry_date='$day' ";
			$out=$this->Mymodel->query1($query);
			
			if(!empty($out))
			{ 
				$sum=round($out[0]['qty']);
			}
			else
			{
				$sum=0;
			}
			$wet_pro[]=array("$day"=>"$sum");
		 }
		 
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    Daily Wet Block Production (Kg.) 
                                                </h3>
                                                <h3 class="panel-title">
                                                    <span style="margin-left:50px;"></span>
                                                    Total Production <span style="color:red;"><?php if(isset($wet_pro_total[0]['qty']))echo round($wet_pro_total[0]['qty']);?></span> Kg.
                                                </h3>

                                                <h3 class="panel-title">
                                                    <span style="margin-left:50px;"></span>
                                                    Total Scrap <span style="color:red;"><?php if(isset($wet_pro1_scrap[0]['qty']))echo round($wet_pro1_scrap[0]['qty']);?></span> Kg.
                                                </h3>

                                                <h3 class="panel-title">
                                                    <span style="margin-left:50px;"></span>
                                                    Per <span style="color:red;">
                                                    <?php 
                                                            if(isset($wet_pro_total[0]['qty']) and isset($wet_pro1_scrap[0]['qty']))
                                                            {
                                                                echo round(($wet_pro1_scrap[0]['qty']*100)/$wet_pro_total[0]['qty'],2).' %';
                                                            }
                                                    ?>
                                                    </span>
                                                </h3>
                                                
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart11" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                        var ctx11 = document.getElementById("chart11").getContext("2d");
						var data11 = {
							labels: [
										<?php
										foreach($wet_pro as $a)
										{
											echo '"';
											foreach($a as $key => $value)
											{
												echo $key;
											}
											echo '",';
										}
										?> 
									],
							datasets: [
								
								{
									label: "Wet block Data",
								fillColor: "rgba(34,200,35,0.5)",
									strokeColor: "rgba(34,186,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php
											foreach($wet_pro as $a)
											{
												
												foreach($a as $key => $value)
												{
													echo $value;
												}
												echo ',';
											}
											?> 
										]
								}
							]
						};
						
						var myBar = new Chart(ctx11).Bar(data11, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});

                    
                        
                        
                        </script>
        <?php
	}//function close
	
	//-------------------------------------------------2
	function wetblock_pro_size_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
        //size list
		$query="SELECT out_product_size FROM wet_mc_production where entry_date between '$firstday' and '$lastday2' GROUP BY out_product_size ORDER BY out_product_size";
		$wet_pro_total_size_list=$this->Mymodel->query1($query);
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
														Size Wise 
													</h3>
												
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart12" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                       var ctx12 = document.getElementById("chart12").getContext("2d");
						var data12 = {
							labels: [
										<?php 
										foreach($wet_pro_total_size_list as $a)
											{
												echo '"';
												foreach($a as $key => $value)
												{
													echo $value;
												}
												echo '",';
											}
										?>
									],
							datasets: [
								
								{
									label: "Wet block Data",
									fillColor: "rgba(34,30,160,0.5)",
									strokeColor: "rgba(34,186,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php 
											//*
											foreach($wet_pro_total_size_list as $a)
												{
													
													foreach($a as $key => $value)
													{
														//echo $value;
														$query="SELECT sum(qty) as qty FROM wet_mc_production where  out_product_size='$value' and entry_date between '$firstday' and '$lastday2' ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
													}
													echo ',';
												}
												//*/
											?>
										]
								}
							]
						};
						
						var myBar = new Chart(ctx12).Bar(data12, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});
						
	
                        
                        </script>
        <?php
	}//function close
	



	//-------------------------------------------------3
	function wetblock_pro_shift_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
        //shift A
		$query="SELECT sum(qty) as qty FROM wet_mc_production where  shift='A' and  entry_date between '$firstday' and '$lastday2'  ";
		$wet_pro_total_a=$this->Mymodel->query1($query);
		
		//shift B
		$query="SELECT sum(qty) as qty FROM wet_mc_production where  shift='B' and  entry_date between '$firstday' and '$lastday2' ";
		$wet_pro_total_b=$this->Mymodel->query1($query);


        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Shift Wise  
													<span style=" margin-left:30px; color:#FD7A7A;">Shift A</span> 
													<span style=" margin-left:30px; color:#36E7C8">Shift B</span>
												</h3>
												
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart13" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx13 = document.getElementById("chart13").getContext("2d");
							var data13 = [
								{
									value: <?php if(isset($wet_pro_total_b[0]['qty'])){echo round($wet_pro_total_b[0]['qty']);}else{echo 0;}?>,
									color: "#22BAA0",
									highlight: "#36E7C8",
									label: "Shift B"
								},
								{
									value: <?php if(isset($wet_pro_total_a[0]['qty'])){echo round($wet_pro_total_a[0]['qty']);}else{echo 0;}?>,
									color:"#F25656",
									highlight: "#FD7A7A",
									label: "Shift A"
								}
								
								
							];

							var myPieChart = new Chart(ctx13).Pie(data13,{
								segmentShowStroke : true,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
	
                        
                        </script>
        <?php
	}//function close
	


	//-------------------------------------------------4
	function wetblock_pro_grade_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
        //grade SS
		$query="SELECT sum(qty) as qty FROM wet_mc_production where  grade='SS 304' and  entry_date between '$firstday' and '$lastday2' ";
		$wet_pro_total_ss=$this->Mymodel->query1($query);

		//grade GI
		$query="SELECT sum(qty) as qty FROM wet_mc_production where  grade='SWRH62A' and  entry_date between '$firstday' and '$lastday2' ";
		$wet_pro_total_gi=$this->Mymodel->query1($query);



        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Shift Wise  
													<span style=" margin-left:30px; color:#FD7A7A;">Shift A</span> 
													<span style=" margin-left:30px; color:#36E7C8">Shift B</span>
												</h3>
												
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart14" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
					    var ctx14 = document.getElementById("chart14").getContext("2d");
						var data14 = [
							{
								value: <?php if(isset($wet_pro_total_gi[0]['qty'])){echo round($wet_pro_total_gi[0]['qty']);}else{echo 0;}?>,
							color: "#F2CA4C",
								highlight: "#FBDB6E",
								label: "G.I"
							},
							{
								value: <?php if(isset($wet_pro_total_ss[0]['qty'])){echo round($wet_pro_total_ss[0]['qty']);}else{echo 0;}?>,
								color: "#9F9",
								highlight: "#9F9",
								label: "S.S"
							}
							
							
						];

						var myPieChart = new Chart(ctx14).Pie(data14,{
							segmentShowStroke : true,
							segmentStrokeColor : "#fff",
							segmentStrokeWidth : 2,
							animationSteps : 100,
							animationEasing : "easeOutBounce",
							animateRotate : true,
							animateScale : false,
							
							responsive: true
						});
							
	
                        
                        </script>
        <?php
	}//function close
	



	//-------------------------------------------------5
	function wetblock_pro_lot_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
        //lotno list
		$query="SELECT out_product_lotno FROM wet_mc_production where entry_date between '$firstday' and '$lastday2' GROUP BY out_product_lotno ORDER BY out_product_lotno";
		$wet_pro_total_lotno_list=$this->Mymodel->query1($query);


        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Lotno Wise  
												</h3>
												
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart15" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
					  var ctx15= document.getElementById("chart15").getContext("2d");
						var data15 = {
							labels: [
										<?php 
										foreach($wet_pro_total_lotno_list as $a)
											{
												echo '"';
												foreach($a as $key => $value)
												{
													echo $value;
												}
												echo '",';
											}
										?>
									],
							datasets: [
								
								{
									label: "Wet block Data",
									fillColor: "rgba(200,30,160,0.5)",
									strokeColor: "rgba(160,80,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php 
											//*
											foreach($wet_pro_total_lotno_list as $a)
												{
													
													foreach($a as $key => $value)
													{
														//echo $value;
														$query="SELECT sum(qty) as qty FROM wet_mc_production where  out_product_lotno='$value' and entry_date between '$firstday' and '$lastday2' ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
													}
													echo ',';
												}
												//*/
											?>
										]
								}
							]
						};
						
						var myBar = new Chart(ctx15).Bar(data15, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});
						
	
                        
                        </script>
        <?php
	}//function close
	



	//-------------------------------------------------5
	function wetblock_pro_mac_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
        $result['lastday']=$lastday;
        
        
       //mc list
		$query="SELECT mc_id FROM wet_mc_production where entry_date between '$firstday' and '$lastday2' GROUP BY mc_id ORDER BY mc_id";
		$wet_pro_total_mc_list=$this->Mymodel->query1($query);
		


        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Machine Wise  
												</h3>
												
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart16" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
					  var ctx16= document.getElementById("chart16").getContext("2d");
						var data16 = {
							labels: [
										<?php 
										foreach($wet_pro_total_mc_list as $a)
											{
												echo '"';
												foreach($a as $key => $value)
												{
													//echo $value;
													//echo $value;
														$query="SELECT name,type FROM wet_mc where  wet_mc_id='$value'  ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo $out[0]['type'].'-'.$out[0]['name'];}else{echo '';}
												}
												echo '",';
											}
										?>
									],
							datasets: [
								
								{
									label: "Wet block Data",
									fillColor: "rgba(150,200,10,0.5)",
									strokeColor: "rgba(160,80,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php 
											//*
											foreach($wet_pro_total_mc_list as $a)
												{
													
													foreach($a as $key => $value)
													{
														//echo $value;
														$query="SELECT sum(qty) as qty FROM wet_mc_production where  mc_id='$value' and entry_date between '$firstday' and '$lastday2' ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
													}
													echo ',';
												}
												//*/
											?>
										]
								}
							]
						};
						
						var myBar = new Chart(ctx16).Bar(data16, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});
											
						
                        
                        </script>
        <?php
	}//function close
	














	//-----------------------------------------------------------------------------------------Spooling
	//-------------------------------------------------1
	function spooling_pro_daily_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		for($i=01;$i<=$lastday;$i++)
		 {
			$day=date("Y-$m-$i");
			$day_list1[]=$day;
			
			$query="SELECT sum(qty) as qty FROM wet_mc_production where entry_date='$day' ";
			$out=$this->Mymodel->query1($query);
			
			if(!empty($out))
			{ 
				$sum=round($out[0]['qty']);
			}
			else
			{
				$sum=0;
			}
			$wet_pro[]=array("$day"=>"$sum");
		 }
        
        //total production
		$query="SELECT sum(qty_kg) as qty FROM spooling where entry_date between '$firstday' and '$lastday2' ";
		$sp_pro_total=$this->Mymodel->query1($query);
		
		// scrap
		$query="SELECT (sum(qty_a)+sum(qty_b)+sum(qty_c)) as qty FROM daily_scrap where  section='2' and entry_date between '$firstday' and '$lastday2' ";
		$sp_pro1_scrap=$this->Mymodel->query1($query);

        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
                                                	<h3 class="panel-title">
														Daily Spooling Production (Kg)
													</h3>
												
													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Total Production <span style="color:red;"><?php if(isset($sp_pro_total[0]['qty']))echo round($sp_pro_total[0]['qty']);?></span> Kg.
													</h3>

													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Total Scrap <span style="color:red;"><?php if(isset($sp_pro1_scrap[0]['qty']))echo round($sp_pro1_scrap[0]['qty']);?></span> Kg.
													</h3>
													
													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Per <span style="color:red;">
														<?php 
																if(isset($sp_pro_total[0]['qty']) and isset($sp_pro1_scrap[0]['qty']))
																{
																	echo round(($sp_pro1_scrap[0]['qty']*100)/$sp_pro_total[0]['qty'],2).' %';
																}
														?>
														</span>
													</h3>
                                                
                                                </div>
                                                <div class="panel-body">
                                                    <div>
                                                        <canvas id="chart17" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>

							var ctx17 = document.getElementById("chart17").getContext("2d");
								var data17 = {
									labels: [
												<?php
												foreach($wet_pro as $a)
												{
													echo '"';
													foreach($a as $key => $value)
													{
														echo $key;
													}
													echo '",';
												}
												?> 
											],
									datasets: [
										
										{
											label: "Wet block Data",
										fillColor: "rgba(34,200,35,0.5)",
											strokeColor: "rgba(34,186,160,0.8)",
											highlightFill: "rgba(34,186,160,0.75)",
											highlightStroke: "rgba(34,186,160,1)",
											data: [
													<?php
													foreach($wet_pro as $a)
													{
														
														foreach($a as $key => $value)
														{
															$query="SELECT sum(qty_kg) as qty FROM spooling where  entry_date='$key' ";
																$out=$this->Mymodel->query1($query);
																if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
														}
														echo ',';
													}
													?> 
												]
										}
									]
								};
								
								var myBar = new Chart(ctx17).Bar(data17, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});

                        
                        </script>
        <?php
	}//function close



	//-------------------------------------------------2
	function spooling_pro_size_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		//size list
		$query="SELECT size FROM spooling where entry_date between '$firstday' and '$lastday2' GROUP BY size ORDER BY size";
		$sp_pro_total_size_list=$this->Mymodel->query1($query);

        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
                                                	<h3 class="panel-title">
														Size Wise 
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart18" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
						var ctx18 = document.getElementById("chart18").getContext("2d");
						var data18 = {
							labels: [
										<?php 
										foreach($sp_pro_total_size_list as $a)
											{
												echo '"';
												foreach($a as $key => $value)
												{
													echo $value;
												}
												echo '",';
											}
										?>
									],
							datasets: [
								
								{
									label: "spooling Data",
									fillColor: "rgba(34,30,160,0.5)",
									strokeColor: "rgba(34,186,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php 
											//*
											foreach($sp_pro_total_size_list as $a)
												{
													
													foreach($a as $key => $value)
													{
														//echo $value;
														$query="SELECT sum(qty_kg) as qty FROM spooling where  size='$value' and entry_date between '$firstday' and '$lastday2' ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
													}
													echo ',';
												}
												//*/
											?>
										]
								}
							]
						};
						
						var myBar = new Chart(ctx18).Bar(data18, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});
						
						
							

                        
                        </script>
        <?php
	}//function close



	//-------------------------------------------------3
	function spooling_pro_mac_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		//mc list
		$query="SELECT mc_no FROM spooling where entry_date between '$firstday' and '$lastday2' GROUP BY mc_no ORDER BY mc_no ";
		$sp_pro_total_mc_list=$this->Mymodel->query1($query);

        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
                                                	<h3 class="panel-title">
														Machine Wise 
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart19" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
						
						var ctx19= document.getElementById("chart19").getContext("2d");
						var data19 = {
							labels: [
										<?php 
										foreach($sp_pro_total_mc_list as $a)
											{
												echo '"';
												foreach($a as $key => $value)
												{
													echo $value;
														
												}
												echo '",';
											}
										?>
									],
							datasets: [
								
								{
									label: "Wet block Data",
									fillColor: "rgba(150,200,10,0.5)",
									strokeColor: "rgba(160,80,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php 
											//*
											foreach($sp_pro_total_mc_list as $a)
												{
													
													foreach($a as $key => $value)
													{
														//echo $value;
														$query="SELECT sum(qty_kg) as qty FROM spooling where  mc_no='$value' and entry_date between '$firstday' and '$lastday2' ";
														$out=$this->Mymodel->query1($query);
														if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
													}
													echo ',';
												}
												//*/
											?>
										]
								}
							]
						};
						
						var myBar = new Chart(ctx19).Bar(data19, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});


							

                        
                        </script>
        <?php
	}//function close




	//-------------------------------------------------4
	function spooling_pro_shift_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
        $m=date('m');
        $firstday = date("Y-$m-01");
        $lastday2 = date("Y-$m-$lastday");
        
        $result['firstday']=$firstday;
        $result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		//shift A
		$query="SELECT sum(qty_kg) as qty FROM spooling where  shift1='A' and  entry_date between '$firstday' and '$lastday2'  ";
		$sp_pro_total_a=$this->Mymodel->query1($query);
		
		//shift B
		$query="SELECT sum(qty_kg) as qty FROM spooling where  shift1='B' and  entry_date between '$firstday' and '$lastday2' ";
		$sp_pro_total_b=$this->Mymodel->query1($query);


        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
														Shift Wise  
														<span style=" margin-left:30px; color:#FD7A7A;">Shift A</span> 
														<span style=" margin-left:30px; color:#36E7C8">Shift B</span>
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart20" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
						var ctx20 = document.getElementById("chart20").getContext("2d");
						var data20 = [
							{
								value: <?php if(isset($sp_pro_total_b[0]['qty'])){echo round($sp_pro_total_b[0]['qty']);}else{echo 0;}?>,
								color: "#22BAA0",
								highlight: "#36E7C8",
								label: "Shift B"
							},
							{
								value: <?php if(isset($sp_pro_total_a[0]['qty'])){echo round($sp_pro_total_a[0]['qty']);}else{echo 0;}?>,
								color:"#F25656",
								highlight: "#FD7A7A",
								label: "Shift A"
							}
							
							
						];

						var myPieChart = new Chart(ctx20).Pie(data20,{
							segmentShowStroke : true,
							segmentStrokeColor : "#fff",
							segmentStrokeWidth : 2,
							animationSteps : 100,
							animationEasing : "easeOutBounce",
							animateRotate : true,
							animateScale : false,
							
							responsive: true
						});
	

						
							

                        
                        </script>
        <?php
	}//function close





	//-----------------------------------------------------------------------------------------Spooling
	//-------------------------------------------------1
	function rope_c_pro_daily_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		//total production
		$query="SELECT sum(total_qty_weight) as qty FROM rope_mc_production where  stage='C' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_total_kg_c=$this->Mymodel->query1($query);

		//total production
		$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_total_mtr_c=$this->Mymodel->query1($query);

		
		$query="SELECT (sum(qty_a)+sum(qty_b)+sum(qty_c)) as qty FROM daily_scrap where section='6' and entry_date between '$firstday' and '$lastday2'  ";
		$rope_pro_scrap_c=$this->Mymodel->query1($query);
		
		
		
		 for($i=01;$i<=$lastday;$i++)
		 {
			$day=date("Y-$m-$i");
			$day_list1[]=$day;
			
			$query=" SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where  stage='C' and entry_date = '$day' ";
			$out=$this->Mymodel->query1($query);
			
			if(!empty($out))
			{ 
				$sum=round($out[0]['qty']);
			}
			else
			{
				$sum=0;
			}
			$rope_pro_c[]=array("$day"=>"$sum");
		 }

        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
														Rope Stage <span style="color:red;">C</span> Production 
													</h3>
													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Total Production <span style="color:red;"><?php if(isset($rope_pro_total_mtr_c[0]['qty'])){echo round($rope_pro_total_mtr_c[0]['qty']).' Mtr. '.round($rope_pro_total_kg_c[0]['qty']).' Kg.';}?></span>
													</h3>

													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Total Scrap <span style="color:red;"><?php if(isset($rope_pro_scrap_c[0]['qty']))echo round($rope_pro_scrap_c[0]['qty']);?></span> Kg.
													</h3>

													<h3 class="panel-title">
														<span style="margin-left:50px;"></span>
														Per <span style="color:red;">
														<?php 
																if(isset($rope_pro_total_kg_c[0]['qty']) and isset($rope_pro_scrap_c[0]['qty']))
																{
																	echo round(($rope_pro_scrap_c[0]['qty']*100)/$rope_pro_total_kg_c[0]['qty'],2).' %';
																}
														?>
														</span>
													</h3>
                                                </div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart21" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
						var ctx21 = document.getElementById("chart21").getContext("2d");
						var data21 = {
							labels: [
										<?php
										foreach($rope_pro_c as $a)
										{
											echo '"';
											foreach($a as $key => $value)
											{
												echo $key;
											}
											echo '",';
										}
										?> 
									],
							datasets: [
								
								{
									label: "Wet block Data",
								fillColor: "rgba(34,200,35,0.5)",
									strokeColor: "rgba(34,186,160,0.8)",
									highlightFill: "rgba(34,186,160,0.75)",
									highlightStroke: "rgba(34,186,160,1)",
									data: [
											<?php
											foreach($rope_pro_c as $a)
											{
												
												foreach($a as $key => $value)
												{
													echo $value;
												}
												echo ',';
											}
											?> 
										]
								}
							]
						};
						
						var myBar = new Chart(ctx21).Bar(data21, {
							showTooltips: false,
							onAnimationComplete: function () {
						
								var ctx = this.chart.ctx;
								ctx.font = this.scale.font;
								ctx.fillStyle = this.scale.textColor
								ctx.textAlign = "center";
								ctx.textBaseline = "bottom";
						
								this.datasets.forEach(function (dataset) {
									dataset.bars.forEach(function (bar) {
										ctx.fillText(bar.value, bar.x, bar.y - 5);
									});
								})
							}
						});
												

                        
                        </script>
        <?php
	}//function close






	//-------------------------------------------------2
	function rope_c_product_daily_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		//size list
		$query="SELECT outward FROM rope_mc_production where stage='C' and entry_date between '$firstday' and '$lastday2' GROUP BY outward ORDER BY outward";
		$rope_pro_product_list_c=$this->Mymodel->query1($query);
		
		
        
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
													Product Wise 
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart22" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
							var ctx22 = document.getElementById("chart22").getContext("2d");
							var data22 = {
								labels: [
											<?php 
											foreach($rope_pro_product_list_c as $a)
												{
													echo '"';
													foreach($a as $key => $value)
													{
															$query=" SELECT * FROM product where product_id='$value' ";
															$out=$this->Mymodel->query1($query);
															if(!empty($out)){echo $out[0]['name'];}else{echo '';}
													}
													echo '",';
												}
											?>
										],
								datasets: [
									
									{
										label: "Wet block Data",
										fillColor: "rgba(34,30,160,0.5)",
										strokeColor: "rgba(34,186,160,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
												<?php 
												//*
												foreach($rope_pro_product_list_c as $a)
													{
														
														foreach($a as $key => $value)
														{
															//echo $value;
															$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and outward='$value' and entry_date between '$firstday' and '$lastday2'  ";
															$out=$this->Mymodel->query1($query);
															if(!empty($out)){echo round($out[0]['qty']);}else{echo 0;}
														}
														echo ',';
													}
													//*/
												?>
											]
									}
								]
							};
							
							var myBar = new Chart(ctx22).Bar(data22, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});					

                        
                        </script>
        <?php
	}//function close




	//-------------------------------------------------3
	function rope_c_pro_shift_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		// Shift A total production
		$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and shift='A' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_shift_a_mtr_c=$this->Mymodel->query1($query);

		// Shift B total production
		$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and shift='B' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_shift_b_mtr_c=$this->Mymodel->query1($query);

		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
														Shift Wise  
														<span style=" margin-left:30px; color:#FD7A7A;">Shift A</span> 
														<span style=" margin-left:30px; color:#36E7C8">Shift B</span>
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart23" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
							var ctx23 = document.getElementById("chart23").getContext("2d");
							var data23 = [
								{
									value: <?php if(isset($rope_pro_shift_b_mtr_c[0]['qty'])){echo round($rope_pro_shift_b_mtr_c[0]['qty']);}else{echo 0;}?>,
									color: "#22BAA0",
									highlight: "#36E7C8",
									label: "Shift B"
								},
								{
									value: <?php if(isset($rope_pro_shift_a_mtr_c[0]['qty'])){echo round($rope_pro_shift_a_mtr_c[0]['qty']);}else{echo 0;}?>,
									color:"#F25656",
									highlight: "#FD7A7A",
									label: "Shift A"
								}
							];

							var myPieChart = new Chart(ctx23).Pie(data23,{
								segmentShowStroke : true,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								responsive: true
							});		
						</script>
        <?php
	}//function close



	//-------------------------------------------------4
	function rope_c_pro_grade_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;
		
		// Shift SS total production
		$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and grade='SS 304' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_ss_mtr_c=$this->Mymodel->query1($query);

		// Shift GI total production
		$query="SELECT sum(total_qty_mtr) as qty FROM rope_mc_production where stage='C' and grade='SWRH62A' and entry_date between '$firstday' and '$lastday2' ";
		$rope_pro_gi_mtr_c=$this->Mymodel->query1($query);

		
        
        ?>
                        
						<div class="col-md-<?php echo $div_length;?>">
									<div class="panel panel-<?php echo $div_background_color;?>">
										<div class="panel-heading">
											<h3 class="panel-title">
												Grade Wise
												<span style=" margin-left:30px; color:#9F9;">S.S</span> 
												<span style=" margin-left:30px; color:#FBDB6E">G.I</span>
											</h3>
										</div>
										
										<div class="panel-body">
											<div>
												<canvas id="chart24" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
											</div>
										</div>
									</div>
						</div>
                        
                                
                        
                        <script>
							var ctx24 = document.getElementById("chart24").getContext("2d");
							var data24 = [
								{
									value: <?php if(isset($rope_pro_gi_mtr_c[0]['qty'])){echo round($rope_pro_gi_mtr_c[0]['qty']);}else{echo 0;}?>,
								color: "#F2CA4C",
									highlight: "#FBDB6E",
									label: "G.I"
								},
								{
									value: <?php if(isset($rope_pro_ss_mtr_c[0]['qty'])){echo round($rope_pro_ss_mtr_c[0]['qty']);}else{echo 0;}?>,
									color: "#9F9",
									highlight: "#9F9",
									label: "S.S"
								}
								
								
							];

							var myPieChart = new Chart(ctx24).Pie(data24,{
								segmentShowStroke : true,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								responsive: true
							});

                        
                        </script>
        <?php
	}//function close





	//-----------------------------------------------------------------------------------------Dispatch
	//-------------------------------------------------1
	function dispatch_customer_per_graph($div_length,$div_background_color,$height,$width)
    {
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$firstday_year = "2019-01-01";//test

		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;

		$query="
			SELECT 
			
			A.schedule_id,A.customer_id,
			sum(A.order_qty) as total_qty,
			sum(A.amt) as total_amt,
			sum(A.send_qty) as total_send_qty,
			sum(A.send_amt) as total_send_amt, 
			
			
			B.schedule_save_date,
			C.name as cname
				
			FROM customer_schedule_details as A
			
			LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
			LEFT JOIN customer C ON C.id=B.customer_id
			
			
			WHERE 1=1
		";
		
		$where=" and B.type_of_bill='Tax Invoice' and A.from_date between '$firstday' and '$lastday2' GROUP BY A.customer_id   ORDER by C.name ASC ";
		$query.=" $where";
		$sale_customer=$this->Mymodel->query1($query);
		$c=count($sale_customer);
											
        
        ?>
                        
						<div class="col-md-<?php echo $div_length;?>">
									<div class="panel panel-<?php echo $div_background_color;?>">
										<div class="panel-heading">
											<h3 class="panel-title">
												Customer wise  Percent (%) Dispatch (<span style="color:red;"><?php echo date('M');?></span>)
											</h3>
										</div>
										
										<div class="panel-body">
											<div>
												<canvas id="chart25" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
											</div>
										</div>
									</div>
						</div>
				
                                
                        
                        <script>
							var ctx25 = document.getElementById("chart25").getContext("2d");
							var data25 = {
								labels: [ 
									<?php 
											for($i=0;$i<$c;$i++)
											{									
												$cname = $sale_customer[$i]['cname'];
												if($i<$c-1)
												{
													echo  '"'.$cname.'",';
												}
												else
												{
													echo  '"'.$cname.'"';
												}
											}
										?>
										
										],
								datasets: [
									{
										label: "Purchase",
										fillColor: "#12AFCB",
										highlightFill: "#12AFCB",
										
										data: [
													<?php 
														for($i=0;$i<$c;$i++)
														{									
															$order = $sale_customer[$i]['total_qty'];
															$send = $sale_customer[$i]['total_send_qty'];
															if($send>$order){$per=100;}else{ $per= round(($send*100)/$order); }
															if($i<$c-1)
															{
															echo  '"'.$per.'",';
															}
															else
															{
																echo  '"'.$per.'"';
															}
														}
													?>
											]
									}
								]
							};
							
						var myBar = new Chart(ctx25).Bar(data25, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
        <?php
	}//function close




	//-------------------------------------------------2
	function dispatch_customer_qty_graph($div_length,$div_background_color,$height,$width)
    {
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$firstday_year = "2019-01-01";//test

		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;

		
		$query="
			SELECT 
			
			A.schedule_id,A.customer_id,
			sum(A.order_qty) as total_qty,
			sum(A.amt) as total_amt,
			sum(A.send_qty) as total_send_qty,
			sum(A.send_amt) as total_send_amt, 
			
			
			B.schedule_save_date,
			C.name as cname
				
			FROM customer_schedule_details as A
			
			LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
			LEFT JOIN customer C ON C.id=B.customer_id
			
			
			WHERE 1=1
		";
		
		$where=" and B.type_of_bill='Tax Invoice' and A.from_date between '$firstday' and '$lastday2' GROUP BY A.customer_id   ORDER by C.name ASC ";
		$query.=" $where";
		$sale_customer=$this->Mymodel->query1($query);
		$c=count($sale_customer);
											
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
													Customer wise  Schedule VS Supply (<span style="color:red;"><?php echo date('M');?></span>) in Qty
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart26" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
							
							var ctx26 = document.getElementById("chart26").getContext("2d");
								var data26 = {
									labels: [ 
										<?php 
										
												for($i=0;$i<$c;$i++)
												{									
													$cname = $sale_customer[$i]['cname'];
													if($i<$c-1)
													{
														echo  '"'.$cname.'",';
														//echo  '"'.$cname.', ('.$order.', '.$send.') ",';
													}
													else
													{
														echo  '"'.$cname.'"';
													}
												}
											?>
											
											],
									datasets: [
										{
											label: "Purchase",
											fillColor: "#12AFCB",
											highlightFill: "#12AFCB",
											
											data: [
														<?php 
															for($i=0;$i<$c;$i++)
															{									
																$order = $sale_customer[$i]['total_qty'];
																if($i<$c-1)
																{
																	echo  '"'.$order.'",';
																}
																else
																{
																	echo  '"'.$order.'"';
																}
															}
														?>
												]
										},
										{
											label: "Sale",
											fillColor: "rgba(255,0,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
												<?php 
															for($i=0;$i<$c;$i++)
															{									
																$send = $sale_customer[$i]['total_send_qty'];
																if($i<$c-1)
																{
																	echo  '"'.$send.'",';
																}
																else
																{
																	echo  '"'.$send.'"';
																}
															}
														?>
														
											]
										}
									]
								};
								
							var myBar = new Chart(ctx26).Bar(data26, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});
									

                        
                        </script>
        <?php
	}//function close


	//-------------------------------------------------3
	function dispatch_customer_rs_graph($div_length,$div_background_color,$height,$width)
    {
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$last_month_from=date("Y-m-01",strtotime ( "-1 month"));
		$last_month_to=date("Y-m-31",strtotime ( "-1 month"));
		
		$this_month_from=date("Y-m-01");
		$this_month_to=date("Y-m-d");
		$last_month_to_till_date=date("Y-m-d",strtotime("-1 month -1 day"));
		
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$firstday_year = "2019-01-01";//test

		$lastday2 = date("Y-$m-$lastday");
		
		$result['firstday']=$firstday;
		$result['lastday2']=$lastday2;
		$result['lastday']=$lastday;

		
		$query="
			SELECT 
			
			A.schedule_id,A.customer_id,
			sum(A.order_qty) as total_qty,
			sum(A.amt) as total_amt,
			sum(A.send_qty) as total_send_qty,
			sum(A.send_amt) as total_send_amt, 
			
			
			B.schedule_save_date,
			C.name as cname
				
			FROM customer_schedule_details as A
			
			LEFT JOIN customer_schedule as B ON B.schedule_id = A.schedule_id
			LEFT JOIN customer C ON C.id=B.customer_id
			
			
			WHERE 1=1
		";
		
		$where=" and B.type_of_bill='Tax Invoice' and A.from_date between '$firstday' and '$lastday2' GROUP BY A.customer_id   ORDER by C.name ASC ";
		$query.=" $where";
		$sale_customer=$this->Mymodel->query1($query);
		$c=count($sale_customer);
											
        
        ?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>">
                                                <div class="panel-heading">
													<h3 class="panel-title">
													Customer wise  Schedule VS Supply (<span style="color:red;"><?php echo date('M');?></span>) in Rs
													</h3>
												</div>
                                                
												<div class="panel-body">
                                                    <div>
                                                        <canvas id="chart27" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                </div>
                        
                                
                        
                        <script>
							
							
								var ctx27 = document.getElementById("chart27").getContext("2d");
									var data27 = {
										labels: [ 
											<?php 
													for($i=0;$i<$c;$i++)
													{									
														$cname = $sale_customer[$i]['cname'];
														if($i<$c-1)
														{
															echo  '"'.$cname.'",';
														}
														else
														{
															echo  '"'.$cname.'"';
														}
													}
												?>
												
												],
										datasets: [
											{
												label: "Purchase",
												fillColor: "#12AFCB",
												highlightFill: "#12AFCB",
												
												data: [
															<?php 
																for($i=0;$i<$c;$i++)
																{									
																	$total_amt = round($sale_customer[$i]['total_amt']);
																	if($i<$c-1)
																	{
																		echo  '"'.$total_amt.'",';
																	}
																	else
																	{
																		echo  '"'.$total_amt.'"';
																	}
																}
															?>
													]
											},
											{
												label: "Sale",
												fillColor: "rgba(255,0,0,0.5)",
												strokeColor: "rgba(220,220,220,0.8)",
												highlightFill: "rgba(220,220,220,0.75)",
												highlightStroke: "rgba(220,220,220,1)",
												data: [
													<?php 
																for($i=0;$i<$c;$i++)
																{									
																	$total_send_amt = round($sale_customer[$i]['total_send_amt']);
																	if($i<$c-1)
																	{
																		echo  '"'.$total_send_amt.'",';
																	}
																	else
																	{
																		echo  '"'.$total_send_amt.'"';
																	}
																}
															?>
															
												]
											}
										]
									};
									
								var myBar = new Chart(ctx27).Bar(data27, {
										showTooltips: false,
										onAnimationComplete: function () {
									
											var ctx = this.chart.ctx;
											ctx.font = this.scale.font;
											ctx.fillStyle = this.scale.textColor
											ctx.textAlign = "center";
											ctx.textBaseline = "bottom";
									
											this.datasets.forEach(function (dataset) {
												dataset.bars.forEach(function (bar) {
													ctx.fillText(bar.value, bar.x, bar.y - 5);
												});
											})
										}
									});

                        
                        </script>
        <?php
	}//function close









	//-----------------------------------------------------------------------------------------Dispatch
	//-------------------------------------------------1
	function purchase_po_gm_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->po
		$where=" status='Active' and stage='2'   ";
		$res=$this->Mymodel->select_where('po_entry',$where);
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">P.O in G.M Account</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	//-------------------------------------------------2
	function purchase_po_md_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->po
		$where=" status='Active' and stage='11'   ";
		$res=$this->Mymodel->select_where('po_entry',$where);
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">P.O in M.D Account</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	//-------------------------------------------------3
	function purchase_po_sw_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->po
		$where=" status='Active' and stage='4'   ";
		$res=$this->Mymodel->select_where('po_entry',$where);
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">P.O in Supplier Waiting Account</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	//-------------------------------------------------4
	function purchase_po_rj_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->po
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$where=" status='Active' and stage='3' and po_date between '$from_date' and '$to_date'  ";
		$res=$this->Mymodel->select_where('po_entry',$where);
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">P.O in Rejection This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                        <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	//-------------------------------------------------5
	function purchase_invoice_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->invoice
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$where="product_invoice_save_date between '$from_date' and '$to_date'  and status='Active'  ";
		$res=$this->Mymodel->select_where('product_invoice_entry',$where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Invoice Entry This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
											<div class="progress progress-xs progress-squared bs-n">
											
												<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
												</div>
											</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------6
	function purchase_invoice_product_entry_graph($div_length,$div_background_color,$div_color)
	{
		$this->load->model('Invoice_model');
		//same as controler->invoice
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$where = " 1=1  and details_save_date between '$from_date' and '$to_date'  ";
		$res = $this->Invoice_model->product_group_by_rate($where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Invoice (Product) Entry This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------7
	function purchase_invoice_product_qc1_entry_graph($div_length,$div_background_color,$div_color)
	{
		$this->load->model('Invoice_model');
		//same as controler->invoice
		
		$where="qc_check='1'";
		$res = $this->Invoice_model->qc_product_group_by_rate($where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Product In Q.C Dept.</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------8
	function purchase_invoice_product_qc2_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->qc
		
		$query="
					SELECT  A.qc_id
					FROM qc as A 
					LEFT JOIN product_invoice_entry_details B ON A.details_id=B.details_id
					WHERE A.stage='1' GROUP BY qc_id
				";
		$res=$this->Mymodel->query1($query);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Product In Q.C Dept. Head</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------9
	function purchase_rgp_w_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->invoice
		
		$where=" stage='1'  ";
		$res=$this->Mymodel->select_where('rgp',$where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">RGP Waiting For Approval</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
											<div class="progress progress-xs progress-squared bs-n">
											
												<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
												</div>
											</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	//-------------------------------------------------10
	function purchase_rgp_al_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$where = "stage>='2' and stage<'9' and entry_date between '$from_date' and '$to_date'  ";
		$res=$this->Mymodel->select_where('rgp',$where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">RGP Approved This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------11
	function purchase_rgp_sendlist_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT A.`rgp_details_id` FROM rgp_details as A LEFT JOIN rgp B ON A.rgp_id=B.rgp_id 
					WHERE  B.entry_date between '$from_date' and '$to_date' and A.`qunt`> A.`rec_qty`
				";

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Product of RGP In Send List</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
											<div class="progress progress-xs progress-squared bs-n">
											
												<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
												</div>
											</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close




	//-------------------------------------------------12
	function purchase_rgp_reclist_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		 $query="
					SELECT 
					A.product_id
					FROM rgp_rec_his as A
					WHERE A.rec_date between '$from_date' and '$to_date'
				";

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Product of RGP In Received List</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                        <!--
											<div class="progress progress-xs progress-squared bs-n">
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
												</div>
											</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close



	//-------------------------------------------------13
	function purchase_nrgp_w_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->invoice
		
		$where=" stage='1'  ";
		$res=$this->Mymodel->select_where('nrgp',$where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">NRGP Waiting For Approval</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close




	//-------------------------------------------------14
	function purchase_nrgp_al_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$where = "stage>='2' and stage<'9' and entry_date between '$from_date' and '$to_date'  ";
		$res=$this->Mymodel->select_where('nrgp',$where);
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">NRGP Approved This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------15
	function purchase_nrgp_sendlist_entry_graph($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
					SELECT A.`nrgp_details_id` FROM nrgp_details as A LEFT JOIN nrgp B ON A.nrgp_id=B.nrgp_id 
					WHERE  B.entry_date between '$from_date' and '$to_date' 
				";

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Product of NRGP In Send List</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------16
	function purchase_invoice_entry_daily_graph($div_length,$div_background_color,$height,$width)
	{
																		

		?>
					<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Purchase this Month With GST
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart28" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						
								
						
						<script>
						var ctx28 = document.getElementById("chart28").getContext("2d");
						var data28 = {
							labels: [ 
										<?php 
										$m=date('m');
										$y=date('Y');
										for($i=1;$i<=31;$i++)
										{
											//creating date
											$test = new DateTime("$i-$m-$y");
											$new_date= date_format($test, 'd');
											
											if($i==31)
											{
												?>"<?php echo $new_date;?>"<?php
											}
											else
											{
												?>"<?php echo $new_date;?>",<?php
											}
											
										}
										?>
									],
						
						
						
							datasets: [
							
										{
											label: "My Second dataset",
											fillColor: "rgba(18,175,203,0.2)",
											strokeColor: "rgba(18,175,203,1)",
											pointColor: "rgba(18,175,203,1)",
											data: [
													<?php 
																		$m=date('m');
																		$y=date('Y');
																		
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'Y-m-d');
																			
																			$query="SELECT sum(grandtotal) as rs FROM product_invoice_entry where product_invoice_save_date = '$new_date'   ";
																			$purchase_this_month=$this->Mymodel->query1($query);
																			if(isset($purchase_this_month[0]['rs']) and $purchase_this_month[0]['rs']>0)
																			{
																				$rs=round($purchase_this_month[0]['rs']);
																			}
																			else
																			{
																				$rs=0;
																			}
																			
																			if($i==31)
																			{
																				?>"<?php echo $rs;?>"<?php
																			}
																			else
																			{
																				?>"<?php echo $rs;?>",<?php
																			}
																			
																			
																		}
																		?>	
												]
										}
							
							
										
								
								
							]
							
							
						};
						var chart28 = new Chart(ctx28).Line(data28, {
							scaleShowGridLines : true,
							scaleGridLineColor : "rgba(0,0,0,.05)",
							scaleGridLineWidth : 1,
							scaleShowHorizontalLines: true,
							scaleShowVerticalLines: true,
							bezierCurve : true,
							bezierCurveTension : 0.4,
							pointDot : true,
							pointDotRadius : 4,
							pointDotStrokeWidth : 1,
							pointHitDetectionRadius : 20,
							datasetStroke : true,
							datasetStrokeWidth : 2,
							datasetFill : true,
							responsive: true
						});
					
					
						
						
						</script>
		<?php
	}//function close



	//-------------------------------------------------17
	function store_min_stock_rm($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				A.product_stock_id

				FROM product_stock as A 
				LEFT JOIN product as P ON P.product_id = A.product_id
				
				
				WHERE  P.row_mat_puc='1' and P.repeated='1'  and P.economic<=A.recive_stock_level  GROUP by A.product_id  
			";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Stock < Min Level (Raw Material)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close




	//-------------------------------------------------17
	function store_max_stock_rm($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				A.product_stock_id
				
				FROM product_stock as A 
				LEFT JOIN product as P ON P.product_id = A.product_id
				
				
				WHERE  P.row_mat_puc='1' and P.repeated='1'  and A.recive_stock_level>=P.max_level  GROUP by A.product_id  
			";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Stock > Max Level (Raw Material)</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------17
	function store_min_stock_all($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				A.product_stock_id,
				sum(A.recive_stock_level) as stock_qty
				
				FROM product_stock as A 
				LEFT JOIN product as P ON P.product_id = A.product_id
				
				
				WHERE  P.economic<=A.recive_stock_level  GROUP by A.product_id  
			";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Stock < Min Level</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------17
	function store_max_stock_all($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				A.product_stock_id,
				sum(A.recive_stock_level) as stock_qty
				
				FROM product_stock as A 
				LEFT JOIN product as P ON P.product_id = A.product_id
				
				
				WHERE  A.recive_stock_level>=P.max_level  GROUP by A.product_id  
			";
		

		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Stock > Max Level</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close








	//------------------------------------------------qc -wetblcok 
	function quality_wetblock_wire_test_graph($div_length,$div_background_color,$height,$width)
	{
										

		?>
					<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Wet Block Wire Test Report Daily
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart29" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						
								
						
						<script>
						


						var ctx29 = document.getElementById("chart29").getContext("2d");
								var data29 = {
									labels: [ 
														<?php 
															$m=date('m');
															$y=date('Y');
															for($i=1;$i<=31;$i++)
															{
																//creating date
																$test = new DateTime("$i-$m-$y");
																$new_date= date_format($test, 'd');
																
																if($i==31)
																{
																	?>"<?php echo $new_date;?>"<?php
																}
																else
																{
																	?>"<?php echo $new_date;?>",<?php
																}
																
															}
														?>
											],
									datasets: [
										{
											label: "My First dataset",
											fillColor: "rgba(34,186,160,0.5)",
											strokeColor: "rgba(34,186,160,0.8)",
											highlightFill: "rgba(34,186,160,0.75)",
											highlightStroke: "rgba(34,186,160,1)",
											data: [
														<?php 
																$m=date('m');
																$y=date('Y');
																
																for($i=1;$i<=31;$i++)
																{
																	//creating date
																	$test = new DateTime("$i-$m-$y");
																	$new_date= date_format($test, 'Y-m-d');
																	
																	$query="SELECT id FROM qc_daily_wet_testing where entry_date = '$new_date'  and color_row='green'  ";
																	$res=$this->Mymodel->query1($query);
																	$c = count($res);
																	
																	if($i==31)
																	{
																		?>"<?php echo $c;?>"<?php
																	}
																	else
																	{
																		?>"<?php echo $c;?>",<?php
																	}
																}
														?>	
													]
										},
										{
											label: "My First dataset",
											fillColor: "rgba(18,175,203,0.5)",
											strokeColor: "rgba(18,175,203,0.8)",
											highlightFill: "rgba(18,175,203,0.75)",
											highlightStroke: "rgba(18,175,203,1)",
											data: [
														<?php 
																$m=date('m');
																$y=date('Y');
																
																for($i=1;$i<=31;$i++)
																{
																	//creating date
																	$test = new DateTime("$i-$m-$y");
																	$new_date= date_format($test, 'Y-m-d');
																	
																	$query="SELECT id FROM qc_daily_wet_testing where entry_date = '$new_date'  and color_row='blue'  ";
																	$res=$this->Mymodel->query1($query);
																	$c = count($res);
																	
																	if($i==31)
																	{
																		?>"<?php echo $c;?>"<?php
																	}
																	else
																	{
																		?>"<?php echo $c;?>",<?php
																	}
																}
														?>	
													]
										},
										{
											label: "My First dataset",
											fillColor: "rgba(242,86,86,0.5)",
											strokeColor: "rgba(242,86,86,0.8)",
											highlightFill: "rgba(242,86,86,0.75)",
											highlightStroke: "rgba(242,86,86,1)",
											data: [
														<?php 
																$m=date('m');
																$y=date('Y');
																
																for($i=1;$i<=31;$i++)
																{
																	//creating date
																	$test = new DateTime("$i-$m-$y");
																	$new_date= date_format($test, 'Y-m-d');
																	
																	$query="SELECT id FROM qc_daily_wet_testing where entry_date = '$new_date'  and color_row='red'  ";
																	$res=$this->Mymodel->query1($query);
																	$c = count($res);
																	
																	if($i==31)
																	{
																		?>"<?php echo $c;?>"<?php
																	}
																	else
																	{
																		?>"<?php echo $c;?>",<?php
																	}
																}
														?>	
													]
										}
									]
								};
								
							var myBar = new Chart(ctx29).Bar(data29, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});
					
						
						
						</script>
		<?php
	}//function close


	//-------------------------------------------------2
	function total_pro_ss_scrap_deptwise_graph($div_length,$div_background_color,$height,$width)
    {
        
        $from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				sum(A.qty_a) as shift_a_scrap,
				sum(A.qty_b) as shift_b_scrap,
				D.name as dname
				
				FROM daily_scrap as A 
				LEFT JOIN scrap_dept_list as D ON D.id = A.section
				
				WHERE A.type='S.S' and A.section!='7' and  A.entry_date between '$from_date' and '$to_date' GROUP BY A.section
			";
		$res=$this->Mymodel->query1($query);
		foreach($res as $r)
		{
			$total[] = round($r['shift_a_scrap']+$r['shift_b_scrap']);
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Dept. Wise Scrap (S.S), Total <?php echo $grand_total;?> Kg. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['shift_a_scrap']+$r['shift_b_scrap']);
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $r['dname'].', Qty: '.$total.' Kg.';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart30" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx30 = document.getElementById("chart30").getContext("2d");
							var data30 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['shift_a_scrap']+$r['shift_b_scrap']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['dname'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx30).Pie(data30,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close



	//-------------------------------------------------3
	function total_pro_gi_scrap_deptwise_graph($div_length,$div_background_color,$height,$width)
    {
        
        $from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				sum(A.qty_a) as shift_a_scrap,
				sum(A.qty_b) as shift_b_scrap,
				D.name as dname
				
				FROM daily_scrap as A 
				LEFT JOIN scrap_dept_list as D ON D.id = A.section
				
				
				WHERE A.type='G.I' and A.section!='7' and  A.entry_date between '$from_date' and '$to_date' GROUP BY A.section
			";
		$res=$this->Mymodel->query1($query);
		foreach($res as $r)
		{
			$total[] = round($r['shift_a_scrap']+$r['shift_b_scrap']);
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}		
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Dept. Wise Scrap (G.I), Total <?php echo $grand_total;?> Kg. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['shift_a_scrap']+$r['shift_b_scrap']);
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $r['dname'].', Qty: '.$total.' Kg.';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart31" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx31 = document.getElementById("chart31").getContext("2d");
							var data31 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['shift_a_scrap']+$r['shift_b_scrap']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['dname'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx31).Pie(data31,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close


	//-------------------------------------------------4
	function total_pro_ss_scrap_gate_graph($div_length,$div_background_color,$height,$width)
    {
        
        $from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				sum(A.qty_a) as shift_a_scrap,
				sum(A.qty_b) as shift_b_scrap
				
				FROM daily_scrap as A 
				
				WHERE A.type='S.S' and A.section='7' and  A.entry_date between '$from_date' and '$to_date' 
			";
		$res=$this->Mymodel->query1($query);
		$a = round($res[0]['shift_a_scrap']);
		$b = round($res[0]['shift_b_scrap']);
		$grand_total = round($a+$b);
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Scrap Form Main Gate (S.S), Total <?php echo $grand_total;?> Kg. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<li style="color:#80C9E6"> <?php echo 'Shift A'.', Qty: '.$a.' Kg.';?> </li>
															<li style="color:#266AA0"> <?php echo 'Shift B'.', Qty: '.$b.' Kg.';?> </li>
														</ol>
													<div>
														<canvas id="chart32" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx32 = document.getElementById("chart32").getContext("2d");
							var data32 = [
											{
												value: <?php echo $a;?>,
												color: "#80C9E6",
												highlight: "#80C9E6",
												label: "Shift A"
											},
											{
												value: <?php echo $b;?>,
												color: "#266AA0",
												highlight: "#266AA0",
												label: "Shift B"
											}
													
										  ];
								

							var myPieChart = new Chart(ctx32).Pie(data32,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close



	//-------------------------------------------------5
	function total_pro_gi_scrap_gate_graph($div_length,$div_background_color,$height,$width)
    {
        
        $from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				
				sum(A.qty_a) as shift_a_scrap,
				sum(A.qty_b) as shift_b_scrap
				
				FROM daily_scrap as A 
				
				WHERE A.type='G.I' and A.section='7' and  A.entry_date between '$from_date' and '$to_date' 
			";
		$res=$this->Mymodel->query1($query);
		$a = round($res[0]['shift_a_scrap']);
		$b = round($res[0]['shift_b_scrap']);
		$grand_total = round($a+$b);
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>" >
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Scrap Form Main Gate (G.I), Total <?php echo $grand_total;?> Kg. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<li style="color:#80C9E6"> <?php echo 'Shift A'.', Qty: '.$a.' Kg.';?> </li>
															<li style="color:#266AA0"> <?php echo 'Shift B'.', Qty: '.$b.' Kg.';?> </li>
														</ol>
													<div>
														<canvas id="chart33" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx33 = document.getElementById("chart33").getContext("2d");
							var data33 = [
											{
												value: <?php echo $a;?>,
												color: "#80C9E6",
												highlight: "#80C9E6",
												label: "Shift A"
											},
											{
												value: <?php echo $b;?>,
												color: "#266AA0",
												highlight: "#266AA0",
												label: "Shift B"
											}
													
										  ];
								

							var myPieChart = new Chart(ctx33).Pie(data33,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close





	//-------------------------------------------------17
	function maint_pending_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				maint_problem_id
				FROM maint_problem 
				WHERE active='Pending' and  entry_date between '$from_date' and '$to_date'
			";
		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Pending Break Down This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------17
	function maint_up_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				maint_problem_id
				FROM maint_problem 
				WHERE active='Under Process' and  entry_date between '$from_date' and '$to_date'
			";
		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Under Process Break Down This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close



	//-------------------------------------------------17
	function maint_pc_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				maint_problem_id
				FROM maint_problem 
				WHERE active='Process Completed' and  entry_date between '$from_date' and '$to_date'
			";
		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Process Completed Break Down This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close


	//-------------------------------------------------17
	function maint_com_this_month_box($div_length,$div_background_color,$div_color)
	{
		//same as controler->RGP
		
		$from_date = date('Y-m-01');
		$to_date = date('Y-m-d');

		$query="
				SELECT 
				maint_problem_id
				FROM maint_problem 
				WHERE active='Completed' and  entry_date between '$from_date' and '$to_date'
			";
		$res=$this->Mymodel->query1($query);	
		
		$nos = count($res);
		$color2='white';
		?>
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
			                <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                        <p style="color:<?php echo $div_color;?>"><span class="counter"><?php echo $nos?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>">Completed Break Down This Month</span>
                                    </div>
                                    <div class="info-box-icon">
                                         <span  style="float:right; color:<?php echo $color2?>"><i class="fa fa-long-arrow-<?php //echo $arrow2;?>"  style=" color:<?php echo $color2?>"></i><?php //echo $nos;?></span>
                                    </div>
                                    <div class="info-box-progress">
                                         <!--
										<div class="progress progress-xs progress-squared bs-n">
                                           
											<div class="progress-bar progress-bar-primery " role="progressbar" aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $per;?>%">
                                            </div>
										</div>
										-->
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close




	//------------------------------------------------34
	function maint_daily_breakdown_graph($div_length,$div_background_color,$height,$width)
	{
										

		?>
					<div class="col-md-<?php echo $div_length;?>">
						<div class="panel panel-<?php echo $div_background_color;?>">
							<div class="panel-heading">
								<h3 class="panel-title">
									Daily Break Down of this month
								</h3>
							
							</div>
							<div class="panel-body">
								<div>
									<canvas id="chart34" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
								</div>
							</div>
						</div>
					</div>
						
								
						
						<script>
						


						var ctx34 = document.getElementById("chart34").getContext("2d");
								var data34 = {
									labels: [ 
														<?php 
															$m=date('m');
															$y=date('Y');

															for($i=1;$i<=31;$i++)
															{
																//creating date
																$test = new DateTime("$i-$m-$y");
																$new_date= date_format($test, 'd');
																
																if($i==31)
																{
																	?>"<?php echo $new_date;?>"<?php
																}
																else
																{
																	?>"<?php echo $new_date;?>",<?php
																}
																
															}
														?>
											],
									datasets: [
										
										{
											label: "My First dataset",
											fillColor: "rgba(51,122,183,0.5)",
											strokeColor: "rgba(51,122,183,0.8)",
											highlightFill: "rgba(51,122,183,0.75)",
											highlightStroke: "rgba(51,122,183,1)",
											data: [
														<?php 
																$m=date('m');
																$y=date('Y');
																
																for($i=1;$i<=31;$i++)
																{
																	//creating date
																	$test = new DateTime("$i-$m-$y");
																	$new_date= date_format($test, 'Y-m-d');
																	
																	$query="
																				SELECT 
																				maint_problem_id
																				FROM maint_problem 
																				WHERE  entry_date = '$new_date' 
																		";
																	$res=$this->Mymodel->query1($query);	
																	$c = count($res);
																	
																	if($i==31)
																	{
																		?>"<?php echo $c;?>"<?php
																	}
																	else
																	{
																		?>"<?php echo $c;?>",<?php
																	}
																}
														?>	
													]
										}
									]
								};
								
							var myBar = new Chart(ctx34).Bar(data34, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});
					
						
						
						</script>
		<?php
	}//function close






	function maint_get_brek_dwon_query($month,$type)
	{
		$lastday = date('t',strtotime('today'));
		$m=date("$month");
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

		if($type=='All')
		{
			$query=" SELECT maint_problem_id FROM maint_problem WHERE  entry_date between  '$firstday' and '$lastday2' ";
		}
		elseif($type=='Completed')
		{
			$query=" SELECT maint_problem_id FROM maint_problem WHERE active='Completed' and  entry_date between  '$firstday' and '$lastday2' ";
		}
		elseif($type=='!Completed')
		{
			$query=" SELECT maint_problem_id FROM maint_problem WHERE active != 'Completed' and  entry_date between  '$firstday' and '$lastday2' ";
		}
		else
		{
			$query=" SELECT maint_problem_id FROM maint_problem WHERE active='$type'  entry_date between  '$firstday' and '$lastday2' ";
		}
		
		$res=$this->Mymodel->query1($query);
		if(!empty($res))
		{
			return  $c = count($res);
		}
		else
		{
			return  $c = count($res);
		}
		

	}//function close


	//------------------------------------------------35
	function maint_yearly_breakdown_graph($div_length,$div_background_color,$height,$width)
	{
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

		
		
		?>
						
						
								<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
												<h3 class="panel-title">
													Break down Yearly 
												</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart35" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

					
						
						<script>
						
							var ctx35 = document.getElementById("chart35").getContext("2d");
								var data35 = {
									labels: [ 
												"January", 
												"February", 
												"March", 
												"April", 
												"May", 
												"June", 
												"July", 
												"August", 
												"September", 
												"October", 
												"November", 
												"December"  
											],
									datasets: [
										{
											label: "My Second dataset",
											fillColor: "rgba(255,255,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("01",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("02",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("03",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("04",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("05",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("06",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("07",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("08",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("09",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("10",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("11",'All');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("12",'All');?>,
												]
										}
									]
								};
								
							var myBar = new Chart(ctx35).Bar(data35, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});

						
						</script>
		<?php
	}//function close




	//------------------------------------------------36
	function maint_yearly_breakdown_graph2($div_length,$div_background_color,$height,$width)
	{
		?>
						
						
								<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
												<h3 class="panel-title">
												Yearly Break Down Completed VS Not Completed
													
												</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart36" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

					
						
						<script>
						
							var ctx36 = document.getElementById("chart36").getContext("2d");
								var data36 = {
									labels: [ 
												"January", 
												"February", 
												"March", 
												"April", 
												"May", 
												"June", 
												"July", 
												"August", 
												"September", 
												"October", 
												"November", 
												"December"  
											],
									datasets: [
										{
											label: "My First dataset",
											fillColor: "rgba(34,186,160,0.5)",
											strokeColor: "rgba(34,186,160,0.8)",
											highlightFill: "rgba(34,186,160,0.75)",
											highlightStroke: "rgba(34,186,160,1)",
											data: [
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("01",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("02",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("03",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("04",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("05",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("06",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("07",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("08",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("09",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("10",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("11",'Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("12",'Completed');?>,
												]
										},
										{
											label: "My Second dataset",
											fillColor: "rgba(255,0,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("01",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("02",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("03",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("04",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("05",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("06",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("07",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("08",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("09",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("10",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("11",'!Completed');?>,
														<?php echo $this->Dashbord->maint_get_brek_dwon_query("12",'!Completed');?>,
												]
										}
									]
								};
								
							var myBar = new Chart(ctx36).Bar(data36, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});

						
						</script>
		<?php
	}//function close





	//-------------------------------------------------37
	function maint_breakdown_dept_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
				SELECT 
				
				count(A.maint_problem_id) as nos,
				D.name as dname
				
				FROM maint_problem as A 
				LEFT JOIN department as D ON D.department_id = A.dept
				
				WHERE   A.entry_date between '$firstday' and '$lastday2' GROUP BY A.dept
			";
		$res=$this->Mymodel->query1($query);
		
		foreach($res as $r)
		{
			$total[] = round($r['nos']);
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Dept. Wise Total Brekdown, Total <?php echo $grand_total;?> nos.
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['nos']);
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $r['dname'].', Qty: '.$total.' nos';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart37" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx37 = document.getElementById("chart37").getContext("2d");
							var data37 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['nos']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['dname'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx37).Pie(data37,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close




	//-------------------------------------------------38
	function maint_breakdown_dept_min_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");


		$query2="
				SELECT 
				
				A.maint_problem_id,
				A.dept,
				D.name as dname
				
				FROM maint_problem as A 
				LEFT JOIN department as D ON D.department_id = A.dept
				
				WHERE A.active='Completed' and   A.entry_date between '$firstday' and '$lastday2' GROUP BY A.dept
			";
		$res2=$this->Mymodel->query1($query2);
		foreach($res2 as $r2)
		{
			$dept_id = $r2['dept'];
			$dept_name[] = $r2['dname'];
			
			
			$query="
				SELECT 
				
				break_down_date,break_down_time,comp_date,comp_time,
				D.name as dname
				
				FROM maint_problem as A 
				LEFT JOIN department as D ON D.department_id = A.dept
				
				WHERE A.dept='$dept_id' and  A.active='Completed' and   A.entry_date between '$firstday' and '$lastday2' 
			";
			$res=$this->Mymodel->query1($query);
			$total_min=0;
			foreach($res as $r)
			{
				$test = new DateTime($r['break_down_date']);
				$break_down_date= date_format($test, 'd-m-Y');
				
				$test = new DateTime($r['break_down_time']);
				$break_down_time= date_format($test, 'h:i:s a');	
				
				if(!empty($r['comp_date']) and $r['comp_date']!='0000-00-00')
				{
				$test = new DateTime($r['comp_date']);
				$comp_date= date_format($test, 'd-m-Y');
				}else{	$comp_date='';}
				
				if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00')
				{
					$test = new DateTime($r['comp_time']);
					$comp_time= date_format($test, 'h:i:s a');	
					
					$to1="$break_down_date $break_down_time";
					$from1="$comp_date $comp_time";
					
					$to_time = strtotime($to1);
					$from_time = strtotime($from1);
					$vr= round(abs($to_time - $from_time) / 60,2);
				}
				else
				{
					$comp_time='';
					$vr='';
				}
				
				$total_min=$total_min+$vr;
			}//$r
			
			$total[] = $total_min; 

		}//r2

		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		$c = count($res2);
		
		
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Dept. Wise Minutes Taken (<span style="color:pink;">Only Completed</span>), Total <?php echo $grand_total;?> minutes.
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																for($j=0;$j<=$c-1;$j++)
																{
																	$dname = $res2[$j]['dname'];
																	$dept_qty = $total[$j];
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $dname.', '.$dept_qty.' minutes';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart38" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx38 = document.getElementById("chart38").getContext("2d");
							var data38 = [
											<?php
												$i=0;
												for($j=0;$j<=$c-1;$j++)
												{
													$dname = $res2[$j]['dname'];
													$dept_qty = $total[$j];
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $dept_qty;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $dname;?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx38).Pie(data38,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close




	//-------------------------------------------------39
	function maint_thismonth_this_month_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
				SELECT 
				
				count(A.maint_problem_id) as nos,
				A.active,
				D.name as dname
				
				FROM maint_problem as A 
				LEFT JOIN department as D ON D.department_id = A.dept
				
				WHERE   A.entry_date between '$firstday' and '$lastday2' GROUP BY A.active
			";
		$res=$this->Mymodel->query1($query);
		
		foreach($res as $r)
		{
			$total[] = round($r['nos']);
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Total Brekdown this month, Total <?php echo $grand_total;?> nos.
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['nos']);
																	
																	if($r['active']=='Completed'){$rand_color='#22BAA0';}
																	elseif($r['active']=='Process Completed'){$rand_color='#12AFCB';}
																	elseif($r['active']=='Under Process'){$rand_color='#f6d433';}
																	else{$rand_color='#f25656';}
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $r['active'].', Qty: '.$total.' nos';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart39" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx39 = document.getElementById("chart39").getContext("2d");
							var data39 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['nos']);
													if($r['active']=='Completed'){$rand_color='#22BAA0';}
													elseif($r['active']=='Process Completed'){$rand_color='#12AFCB';}
													elseif($r['active']=='Under Process'){$rand_color='#f6d433';}
													else{$rand_color='#f25656';}
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color;?>",
															highlight: "<?php echo $rand_color;?>",
															label: "<?php echo $r['active'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx39).Pie(data39,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close




	//-------------------------------------------------40
	function maint_breakdown_type_graph($div_length,$div_background_color,$height,$width)
    {
        
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
				SELECT 
				
				count(maint_problem_id) as nos
				
				FROM maint_problem WHERE entry_date between '$firstday' and '$lastday2' GROUP BY type2
			";
		$res=$this->Mymodel->query1($query);
		$a = round($res[0]['nos']);
		$b = round($res[1]['nos']);
		$grand_total = round($a+$b);
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													MBD & EBD, Total <?php echo $grand_total;?> nos. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<li style="color:#80C9E6"> <?php echo 'EBD'.', Qty: '.$a.' nos.';?> </li>
															<li style="color:#266AA0"> <?php echo 'MBD'.', Qty: '.$b.' nos.';?> </li>
														</ol>
													<div>
														<canvas id="chart40" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx40 = document.getElementById("chart40").getContext("2d");
							var data40 = [
											{
												value: <?php echo $a;?>,
												color: "#80C9E6",
												highlight: "#80C9E6",
												label: "EBD"
											},
											{
												value: <?php echo $b;?>,
												color: "#266AA0",
												highlight: "#266AA0",
												label: "MBD"
											}
													
										  ];
								

							var myPieChart = new Chart(ctx40).Pie(data40,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close



	//-------------------------------------------------41
	function maint_breakdown_type2_graph($div_length,$div_background_color,$height,$width)
    {
        
		$lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
				SELECT 
				
				count(maint_problem_id) as nos
				
				FROM maint_problem WHERE entry_date between '$firstday' and '$lastday2' GROUP BY type
			";
		$res=$this->Mymodel->query1($query);
		$a = round($res[0]['nos']);
		$b = round($res[1]['nos']);
		$grand_total = round($a+$b);
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
												Critical & Non Critical, Total <?php echo $grand_total;?> nos. 
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<li style="color:#80C9E6"> <?php echo 'Critical'.', Qty: '.$a.' nos.';?> </li>
															<li style="color:#266AA0"> <?php echo 'Non Critical'.', Qty: '.$b.' nos.';?> </li>
														</ol>
													<div>
														<canvas id="chart41" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx41 = document.getElementById("chart41").getContext("2d");
							var data41 = [
											{
												value: <?php echo $a;?>,
												color: "#80C9E6",
												highlight: "#80C9E6",
												label: "Critical"
											},
											{
												value: <?php echo $b;?>,
												color: "#266AA0",
												highlight: "#266AA0",
												label: "Non Critical"
											}
													
										  ];
								

							var myPieChart = new Chart(ctx41).Pie(data41,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close




	//-------------------------------------------------42
	function maint_breakdown_top_time_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
					SELECT 

					A.mc_no,A.problem,
					CONCAT_WS(' ',A.`comp_date`,A.`comp_time`) as date1,
					CONCAT_WS(' ',A.`break_down_date`,A.`break_down_time`) as date2,
					D.name as dname,
					
					TIMEDIFF(CONCAT_WS(' ',A.`comp_date`,A.`comp_time`),CONCAT_WS(' ',A.`break_down_date`,A.`break_down_time`)) as nos
					
					FROM maint_problem as A 
					LEFT JOIN department as D ON D.department_id = A.dept	

					WHERE A.entry_date between '$firstday' and '$lastday2' ORDER BY nos DESC LIMIT 10
			";
		$res=$this->Mymodel->query1($query);

		foreach($res as $r)
		{
			$total[] = round($r['nos']);
			$name =  $r['mc_no'].' '.$r['problem'];
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Top 10 Time Taken Break Down, Total <?php echo $grand_total;?> Hours.
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['nos']);
																	$name =  $r['dname'].', '.$r['mc_no'].', '.$r['problem'];
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $name.', '.$total.' hrs. ';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart42" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx42 = document.getElementById("chart42").getContext("2d");
							var data42 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['nos']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['dname'].', '.$r['mc_no'].', '.$r['problem'].' hrs.';?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx42).Pie(data42,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close




	//-------------------------------------------------43
	function maint_breakdown_attend_person_graph($div_length,$div_background_color,$height,$width)
    {
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");

        
		$query="
					SELECT 

					count(maint_problem_id) as nos,
					attend_by

					FROM maint_problem 
					
					WHERE entry_date between '$firstday' and '$lastday2' GROUP BY attend_by LIMIT 10
			";
		$res=$this->Mymodel->query1($query);

		foreach($res as $r)
		{
			$total[] = round($r['nos']);
		}
		if(!empty($total)){$grand_total = array_sum($total);}else{$grand_total =0;}	
		?>
                        
                                <div class="col-md-<?php echo $div_length;?>">
                                            <div class="panel panel-<?php echo $div_background_color;?>" style="height:550px;">
                                                <div class="panel-heading">
												<h3 class="panel-title">
													Break Down Attend by Person, Total <?php echo $grand_total;?> Nos.
												</h3>
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['nos']);
																	$name =  $r['attend_by'];
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $name.', '.$total.' nos. ';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart43" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx43 = document.getElementById("chart43").getContext("2d");
							var data43 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['nos']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['attend_by'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx43).Pie(data43,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});
							
                        </script>
        <?php
	}//function close










	//----------------------------------------------HR ------------------------------------------------
	function hr_total_employee_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " 1=1 ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Total Employee</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
                                        <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close


	function hr_total_employee_staff_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " staff_tech='Staff' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Total Staff</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close

	function hr_total_employee_tech_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " staff_tech='Tech' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Total Associate</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close

	function hr_total_employee_male_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " gender='Male' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Total Male</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close

	function hr_total_employee_female_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " gender='Female' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">Total Female</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close


	function hr_total_employee_newjoin_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$day1=date("Y-m-01");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " doj between '$day1' and '$today' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">New Joining this Month</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close

	function hr_total_employee_resign_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$day1=date("Y-m-01");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " dor between '$day1' and '$today' ";
		$emp_total=$this->Mymodel->get_all_emp_list($where);
		$emp_total_salary=$this->Mymodel->emp_total_salary($where);
		$avg = round($emp_total_salary/$emp_total);
	
	?>
		
			<div class="col-lg-<?php echo $div_length;?> col-md-6">
                            <div class="panel info-box panel-success" style="background-color:<?php echo $div_background_color;?>; color:<?php echo $div_color;?>;">
                                <div class="panel-body">
                                    <div class="info-box-stats">
                                       <p style="color:<?php echo $div_color;?>;"> <span class="counter"><?php echo $emp_total?></span></p>
                                        <span class="info-box-title" style="color:<?php echo $div_color;?>;">New Resign this Month</span>
                                    </div>
									<div class="info-box-icon">
                                        <i class="icon-users"  style=" color:white"></i>
                                    </div>
                                    <div class="info-box-progress">
                                        <div class="progress progress-xs progress-squared bs-n">
                                            <div class="progress-bar progress-bar-primary " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            </div>
                                        </div>
                                         <br>
										 <span  style="float:left; color:<?php echo $div_color;?>;"> Total CTC : <?php echo $emp_total_salary;?> / Avg : <?php echo $avg;?> </span>
                                    </div>
                               
                                </div>
                            </div>
			</div>
		<?php
	}//function close


	function contract_wise_salary_graph($div_length,$div_background_color,$height,$width,$search_year,$search_month)
    {
		$firstday = date("$search_year-$search_month-01");
		$lastday = date("$search_year-$search_month-t",strtotime($firstday));
		
		$query=" SELECT  company_role_id, sum(total_present) as total_present, sum(total_ot) as total_ot,sum(esic_payable) as esic_payable,sum(epf_payable) as epf_payable,sum(current_total_ctc_payable) as current_total_ctc_payable  FROM daily_attendance_monthly WHERE att_year='$search_year' and att_month='$search_month' GROUP BY company_role_id ORDER BY company_role_id ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-md-<?php echo $width;?>" >
                            <div class="panel panel-white" style="height:<?php echo $height;?>">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Contract Salary Details (Current Month till Date)</h4>
								
									<div style="margin-left:30px;" >
										<select id="contract_salary_details_year">
											<option <?php if(isset($search_year) and $search_year=='2020'){echo "selected";}?>>2020</option>
											<option <?php if(isset($search_year) and $search_year=='2021'){echo "selected";}?>>2021</option>
											<option <?php if(isset($search_year) and $search_year=='2022'){echo "selected";}?>>2022</option>
											<option <?php if(isset($search_year) and $search_year=='2023'){echo "selected";}?>>2023</option>
											<option <?php if(isset($search_year) and $search_year=='2024'){echo "selected";}?>>2024</option>
											<option <?php if(isset($search_year) and $search_year=='2025'){echo "selected";}?>>2025</option>
										</select>

										<select id="contract_salary_details_month">
											<option <?php if(isset($search_month) and $search_month=='01'){echo "selected";}?> value="01">Jan</option>
											<option <?php if(isset($search_month) and $search_month=='02'){echo "selected";}?> value="02">Feb</option>
											<option <?php if(isset($search_month) and $search_month=='03'){echo "selected";}?> value="03">Mar</option>
											<option <?php if(isset($search_month) and $search_month=='04'){echo "selected";}?> value="04">Apr</option>
											<option <?php if(isset($search_month) and $search_month=='05'){echo "selected";}?> value="05">May</option>
											<option <?php if(isset($search_month) and $search_month=='06'){echo "selected";}?> value="06">Jun</option>
											<option <?php if(isset($search_month) and $search_month=='07'){echo "selected";}?> value="07">Jul</option>
											<option <?php if(isset($search_month) and $search_month=='08'){echo "selected";}?> value="08">Aug</option>
											<option <?php if(isset($search_month) and $search_month=='09'){echo "selected";}?> value="09">Sep</option>
											<option <?php if(isset($search_month) and $search_month=='10'){echo "selected";}?> value="10">Oct</option>
											<option <?php if(isset($search_month) and $search_month=='11'){echo "selected";}?> value="11">Nov</option>
											<option <?php if(isset($search_month) and $search_month=='12'){echo "selected";}?> value="12">Dec</option>
										</select>
										<button id="contract_salary_details_search" >Search</button>
									</div>
                               
							    </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Contract</th>
                                                   <th>New Join</th>
                                                   <th>New Resign</th>
                                                   <th>Total Employee</th>
                                                   <th>Paid Days</th>
                                                   <th>OT Hours</th>
                                                   <th>EPF Amt.</th>
                                                   <th>ESIC Amt.</th>
                                                   <th>Total Payable Amt.</th>
                                               </tr>
                                           </thead>
                                           
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$company_role_id = $r['company_role_id'];
													
													//total join
													$where = " company_role='$company_role_id' and doj between '$firstday' and '$lastday' ";
													$emp_total_join =$this->Mymodel->get_all_emp_list($where);

													//getting resign
													$where = " company_role='$company_role_id' and  dor between '$firstday' and '$lastday' ";
													$emp_total_rej=$this->Mymodel->get_all_emp_list($where);

													//total join
													$where = "company_role='$company_role_id' ";
													$all_emp =$this->Mymodel->get_all_emp_list($where);
											   ?>
											   <tr>
                                                   <th scope="row"><?php echo $i;?></th>
												   <td><?php echo $r['company_role_id'];?></td>
												   <td><?php echo $a1[] = $emp_total_join;?></td>
												   <td><?php echo $a2[] = $emp_total_rej;?></td>
												   <td><?php echo $a3[] = $all_emp;?></td>
                                                   <td><?php echo $a4[] = round($r['total_present']);?></td>
												   <td><?php echo $a5[] = round($r['total_ot']);?></td>
												   <td><?php echo $a6[] = round($r['epf_payable']);?></td>
												   <td><?php echo $a7[] = round($r['esic_payable']);?></td>
												   <td><?php echo $a8[] = round($r['current_total_ctc_payable']);?></td>
                                                </tr>
												 <?php 
												$i++;
												}
												?>

												<tr style="font-weight:bold">
														<td></td>
														<td>Total (Rs.)</td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a1)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a2)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a3)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a4)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a5)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a6)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a7)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a8)); }?></td>
												</tr>


                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                       
						<div class="col-md-<?php echo 12-$width;?>">
                                            <div class="panel panel-white" style="height:<?php echo $height;?>">
                                                <div class="panel-heading">
												<!--<h3 class="panel-title">Graph</h3>-->
												 </div>
                                                <div class="panel-body">
														<ol>
															<?php
																foreach($res as $r)
																{
																	$total = round($r['current_total_ctc_payable']);
																	$name =  $r['company_role_id'];
																	$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
																	$rand_color= ('#' . $rand);$rand_color2[]=$rand_color;
																	?>
																		<li style="color:<?php echo $rand_color?>"> <?php echo $name.', '.$total.' Rs. ';?> </li>
																	<?php
																}
															?>
														</ol>
												    
													<div>
														<canvas id="chart44" style="height:100; width:100;"></canvas>
                                                    </div>
                                                </div>

												
                                            </div>
                                </div>
                        
                                
                        
                        <script>
                      
							var ctx44 = document.getElementById("chart44").getContext("2d");
							var data44 = [
											<?php
												$i=0;
												foreach($res as $r)
												{
													$total = round($r['current_total_ctc_payable']);
													$rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
													?>
														{
															value: <?php echo $total;?>,
															color: "<?php echo $rand_color2[$i];?>",
															highlight: "<?php echo $rand_color2[$i];?>",
															label: "<?php echo $r['company_role_id'];?>"
														},
													<?php
												$i++;
												}
											?>
										  ];
								

							var myPieChart = new Chart(ctx44).Pie(data44,{
								segmentShowStroke : false,
								segmentStrokeColor : "#fff",
								segmentStrokeWidth : 2,
								animationSteps : 100,
								animationEasing : "easeOutBounce",
								animateRotate : true,
								animateScale : false,
								
								responsive: true
							});




							//-----------------------------------------------search
							$('#contract_salary_details_search').click(function(){
							
								var con=doesConnectionExist();if(con==0){ error('No Internet Connection.');return false;}
								
								var contract_salary_details_year=$('#contract_salary_details_year').val();
								var contract_salary_details_month=$('#contract_salary_details_month').val();
								
								//-------------------------------getting gst type
								$('.loader').show();
								setTimeout(function() {
										jQuery.post("<?php echo base_url().'index.php/Hr/contract_salary_details_search';?>", 
												{
													
													contract_salary_details_year:contract_salary_details_year,
													contract_salary_details_month:contract_salary_details_month,

												}, 
												
												function(data, textStatus)
												{	
													//alert(data);
													$('#contract_wise_salary_graph_dis').html(data);
													$('.loader').hide();
												});
								});
							});//search close
							
                        </script>  
                        
        <?php
	}//function close





	function dept_wise_salary_graph($div_length,$div_background_color,$height,$width,$search_year,$search_month)
    {
        $firstday = date("$search_year-$search_month-01");
		$lastday = date("$search_year-$search_month-t",strtotime($firstday));

		$query="SELECT department_id,name FROM department WHERE status='Active'  ORDER BY name ";
		$res=$this->Mymodel->query1($query);
		//print_r($res);
		?>
                    <div class="col-lg-12 col-md-12" >
                            <div class="panel panel-white" >
                                <div class="panel-heading">
                                    <h4 class="panel-title">Dept. wise salary details (Current Month till Date)</h4>

									<div style="margin-left:30px;" >
										<select id="contract_salary_details_year2">
											<option <?php if(isset($search_year) and $search_year=='2020'){echo "selected";}?>>2020</option>
											<option <?php if(isset($search_year) and $search_year=='2021'){echo "selected";}?>>2021</option>
											<option <?php if(isset($search_year) and $search_year=='2022'){echo "selected";}?>>2022</option>
											<option <?php if(isset($search_year) and $search_year=='2023'){echo "selected";}?>>2023</option>
											<option <?php if(isset($search_year) and $search_year=='2024'){echo "selected";}?>>2024</option>
											<option <?php if(isset($search_year) and $search_year=='2025'){echo "selected";}?>>2025</option>
										</select>

										<select id="contract_salary_details_month2">
											<option <?php if(isset($search_month) and $search_month=='01'){echo "selected";}?> value="01">Jan</option>
											<option <?php if(isset($search_month) and $search_month=='02'){echo "selected";}?> value="02">Feb</option>
											<option <?php if(isset($search_month) and $search_month=='03'){echo "selected";}?> value="03">Mar</option>
											<option <?php if(isset($search_month) and $search_month=='04'){echo "selected";}?> value="04">Apr</option>
											<option <?php if(isset($search_month) and $search_month=='05'){echo "selected";}?> value="05">May</option>
											<option <?php if(isset($search_month) and $search_month=='06'){echo "selected";}?> value="06">Jun</option>
											<option <?php if(isset($search_month) and $search_month=='07'){echo "selected";}?> value="07">Jul</option>
											<option <?php if(isset($search_month) and $search_month=='08'){echo "selected";}?> value="08">Aug</option>
											<option <?php if(isset($search_month) and $search_month=='09'){echo "selected";}?> value="09">Sep</option>
											<option <?php if(isset($search_month) and $search_month=='10'){echo "selected";}?> value="10">Oct</option>
											<option <?php if(isset($search_month) and $search_month=='11'){echo "selected";}?> value="11">Nov</option>
											<option <?php if(isset($search_month) and $search_month=='12'){echo "selected";}?> value="12">Dec</option>
										</select>
										<button id="dept_salary_details_search" >Search</button>
									</div>

                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Dept.</th>
                                                   <th>New Join</th>
                                                   <th>New Resign</th>
                                                   <th>Total Employee</th>
												   <th>Staff</th>
												   <th>Associate</th>
                                                   <th>Paid Days</th>
                                                   <th>OT Hours</th>
                                                   <th>EPF Amt.</th>
                                                   <th>ESIC Amt.</th>
                                                   <th>Total Payable Amt.</th>
                                               </tr>
                                           </thead>
                                           
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$department_id = $r['department_id'];

													$query="
																SELECT 
																D.name as dname,A.company_role_id, sum(A.total_present) as total_present, sum(A.total_ot) as total_ot,sum(A.esic_payable) as esic_payable,
																sum(A.epf_payable) as epf_payable,sum(A.current_total_ctc_payable) as current_total_ctc_payable
																
																FROM daily_attendance_monthly as A
																
																LEFT JOIN employee E ON A.emp_code=E.emp_code
																LEFT JOIN department D ON E.department_id=D.department_id
																
																WHERE  E.department_id='$department_id' and   A.att_year='$search_year' and A.att_month='$search_month'  GROUP BY E.department_id   ";
													$res2=$this->Mymodel->query1($query);
													
													//total employee
													$where = "department_id='$department_id' ";
													$all_emp =$this->Mymodel->get_all_emp_list($where);

													//total staff
													$where = "department_id='$department_id' and staff_tech='Staff'  ";
													$all_staff =$this->Mymodel->get_all_emp_list($where);

													//total Associate
													$where = "department_id='$department_id'  and staff_tech = 'Tech' ";
													$all_worker =$this->Mymodel->get_all_emp_list($where);
												
													//getting resign
													$where = " department_id='$department_id' and  dor between '$firstday' and '$lastday' ";
													$emp_total_rej=$this->Mymodel->get_all_emp_list($where);
													//total join
													$where = " department_id='$department_id' and doj between '$firstday' and '$lastday' ";
													$emp_total_join =$this->Mymodel->get_all_emp_list($where);

												
											   ?>
											   <tr>
                                                   <th scope="row"><?php echo $i;?></th>
												   <td><?php echo $r['name'];?></td>
												   <td><?php echo $a1[] = $emp_total_join;?></td>
												   <td><?php echo $a2[] = $emp_total_rej;?></td>
												   <td><?php echo $a3[] = $all_emp;?></td>
												   <td><?php echo $a9[] = $all_staff;?></td>
												   <td><?php echo $a10[] = $all_worker;?></td>
                                                   <td><?php if(isset($res2[0]['total_present']))echo $a4[] = round($res2[0]['total_present']);?></td>
												   <td><?php if(isset($res2[0]['total_ot']))echo $a5[] = round($res2[0]['total_ot']);?></td>
												   <td><?php if(isset($res2[0]['epf_payable']))echo $a6[] = round($res2[0]['epf_payable']);?></td>
												   <td><?php if(isset($res2[0]['esic_payable'])) echo $a7[] = round($res2[0]['esic_payable']);?></td>
												   <td><?php if(isset($res2[0]['current_total_ctc_payable']))echo $a8[] = round($res2[0]['current_total_ctc_payable']);?></td>
                                                  
                                                  
                                               </tr>
												 <?php 
												$i++;
												}
												?>

												<tr style="font-weight:bold">
														<td></td>
														<td>Total (Rs.)</td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a1)); }?></td>
														<td><?php if(!empty($a2)){ echo round(array_sum($a2)); }?></td>
														<td><?php if(!empty($a3)){ echo round(array_sum($a3)); }?></td>
														<td><?php if(!empty($a9)){ echo round(array_sum($a9)); }?></td>
														<td><?php if(!empty($a10)){ echo round(array_sum($a10)); }?></td>
														<td><?php if(!empty($a4)){ echo round(array_sum($a4)); }?></td>
														<td><?php if(!empty($a5)){ echo round(array_sum($a5)); }?></td>
														<td><?php if(!empty($a6)){ echo round(array_sum($a6)); }?></td>
														<td><?php if(!empty($a7)){ echo round(array_sum($a7)); }?></td>
														<td><?php if(!empty($a8)){ echo round(array_sum($a8)); }?></td>
												</tr>


                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

						<script>
							//-----------------------------------------------search
							$('#dept_salary_details_search').click(function(){
							
								var con=doesConnectionExist();if(con==0){ error('No Internet Connection.');return false;}
								
								var contract_salary_details_year=$('#contract_salary_details_year2').val();
								var contract_salary_details_month=$('#contract_salary_details_month2').val();
								
								//-------------------------------getting gst type
								$('.loader').show();
								setTimeout(function() {
										jQuery.post("<?php echo base_url().'index.php/Hr/dept_wise_salary_graph';?>", 
												{
													
													contract_salary_details_year:contract_salary_details_year,
													contract_salary_details_month:contract_salary_details_month,

												}, 
												
												function(data, textStatus)
												{	
													//alert(data);
													$('#dept_wise_salary_graph_dis').html(data);
													$('.loader').hide();
												});
								});
							});//search close
					  
				  		</script>  

                       
                        
        <?php
	}//function close




	function yearly_salary_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		$att_year = date('Y');
		$att_month = date('m');
		?>
						
						
								<div class="col-md-6">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													 Mothly Salary Chart (Payable Amount)
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart46" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

						<script>
						<?php
						$out1 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','1',$att_year);
						$out2 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','2',$att_year);
						$out3 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','3',$att_year);
						$out4 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','4',$att_year);
						$out5 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','5',$att_year);
						$out6 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','6',$att_year);
						$out7 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','7',$att_year);
						$out8 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','8',$att_year);
						$out9 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','9',$att_year);
						$out10 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','10',$att_year);
						$out11 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','11',$att_year);
						$out12 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','12',$att_year);

						?>          
						

						var ctx46 = document.getElementById("chart46").getContext("2d");
							var data46 = {
								labels: [ 
											"January", 
											"February", 
											"March", 
											"April", 
											"May", 
											"June", 
											"July", 
											"August", 
											"September", 
											"October", 
											"November", 
											"December"  
										],
								datasets: [
									
									{
										label: "My Second dataset",
										fillColor: "rgba(34,186,160,0.5)",
										strokeColor: "rgba(34,186,160,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
												<?php if(isset($out1[0]['current_total_ctc_payable'])){echo $out1[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out2[0]['current_total_ctc_payable'])){echo $out2[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out3[0]['current_total_ctc_payable'])){echo $out3[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out4[0]['current_total_ctc_payable'])){echo $out4[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out5[0]['current_total_ctc_payable'])){echo $out5[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out6[0]['current_total_ctc_payable'])){echo $out6[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out7[0]['current_total_ctc_payable'])){echo $out7[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out8[0]['current_total_ctc_payable'])){echo $out8[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out9[0]['current_total_ctc_payable'])){echo $out9[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out10[0]['current_total_ctc_payable'])){echo $out10[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out11[0]['current_total_ctc_payable'])){echo $out11[0]['current_total_ctc_payable'];}else{echo 0;}?>,
												<?php if(isset($out12[0]['current_total_ctc_payable'])){echo $out12[0]['current_total_ctc_payable'];}else{echo 0;}?>
												

											]
									}
								]
							};
							
						var myBar = new Chart(ctx46).Bar(data46, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close






	function yearly_ot_hours_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		$att_year = date('Y');
		$att_month = date('m');
		?>
						
						
								<div class="col-md-6">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													 Mothly O.T Chart (Hours)
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart47" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

						<script>
						<?php
						$out1 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','1',$att_year);
						$out2 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','2',$att_year);
						$out3 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','3',$att_year);
						$out4 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','4',$att_year);
						$out5 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','5',$att_year);
						$out6 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','6',$att_year);
						$out7 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','7',$att_year);
						$out8 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','8',$att_year);
						$out9 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','9',$att_year);
						$out10 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','10',$att_year);
						$out11 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','11',$att_year);
						$out12 = $this->Mymodel->emp_total_salary_from_attendance_monthly('All','12',$att_year);

						?>          
						

						var ctx47 = document.getElementById("chart47").getContext("2d");
							var data47 = {
								labels: [ 
											"January", 
											"February", 
											"March", 
											"April", 
											"May", 
											"June", 
											"July", 
											"August", 
											"September", 
											"October", 
											"November", 
											"December"  
										],
								datasets: [
									
									{
										label: "My First dataset",
										fillColor: "rgba(255,0,0,0.5)",
										strokeColor: "rgba(220,220,220,0.8)",
										highlightFill: "rgba(220,220,220,0.75)",
										highlightStroke: "rgba(220,220,220,1)",
										data: [
												<?php if(isset($out1[0]['total_ot'])){echo round($out1[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out2[0]['total_ot'])){echo round($out2[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out3[0]['total_ot'])){echo round($out3[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out4[0]['total_ot'])){echo round($out4[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out5[0]['total_ot'])){echo round($out5[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out6[0]['total_ot'])){echo round($out6[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out7[0]['total_ot'])){echo round($out7[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out8[0]['total_ot'])){echo round($out8[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out9[0]['total_ot'])){echo round($out9[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out10[0]['total_ot'])){echo round($out10[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out11[0]['total_ot'])){echo round($out11[0]['total_ot']);}else{echo 0;}?>,
												<?php if(isset($out12[0]['total_ot'])){echo round($out12[0]['total_ot']);}else{echo 0;}?>
												

											]
									}
								]
							};
							
						var myBar = new Chart(ctx47).Bar(data47, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close




	function gatepass_graph($div_length,$div_background_color,$height,$width)
    {
        $yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$query=" SELECT  *   FROM emp_gatepass WHERE entry_date >= '$yesterday' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Gate Pass Used form Yesterday</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                   <th>Out Date</th>
                                                   <th>Out Time</th>
                                                   <th>In Time</th>
                                                   <th>Time Taken (Min)</th>
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($_REQUEST['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['time_out'];?></td>
												   <td><?php echo $r['time_in'];?></td>
												   <td><?php echo $r['time_diff'];?></td>
												   
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close






	function leave_graph($div_length,$div_background_color,$height,$width)
    {
		$thismonth=date("Y-m-01");
		//$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		$query=" SELECT  *   FROM emp_leave WHERE from_date >= '$thismonth' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
								<h4 class="panel-title">Leave on this month</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                   <th>From Date</th>
                                                   <th>To Date</th>
                                                   <th>Total Days</th>
                                                  
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($r['from_date']);
													$from_date= date_format($test, 'd-m-Y');
													
													$test = new DateTime($r['to_date']);
													$to_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   <td><?php echo $from_date;?></td>
												   <td><?php echo $to_date;?></td>
												   <td><?php echo $r['total_days'];?></td>
												   
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close


	function complaint_graph($div_length,$div_background_color,$height,$width)
    {
        $thisyear=date("Y-01-01");
		$query=" SELECT  *   FROM emp_complaint WHERE entry_date >= '$thisyear' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Complaint on employee in this Year</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                  
												   <th>Date</th>
                                                   <th>Type_of_comp</th>
                                                   <th>Offenses</th>
                                                   
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($_REQUEST['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['type_of_comp'];?></td>
												   <td><?php echo $r['offenses'];?></td>
												  
												   
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close



	function fine_graph($div_length,$div_background_color,$height,$width)
    {
        $thisyear=date("Y-01-01");
		$query=" SELECT  *   FROM emp_fine WHERE entry_date >= '$thisyear' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Fine on employee in this Year</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                  
												   <th>Date</th>
                                                   <th>Type_of_comp</th>
                                                   <th>Subject</th>
                                                   
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($_REQUEST['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['type_of_comp'];?></td>
												   <td><?php echo $r['subject'];?></td>
												  
												   
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close




	function accident_graph($div_length,$div_background_color,$height,$width)
    {
        $thisyear=date("Y-01-01");
		$query=" SELECT  *   FROM emp_accident WHERE entry_date >= '$thisyear' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-12 col-md-12">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Accident in this Year</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
												   <th>Date</th>
												   <th>Type_of_comp</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                  
												   
                                                   
                                                   <th>Details</th>
                                                   
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['type_of_comp'];?></td>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   <td><?php echo $r['infraction'];?></td>
												</tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close



	function kaizen_graph($div_length,$div_background_color,$height,$width)
    {
        $thismonth=date("Y-m-01");
		$query=" SELECT  *   FROM emp_kaizen WHERE entry_date >= '$thismonth' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Kaizen in this Month</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                   <th>Date</th>
                                                   <th>Subject</th>
                                                   
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($_REQUEST['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['subject'];?></td>
												  
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close



	function suggestion_graph($div_length,$div_background_color,$height,$width)
    {
        $thismonth=date("Y-m-01");
		$query=" SELECT  *   FROM emp_suggestion WHERE entry_date >= '$thismonth' ORDER BY entry_date DESC ";
		$res=$this->Mymodel->query1($query);
		
		?>
                    <div class="col-lg-6 col-md-6">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Suggestion in this Month</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>ID</th>
                                                   <th>Name</th>
                                                   <th>Dept.</th>
                                                   <th>Date</th>
                                                   <th>Subject</th>
                                                   
                                               </tr>
                                           </thead>
                                           <tbody>
											   <?php 
												 $i=1;
												 foreach($res as $r)
												 {  
													$test = new DateTime($_REQUEST['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');
											   ?>
                                               <tr>
                                                   <th scope="row"><?php echo $i;?></th>
                                                   <td><?php echo $r['emp_id'];?></td>
												   <td><?php echo $r['emp_name'];?></td>
												   <td><?php echo $r['emp_dept'];?></td>
												   
												   <td><?php echo $entry_date;?></td>
												   <td><?php echo $r['subject'];?></td>
												  
                                               </tr>
											   <?php 
											   	 $i++;
												 }
												 ?>
                                           </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

        <?php
	}//function close



	function sales_vs_salary_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		$att_year = date('Y');
		$att_month = date('m');

		$out1 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','01',$att_year);
		$out2 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','02',$att_year);
		$out3 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','03',$att_year);
		$out4 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','04',$att_year);
		$out5 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','05',$att_year);
		$out6 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','06',$att_year);
		$out7 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','07',$att_year);
		$out8 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','08',$att_year);
		$out9 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','09',$att_year);
		$out10 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','10',$att_year);
		$out11 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','11',$att_year);
		$out12 = $this->Mymodel->emp_total_salary_from_attendance_monthly_vs_total_sales('All','12',$att_year);

		$avg = round(($out1+$out2+$out3+$out4+$out5+$out6+$out7+$out8+$out9+$out10+$out11+$out12)/date('m'),1);
		?>
						
						
								<div class="col-md-4">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
													Salary Percentage (%) "<?php echo date('M');?> Sales (With GST) VS Salary (Payable Amount) "
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart48" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
													Avg : <?php echo $avg.' %';?>
												</div>
											</div>
								</div>
						
						
						<script>
						
						var ctx48 = document.getElementById("chart48").getContext("2d");
							var data48 = {
								labels: [ 
											"January (%)", 
											"February (%)", 
											"March (%)", 
											"April (%)", 
											"May (%)", 
											"June (%)", 
											"July (%)", 
											"August (%)", 
											"September (%)", 
											"October (%)", 
											"November (%)", 
											"December (%)"  
										],
								datasets: [
									
									{
										label: "My Second dataset",
										fillColor: "rgba(112,111,190,0.5)",
										strokeColor: "rgba(112,111,190,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
												<?php if(!empty($out1)){echo $out1;}else{echo 0;}?>,
												<?php if(!empty($out2)){echo $out2;}else{echo 0;}?>,
												<?php if(!empty($out3)){echo $out3;}else{echo 0;}?>,
												<?php if(!empty($out4)){echo $out4;}else{echo 0;}?>,
												<?php if(!empty($out5)){echo $out5;}else{echo 0;}?>,
												<?php if(!empty($out6)){echo $out6;}else{echo 0;}?>,
												<?php if(!empty($out7)){echo $out7;}else{echo 0;}?>,
												<?php if(!empty($out8)){echo $out8;}else{echo 0;}?>,
												<?php if(!empty($out9)){echo $out9;}else{echo 0;}?>,
												<?php if(!empty($out10)){echo $out10;}else{echo 0;}?>,
												<?php if(!empty($out11)){echo $out11;}else{echo 0;}?>,
												<?php if(!empty($out12)){echo $out12;}else{echo 0;}?>

											]
									}
								]
							};
							
						var myBar = new Chart(ctx48).Bar(data48, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close






	function emp_attrition_monthly($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		//$att_year = date('Y');
		//$att_month = date('m');

		//getting resign
		$day1=date("Y-01-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out1=$this->Mymodel->get_all_emp_list($where); // month 1
		$day1=date("Y-02-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out2=$this->Mymodel->get_all_emp_list($where); // month 2
		$day1=date("Y-03-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out3=$this->Mymodel->get_all_emp_list($where); // month 3
		$day1=date("Y-04-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out4=$this->Mymodel->get_all_emp_list($where); // month 4
		$day1=date("Y-05-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out5=$this->Mymodel->get_all_emp_list($where); // month 5
		$day1=date("Y-06-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out6=$this->Mymodel->get_all_emp_list($where); // month 6
		$day1=date("Y-07-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out7=$this->Mymodel->get_all_emp_list($where); // month 7
		$day1=date("Y-08-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out8=$this->Mymodel->get_all_emp_list($where); // month 8
		$day1=date("Y-09-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out9=$this->Mymodel->get_all_emp_list($where); // month 9
		$day1=date("Y-10-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out10=$this->Mymodel->get_all_emp_list($where); // month 10
		$day1=date("Y-11-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out11=$this->Mymodel->get_all_emp_list($where); // month 11
		$day1=date("Y-12-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out12=$this->Mymodel->get_all_emp_list($where); // month 12

		
		//total join
		//$where = " company_role='$company_role_id' and doj between '$day1' and '$today' ";
		//$emp_total_join =$this->Mymodel->get_all_emp_list($where);

		$total = round($out1+$out2+$out3+$out4+$out5+$out6+$out7+$out8+$out9+$out10+$out11+$out12);
		$avg = round($total/date('m'));
		?>
						
						
								<div class="col-md-4">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Employee Attrition <?php echo date('Y');?> in nos
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart49" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
													Total : <?php echo $total ;?>, Avg : <?php echo $avg ;?>
												</div>
											</div>
								</div>
						
						
						<script>
						
						var ctx49 = document.getElementById("chart49").getContext("2d");
							var data49 = {
								labels: [ 
									"January", 
											"February", 
											"March", 
											"April", 
											"May", 
											"June", 
											"July", 
											"August", 
											"September", 
											"October", 
											"November", 
											"December"  
										],
								datasets: [
									
									{
										label: "My Second dataset",
										fillColor: "rgba(112,111,190,0.5)",
										strokeColor: "rgba(112,111,190,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
												<?php if(!empty($out1)){echo $out1;}else{echo 0;}?>,
												<?php if(!empty($out2)){echo $out2;}else{echo 0;}?>,
												<?php if(!empty($out3)){echo $out3;}else{echo 0;}?>,
												<?php if(!empty($out4)){echo $out4;}else{echo 0;}?>,
												<?php if(!empty($out5)){echo $out5;}else{echo 0;}?>,
												<?php if(!empty($out6)){echo $out6;}else{echo 0;}?>,
												<?php if(!empty($out7)){echo $out7;}else{echo 0;}?>,
												<?php if(!empty($out8)){echo $out8;}else{echo 0;}?>,
												<?php if(!empty($out9)){echo $out9;}else{echo 0;}?>,
												<?php if(!empty($out10)){echo $out10;}else{echo 0;}?>,
												<?php if(!empty($out11)){echo $out11;}else{echo 0;}?>,
												<?php if(!empty($out12)){echo $out12;}else{echo 0;}?>

											]
									}
								]
							};
							
						var myBar = new Chart(ctx49).Bar(data49, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close




	function emp_join_monthly($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		//$att_year = date('Y');
		//$att_month = date('m');

		//total join
		$day1=date("Y-01-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out1=$this->Mymodel->get_all_emp_list($where); // month 1
		$day1=date("Y-02-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out2=$this->Mymodel->get_all_emp_list($where); // month 2
		$day1=date("Y-03-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out3=$this->Mymodel->get_all_emp_list($where); // month 3
		$day1=date("Y-04-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out4=$this->Mymodel->get_all_emp_list($where); // month 4
		$day1=date("Y-05-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out5=$this->Mymodel->get_all_emp_list($where); // month 5
		$day1=date("Y-06-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out6=$this->Mymodel->get_all_emp_list($where); // month 6
		$day1=date("Y-07-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out7=$this->Mymodel->get_all_emp_list($where); // month 7
		$day1=date("Y-08-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out8=$this->Mymodel->get_all_emp_list($where); // month 8
		$day1=date("Y-09-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out9=$this->Mymodel->get_all_emp_list($where); // month 9
		$day1=date("Y-10-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out10=$this->Mymodel->get_all_emp_list($where); // month 10
		$day1=date("Y-11-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out11=$this->Mymodel->get_all_emp_list($where); // month 11
		$day1=date("Y-12-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out12=$this->Mymodel->get_all_emp_list($where); // month 12

		
		$total = round($out1+$out2+$out3+$out4+$out5+$out6+$out7+$out8+$out9+$out10+$out11+$out12);
		$avg = round($total/date('m'));
		?>
						
						
								<div class="col-md-4">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														Employee New Join <?php echo date('Y');?> in nos
													</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart50" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
													Total : <?php echo $total ;?>, Avg : <?php echo $avg ;?>
												</div>
											</div>
								</div>
						
						
						<script>
						
						var ctx50 = document.getElementById("chart50").getContext("2d");
							var data50 = {
								labels: [ 
											"January", 
											"February", 
											"March", 
											"April", 
											"May", 
											"June", 
											"July", 
											"August", 
											"September", 
											"October", 
											"November", 
											"December"  
										],
								datasets: [
									
									{
										label: "My Second dataset",
										fillColor: "rgba(112,111,190,0.5)",
										strokeColor: "rgba(112,111,190,0.8)",
										highlightFill: "rgba(34,186,160,0.75)",
										highlightStroke: "rgba(34,186,160,1)",
										data: [
												<?php if(!empty($out1)){echo $out1;}else{echo 0;}?>,
												<?php if(!empty($out2)){echo $out2;}else{echo 0;}?>,
												<?php if(!empty($out3)){echo $out3;}else{echo 0;}?>,
												<?php if(!empty($out4)){echo $out4;}else{echo 0;}?>,
												<?php if(!empty($out5)){echo $out5;}else{echo 0;}?>,
												<?php if(!empty($out6)){echo $out6;}else{echo 0;}?>,
												<?php if(!empty($out7)){echo $out7;}else{echo 0;}?>,
												<?php if(!empty($out8)){echo $out8;}else{echo 0;}?>,
												<?php if(!empty($out9)){echo $out9;}else{echo 0;}?>,
												<?php if(!empty($out10)){echo $out10;}else{echo 0;}?>,
												<?php if(!empty($out11)){echo $out11;}else{echo 0;}?>,
												<?php if(!empty($out12)){echo $out12;}else{echo 0;}?>

											]
									}
								]
							};
							
						var myBar = new Chart(ctx50).Bar(data50, {
								showTooltips: false,
								onAnimationComplete: function () {
							
									var ctx = this.chart.ctx;
									ctx.font = this.scale.font;
									ctx.fillStyle = this.scale.textColor
									ctx.textAlign = "center";
									ctx.textBaseline = "bottom";
							
									this.datasets.forEach(function (dataset) {
										dataset.bars.forEach(function (bar) {
											ctx.fillText(bar.value, bar.x, bar.y - 5);
										});
									})
								}
							});
						</script>
		<?php
	}//function close







	//row 4
	function daily_sale_section_in_rs_graph($div_background_color,$height,$width)
	{
		$m=date('m');
		$y=date('Y');
		
		//getting all section 
		$this_month_from = date("$y-$m-01");
		$this_month_to = date("$y-$m-t");
		$query=" SELECT 
				G.category_id as category_id,
				G.sales_target as sales_target,
				G.name as name
				FROM dispatch as A
				LEFT JOIN dispatch_details as B ON B.dispatch_id = A.dispatch_id 
				LEFT JOIN product as P ON P.product_id = B.product_id
				LEFT JOIN category as G ON G.category_id = P.category_id
				WHERE  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0  and A.entry_date between '$this_month_from' and '$this_month_to'  and G.category_id>0
				GROUP BY G.category_id ORDER BY G.name ";
		$section_list=$this->Mymodel->query1($query);
		//print_r($section_list);
		//$query = "SELECT * FROM category WHERE show_in_dashbord=1  ";
		//$section_list = $this->Mymodel->query1($query);
		$j=1;
		?>
		<div class="row" >
		<?php
		foreach($section_list as $s)
		{
			$category_id = $s['category_id'];
			$section_name = $s['name'];
			$dipatch_target = $s['sales_target'];
			//converting to short name
			$getting_div_digit = strlen($dipatch_target);
			if($getting_div_digit == 7){$getting_div_digit=6;}elseif($getting_div_digit >= 9){$getting_div_digit=8;}
			$getting_div_val = str_pad(1, $getting_div_digit, '0', STR_PAD_RIGHT);
			
		?>
						
								<div class="col-md-6">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
													<h3 class="panel-title">
														<?php echo $section_name;?> Sales In Rs. without GST  <?php echo date('M-Y');?>
													</h3>
												</div>
												
												<div class="panel-body">
													<div>
														<canvas id="chart1abc<?php echo $j;?>" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												
													<script>
														var ctx1abc<?php echo $j;?> = document.getElementById("chart1abc<?php echo $j;?>").getContext("2d");
														var data1abc<?php echo $j;?> = {
															labels: [ 
																		<?php 
																		for($i=1;$i<=31;$i++)
																		{
																			//creating date
																			$test = new DateTime("$i-$m-$y");
																			$new_date= date_format($test, 'd');
																			
																			if($i==31)
																			{
																				?>"<?php echo $new_date;?>"<?php
																			}
																			else
																			{
																				?>"<?php echo $new_date;?>",<?php
																			}
																			
																		}
																		?>
																	],
														
														
														
															datasets: [
															
																		
																		{
																			label: "My First dataset",
																			fillColor: "rgba(18,175,203,0.2)",
																			strokeColor: "rgba(18,175,203,1)",
																			pointColor: "rgba(18,175,203,1)",
																			data: [
																					<?php 
																					

																					for($i=1;$i<=31;$i++)
																					{
																						$dipatch_target2 = round($dipatch_target/$getting_div_val,1);
																						if($i == 31)
																						{
																							echo $dipatch_target2;
																						}
																						else
																						{
																							
																							echo "$dipatch_target2,";
																						}
																					}
																					?>
																					
															
																				]
																		},
																		
																		{
																			fillColor: "rgba(34,186,160,0.5)",
																			strokeColor: "rgba(34,186,160,0.8)",
																			highlightFill: "rgba(34,186,160,0.75)",
																			highlightStroke: "rgba(34,186,160,1)",
																			data: [
																					<?php 
																						$total = array();
																						$m=date('m');
																						$y=date('Y');
																						for($i=1;$i<=31;$i++)
																						{
																							//creating date
																							$test = new DateTime("$i-$m-$y");
																							$new_date= date_format($test, 'Y-m-d');
																							
																							$query = "
																										SELECT sum(B.total_amt) as rs FROM dispatch_details as B 
																										LEFT JOIN dispatch as A ON B.dispatch_id = A.dispatch_id 
																										LEFT JOIN product as P ON P.product_id = B.product_id 
																										WHERE A.entry_date='$new_date' and A.type_of_bill = 'Tax Invoice' and A.is_it_cancel='0' and P.category_id='$category_id' GROUP BY P.category_id ORDER BY P.category_id,P.product_id
																									
																										";
																							
																							$out=$this->Mymodel->query1($query);
																							$total_day = array();
																							foreach($out as $o)
																							{
																								$total_day[] = $o['rs'];
																							}
																							

																							if($i==31)
																							{
																								?>"<?php echo round(array_sum($total_day)/$getting_div_val,1);  $total[] = round(array_sum($total_day));?>"<?php
																							}
																							else
																							{
																								?>"<?php echo round(array_sum($total_day)/$getting_div_val,1); $total[] = round(array_sum($total_day));?>",<?php
																							}
																							
																						}
																					?>				 	  
																				]
																		}
															]
															
															
														};
													

														var myBar = new Chart(ctx1abc<?php echo $j;?>).Bar(data1abc<?php echo $j;?>, {
														showTooltips: false,
														onAnimationComplete: function () {
													
															var ctx = this.chart.ctx;
															ctx.font = this.scale.font;
															ctx.fillStyle = this.scale.textColor
															ctx.textAlign = "center";
															ctx.textBaseline = "bottom";
													
															this.datasets.forEach(function (dataset) {
																dataset.bars.forEach(function (bar) {
																	ctx.fillText(bar.value, bar.x, bar.y - 5);
																});
															})
														}
													});
													</script>
													<?php 
														if(!empty($total))
														{
															echo "Total : ".$total_sale_this_month =  round(array_sum($total));
															$total_sale_this_month = round($total_sale_this_month/date('d'));
															echo ', Avg : '.$total_sale_this_month ;
														}
														echo "<br> Divide By : ";
														echo $getting_div_rs = $this->Mymodel->convert_number_to_words($getting_div_val);
													?>
												</div> <!---<div class="panel-body">-->
											</div> <!--<div class="panel panel-->
								</div><!--<div class="col-md-12">-->
		<?php
		$j++;
		}//section close
		?>
		</div>    
		<!-- Row -->
		<?php
	}//function close

	



	// attendance function 1
	function date_wise_attendance($color,$column_length,$form_month,$to_month,$year2,$emp_code)
    {
		$query = " SELECT * FROM employee WHERE emp_code = '$emp_code' ";
		$out=$this->Mymodel->query1($query);
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	<?php echo $out[0]['name'].' '.$out[0]['last_name'];?> your daily attendance reports - <?php echo $year2;?>
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<h4>
										P : Present, A : Absent, H : Holiday, S : Sunday, SL : Sick Leave, CL : Casual Leave, EL : Emergency Leave, OL : Other Leave, For Half Day enter A and add hours in OT Sheet.
									</h4>
									<br>
										<table  border="1" width="100%">
											<tr>
												<th>Month / Date</th>
												<?php 
													for($i=1;$i<=31;$i++)
													{
													?>
														<th><?php if($i<10){echo "0";}echo $i;?></th>
													<?php 
													}
												?>
												<th>Month Days</th>
												<th>Total Sunday</th>
												<th>Total Holiday</th>
												<th>Total SL</th>
												<th>Total CL</th>
												<th>Total EL</th>
												<th>Total OL</th>
												<th>Present</th>
												<th>Total Present</th>
												<th>Total Absent</th>
												<th>Total OT Hrs.</th>
												<th>Total GatePass</th>
												<!--<th>Total Kaizen</th>
												<th>Total Traning</th>-->
											</tr>
											<?php 
												$this->Dashbord->date_wise_attendance_rows($form_month,$to_month,$year2,$emp_code);
											?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close

	
	// attendance function 2
	function date_wise_attendance_rows($form_month,$to_month,$year2,$emp_code)
    {
		for($j=$form_month;$j<=$to_month;$j++)
		{
			if($j==1){$last_day_of_month=31;}
			elseif($j==2){$last_day_of_month=29;}
			elseif($j==3){$last_day_of_month=31;}
			elseif($j==4){$last_day_of_month=30;}
			elseif($j==5){$last_day_of_month=31;}
			elseif($j==6){$last_day_of_month=30;}
			elseif($j==7){$last_day_of_month=31;}
			elseif($j==8){$last_day_of_month=31;}
			elseif($j==9){$last_day_of_month=30;}
			elseif($j==10){$last_day_of_month=31;}
			elseif($j==11){$last_day_of_month=30;}
			elseif($j==12){$last_day_of_month=31;}
			
			
			$test = new DateTime("1-$j-$year2");
			$month= date_format($test, 'M');
			$from_date = date_format($test, 'Y-m-d');
			$to_date = date_format($test, 'Y-m-t');
			
			//geting data from attendance table
			$query=" SELECT * FROM daily_attendance_monthly where emp_code='$emp_code'  and att_year='$year2' and att_month='$j' ";
			$out=$this->Mymodel->query1($query);
			
			$query=" SELECT count(id) as nos FROM emp_gatepass where emp_id='$emp_code' and   entry_date between '$from_date' and '$to_date'  ";
			$gatepass=$this->Mymodel->query1($query);
			
			?>
			<tr style="height:10px; ">
			  <td><?php echo $month;?></td>
			  <?php if(isset($out[0]['d1'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d1'],$out[0]['o1']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d2'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d2'],$out[0]['o2']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d3'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d3'],$out[0]['o3']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d4'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d4'],$out[0]['o4']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d5'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d5'],$out[0]['o5']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d6'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d6'],$out[0]['o6']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d7'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d7'],$out[0]['o7']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d8'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d8'],$out[0]['o8']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d9'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d9'],$out[0]['o9']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d10'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d10'],$out[0]['o10']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d11'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d11'],$out[0]['o11']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d12'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d12'],$out[0]['o12']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d13'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d13'],$out[0]['o13']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d14'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d14'],$out[0]['o14']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d15'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d15'],$out[0]['o15']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d16'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d16'],$out[0]['o16']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d17'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d17'],$out[0]['o17']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d18'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d18'],$out[0]['o18']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d19'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d19'],$out[0]['o19']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d20'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d20'],$out[0]['o20']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d21'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d21'],$out[0]['o21']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d22'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d22'],$out[0]['o22']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d23'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d23'],$out[0]['o23']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d24'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d24'],$out[0]['o24']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d25'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d25'],$out[0]['o25']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d26'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d26'],$out[0]['o26']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d27'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d27'],$out[0]['o27']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d28'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d28'],$out[0]['o28']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d29'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d29'],$out[0]['o29']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d30'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d30'],$out[0]['o30']);}else{echo "<td></td>";} ?>
			  <?php if(isset($out[0]['d31'])){echo $this->Dashbord->get_attendance_p_a($out[0]['d31'],$out[0]['o31']);}else{echo "<td></td>";} ?>
			  
			  <td align="center"><b><?php if(isset($out[0]['total_day_in_month'])){echo $total_day_in_month[]=$out[0]['total_day_in_month'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_sunday'])){echo $total_sunday[]=$out[0]['total_sunday'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_holiday'])){echo $total_holiday[]=$out[0]['total_holiday'];}else{echo "";} ?></b></td>
			  
			  <td align="center"><b><?php if(isset($out[0]['total_sl'])){echo $total_sl[]=$out[0]['total_sl'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_cl'])){echo $total_cl[]=$out[0]['total_cl'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_el'])){echo $total_el[]=$out[0]['total_el'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_ol'])){echo $total_ol[]=$out[0]['total_ol'];}else{echo "";} ?></b></td>
			  
			  <td align="center"><b><?php if(isset($out[0]['total_p'])){echo $total_p[]=$out[0]['total_p'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_present'])){echo $total_present[]=$out[0]['total_present'];}else{echo "";} ?></b></td>
			  <td align="center"><b><?php if(isset($out[0]['total_absent'])){echo $total_absent[]=$out[0]['total_absent'];}else{echo "";} ?></b></td>
			  
			  <td align="center"><b><?php if(isset($out[0]['total_ot'])){echo $total_ot[]=$out[0]['total_ot'];}else{echo "";} ?></b></td>
			  
			  <td align="center"><b><?php if(isset($gatepass)){ echo $gatepass2[]=$gatepass[0]['nos'];}else{echo "";} ?></b></td>
			</tr>
		 <?php
		}//for
		?>
			<tr>
			<td></td>
				<td colspan="31"><b>Total</b></td>
				<td align="center"><b><?php if(!empty($total_day_in_month)){echo array_sum($total_day_in_month);}?></b></td>
				<td align="center"><b><?php if(!empty($total_sunday)){echo array_sum($total_sunday);}?></b></td>
				<td align="center"><b><?php if(!empty($total_holiday)){echo array_sum($total_holiday);}?></b></td>

				<td align="center"><b><?php if(!empty($total_sl)){echo array_sum($total_sl);}?></b></td>
				<td align="center"><b><?php if(!empty($total_cl)){echo array_sum($total_cl);}?></b></td>
				<td align="center"><b><?php if(!empty($total_el)){echo array_sum($total_el);}?></b></td>
				<td align="center"><b><?php if(!empty($total_ol)){echo array_sum($total_ol);}?></b></td>
				
				<td align="center"><b><?php if(!empty($total_p)){echo array_sum($total_p);}?></b></td>
				<td align="center"><b><?php if(!empty($total_present)){echo array_sum($total_present);}?></b></td>
				<td align="center"><b><?php if(!empty($total_absent)){echo array_sum($total_absent);}?></b></td>
				<td align="center"><b><?php if(!empty($total_ot)){echo array_sum($total_ot);}?></b></td>
				<td align="center"><b><?php if(!empty($gatepass2)){echo array_sum($gatepass2);}?></b></td>
			</tr>   
		<?php
	
	}//function close

	// attendance function 3
	function get_attendance_p_a($data,$ot_hrs)
	{
			if($data=='P'){$out = 'P';     $color = 'background-color:green;color:white; padding-left:5px;';}
			elseif($data=='A'){$out = 'A'; $color = 'background-color:red;color:white;padding-left:5px;';}
			elseif($data=='H'){$out = 'H'; $color = 'background-color:yellow;color:black;padding-left:5px;';}
			elseif($data=='S'){$out = 'S'; $color = 'background-color:blue;color:white;padding-left:5px;'; }
			elseif($data=='SL'){$out = 'SL'; $color = 'background-color:blue;color:white;padding-left:5px;'; }
			elseif($data=='SL'){$out = 'SL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='CL'){$out = 'CL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='EL'){$out = 'EL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='EL'){$out = 'EL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data=='OL'){$out = 'OL'; $color = 'background-color:purple;color:white;padding-left:5px;'; }
			elseif($data==NULL){$out = '';$color = '';}
			else{$out = '';$color = '';}
		  
		  	//print_r($data);
		  	//$res = "<td style='$color'>$out</td>";
		   	
			if($ot_hrs > 0){$ot_hrs2 = $ot_hrs;}  else{$ot_hrs2 = '';}
			return $res = "<td style='$color'>$out<br>$ot_hrs2</td>";
		   
		  
	}//function







	// emp_month_wise_salary
	function emp_month_wise_salary($color,$column_length,$form_month,$to_month,$year2,$emp_code)
    {
		$query = " SELECT * FROM employee WHERE emp_code = '$emp_code' ";
		$out=$this->Mymodel->query1($query);
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	<?php echo $out[0]['name'].' '.$out[0]['last_name'];?> your monthly salary reports - <?php echo $year2;?>
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
											<tr>
												<th  align='right' width="70px;">Month</th>
                                                <td align='right' width="70px;">Paid Days</td>
                                                <td align='right' width="70px;">OT Hours</td>
                                                
                                                <td align='right' width="70px;">Basic</td>
                                                <td align='right' width="70px;">HRA</td>
                                                <td align='right' width="70px;">Conv</td>
                                                <td align='right' width="70px;">CCA</td>
                                                <td align='right' width="70px;">Other Allow</td>
                                                <td align='right' width="70px;">Spl Pay</td>
                                                <td align='right' width="70px;">Medi Rem</td>
                                                <td align='right' width="70px;">Arrear</td>
                                                <td align='right' width="70px;">Ext.Atten.</td>
                                                <td align='right' width="70px;">Bonus</td>
                                                <td align='right' width="70px;">OT</td>
                                                <td align='right' width="70px;">Total Gross</td>


                                                <td align='right' width="70px;">EPF</td>
                                                <td align='right' width="70px;">ESIC</td>
                                                <td align='right' width="70px;">Canteen</td>
                                                <td align='right' width="70px;">Breakfast</td>
                                                <td align='right' width="70px;">Transport</td>
                                                <td align='right' width="70px;">Advance</td>
                                                
                                                <td align='right' width="70px;">Net Pay</td>
											</tr>
											
											<?php 
											for($j=$form_month;$j<=$to_month;$j++)
											{
												if($j==1){$last_day_of_month=31;}
												elseif($j==2){$last_day_of_month=29;}
												elseif($j==3){$last_day_of_month=31;}
												elseif($j==4){$last_day_of_month=30;}
												elseif($j==5){$last_day_of_month=31;}
												elseif($j==6){$last_day_of_month=30;}
												elseif($j==7){$last_day_of_month=31;}
												elseif($j==8){$last_day_of_month=31;}
												elseif($j==9){$last_day_of_month=30;}
												elseif($j==10){$last_day_of_month=31;}
												elseif($j==11){$last_day_of_month=30;}
												elseif($j==12){$last_day_of_month=31;}
												
												
												$test = new DateTime("1-$j-$year2");
												$month= date_format($test, 'M');
												$from_date = date_format($test, 'Y-m-d');
												$to_date = date_format($test, 'Y-m-t');
												
												//geting data from attendance table
												$query=" SELECT * FROM daily_attendance_monthly where emp_code='$emp_code'  and att_year='$year2' and att_month='$j' ";
												$out=$this->Mymodel->query1($query);

												?>
												<tr style="height:10px; ">
												  	<td><?php echo $month;?></td>

												  	<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['total_present'])){ echo $a12[] = $out[0]['total_present'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['total_ot'])){ echo $a13[] = $out[0]['total_ot'];}?></span></td>
													
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['basic_salary_payable'])){ echo $a14[] = $out[0]['basic_salary_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['hra_payable'])){ echo $a15[] = $out[0]['hra_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['conv_payable'])){ echo $a16[] = $out[0]['conv_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['city_comp_payable'])){ echo $a17[] = $out[0]['city_comp_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['other_allow_payable'])){ echo $a18[] = $out[0]['other_allow_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['spl_pay_payable'])){ echo $a19[] = $out[0]['spl_pay_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['medi_rem_payable'])){ echo $a20[] = $out[0]['medi_rem_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['fuel_reimb_payable'])){ echo $a21[] = $out[0]['fuel_reimb_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_attendance_all_payable'])){ echo $a22[] = $out[0]['get_attendance_all_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['bonus_payable'])){ echo $a23[] = $out[0]['bonus_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['total_ot_rs'])){ echo $a24[] = $out[0]['total_ot_rs'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['current_ctc_payable'])){ echo $a25[] = $out[0]['current_ctc_payable'];}?></span></td>
													

													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['epf_payable'])){ echo $a26[] = $out[0]['epf_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['esic_payable'])){ echo $a27[] = $out[0]['esic_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_canteen_payable'])){ echo $a28[] = $out[0]['lost_canteen_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_breakfast_payable'])){ echo $a29[] = $out[0]['lost_breakfast_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_bus_payable'])){ echo $a30[] = $out[0]['lost_bus_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px; "><?php //if(isset($out[0]['current_ctc_payable'])){ echo $a31[] = $out[0]['current_ctc_payable'];}?></span></td>
													<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['current_total_ctc_payable'])){ echo $a32[] = $out[0]['current_total_ctc_payable'];}?></span></td>
													
												  
												  
												</tr>
											 <?php
											}//for
											
											?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close





		
	// emp_training_all_report
	function emp_training_all_report($color,$column_length,$emp_id)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Training Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
											<tr>
												<th>#</th>
												<th>Date</th>
                                                <th>Name</th>
                                                <th>Result</th>
												<th>Marks</th>
                                                <th>Score</th>
												<th>Remarks</th>
												<th>Photo</th>
											</tr>
											
											<?php 
												$query=" SELECT 
													A.level_id,A.emp_id,A.exam_date,A.exam_level,A.exam_result,A.exam_marks,A.exam_remarks,A.exam_photo,
													B.name as bname
													FROM emp_training_exam as A 
													LEFT JOIN emp_training_list as B ON B.emp_training_table1_id = A.exam_level
													WHERE  A.emp_id='$emp_id' ORDER BY exam_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $o)
												{
													$test = new DateTime($o['exam_date']);
													$exam_date= date_format($test, 'd-M-Y');
													
													if($o['exam_marks'] >= 90){$chat_color = "success";}
													elseif($o['exam_marks'] < 90 and $o['exam_marks'] >= 75){$chat_color = "info";}
													elseif($o['exam_marks'] < 75 and $o['exam_marks'] >= 60){$chat_color = "warning";}
													else{$chat_color = "danger";}
												?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $exam_date;?></td>
														<td><?php echo $o['bname'];?></td>
														<td><?php echo $o['exam_result'];?></td>
														<td><?php echo $o['exam_marks'];?></td>
														<td style="width:200px; "> 
															<div class="progress progress">
																<div class="progress-bar progress-bar-<?php echo $chat_color;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $o['exam_marks'];?>%"><?php echo $o['exam_marks'];?>
																</div>
															</div>
                                                      	</td>
														<td><?php echo $o['exam_remarks'];?></td>
														<td>
														<?php 
															if(strlen($o['exam_photo'])>0)
															{
															?>				
																<a target="_blank" href="<?php echo base_url().$o['exam_photo'];?>">View</a>
															<?php 
															}
															else
															{
																echo " ";
															}
															?>  
														</td>
														
													</tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close




	// emp_level_training_all_report
	function emp_level_training_all_report($color,$column_length,$emp_id)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Level Training Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
											<tr>
												<th>#</th>
												<th>Date</th>
                                                <th>Level</th>
                                                <th>Result</th>
												<th>Marks</th>
                                                <th>Score</th>
												<th>Remarks</th>
												<th>Photo</th>
											</tr>
											
											<?php 
												$query=" SELECT 
													A.level_id,A.emp_id,A.exam_date,A.exam_level,A.exam_result,A.exam_marks,A.exam_remarks,A.exam_photo
													FROM emp_level_exam as A 
													WHERE  A.emp_id='$emp_id' ORDER BY exam_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $o)
												{
													$test = new DateTime($o['exam_date']);
													$exam_date= date_format($test, 'd-M-Y');
													
													if($o['exam_marks'] >= 90){$chat_color = "success";}
													elseif($o['exam_marks'] < 90 and $o['exam_marks'] >= 75){$chat_color = "info";}
													elseif($o['exam_marks'] < 75 and $o['exam_marks'] >= 60){$chat_color = "warning";}
													else{$chat_color = "danger";}
												?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $exam_date;?></td>
														<td> Level - <?php echo $o['exam_level'];?></td>
														<td><?php echo $o['exam_result'];?></td>
														<td><?php echo $o['exam_marks'];?></td>
														<td style="width:200px; "> 
															<div class="progress progress">
																<div class="progress-bar progress-bar-<?php echo $chat_color;?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $o['exam_marks'];?>%"><?php echo $o['exam_marks'];?>
																</div>
															</div>
                                                      	</td>
														<td><?php echo $o['exam_remarks'];?></td>
														<td>
														<?php 
															if(strlen($o['exam_photo'])>0)
															{
															?>				
																<a target="_blank" href="<?php echo base_url().$o['exam_photo'];?>">View</a>
															<?php 
															}
															else
															{
																echo " ";
															}
															?>  
														</td>
													</tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close





		
	function emp_kaizen_all_report($color,$column_length,$emp_code)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Kaizen Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
												<tr>
                                                    <th>#</th>
                                                      <th>Date</th>
                                                      <th>Subject</th>
                                                      <th>Process</th>
                                                      <th>Location</th>
                                                     
                                                      <th>Condition</th>
                                                      <th>Solution</th>
                                                      <th>Category</th>
                                                      <th>Benefits</th>
                                                      
                                                      <th>Originated</th>
                                                      <th>Validated</th>
                                                      <th>Approved</th>
                                                      <th>Contact_details</th>
                                                      
                                                      <th>Team_member</th>
                                                      <th>Implementation_date</th>
                                                      <th>Date_of_comp</th>
                                                      <th>Remarks</th>
                                                      <th>Status</th>
                                                </tr>
											
											<?php 
												$query=" SELECT * FROM emp_kaizen WHERE  emp_id='$emp_code' ORDER BY entry_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $r)
												{
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');	
													
													$test = new DateTime($r['implementation_date']);
													$implementation_date= date_format($test, 'd-m-Y');	
													
													$test = new DateTime($r['date_of_comp']);
													$date_of_comp= date_format($test, 'd-m-Y');	
													
												  
											   ?>
												  <tr>
													  <td><?php echo $i;?>.</td>
													  <td><?php echo $entry_date;?></td>
													 
													  <td><?php if(isset($r['subject']))echo $r['subject'];?></td>
													  <td><?php if(isset($r['process1']))echo $r['process1'];?></td>
													  <td><?php if(isset($r['location']))echo $r['location'];?></td>
													  
													  <td><?php if(isset($r['condition']))echo $r['condition'];?></td>
													  <td><?php if(isset($r['solution']))echo $r['solution'];?></td>
													  <td><?php if(isset($r['benefits']))echo $r['benefits'];?></td>
													  <td><?php if(isset($r['benefits2']))echo $r['benefits2'];?></td>
													  
													  <td><?php if(isset($r['originated']))echo $r['originated'];?></td>
													  <td><?php if(isset($r['validated']))echo $r['validated'];?></td>
													  <td><?php if(isset($r['approved']))echo $r['approved'];?></td>
													  <td><?php if(isset($r['contact_details']))echo $r['contact_details'];?></td>
													  
													  <td><?php if(isset($r['team_member']))echo $r['team_member'];?></td>
													  <td><?php echo $implementation_date;?></td>
													  <td><?php echo $date_of_comp;?></td>
													  <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
													  <td><?php if(isset($r['status'])){  if($r['status']==1){echo "R";}else{echo "A";}   }?></td>
							  
												  </tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close



	function emp_suggestion_all_report($color,$column_length,$emp_code)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Suggestion Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
												<tr>
                                                    <th>#</th>
                                                      <th>Date</th>
                                                      <th>Subject</th>
                                                      <th>Process</th>
                                                      <th>Location</th>
                                                     
                                                      <th>Condition</th>
                                                      <th>Solution</th>
                                                      <th>Category</th>
                                                      <th>Benefits</th>
                                                      
                                                      <th>Originated</th>
                                                      <th>Validated</th>
                                                      <th>Approved</th>
                                                      <th>Contact_details</th>
                                                      
                                                      <th>Team_member</th>
                                                      <th>Implementation_date</th>
                                                      <th>Date_of_comp</th>
                                                      <th>Remarks</th>
                                                      <th>Status</th>
                                                </tr>
											
											<?php 
												$query=" SELECT * FROM emp_suggestion WHERE  emp_id='$emp_code' ORDER BY entry_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $r)
												{
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');	
													
													$test = new DateTime($r['implementation_date']);
													$implementation_date= date_format($test, 'd-m-Y');	
													
													$test = new DateTime($r['date_of_comp']);
													$date_of_comp= date_format($test, 'd-m-Y');	
													
												  
											   ?>
												  <tr>
													  <td><?php echo $i;?>.</td>
													  <td><?php echo $entry_date;?></td>
													 
													  <td><?php if(isset($r['subject']))echo $r['subject'];?></td>
													  <td><?php if(isset($r['process1']))echo $r['process1'];?></td>
													  <td><?php if(isset($r['location']))echo $r['location'];?></td>
													  
													  <td><?php if(isset($r['condition']))echo $r['condition'];?></td>
													  <td><?php if(isset($r['solution']))echo $r['solution'];?></td>
													  <td><?php if(isset($r['benefits']))echo $r['benefits'];?></td>
													  <td><?php if(isset($r['benefits2']))echo $r['benefits2'];?></td>
													  
													  <td><?php if(isset($r['originated']))echo $r['originated'];?></td>
													  <td><?php if(isset($r['validated']))echo $r['validated'];?></td>
													  <td><?php if(isset($r['approved']))echo $r['approved'];?></td>
													  <td><?php if(isset($r['contact_details']))echo $r['contact_details'];?></td>
													  
													  <td><?php if(isset($r['team_member']))echo $r['team_member'];?></td>
													  <td><?php echo $implementation_date;?></td>
													  <td><?php echo $date_of_comp;?></td>
													  <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
													  <td><?php if(isset($r['status'])){  if($r['status']==1){echo "R";}else{echo "A";}   }?></td>
							  
												  </tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close





	function emp_complaint_all_report($color,$column_length,$emp_code)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Complaint Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
												<tr>
													<th>#</th>
                                                      <th>Date</th>
                                                      <th>Employee</th>
                                                      <th>Name</th>
                                                      <th>Department</th>
                                                      <th>type_of_comp</th>
                                                      <th>offenses</th>
                                                      <th>offenses2</th>
                                                      <th>infraction</th>
                                                      <th>improvement</th>
                                                      <th>cons</th>
                                                      
                                                      <th>Supervisor</th>
                                                      <th>HOD</th>
                                                      <th>HR</th>
                                                      <th>Plant Head</th>
                                                </tr>
											
											<?php 
												$query=" SELECT * FROM emp_complaint WHERE  emp_id='$emp_code' ORDER BY entry_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $r)
												{
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');	
													
													
												?>
													<tr>
														<td><?php echo $i;?>.</td>
														<td><?php echo $entry_date;?></td>
														<td><?php if(isset($r['emp_id']))echo $r['emp_id'];?></td>
														<td><?php if(isset($r['emp_name']))echo $r['emp_name'];?></td>

														<td><?php if(isset($r['emp_dept']))echo $r['emp_dept'];?></td>
														
														<td><?php if(isset($r['type_of_comp']))echo $r['type_of_comp'];?></td>
														<td><?php if(isset($r['offenses']))echo $r['offenses'];?></td>
														<td><?php if(isset($r['offenses2']))echo $r['offenses2'];?></td>
														
														<td><?php if(isset($r['infraction']))echo $r['infraction'];?></td>
														<td><?php if(isset($r['improvement']))echo $r['improvement'];?></td>
														<td><?php if(isset($r['cons']))echo $r['cons'];?></td>
														
														
														<td><?php if(isset($r['sign_supervisor']))echo $r['sign_supervisor'];?></td>
														<td><?php if(isset($r['sign_dept_hod']))echo $r['sign_dept_hod'];?></td>
														<td><?php if(isset($r['sign_hr']))echo $r['sign_hr'];?></td>
														<td><?php if(isset($r['sign_plant_head']))echo $r['sign_plant_head'];?></td>

													</tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close


	function emp_fine_all_report($color,$column_length,$emp_code)
    {
		?>       
                 <div class="col-md-<?php echo $column_length;?>">
                            <div class="panel panel-<?php echo $color;?>">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                    	Your Fine Report
                                    </h3>
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
												<tr>
														<th>#</th>
                                                      <th>Date</th>
                                                      <th>Employee</th>
                                                      <th>Name</th>
                                                      <th>Department</th>
                                                      <th>type_of_comp</th>
                                                      <th>Subject</th>
                                                     
                                                      <th>infraction</th>
                                                      <th>improvement</th>
                                                      <th>Amt</th>
                                                      <th>Remarks</th>
                                                      
                                                      <th>Supervisor</th>
                                                      <th>HOD</th>
                                                      <th>HR</th>
                                                      <th>Plant Head</th>
                                                </tr>
											
												<?php 
												$query=" SELECT * FROM emp_fine WHERE  emp_id='$emp_code' ORDER BY entry_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $r)
												{
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');	
												?>
													<tr>
														<td><?php echo $i;?>.</td>
														<td><?php echo $entry_date;?></td>
														<td><?php if(isset($r['emp_id']))echo $r['emp_id'];?></td>
														<td><?php if(isset($r['emp_name']))echo $r['emp_name'];?></td>
														<td><?php if(isset($r['emp_dept']))echo $r['emp_dept'];?></td>
														<td><?php if(isset($r['type_of_comp']))echo $r['type_of_comp'];?></td>
														<td><?php if(isset($r['subject']))echo $r['subject'];?></td>
														<td><?php if(isset($r['infraction']))echo $r['infraction'];?></td>
														<td><?php if(isset($r['improvement']))echo $r['improvement'];?></td>
														<td><?php if(isset($r['amt']))echo $r['amt'];?></td>
														<td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
														<td><?php if(isset($r['sign_supervisor']))echo $r['sign_supervisor'];?></td>
														<td><?php if(isset($r['sign_dept_hod']))echo $r['sign_dept_hod'];?></td>
														<td><?php if(isset($r['sign_hr']))echo $r['sign_hr'];?></td>
														<td><?php if(isset($r['sign_plant_head']))echo $r['sign_plant_head'];?></td>
													</tr>
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close




		function emp_accident_all_report($color,$column_length,$emp_code)
		{
			?>       
					 <div class="col-md-<?php echo $column_length;?>">
								<div class="panel panel-<?php echo $color;?>">
									<div class="panel-heading">
										<h3 class="panel-title">
											Your Accident Report
										</h3>
									   
									</div>
									<div class="panel-body">
									<div class="table-responsive" style="margin-top:10px;">
										<table  border="1" width="100%">
													<tr>
													  <th>#</th>
                                                      <th>Date</th>
                                                      <th>Time</th>
                                                      <th>Employee</th>
                                                      <th>Name</th>
                                                      <th>Department</th>
                                                      <th>type_of_comp</th>
                                                      <th>Loaction</th>
                                                      <th>Dept.</th>
                                                      <th>Infraction</th>
                                                      <th>Medical</th>
                                                      <th>improvement</th>
                                                      <th>Remarks</th>
                                                      <th>Supervisor</th>
                                                      <th>HOD</th>
                                                      <th>HR</th>
                                                      <th>Plant Head</th>
													</tr>
												
												<?php 
													$query=" SELECT * FROM emp_accident WHERE  emp_id='$emp_code' ORDER BY entry_date ASC";
													$out=$this->Mymodel->query1($query);
													$i=1;
													foreach($out as $r)
													{
														$test = new DateTime($r['entry_date']);
														$entry_date= date_format($test, 'd-m-Y');	
														
														$test = new DateTime($r['entry_time']);
														$entry_time= date_format($test, 'h:i:s a');
													  
												   ?>
													  	<tr>
														  <td><?php echo $i;?>.</td>
														  <td><?php echo $entry_date;?></td>
														  <td><?php echo $entry_time;?></td>
														  <td><?php if(isset($r['emp_id']))echo $r['emp_id'];?></td>
														  <td><?php if(isset($r['emp_name']))echo $r['emp_name'];?></td>
								  						  <td><?php if(isset($r['emp_dept']))echo $r['emp_dept'];?></td>
														  <td><?php if(isset($r['type_of_comp']))echo $r['type_of_comp'];?></td>
														  <td><?php if(isset($r['location']))echo $r['location'];?></td>
														  <td><?php if(isset($r['accident_dept']))echo $r['accident_dept'];?></td>
														  <td><?php if(isset($r['infraction']))echo $r['infraction'];?></td>
														  <td><?php if(isset($r['medical']))echo $r['medical'];?></td>
														  <td><?php if(isset($r['improvement']))echo $r['improvement'];?></td>
														  <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
														  <td><?php if(isset($r['sign_supervisor']))echo $r['sign_supervisor'];?></td>
														  <td><?php if(isset($r['sign_dept_hod']))echo $r['sign_dept_hod'];?></td>
														  <td><?php if(isset($r['sign_hr']))echo $r['sign_hr'];?></td>
														  <td><?php if(isset($r['sign_plant_head']))echo $r['sign_plant_head'];?></td>
								  						</tr>
													<?php
													$i++;
													}//for
													?>
											
											</table>
										</div>
									</div>
								</div>
					</div>    
			<?php 
			}//function close





			function emp_gatepass_all_report($color,$column_length,$emp_code,$year)
			{
				?>       
						 <div class="col-md-<?php echo $column_length;?>">
									<div class="panel panel-<?php echo $color;?>">
										<div class="panel-heading">
											<h3 class="panel-title">
												Your Gate Pass Report 
											</h3>
										   
										</div>
										<div class="panel-body">
										<div class="table-responsive" style="margin-top:10px;">
											<table  border="1" width="100%">
														<tr>
															<th>#</th>
															<th>Date</th>
															<th>Employee</th>
															<th>Name</th>
															<th>Department</th>
															<th>Reason For</th>
															<th>Reason</th>
															<th>Vehical</th>
															<th>K.M Start</th>
															<th>K.M End</th>
															<th>K.M Diff</th>
															<th>Time Out</th>
															<th>Time In</th>
															<th>Time Taken</th>
															<th>Supervisor</th>
															<th>HOD</th>
															<th>HR</th>
															<th>Plant Head</th>
															<th>Status</th>
															
                                                     
														</tr>
													
													<?php 
														$query=" SELECT * FROM emp_gatepass WHERE  emp_id='$emp_code'   ORDER BY entry_date ASC";
														$out=$this->Mymodel->query1($query);
														$i=1;
														foreach($out as $r)
														{
															$test = new DateTime($r['entry_date']);
															$entry_date= date_format($test, 'd-m-Y');	
															
															
														?>
															<tr>
																<td><?php echo $i;?>.</td>
																<td><?php echo $entry_date;?></td>
																<td><?php if(isset($r['emp_id']))echo $r['emp_id'];?></td>
																<td><?php if(isset($r['emp_name']))echo $r['emp_name'];?></td>

																<td><?php if(isset($r['emp_dept']))echo $r['emp_dept'];?></td>
																<td><?php if(isset($r['reason_for']))echo $r['reason_for'];?></td>
																<td><?php if(isset($r['reason']))echo $r['reason'];?></td>
																<td><?php if(isset($r['vehical_if']))echo $r['vehical_if'];?></td>
																
																<td><?php if(isset($r['km_start']))echo $r['km_start'];?></td>
																<td><?php if(isset($r['km_return']))echo $r['km_return'];?></td>
																<td><?php if(isset($r['km_diff']))echo $r['km_diff'];?></td>
																
																<td><?php if(isset($r['time_out']))echo $r['time_out'];?></td>
																<td><?php if(isset($r['time_in']))echo $r['time_in'];?></td>
																<td><?php if(isset($r['time_diff']))echo $r['time_diff'];?></td>
																
																<td><?php if(isset($r['sign_supervisor']))echo $r['sign_supervisor'];?></td>
																<td><?php if(isset($r['sign_dept_hod']))echo $r['sign_dept_hod'];?></td>
																<td><?php if(isset($r['sign_hr']))echo $r['sign_hr'];?></td>
																<td><?php if(isset($r['sign_plant_head']))echo $r['sign_plant_head'];?></td>

																<td><?php if(isset($r['status'])){  if($r['status']==1){echo "R";}else{echo "A";}   }?></td>
																
															
															</tr>
														<?php
														$i++;
														}//for
														?>
												
												</table>
											</div>
										</div>
									</div>
						</div>    
				<?php 
				}//function close
		


	function emp_leave_all_report($color,$column_length,$emp_code,$year)
	{
		?>       
					<div class="col-md-<?php echo $column_length;?>">
							<div class="panel panel-<?php echo $color;?>">
								<div class="panel-heading">
									<h3 class="panel-title">
										Your leave Form Report 
									</h3>
									
								</div>
								<div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<table  border="1" width="100%">
												<tr>
													<th>#</th>
                                                      <th>Apply Date</th>
                                                      <th>Employee</th>
                                                      <th>Name</th>
                                                      <th>Department</th>
                                                      <th>Reason For</th>
                                                      <th>Reason</th>
                                                      
                                                      <th>Total Days</th>
                                                      <th>From</th>
                                                      <th>To</th>
                                                      <th>S.L</th>
                                                      <th>C.L</th>
                                                      <th>E.L</th>
                                                      <th>P.L</th>
                                                      <th>Address on Leave</th>
                                                      
                                                      <th>Supervisor</th>
                                                      <th>HOD</th>
                                                      <th>HR</th>
                                                      <th>Plant Head</th>
                                                      <th>Status</th>
													
												
												</tr>
											
											<?php 
												$query=" SELECT * FROM emp_leave WHERE  emp_id='$emp_code'   ORDER BY entry_date ASC";
												$out=$this->Mymodel->query1($query);
												$i=1;
												foreach($out as $r)
												{
													$test = new DateTime($r['entry_date']);
													$entry_date= date_format($test, 'd-m-Y');	

													$test = new DateTime($r['from_date']);
													$from_date= date_format($test, 'd-m-Y');	

													$test = new DateTime($r['to_date']);
													$to_date= date_format($test, 'd-m-Y');	
													
													
												?>
													<tr>
														<td><?php echo $i;?>.</td>
														<td><?php echo $entry_date;?></td>
														<td><?php if(isset($r['emp_id']))echo $r['emp_id'];?></td>
														<td><?php if(isset($r['emp_name']))echo $r['emp_name'];?></td>

														<td><?php if(isset($r['emp_dept']))echo $r['emp_dept'];?></td>
														<td><?php if(isset($r['reason_for']))echo $r['reason_for'];?></td>
														<td><?php if(isset($r['reason']))echo $r['reason'];?></td>
														
														<td><?php if(isset($r['total_days']))echo $r['total_days'];?></td>
														<td><?php echo $from_date;?></td>
														<td><?php echo $to_date;?></td>
														
														<td><?php if(isset($r['no_of_sl']))echo $r['no_of_sl'];?></td>
														<td><?php if(isset($r['no_of_cl']))echo $r['no_of_cl'];?></td>
														<td><?php if(isset($r['no_of_el']))echo $r['no_of_el'];?></td>
														<td><?php if(isset($r['no_of_pl']))echo $r['no_of_pl'];?></td>
														<td><?php if(isset($r['address_on_leave']))echo $r['address_on_leave'];?></td>
														
														<td><?php if(isset($r['sign_supervisor']))echo $r['sign_supervisor'];?></td>
														<td><?php if(isset($r['sign_dept_hod']))echo $r['sign_dept_hod'];?></td>
														<td><?php if(isset($r['sign_hr']))echo $r['sign_hr'];?></td>
														<td><?php if(isset($r['sign_plant_head']))echo $r['sign_plant_head'];?></td>
														<td><?php if(isset($r['status'])){  if($r['status']==1){echo "R";}else{echo "A";}   }?></td>
														
													
													</tr>
               
												<?php
												$i++;
												}//for
												?>
										
										</table>
									</div>
								</div>
							</div>
				</div>    
		<?php 
		}//function close



	function get_dept_production($m,$dept,$emp_code)
	{
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-t");
		
		if($dept == 'wet')
		{
			$query = " SELECT sum(qty) as nos FROM wet_mc_production WHERE op_name = '$emp_code' and  entry_date between '$firstday' and '$lastday2' "; 
		}
		elseif($dept == 'spooling')
		{
			$query = " SELECT sum(qty_kg) as nos FROM spooling WHERE op_name = '$emp_code' and  entry_date between '$firstday' and '$lastday2' "; 
		}
		elseif($dept == 'rope')
		{
			$query = " SELECT sum(total_qty_mtr) as nos FROM rope_mc_production WHERE op_name = '$emp_code' and  entry_date between '$firstday' and '$lastday2' "; 
		}
		elseif($dept == 'rewinding')
		{
			$query = " SELECT sum(total_qty_mtr) as nos FROM fg_production WHERE op_name = '$emp_code' and  entry_date between '$firstday' and '$lastday2' "; 
		}
		
		else
		{
			$query = "";
		}
		
		$out = $this->Mymodel->query1($query);
		return round($out[0]['nos']);
	}//function close


		
	
	//------------------------------------------------35
	function emp_production_monthly_eff($div_length,$div_background_color,$height,$width,$emp_code)
	{
		$query = " SELECT * FROM employee WHERE emp_code = '$emp_code' ";
		$out=$this->Mymodel->query1($query);
		$department_id = $out[0]['department_id'];

		if($department_id == 5 or $department_id == 6)
		{
			//wetblock
			$dept_name = "Wet Block Production in kg. ";
			$d1 = $this->Dashbord->get_dept_production('01','wet',$emp_code);
			$d2 = $this->Dashbord->get_dept_production('02','wet',$emp_code);
			$d3 = $this->Dashbord->get_dept_production('03','wet',$emp_code);
			$d4 = $this->Dashbord->get_dept_production('04','wet',$emp_code);
			$d5 = $this->Dashbord->get_dept_production('05','wet',$emp_code);
			$d6 = $this->Dashbord->get_dept_production('06','wet',$emp_code);
			$d7 = $this->Dashbord->get_dept_production('07','wet',$emp_code);
			$d8 = $this->Dashbord->get_dept_production('08','wet',$emp_code);
			$d9 = $this->Dashbord->get_dept_production('09','wet',$emp_code);
			$d10 = $this->Dashbord->get_dept_production('10','wet',$emp_code);
			$d11 = $this->Dashbord->get_dept_production('11','wet',$emp_code);
			$d12 = $this->Dashbord->get_dept_production('12','wet',$emp_code);
		}
		elseif($department_id == 14)
		{
			//spooling
			$dept_name = "Spooling Production in kg.";
			$d1 = $this->Dashbord->get_dept_production('01','spooling',$emp_code);
			$d2 = $this->Dashbord->get_dept_production('02','spooling',$emp_code);
			$d3 = $this->Dashbord->get_dept_production('03','spooling',$emp_code);
			$d4 = $this->Dashbord->get_dept_production('04','spooling',$emp_code);
			$d5 = $this->Dashbord->get_dept_production('05','spooling',$emp_code);
			$d6 = $this->Dashbord->get_dept_production('06','spooling',$emp_code);
			$d7 = $this->Dashbord->get_dept_production('07','spooling',$emp_code);
			$d8 = $this->Dashbord->get_dept_production('08','spooling',$emp_code);
			$d9 = $this->Dashbord->get_dept_production('09','spooling',$emp_code);
			$d10 = $this->Dashbord->get_dept_production('10','spooling',$emp_code);
			$d11 = $this->Dashbord->get_dept_production('11','spooling',$emp_code);
			$d12 = $this->Dashbord->get_dept_production('12','spooling',$emp_code);
		}
		elseif($department_id == 11 or $department_id == 12 or $department_id == 8 or $department_id == 17 )
		{
			//rope
			$dept_name = "Rope Core / Standing / Extruder / Production in mtr.";
			$d1 = $this->Dashbord->get_dept_production('01','rope',$emp_code);
			$d2 = $this->Dashbord->get_dept_production('02','rope',$emp_code);
			$d3 = $this->Dashbord->get_dept_production('03','rope',$emp_code);
			$d4 = $this->Dashbord->get_dept_production('04','rope',$emp_code);
			$d5 = $this->Dashbord->get_dept_production('05','rope',$emp_code);
			$d6 = $this->Dashbord->get_dept_production('06','rope',$emp_code);
			$d7 = $this->Dashbord->get_dept_production('07','rope',$emp_code);
			$d8 = $this->Dashbord->get_dept_production('08','rope',$emp_code);
			$d9 = $this->Dashbord->get_dept_production('09','rope',$emp_code);
			$d10 = $this->Dashbord->get_dept_production('10','rope',$emp_code);
			$d11 = $this->Dashbord->get_dept_production('11','rope',$emp_code);
			$d12 = $this->Dashbord->get_dept_production('12','rope',$emp_code);
		}
		elseif($department_id == 13 )
		{
			//rope
			$dept_name = "Rewinding Production in mtr.";
			$d1 = $this->Dashbord->get_dept_production('01','rewinding',$emp_code);
			$d2 = $this->Dashbord->get_dept_production('02','rewinding',$emp_code);
			$d3 = $this->Dashbord->get_dept_production('03','rewinding',$emp_code);
			$d4 = $this->Dashbord->get_dept_production('04','rewinding',$emp_code);
			$d5 = $this->Dashbord->get_dept_production('05','rewinding',$emp_code);
			$d6 = $this->Dashbord->get_dept_production('06','rewinding',$emp_code);
			$d7 = $this->Dashbord->get_dept_production('07','rewinding',$emp_code);
			$d8 = $this->Dashbord->get_dept_production('08','rewinding',$emp_code);
			$d9 = $this->Dashbord->get_dept_production('09','rewinding',$emp_code);
			$d10 = $this->Dashbord->get_dept_production('10','rewinding',$emp_code);
			$d11 = $this->Dashbord->get_dept_production('11','rewinding',$emp_code);
			$d12 = $this->Dashbord->get_dept_production('12','rewinding',$emp_code);
		}
		else
		{
			$dept_name = " ";
		}
		
		
		?>
							<div class="col-md-<?php echo $div_length;?>">
											<div class="panel panel-<?php echo $div_background_color;?>">
												<div class="panel-heading">
												<h3 class="panel-title">
													<?php echo $dept_name;?> 
												</h3>
												
												</div>
												<div class="panel-body">
													<div>
														<canvas id="chart51" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></canvas>
													</div>
												</div>
											</div>
								</div>
						

					
						
						<script>
						
							var ctx51 = document.getElementById("chart51").getContext("2d");
								var data51 = {
									labels: [ 
												"January", 
												"February", 
												"March", 
												"April", 
												"May", 
												"June", 
												"July", 
												"August", 
												"September", 
												"October", 
												"November", 
												"December"  
											],
									datasets: [
										{
											label: "My Second dataset",
											fillColor: "rgba(255,255,0,0.5)",
											strokeColor: "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data: [
														<?php if(!empty($d1)){echo $d1;}else{echo 0;}?>,
														<?php if(!empty($d2)){echo $d2;}else{echo 0;}?>,
														<?php if(!empty($d3)){echo $d3;}else{echo 0;}?>,
														<?php if(!empty($d4)){echo $d4;}else{echo 0;}?>,
														<?php if(!empty($d5)){echo $d5;}else{echo 0;}?>,
														<?php if(!empty($d6)){echo $d6;}else{echo 0;}?>,
														<?php if(!empty($d7)){echo $d7;}else{echo 0;}?>,
														<?php if(!empty($d8)){echo $d8;}else{echo 0;}?>,
														<?php if(!empty($d9)){echo $d9;}else{echo 0;}?>,
														<?php if(!empty($d10)){echo $d10;}else{echo 0;}?>,
														<?php if(!empty($d11)){echo $d11;}else{echo 0;}?>,
														<?php if(!empty($d12)){echo $d12;}else{echo 0;}?>

												]
										}
									]
								};
								
							var myBar = new Chart(ctx51).Bar(data51, {
									showTooltips: false,
									onAnimationComplete: function () {
								
										var ctx = this.chart.ctx;
										ctx.font = this.scale.font;
										ctx.fillStyle = this.scale.textColor
										ctx.textAlign = "center";
										ctx.textBaseline = "bottom";
								
										this.datasets.forEach(function (dataset) {
											dataset.bars.forEach(function (bar) {
												ctx.fillText(bar.value, bar.x, bar.y - 5);
											});
										})
									}
								});

						
						</script>
		<?php
	}//function close


	function get_calendar_data($emp_id,$where)
	{
		$query = " SELECT * FROM task_planning WHERE   (save_by = '$emp_id' OR  resp like  '%~$emp_id%')       $where ";
		return $out=$this->Mymodel->query1($query);
	}//function close

	//------------------------------------------------dashbord / calendar
	function calender_view($box_length1,$box_length2,$no_of_div,$other)
	{
		//getting data
		$emp_id=$this->session->userdata('emp_id');
		$where = " GROUP BY id ORDER BY entry_date DESC ";
		$res = $this->Dashbord->get_calendar_data($emp_id,$where);
		$no = count($res);

		//$bday = $this->Dashbord->get_birthday_today('Yes',date('Y-m-01'),date('Y-m-t'));
		//$remind = $this->Dashbord->get_self_reminder_today('Yes',date('Y-01-01'),date('Y-12-t'));
		//$mom = $this->Dashbord->get_mom_today('Yes',date('Y-01-01'),date('Y-12-t'));
		
		//print_r($bday);
		
		?>
					<div class="col-md-<?php echo $box_length1;?>" style="border:solid 1px " >
						<div id="calendar"></div>
					</div>
					<!-- Javascripts -->
					<script>
						$(document).ready(function() {
							var date = new Date();
							var day = date.getDate();
							var month = date.getMonth();
							var year = date.getFullYear();
							
							$('#calendar').fullCalendar({
							
									header: {
										left: 'prev,next today',
										center: 'title',
										right: 'month,agendaWeek,agendaDay'
									},
									editable: false, // True
									droppable: false, // True this allows things to be dropped onto the calendar
									eventLimit: true, // allow "more" link when too many events
									eventColor: '#378006',
									overlap: true,
									
									events: [
												<?php 
												//b'day
												foreach($bday as $b)
												{
													if(!empty($b['dob_m']) and $b['dob_m']>0)
													{
														$start_date_y = date('Y'); 
														$start_date_m = ($b['dob_m']-1); 
														$start_date_d = $b['dob_d'];  
													?>
														{
															title: 'B`day: <?php echo $b['name'].':'.$b['emp_code'];  ?>',
															start: new Date(<?php echo $start_date_y.','.$start_date_m.','.$start_date_d;?>),
															color: 'pink',
														},
													<?php
													}
												}//foreach
												/*
												//remind
												foreach($remind as $b)
												{
													if(!empty($b['event_date']))
													{
														$test = new DateTime($b['event_date']);
														$start_date_y = date_format($test, 'Y'); 
														$start_date_m = date_format($test, 'm')-1; 
														$start_date_d = date_format($test, 'd'); 
													?>
														{
															title: 'R: <?php echo $b['subject'];  ?>',
															start: new Date(<?php echo $start_date_y.','.$start_date_m.','.$start_date_d;?>),
															color: 'brown',
														},
													<?php
													}
												}//foreach

												//mom
												foreach($mom as $b)
												{
													if(!empty($b['target_date']))
													{
														$test = new DateTime($b['target_date']);
														$start_date_y = date_format($test, 'Y'); 
														$start_date_m = date_format($test, 'm')-1; 
														$start_date_d = date_format($test, 'd'); 
													?>
														{
															title: 'M: <?php echo $b['review'];  ?>',
															start: new Date(<?php echo $start_date_y.','.$start_date_m.','.$start_date_d;?>),
															color: 'purple',
														},
													<?php
													}
												}//foreach
												*/

												for($i=0;$i<$no;$i++)
												{
													//start date
													if(!empty($res[$i]['entry_date']))
													{
														$test = new DateTime($res[$i]['entry_date']);
														$start_date_y = date_format($test, 'Y'); 
														$start_date_m = date_format($test, 'm')-1; 
														$start_date_d = date_format($test, 'd');  
													}
													else
													{
														$start_date_y = date('Y');
														$start_date_m = date('m');
														$start_date_d = date('d');
													}
													//due date
													if(!empty($res[$i]['due_date']))
													{
														$test = new DateTime($res[$i]['due_date']);
														$end_date_y = date_format($test, 'Y'); 
														$end_date_m = date_format($test, 'm')-1; 
														$end_date_d = date_format($test, 'd');  
													}
													else
													{
														$end_date_y = date('Y');
														$end_date_m = date('m');
														$end_date_d = date('d');
													}
													//color
													if(!empty($res[$i]['status']))
													{
														if($res[$i]['status'] == 1)
														{
															$status = "New";
															$color2 = "blue";
														}
														elseif($res[$i]['status'] == 2)
														{
															$status = "IP";
															$color2 = "orange";
														}
														elseif($res[$i]['status'] == 3)
														{
															$status = "Comp";
															$color2 = "green";
														}
														elseif($res[$i]['status'] == 4)
														{
															$status = "Can";
															$color2 = "red";
														}
														else
														{
															$status = "";
															$color2 = "";
														}
														
													}
													else{$status = "";$color2 = "";}

													


													//priority
													if(!empty($res[$i]['priority']))
													{
														if($res[$i]['priority'] == 'High')
														{
															$priority = "@";
															$color = "red";
														}
														elseif($res[$i]['priority'] == 'Medium')
														{
															$priority = "*";
															$color = "blue";
														}
														elseif($res[$i]['priority'] == 'Low')
														{
															$priority = "";
															$color = "black";
														}
														else
														{
															$priority = "";
														}
													}
													else{$priority = "";}


														?>
															{
																id: <?php if(!empty($res[$i]['id'])){echo $id = $res[$i]['id'];}else{echo $id = "";}?>,
																title: '<?php echo $priority.' '; echo "ID ".$id ; echo " "; if(!empty($res[$i]['tittle_name'])){echo $res[$i]['tittle_name'];}else{echo "";} ?>',
																start: new Date(<?php echo $start_date_y.','.$start_date_m.','.$start_date_d;?>),
																end: new Date(<?php echo $end_date_y.','.$end_date_m.','.$end_date_d;?>),
																color: '<?php echo $color2;?>',
																//url: 'http://google.com/',
															}
														<?php
															//putting , in last row
															if($i == $no-1){}else{echo ",";}
													
												}//for	
												?>
									],
									timeFormat: ' '
								});
							
						});
					</script>
  
					<?php 
					if($no_of_div == 2)
					{
					?>
					<style>
						#printed_table_div  tr:hover 
						{ 
							background-color: #ccc;
						}
						#out  tr:hover 
						{ 
							background-color: #ccc;
						}
					</style>
						<div class="col-md-<?php echo $box_length2;?>">
							<table border=1 style="width:100%" id='printed_table_div'>
								<tr style="background-color:#f2f2f2;color:black">
									<th>#</th>
									<th>ID</th>
									<th>Edit</th>
									<th>Status</th>
									<th>Priority</th>
									<th>Task Name</th>
									<th>Start Date</th>
									<th>Due Date</th>
									<th>Project</th>
									<th>Description</th>
									<th>Comp. Date</th>
									<th>Late</th>
									<th>Remarks</th>
									<th>Created By</th>
								</tr>
								<?php 
								$i=1;
								foreach($res as $r)
								{
									if(!empty($r['entry_date']))
									{
										$test = new DateTime($r['entry_date']);
										$start_date = date_format($test, 'd-m-Y'); 
									}else{ $start_date = "";}

									if(!empty($r['due_date']))
									{
										$test = new DateTime($r['due_date']);
										$due_date = date_format($test, 'd-m-Y'); 
									}else{ $due_date = "";}

									if(!empty($r['comp_date']) and $r['comp_date'] != '0000-00-00')
									{
										$test = new DateTime($r['comp_date']);
										$comp_date = date_format($test, 'd-m-Y'); 
									}else{ $comp_date = "";}

									//priority
									if(!empty($r['priority']))
									{
										if($r['priority'] == 'High')
										{
											$priority = "(@)";
										}
										elseif($r['priority'] == 'Medium')
										{
											$priority = "(*)";
										}
										elseif($r['priority'] == 'Low')
										{
											$priority = "";
										}
										else
										{
											$priority = "";
										}
									}
									else{$priority = "";}

									if(!empty($r['status']))
									{
										if($r['status'] == 1)
										{
											$color2 = "blue";
											$status = "New";
										}
										elseif($r['status'] == 2)
										{
											$status = "In Progress";
											$color2 = "orange";
										}
										elseif($r['status'] == 3)
										{
											$status = "Completed";
											$color2 = "green";
										}
										elseif($r['status'] == 4)
										{
											$status = "Cancel";
											$color2 = "red";
										}
										else
										{
											$status = "";
										}
										
									}
									else{$status = "";}

										//late
										if($r['comp_date'] == '0000-00-00'  and date('Y-m-d') > $r['due_date'] )
										{
											$status3 = "Late";
											$color3 = "background-color:gray;color:white;";
										}
										elseif($r['comp_date'] != '0000-00-00'   and $comp_date>$due_date)
										{
											$status3 = "Late";
											$color3 = "background-color:Black;color:white;";
										}
										else
										{
											$status3 = "";
											$color3 = "";	
										}

										
									//all resp person name
									$resp = explode("~",$r['resp']);
									?>
										<tr style="height;30px;">
											<td><?php echo $i;?></td>
											<td><?php echo $r['id'];?></td>
											<td> 
												<?php 
													//if emp id is in array he can update
													$emp_id=$this->session->userdata('emp_id');
													if(in_array($emp_id,$resp) or $r['save_by'] == $emp_id)
													{
													?>
													<button type="button" class="btn btn-default" data-toggle="modal" data-target="#taskEditModal" id="taskeditform_<?php echo $r['id']; ?>" style="width:100%; height:30px;" onclick="fun_get_edit_from(this.id)">
														<div class="fa-item"><i class="fa fa-pencil" style="color:black"></i></div>
													</button>
													<?php 
													}
												?>
											</td>
											<td align='center' style="color:<?php echo $color2;?>;"><b><?php echo $status;?></b></td>
											<td align='center' style="<?php if($r['priority'] == "High"){echo "color:red;font-weight:bold";} elseif($r['priority'] == "Medium"){echo "color:blue;font-weight:bold";}?>"><b><?php echo $r['priority'].' '.$priority;?></b></td>
											<td><?php echo $r['tittle_name'];?></td>
											<td><?php echo $start_date;?></td>
											<td><?php echo $due_date;?></td>
											<td><?php echo $r['project'];?></td>
											<td><?php echo $r['descr'];?></td>
											<td><?php echo $comp_date;?></td>
											<td style="<?php echo $color3;?>"><?php echo $status3;?></td>
											<td><?php echo $r['comp_remarks'];?></td>
											<td><?php $emp_details = $this->Mymodel->get_emp_name_form_emp_id($r['save_by']); if(!empty($emp_details))echo $emp_details[0]['first_name'].' '.$emp_details[0]['last_name'];//created by ?></td>
										</tr>
									<?php
									$i++;	
								}
								?>
							</table>
						</div>
						<?php
					}//if($no_of_div == 2)
		
	}//function close


	function task_project_list($box_length1,$where)
	{
		//getting data
		$emp_id=$this->session->userdata('emp_id');
		$where = " GROUP BY project ORDER BY priority,project  ";
		$res = $this->Dashbord->get_calendar_data($emp_id,$where);
		$i=1;
		foreach($res as $re)
		{
			$project = $re['project'];
			
			//status
				//Not Started
				$query2 = " SELECT count(id) as nos FROM task_planning WHERE  project='$project' and status='1' GROUP BY status   ";
				$out2 = $this->Mymodel->query1($query2);
				if(!empty($out2)){ $not_started = $out2[0]['nos'];}else{$not_started =0;}

				//In Progress
				$query2 = " SELECT count(id) as nos FROM task_planning WHERE  project='$project' and status='2' GROUP BY status   ";
				$out2 = $this->Mymodel->query1($query2);
				if(!empty($out2)){ $in_progress = $out2[0]['nos'];}else{$in_progress =0;}

				//Complete
				$query2 = " SELECT count(id) as nos FROM task_planning WHERE  project='$project' and status='3' GROUP BY status   ";
				$out2 = $this->Mymodel->query1($query2);
				if(!empty($out2)){ $complete = $out2[0]['nos'];}else{$complete =0;}

				//cancel
				$query2 = " SELECT count(id) as nos FROM task_planning WHERE  project='$project' and status='4' GROUP BY status   ";
				$out2 = $this->Mymodel->query1($query2);
				if(!empty($out2)){ $cancel = $out2[0]['nos'];}else{$cancel =0;}

				//late
				$query2 = " SELECT count(id) as nos FROM task_planning WHERE  project='$project' and comp_date > due_date and comp_date != '0000-00-00' GROUP BY id   ";
				$out2 = $this->Mymodel->query1($query2);
				if(!empty($out2)){ $late = $out2[0]['nos'];}else{$late =0;}

			
			//min date or max date
			$query4 = " SELECT min(entry_date) as min_start_date,max(due_date) as max_due_date,max(comp_date) as max_comp_date FROM task_planning WHERE  project='$project'    ";
			$out4 = $this->Mymodel->query1($query4);
			//print_r($out4);
			$date_start = $out4[0]['min_start_date'];
			$test = new DateTime($date_start);
			$start_d = date_format($test, 'd');  
			if($out4[0]['max_due_date'] >= $out4[0]['max_comp_date'])
			{
				$date_end = $out4[0]['max_due_date'];
			}
			else
			{
				$date_end = $out4[0]['max_comp_date'];
			}
			//date diff
			$date1=date_create($date_start);
			$date2=date_create($date_end);
			$diff=date_diff($date1,$date2);
			$diff_nos = $diff->format("%a");
			
			

		?>
			<div class="row" >
				<div class="col-md-12" >
					<div class="panel panel-white">
						<div class="panel-heading">
							 <h3 class="panel-title"><?php echo $re['project'];?></h3><br>
						</div>
						<div class="panel-body">
							<div class="col-md-2">
								<div>
									<canvas id="chartabcd<?php echo $i;?>" height="250"></canvas>
								</div>
								<h5 > 
									<span style="color:blue; margin-left:5px">New (<?php echo $not_started;?>)</span> 
									<span style="color:orange; margin-left:5px">In Progress (<?php echo $in_progress;?>)</span> 
									<span style="color:green; margin-left:5px">Complete (<?php echo $complete;?>)</span> <br>
									<span style="color:black; margin-left:5px">Late (<?php echo $late;?>)</span> 
									<span style="color:red; margin-left:5px">Cancel (<?php echo $cancel;?>)</span> 
								</h5>
							</div>
							<div class="col-md-10">
							<style>
								#printed_table_div  tr:hover 
								{ 
									background-color: #ccc;
								}
							</style>
								<div class="table-responsive">
								<table border=1 style="width:100%" id='printed_table_div'>
									<tr style="background-color:#f2f2f2;color:black">
										<th>#</th>
										<th>Edit</th>
										<th>Status</th>
										<th>Priority</th>
										<th>Task Name</th>
										<th>Description</th>
										<th>Start Date</th>
										<th>Due Date</th>
										<th>Comp. Date</th>
										<th>Late</th>
										<th>Remarks</th>
										<th>Created By</th>
										<th>Resp.</th>
										<?php 
											$date_plue = 0;
											for($k = $start_d;  $k<=$start_d+$diff_nos; $k++)
											{
												$stop_date = new DateTime($date_start);
												$stop_date->modify("+$date_plue day");
												$date_no = $stop_date->format('d');
												?>
													<th><?php echo $date_no;?></th>
												<?php
												$date_plue++;
											}
										?>
										
									</tr>
									<?php 
									//getting all work in this project
									$query3 = " SELECT * FROM task_planning WHERE  project='$project'  GROUP BY id ORDER BY entry_date,priority  ";
									$out3 = $this->Mymodel->query1($query3);
									$j=1;
									foreach($out3 as $r)
									{
										if(!empty($r['entry_date']))
										{
											$test = new DateTime($r['entry_date']);
											$start_date = date_format($test, 'd-m-Y'); 
										}else{ $start_date = "";}

										if(!empty($r['due_date']))
										{
											$test = new DateTime($r['due_date']);
											$due_date = date_format($test, 'd-m-Y'); 
										}else{ $due_date = "";}

										if(!empty($r['comp_date']) and $r['comp_date'] != '0000-00-00')
										{
											$test = new DateTime($r['comp_date']);
											$comp_date = date_format($test, 'd-m-Y'); 
										}else{ $comp_date = "";}

										//priority
										if(!empty($r['priority']))
										{
											if($r['priority'] == 'High')
											{
												$priority = "";
											}
											elseif($r['priority'] == 'Medium')
											{
												$priority = "";
											}
											elseif($r['priority'] == 'Low')
											{
												$priority = "";
											}
											else
											{
												$priority = "";
											}
										}
										else{$priority = "";}

										if(!empty($r['status']))
										{
											if($r['status'] == 1)
											{
												$color2 = "blue";
												$status = "New";
											}
											elseif($r['status'] == 2)
											{
												$status = "In Progress";
												$color2 = "orange";
											}
											elseif($r['status'] == 3)
											{
												$status = "Completed";
												$color2 = "green";
											}
											elseif($r['status'] == 4)
											{
												$status = "Cancel";
												$color2 = "red";
											}
											else
											{
												$status = "";
											}
										}
										else{$status = "";}


										//late
										if($r['comp_date'] == '0000-00-00'  and date('Y-m-d') > $r['due_date'] )
										{
											$status3 = "Late";
											$color3 = "background-color:gray;color:white;";
										}
										elseif($r['comp_date'] != '0000-00-00'   and $comp_date>$due_date)
										{
											$status3 = "Late";
											$color3 = "background-color:Black;color:white;";
										}
										else
										{
											$status3 = "";
											$color3 = "";	
										}
										//all resp person name
										$resp = explode("~",$r['resp']);
										?>
											<tr style="height:30px;">
												<td><?php echo $j;?></td>
												<td> 
													<?php 
													//if emp id is in array he can update
													$emp_id=$this->session->userdata('emp_id');
													if(in_array($emp_id,$resp) or $r['save_by'] == $emp_id)
													{
													?>
													<button type="button" class="btn btn-default" data-toggle="modal" data-target="#taskEditModal" id="taskeditform_<?php echo $r['id']; ?>" style="width:100%; height:30px;" onclick="fun_get_edit_from(this.id)">
														<div class="fa-item"><i class="fa fa-pencil" style="color:black"></i></div>
													</button>
													<?php 
													}
													?>
												</td>
												<td align='center' style="color:<?php echo $color2;?>; "><b><?php echo $status;?></b></td>
												<td align='center' style="<?php if($r['priority'] == "High"){echo "color:red;font-weight:bold";} elseif($r['priority'] == "Medium"){echo "color:blue;font-weight:bold";}?>"><b><?php echo $r['priority'].' '.$priority;?></b></td>
												<td><?php echo $r['tittle_name']; ?></td>
												<td><?php echo $r['descr'];?></td>
												<td><?php echo $start_date;?></td>
												<td><?php echo $due_date;?></td>
												<td><?php echo $comp_date;?></td>
												<td style="<?php echo $color3;?>"><?php echo $status3;?></td>
												<td><?php echo $r['comp_remarks'];?></td>
												<td><?php $emp_details = $this->Mymodel->get_emp_name_form_emp_id($r['save_by']); if(!empty($emp_details))echo $emp_details[0]['first_name'].' '.$emp_details[0]['last_name'];//created by ?></td>
												<td>
													<?php 
														$resp = explode("~",$r['resp']);
														foreach($resp as $rp)
														{
															if(!empty($rp))
															{
																$emp_details = $this->Mymodel->get_emp_name_form_emp_id($rp); if(!empty($emp_details))echo $emp_details[0]['first_name'].' '.$emp_details[0]['last_name'];
																echo ", ";
															}
														}
													?>
												</td>
												<?php 
													$date_plue = 0;
													for($k = $start_d;  $k<=$start_d+$diff_nos; $k++)
													{
														$stop_date = new DateTime($date_start);
														$stop_date->modify("+$date_plue day");
														$date_no = $stop_date->format('d');
														$date_no_full_date = $stop_date->format('Y-m-d');
														if($r['comp_date'] == $date_no_full_date )
														{
															$field_color = "background-color:#abf5b8;color:black;";
															$msg= "C";
														}
														
														elseif($r['due_date'] == $date_no_full_date and $r['entry_date'] == $date_no_full_date)
														{
															$field_color = "background-color:#f5abba;color:black;";
															$msg= "S/D";
														}
														
														elseif($r['due_date'] == $date_no_full_date )
														{
															$field_color = "background-color:#f5abba;color:black;";
															$msg= "D";
														}
														elseif($r['entry_date'] == $date_no_full_date )
														{
															$field_color = "background-color:#a0a5e8;color:black;";
															$msg= "S";
														}
														elseif(date('Y-m-d') == $date_no_full_date )
														{
															$field_color = "background-color:yellow;color:black;";
															$msg= "T";
														}
														else
														{
															$field_color = "";
															$msg= "";	
														}
														?>
															<td align="center" style="<?php echo $field_color;?>"><?php echo $msg;?></td>
														<?php
														$date_plue++;
													}
												?>
											</tr>
											
										<?php
									$j++;
									}
									?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			

			<script>
				$( document ).ready(function() {
					var ctxabcd<?php echo $i;?> = document.getElementById("chartabcd<?php echo $i;?>").getContext("2d");
					var dataabcd<?php echo $i;?> = [
						{
							value: <?php echo $not_started;?>,
							color:"blue",
							//highlight: "#FD7A7A",
							label: "Not Started"
						},
						{
							value: <?php echo $in_progress;?>,
							color: "orange",
							//highlight: "#36E7C8",
							label: "In Progress"
						},
						{
							value: <?php echo $complete;?>,
							color: "green",
							//highlight: "#FBDB6E",
							label: "Complete"
						},
						{
							value: <?php echo $late;?>,
							color: "black",
							//highlight: "#FBDB6E",
							label: "Late"
						},
						{
							value: <?php echo $cancel;?>,
							color: "red",
							//highlight: "#FBDB6E",
							label: "Cancel"
						}
					];
					
					var myDoughnutChart = new Chart(ctxabcd<?php echo $i;?>).Doughnut(dataabcd<?php echo $i;?>,{
						segmentShowStroke : true,
						segmentStrokeColor : "#fff",
						segmentStrokeWidth : 2,
						animationSteps : 100,
						animationEasing : "easeOutBounce",
						animateRotate : true,
						animateScale : false,
						responsive: true
					});
				});
			</script>
		</div>
		<?php
		$i++;
		}//foreach
	}//function close



	function my_task_list($where)
	{
		$emp_id=$this->session->userdata('emp_id');

		
		?>
				<style>
					#printed_table_div  tr:hover 
					{ 
						background-color: #ccc;
					}
				</style>

				<div class="row" >

					<?php 
					$row_name = array('New','In Progress','Complete','Cancel');
					$row_color = array('#a0a5e8','orange','#abf5b8','red');
					for($j=1;$j<=4;$j++)
					{
					?>
					<div class="col-md-3" >
						<div class="panel panel" >
							<div class="panel-heading">
								<h3 class="panel-title"><?php echo $row_name[$j-1];?></h3><br>
							</div>
							<div class="panel-body">
								<div class="col-md-">
									<div class="table-responsive">
										<table border=1 style="width:100%" id='printed_table_div'>
											<tr style="background-color:<?php echo $row_color[$j-1];?>;color:black">
												<th>#</th>
												<th>Edit</th>
												<th>Priority</th>
												<th>Task Name</th>
												<th>Start Date</th>
												<th>Due Date</th>
												<th>Late</th>
											</tr>
											<?php 
												//getting data
												$where = " and status='$j' GROUP BY id ORDER BY entry_date DESC  ";
												$res = $this->Dashbord->get_calendar_data($emp_id,$where);
												$i=1;
												foreach($res as $r)
												{
													if(!empty($r['entry_date']))
													{
														$test = new DateTime($r['entry_date']);
														$start_date = date_format($test, 'd-m-Y'); 
													}else{ $start_date = "";}
													
													if(!empty($r['due_date']))
													{
														$test = new DateTime($r['due_date']);
														$due_date = date_format($test, 'd-m-Y'); 
													}else{ $due_date = "";}

													//day rem
													$date1=date_create($start_date);
													$date2=date_create($due_date);
													$diff=date_diff($date1,$date2);
													$diff_nos = $diff->format("%a");

													if(!empty($r['comp_date']) and $r['comp_date'] != '0000-00-00')
													{
														$test = new DateTime($r['comp_date']);
														$comp_date = date_format($test, 'd-m-Y'); 
													}else{ $comp_date = "";}

													//priority
													if(!empty($r['priority']))
													{
														if($r['priority'] == 'High')
														{
															$priority = "";
														}
														elseif($r['priority'] == 'Medium')
														{
															$priority = "";
														}
														elseif($r['priority'] == 'Low')
														{
															$priority = "";
														}
														else
														{
															$priority = "";
														}
													}
													else{$priority = "";}

													//late
													if($r['comp_date'] == '0000-00-00'  and date('Y-m-d') > $r['due_date'] )
													{
														$status3 = "Late";
														$color3 = "background-color:gray;color:white;";
													}
													elseif($r['comp_date'] != '0000-00-00'   and $comp_date>$due_date)
													{
														$status3 = "Late";
														$color3 = "background-color:Black;color:white;";
													}
													else
													{
														$status3 = "";
														$color3 = "";	
													}
													//all resp person name
													$resp = explode("~",$r['resp']);
													?>
														<tr style="height:30px;">
															<td><?php echo $i;?></td>
															<td> 
																<?php 
																//if emp id is in array he can update
																$emp_id=$this->session->userdata('emp_id');
																if(in_array($emp_id,$resp) or $r['save_by'] == $emp_id)
																{
																?>
																<button type="button" class="btn btn-default" data-toggle="modal" data-target="#taskEditModal" id="taskeditform_<?php echo $r['id']; ?>" style="width:100%; height:30px;" onclick="fun_get_edit_from(this.id)">
																	<div class="fa-item"><i class="fa fa-pencil" style="color:<?php echo $row_color[$j-1];?>;"></i></div>
																</button>
																<?php 
																}
																?>
															</td>
															<td align='center' style="<?php if($r['priority'] == "High"){echo "color:red;font-weight:bold";} elseif($r['priority'] == "Medium"){echo "color:blue;font-weight:bold";}?>"><b><?php echo $r['priority'].' '.$priority;?></b></td>
															<td><?php echo $r['tittle_name']; ?></td>
															<td><?php echo $start_date;?></td>
															<td><?php echo $due_date;?></td>
															<td style="<?php echo $color3;?>"><?php echo $status3;?></td>
														</tr>
														
													<?php
													$i++;		
												}//foreach
											?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php 
				}//for $j
				?>							


				</div>
			<?php
			

	}//function close



	




	
























	

//----------------------------------------------Graph End------------------------------------------------























	
	

	
}//class close



?>