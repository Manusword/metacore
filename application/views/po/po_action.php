      

        <!-- ============ Body content start ============= -->
        <div class="main-content" >
                <div class="breadcrumb">
                    <!--<h1>Purchase Order</h1>-->
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
				<div class="col-md-2"></div>
					<div class="col-md-6">
						<div class="card-body"><?php echo $this->Pomodel->print_po($po[0]['po_id']);?></div>
						
						<!------button--->
						<div class="col-md-12" style="margin-bottom:100px;">
							<div class="panel panel-info">
								<div class="panel-heading clearfix">
									<h4 class="panel-title" align="center">Action</h4>
								</div>
								<input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
								<input type="hidden" name="po_id" id="po_id" value="<?php if(isset($po[0]['po_id']))echo $po[0]['po_id']; ?>">                  
								<input type="hidden" name="current_status" id="current_status" value="<?php if(isset($po[0]['stage']))echo $po[0]['stage']; ?>">                  
												
								<div class="panel-body" id="take_action">
									<div class="col-md-12">
										<textarea class="form-control" name="comment" id="comment" placeholder="Any Comment"></textarea>
									</div>
									<div class="col-md-12" style=" margin-top:20px;">
										<div class="col-md-1"> <input type="checkbox" id="chk" name="checkbox[]" class="form-control"  ></div>Select before save
									</div>
												
									<?php 
										if(isset($po[0]['stage']) and $po[0]['stage']!=4)
										{
											?>
												<div class="col-md-6" style="float:left; margin-top:20px;">
													<button type="button" id="po_accept" name="accept" class="btn btn-success btn-block"><i class="fa fa-check m-r-xs"></i>Approve</button>
												</div>
												<div class="col-md-6" style="float:left; margin-top:20px;">
													<button type="button" id="po_reject" name="reject" class="btn btn-danger btn-block"><i class="fa fa-close m-r-xs"></i>Reject</button>
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
						<!------button--->
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-3 user-profile panel-white">
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

						
						<div class="col-md-12">
							<hr>
							<h3>Product Details</h3>
							<style>
								/* Force absolute fallback to table elements layout */
								.table-responsive table.table,
								.table-responsive table.table thead,
								.table-responsive table.table tbody,
								.table-responsive table.table tr,
								.table-responsive table.table th,
								.table-responsive table.table td {
									float: none !important;
									position: static !important;
									width: auto !important;
								}
								.table-responsive table.table {
									display: table !important;
									width: 100% !important;
									border-collapse: collapse !important;
								}
								.table-responsive table.table thead {
									display: table-header-group !important;
								}
								.table-responsive table.table tbody {
									display: table-row-group !important;
								}
								.table-responsive table.table tr {
									display: table-row !important;
								}
								.table-responsive table.table th,
								.table-responsive table.table td {
									display: table-cell !important;
								}
							</style>
							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Product</th>
											<th>Order Qty</th>
											<th>UOM</th>
											<th>Rate</th>
											<th>Disc %</th>
											<th>Rate After Discount</th>
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
											$invoice_price2 = $this->Invoicemodel->get_product_last_invoice_entry_rate($id,$supplier_id,'diff_supplier');
											//unit
											$unit_name = $this->Base->get_unit_name_from_id($in['unitname_id']);
											
											$qunt=$in['qunt'];
											$rate=$in['rate'];
											$dic=$in['disc'];
											$net=$in['net'];
											$amt=$in['amount'];
											$goodsdetails=$in['goodsdetails'];
										
											?>
											<tr style="font-size:12px;">
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
															<th>Stock Min</th>
															<th>Stock Max</th>
															<th>Stock</th>
														</tr>
														<tr style="font-size:12px;">
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

				</div><!-- row -->					
		</div><!-- end of main-content -->
                    
               
                									
													
											
<?php $this->load->view('js/po_js');?>
