      

        <!-- ============ Body content start ============= -->
        <div class="main-content" >
                <div class="breadcrumb">
                    <h1>Purchase Order</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                   	<div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                               <!-------------------------------------------------------------------------------> 
							   
								<div class="page-inner">
									<h2 align="center">"<?php if(isset($po[0]['s_name']))echo $po[0]['s_name'];?>" </h2>
									<h3 align="center" style="color:red;"><?php if(isset($dis))echo $dis;?></h5>
									<div id="main-wrapper">
										<div class="row">
											<div class="col-md-3 user-profile panel-white">
												Purchase Order of:
												<h5> <?php if(isset($po[0]['s_name']))echo $po[0]['s_name'];?></h5>
												<hr>
												<h5>PO NO: <?php if(isset($po[0]['po_no']))echo $po[0]['po_no'];?></h5>
												<hr>
												<h5>
												PO Date:
												<?php if(isset($po[0]['po_date'])){echo $this->Base->change_date_dmy($po[0]['po_date']);}?>
												</h5>
												<hr>
												<h5>
												PO Validity:
												<?php if(isset($po[0]['po_validity'])){echo $this->Base->change_date_dmy($po[0]['po_validity']);}?>
												</h5>
												<hr>	
												<h5>Supplier Id: <?php if(isset($po[0]['supplier_id']))echo $po[0]['supplier_id'];?></h5>
												<hr>	
												<h5>Is Supplier Approved ? : 
													<?php 
														$supplier_id=$po[0]['supplier_id'];
														if($approved_id = $this->Suppliermodel->is_supplier_approved($supplier_id) != "FALSE")
														{
															?>
																<span class="badge badge-success">Approved (ID :<?php echo $approved_id;?>)</span><br>
															<?php
														}
														else
														{
															?><span class="badge badge-danger">Not Approved</span><?php
														}
													?>
												</h5>
												<hr>
												<ul class="list-unstyled">
													<li><p><i class="fa fa-map-marker m-r-xs"></i><?php if(isset($po[0]['s_address']))echo $po[0]['s_address'];?></p></li>
													<li><p><?php if(isset($po[0]['s_address']))echo $po[0]['s_address'];?></p></li>
													<li><p><?php if(isset($po[0]['s_city']))echo $po[0]['s_city'];?></p></li>
												</ul>
												<h5> Order By:<?php if(isset($po[0]['order_by']))echo $po[0]['order_by'];?></h5>
												<h5> Department: <?php if(isset($po[0]['department']))echo $po[0]['department'];?></h5>
												<h5> M/C no: <?php if(isset($po[0]['mc_no']))echo $po[0]['mc_no'];?></h5>
												<hr>
												<h5>PCC Image: </h5>
												<?php if(isset($po[0]['pcc_img_status']) and $po[0]['pcc_img_status']==1)
												{
													?>
														<div>
																<a href="<?php echo base_url();?><?php if(isset($po[0]['pcc_img']))echo $po[0]['pcc_img']; ?>">
																	<img src="<?php echo base_url();?><?php if(isset($po[0]['pcc_img']))echo $po[0]['pcc_img']; ?>" style="height:350px; width:100%">
																</a>
														</div>
													<?php
												}//image
												if($po[0]['stage']<2)
												{
													?>
														<div>
															<form action="<?php echo base_url();?>index.php/Ajex/pcc_upload" method="post" enctype="multipart/form-data">

																<input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
																<input type="hidden" name="po_id" id="po_id" value="<?php if(isset($po[0]['po_id']))echo $po[0]['po_id']; ?>">                  

																<div class="col-md-12" style=" margin-top:20px;">
																	<input type="file" name="img" class="form-control">
																</div>	
																<div class="col-md-12" style=" margin-top:20px;  margin-bottom:20px;">
																	<button type="submit"  name="upload" class="btn btn-primary btn-block"><i class="fa fa-file m-r-xs"></i>Upload</button>
																</div>	
															</form>
														</div>
													<?php
												}
												?>
											</div>
													
														
													
											<div class="col-md-9 m-t-lg">
													<div class="col-md-12">
													<div class="panel panel-info">
														<div class="panel-heading clearfix">
															<h4 class="panel-title">Product List</h5>
														</div>
														<div class="panel-body">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
																		<tr>
																			<th>#</th>
																			<th>Product</th>
																			<th>Qty</th>
																			<th>UOM</th>
																			<th>Rate</th>
																			<th>Disc %</th>
																			<th>Net</th>
																			<th>Amount</th>
																			<th>
																				<?php 
																					if(isset($po[0]['gst_type']))
																					{
																						echo $po[0]['gst_type'];
																					}
																				?>
																			</th>
																			<th>GST Amt.</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php 
																		$i=1;
																		foreach($po2 as $in)
																		{
																			///name
																			$id= $in['product_id'];
																			$out=$this->Productmodel->get_product_data_with_id($id);
																			$pro_name= $out[0]['name'];
																			$min= $out[0]['reorder'];
																			$max= $out[0]['max_level'];
																			$product_details= $out[0]['details'];

																			//qty in stock
																			$stock_qty = $this->Storemodel->get_stock_product_id($id);
																			//last rate in stock same supplier
																			$invoice_price = $this->Invoicemodel->get_product_last_invoice_entry_rate($id,$supplier_id,'same_supplier');
																			//last rate in stock Other supplier
																			$invoice_price2 = $this->Invoicemodel->get_product_last_invoice_entry_rate($id,$supplier_id,'same_supplier');
																			//unit
																			$unit_name = $this->Base->get_unit_name_from_id($in['unitname_id']);
																			
																			$qunt=$in['qunt'];
																			$rate=$in['rate'];
																			$dic=$in['disc'];
																			$net=$in['net'];
																			$amt=$in['amount'];
																			$goodsdetails=$in['goodsdetails'];
																		
																			?>
																			<tr>
																				<td><?php echo $i;?></td>
																				<td title="<?php echo $id;?>">
																					<?php if(isset($pro_name)){echo $pro_name;}?>
																					<?php 
																						if(strlen($product_details)>0)
																						{ 
																							?>
																							<span style="font-size:12px;"> 
																							"<?php echo $product_details;?>"
																							</span> 
																							<?php 
																						}
																						
																						//
																						if(strlen($goodsdetails)>0)
																						{ 
																							?>
																							<span style="font-size:12px;"> 
																							(<?php echo $goodsdetails;?>) 
																							</span>
																							<?php 
																						}
																					?>
																				</td>
																		
																				<td>
																					<span style="color:blue; font-weight:bold"><?php if(isset($qunt))echo $qunt;?> </span>
																					<br><br>
																					<table border="1">
																						<tr style="background-color:#e9edf2">
																							<th>Min</th>
																							<th>Max</th>
																							<th>Stock</th>
																						</tr>
																						<tr>
																							<td><?php echo $min;?></td>
																							<td><?php echo $max;?></td>
																							<td><?php echo $stock_qty[0]['total_qty'];?></td>
																						</tr>
																					</table>
																				</td>
																				<td><?php if(isset($unit_name))echo $unit_name;?></td>
																		
																		
																				<td title="<?php if(!empty($invoice_price[0]['details_id']))echo $invoice_price[0]['details_id'];?>">
																					<?php if(!empty($rate))echo $rate;?>
																				</td>
																				
																				
																				<td><?php if(!empty($dic))echo $dic;?></td>
																				<td>
																					<span style="color:blue; font-weight:bold"><?php if(!empty($net))echo $net;?></span>
																					<br><br>
																						<?php if(!empty($invoice_price[0]['price'])){echo 'Same Supplier Last Rate : '.$invoice_price[0]['price'];}else{echo " 1st Time Purchasing";}?> <?php if(!empty($invoice_price[0]['invoice_date']))echo '('.$invoice_price[0]['invoice_date'].')';?>
																						<br>
																						<?php 
																						if(!empty($invoice_price[0]['price']) and $invoice_price[0]['price']!=$net)
																						{
																							if($invoice_price[0]['price'] > $net)
																							{
																								$total_diff = round($invoice_price[0]['price']-$net,2);
																								$total_diff2 = round($total_diff*$qunt);
																								echo "<span style='color:green; font-size:15px'><b> Profit - $total_diff Rs/$unit_name, Total Profit $total_diff2 Rs. </b></span>";
																							}
																							elseif($invoice_price[0]['price'] < $net)
																							{
																								$total_diff = round($net- $invoice_price[0]['price'],2);
																								$total_diff2 = round($total_diff*$qunt);
																								echo "<span style='color:red; font-size:15px'><b> Loss - $total_diff Rs/$unit_name, Total Loss $total_diff2 Rs. </b></span>";
																							}
																							else
																							{
																								echo " ";
																							}
																						}
																						?>
																					<br>
																					<br>
																					<b> <?php if(!empty($invoice_price2[0]['price'])){echo $invoice_price2[0]['sname'].'<br> Last Rate : '.$invoice_price2[0]['price'];}else{echo "";}?> <?php if(!empty($invoice_price2[0]['invoice_date']))echo '('.$invoice_price2[0]['invoice_date'].')';?></b>
																					<br>
																					<?php 
																						if(!empty($invoice_price2[0]['price']) and $invoice_price2[0]['price']!=$net)
																						{
																							if($invoice_price2[0]['price'] > $net)
																							{
																								$total_diff = round($invoice_price2[0]['price']-$net,2);
																								$total_diff2 = round($total_diff*$qunt);
																								echo "<span style='color:green; font-size:15px'><b> Profit - $total_diff Rs/$unit_name, Total Profit $total_diff2 Rs. </b></span>";
																							}
																							elseif($invoice_price2[0]['price'] < $net)
																							{
																								$total_diff = round($net- $invoice_price2[0]['price'],2);
																								$total_diff2 = round($total_diff*$qunt);
																								echo "<span style='color:red; font-size:15px'><b> Loss - $total_diff Rs/$unit_name, Total Loss $total_diff2 Rs. </b></span>";
																							}
																							else
																							{
																								echo " ";
																							}
																						}
																						?>
																				</td>
																				<td><span style="color:#EB8653; font-weight:bold"><?php if(isset($amt))echo $amt;?></span></td>
																				<td>
																					<?php 
																						if($in['itemigst']>0)
																						{
																							echo $in['itemigst'].'%';
																						}
																						else
																						{
																							echo $in['itemsgst'].'%, '.$in['itemcgst'].'%';
																						}
																					?>
																				</td>
																				<td><?php echo $in['itemgstrs'];?></td>
																			</tr>
																			<?php
																			$i++;
																		}//loop
																		?>
																	</tbody>
																	</table>
																</div>
														</div> 
													</div>
													</div>  
													
												<div class="col-md-12">
													<div class="panel panel-info">
														<div class="panel-body">
															<div class="table-responsive">
																
																<table class="table table-bordered">
																	<tr>
																		<tr style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
																			<th>Total</th>
																			<th>After  <?php if(isset($po[0]['total']) and $po[0]['dis_per']>0){echo $po[0]['dis_per'].' %';}?> Discount</th>
																			<th>Total GST</th>
																			<th>Round Off</th>
																			<th>Grand Amount</th>
																		</tr>
																		<tr>
																			<td><?php if(isset($po[0]['total_old'])){ echo  $po[0]['total_old'];}?></td>
																			<td><?php if(isset($po[0]['total']))echo $po[0]['total'];?></td>
																			<td><?php if(isset($po[0]['gstcharge']))echo $po[0]['gstcharge'];?></td>
																			<td><?php if(isset($po[0]['roundoff']))echo $po[0]['roundoff'];?></td>
																			<td><?php if(isset($po[0]['grandtotal'])){ echo $grandtotal =  $po[0]['grandtotal'];}else{  $grandtotal = 0;}?></td>
																		</tr>
																	</tr>
																</table>
																<table class="table table-bordered">
																	<tr>
																		<tr style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
																			<th>Delivery Schedule</th>
																			<th>Payment Payment Terms</th>
																			<th>Place Of Delivery</th>
																			<th>Mode Of Dispatch</th>
																		</tr>
																		<tr>
																			<td><?php if(isset($po[0]['del_schedule'])){ echo  $po[0]['del_schedule'];}?></td>
																			<td><?php if(isset($po[0]['payment_terms'])){ echo  $po[0]['payment_terms'];}?></td>
																			<td><?php if(isset($po[0]['del_place'])){ echo  $po[0]['del_place'];}?></td>
																			<td><?php if(isset($po[0]['mod_of_dis'])){ echo  $po[0]['mod_of_dis'];}?></td>
																		</tr>

																		<tr>
																			<td colspan='4' style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">Remarks</td>
																		</tr>
																		<tr>
																			<td colspan='4'><?php if(isset($po[0]['remarks'])){ echo  $po[0]['remarks'];}?></td>
																		</tr>

																	</tr>
																</table>

															</div>
														</div> 
													</div>
												</div>   
											
											
												<?php 
												
												//-----if pcc uploades image
												//if((isset($po[0]['pcc_img_status']) and $po[0]['pcc_img_status']==1) or ($po[0]['stage']>1))
												//{
													
												?>                         
												<div class="col-md-12">
													<div class="panel panel-info">
														<div class="panel-heading clearfix">
															<h4 class="panel-title">Action</h4>
															<p>
															<a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_po/<?php if(isset($po[0]['po_id']))echo $po[0]['po_id'];?>" class="btn btn-info">Print</a>
															</p>
														</div>


														<input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
														<input type="hidden" name="po_id" id="po_id" value="<?php if(isset($po[0]['po_id']))echo $po[0]['po_id']; ?>">                  
														<input type="hidden" name="current_status" id="current_status" value="<?php if(isset($po[0]['stage']))echo $po[0]['stage']; ?>">                  
														
														<div class="panel-body" id="take_action">
																<div class="col-md-12">
																	<textarea class="form-control" name="comment" id="comment" placeholder="Any Comment"></textarea>
																</div>
															
															<div class="col-md-12" style=" margin-top:20px;">
																<div class="col-md-1"> <input type="checkbox" id="chk" name="checkbox[]" class="form-control"  ></div>
																<div class="col-md-4"><span style=" margin-top:30px;font-size:20px;">  <?php  if($grandtotal >= 200000){?>Total Amt : <blink style="color:red; font-weight:bold; font-size:30px;"><?php echo round($grandtotal);?></blink> <?php }?> Ready To Save</span></div>
																</div>
															
															<?php 
																if(isset($po[0]['stage']) and $po[0]['stage']!=4)
																{
																	?>
																		<div class="col-md-6" style="float:left; margin-top:20px;">
																			<button type="button" id="po_accept" name="accept" class="btn btn-success btn-block"><i class="fa fa-check m-r-xs"></i>Approved</button>
																		</div>
																		<div class="col-md-6" style="float:left; margin-top:20px;">
																			<button type="button" id="po_reject" name="reject" class="btn btn-danger btn-block"><i class="fa fa-close m-r-xs"></i>Rejected</button>
																		</div>
																	<?php 
																}
																else
																{
																	?> 
																		<div class="col-md-12" style=" margin-top:20px;">
																			<button type="button" id="po_accept" name="accept" class="btn btn-success btn-block"><i class="fa fa-check m-r-xs"></i>Po Send to Supplier</button>
																		</div>
																	<?php 
																}
															?>
														</div>
													</div>
												</div>   
												<?php 
												/*
												}//pcc
												else
												{
													echo "<h2>Upload PCC Image 1st</h2>";
												}
												*/
												?>
										</div>
									</div> 
								</div>
									<!------------------------------------------------------------------------------->       
                               
							</div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


           
<?php $this->load->view('js/po_js');?>
