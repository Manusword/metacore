 <?php 
 	$emp_id = $this->session->userdata('login_emp_id');
	//$user_email = $this->session->userdata('email');
?>  

<div class="table-responsive">
	<table class="table table-bordered table-striped table-sm" id="printed_table">
	    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      		<tr>
				<th>#</th>
					<th>PO Date</th>
					<th>PO No</th>
					<th>Supplier</th>
					<th>Amount (₹)</th>
					<?php 
						if(isset($po_search_stage) and $po_search_stage==3)
						{
							?>
								<th>Rejected By</th>
								<th>Comment</th>
								<th>Re Send</th>
							<?php 
						}
						else
						{
							?>
								<th>Action</th>
							<?php 
						}
					?>
					<th>Edit</th>
					<?php 
					if(isset($po_search_stage) and $po_search_stage>3)
					{
						?> 
							<th>Print</th>
						<?php 
					}
					?>
			</tr>
		</thead>
		<tbody>
		   <?php 
                $i=1;
				$rs=array();
                foreach($res2 as $r)
                {
                	?>
                  	<tr <?php  if(isset($r['invoice_entry_disable']) and $r['invoice_entry_disable']==1){?> style="color:red" title="PO DISABLE"  <?php }?>>
						<td><?php echo $i;?>.<?php  if(isset($r['text_edited'])){if($r['text_edited']==1){?><span class="badge bg-green" >Edit</span> <?php }}?></td>
                  		<td><?php if(isset($r['po_date'])){ echo $this->Base->change_date_dmy($r['po_date']);}?></td>
                  		<td><?php if(isset($r['po_no']))echo $r['po_no'];?></td>
						<td><?php if(isset($r['sname']))echo $r['sname'];?></td>
                 		<td><?php if(isset($r['grandtotal']))echo $rs[]=$r['grandtotal'];?></td>
						<?php 
							if(isset($po_search_stage) and $po_search_stage==3)
							{
								?>
                 					<td><?php if(isset($r['reject_by']))echo $r['reject_by'];?></td>
                 					<td><?php if(isset($r['comment']))echo $r['comment'];?></td>
								<?php 
							}
						?>
						<td>
							<?php 
								//same change po/po_reject_display pr krna hai
								if(isset($r['stage']) and $r['stage']>0)
								{
									if($r['stage']=='1' or $r['stage']=='3')
									{
										$stage_no=2; 
										if($r['stage']=='1'){$button_name="Approved OR Reject";}
										if($r['stage']=='3'){$button_name="Resend";}
										
										$newdate = $this->Base->add_no_of_days_in_date_ymd($r['po_date'],$this->Company->po_expire_after_days());
										$today_date =  date('Y-m-d');
										if($r['po_date'] <= $today_date and $today_date <= $newdate)
										{ 
											echo 'in date';
										}
										else
										{ 
											if($this->Company->check_po_expire_access_in_this_user($emp_id) == "TRUE")
											{
												//echo "login access";
											}
											else
											{
												$button_name="NO";
											}
										}
									}
									elseif($r['stage']=='2')
									{
										$stage_no=4;//stage ko ready kr dega mail send krne k liye
										$button_name="Approve OR Reject";
									}
									elseif($r['stage']=='11')
									{
										$stage_no=16;//mail sended to customer 
										$button_name="Approve OR Reject BY MD";
									}
									elseif($r['stage']=='4')
									{
										$stage_no=5;//mail sended to customer 
										$button_name="Send to customer";
									}
									elseif($r['stage']=='5')
									{
										$stage_no=6;//mail sended to customer 
										$button_name="NO";
									}
									else
									{
										$stage_no=0;
										$button_name="NO";
									}
									
									if($button_name!='NO')
									{
										/*$where=" emp_id='$emp_id' and access_name='$stage_no'  ";
										$access=$this->Mymodel->select_where('emp_access',$where);
										if(isset($access) and count($access)>0)
										{
											//print_r($access);
											*/
											?>
											<a target="_blank" class="btn btn-info"   href="<?php echo base_url().'index.php/Welcome/home?';?>Po/po_action/<?php echo $r['po_id'];?>"  >
													<?php echo $button_name;?> 
											</a>
											<?php
										//}//if
									}//NO
									else
									{
										//if po send to customer and invocie recived
										echo "Receive: ";
										if(!empty($r['rec_item'])){echo $r['rec_item'].' / ';}else {echo '0 / ';}
										if(!empty($r['total_item'])){echo $r['total_item'];}
									}//yes
								}//po stage
							?>
	                  	</td>
						<?php  
						if(isset($r['invoice_entry_disable']) and $r['invoice_entry_disable']==1)
						{
							?>
								<td></td>
							<?php
						}
						else
						{
							?> 
								<td>
									<a target="_blank"   href="<?php echo base_url().'index.php/Welcome/home?';?>Po/add/<?php if(isset($r['po_id']))echo $r['po_id']?>"  class="btn btn-warning" style=" float:left;">
										<i class="nav-icon i-Pen-2"></i>
									</a>
								</td>     
							<?php 
						}//po edit option

						if(isset($po_search_stage) and $po_search_stage>3)
						{
							?> 
								<td> 
									<a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_po/<?php echo $r['po_id'];?>" class="btn btn-info">Print</a>
								</td>
							<?php 
						}//po stage
				$i++; 
			}//foreach
			?>
			<tr>
				<td>#</td>
				<td colspan="2"></td>
				<td style="color:black; font-weight:bolder"></td>
				<td style="color:black; font-weight:bolder"><?php echo number_format(array_sum($rs),2);?></td>
				<?php if(isset($po_search_stage) and $po_search_stage==3){?>
				<td colspan="5"></td>
				<?php }else{?>
				<td colspan="2"></td>
				<?php }?>
			</tr>
		</tbody>
	</table>
</div>


