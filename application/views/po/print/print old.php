<?php 
$design = $this->Company->design();
$company = $this->Company->profile();
$our_gst_no = $this->Company->our_gst_details();
$po_print_details = $this->Company->po_print_details();
$our_address = $this->Company->dispatch_details();


//company details
$com_name = $company[0]['details1'];
$com_gst = $our_gst_no[0]['details1'];
$com_address1 = $our_address[0]['details2'];
$com_email = $po_print_details[0]['details3'];
$logo = base_url().$company[0]['details3']; 

//supplier details
$supplier_gst=$sup[0]['gst_no'];
$sname=$sup[0]['name'];
$saddress=$sup[0]['address'];
$scity=$sup[0]['city'].' '.$sup[0]['state'].' '.$sup[0]['zip'];
$sper_name=$sup[0]['con_name1'];
$sper_mob=$sup[0]['con_mob1'];
$semail=$sup[0]['con_email1'];
$approved_no=$sup[0]['approved_no'];



//po details
$po_date = $this->Base->change_date_dmy($res2[0]['po_date']);
$po_validity = $this->Base->change_date_dmy($res2[0]['po_validity']);
$quotation_ref=$res2[0]['quotation_ref'];
$indent_ref=$res2[0]['indent_ref'];
$payment_terms=$res2[0]['payment_terms'];
$del_schedule=$res2[0]['del_schedule'];
$del_place=$res2[0]['del_place'];
$mod_of_dis=$res2[0]['mod_of_dis'];
$loading_charge=$res2[0]['loading_charge'];
if($res2[0]['total_old']>0){$total_old=$res2[0]['total_old'];}else{$total_old= '0.00';}
if($res2[0]['dis_per']>0){$dis_per=$res2[0]['dis_per'];}else{$dis_per= '0.00';}
if($res2[0]['dis_amt']>0){$dis_amt=$res2[0]['total'];}else{$dis_amt= '0.00';}
if($res2[0]['total']>0){$total=$res2[0]['total'];}else{$total= '0.00';}
if($res2[0]['ffc_charge']>0){$ffc_charge= $res2[0]['ffc_charge'];}else{$ffc_charge= '0.00';}
if($res2[0]['ffc_gst_amt']>0){$ffc_gst_amt= $res2[0]['ffc_gst_amt'];}else{$ffc_gst_amt= '0.00';}
if($res2[0]['ffc_amt']>0){$ffc_amt= $res2[0]['ffc_amt'];}else{$ffc_amt= '0.00';}
$gstval=$res2[0]['gstval'];
if($res2[0]['gstcharge']>0){$gstcharge= $res2[0]['gstcharge']+$ffc_gst_amt;}else{$gstcharge= '0.00';}
if($res2[0]['roundoff']>0){$roundoff= $res2[0]['roundoff'];}else{$roundoff= '0.00';}
if($res2[0]['grandtotal']>0){$grandtotal= $res2[0]['grandtotal'];}else{$grandtotal= '0.00';}
if(isset($res2[0]['amount_word'])){$amount_word= $res2[0]['amount_word'];}else{$amount_word= '';}
if(isset($res2[0]['remarks'])){$remarks= $res2[0]['remarks'];}else{$remarks= '';}
$po_no=$res2[0]['po_no'];
$text_edited=$res2[0]['text_edited'];



?> 

<style>

	*{
		border: 0;
		box-sizing: content-box;
		color: inherit;
		font-family: inherit;
		font-size: inherit;
		font-style: inherit;
		font-weight: inherit;
		line-height: inherit;
		list-style: none;
		margin: 0;
		padding: 0;
		text-decoration: none;
		vertical-align: top;
	}
	*[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }
	*[contenteditable] { cursor: pointer; }
	*[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }
	span[contenteditable] { display: inline-block; }
	h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }
	table { font-size: 75%; table-layout: ; width: 100%; }
	table { border-collapse: separate; border-spacing: 2px; }
	th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
	th, td { border-radius: 0.25em; border-style: solid; }
	th { background: <?php if(isset($design[0]['details1'])){echo $design[0]['details1'];}else{echo "red";}?>; color:white; border-color: <?php if(isset($design[0]['details1'])){echo $design[0]['details1'];}else{echo "red";}?>; }
	td { border-color: #DDD; }
	html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
	html { background: #999; cursor: default; }
	body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
	body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
	header { margin: 0 0 3em; }
	header:after { clear: both; content: ""; display: table; }
	header h1 { background: <?php if(isset($design[0]['details1'])){echo $design[0]['details1'];}else{echo "red";}?>; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
	header address { float: right; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
	header address p { margin: 0 0 0.25em; }
	header span, header img { display: block; float: left; }
	header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
	header img { max-height: 100%; max-width: 100%; }
	header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }
	article, article address, table.meta, table.inventory { margin: 0 0 3em; }
	article:after { clear: both; content: ""; display: table; }
	article h1 { clip: rect(0 0 0 0); position: absolute; }
	article address { float: left; font-size: 125%; font-weight: bold; }
	table.meta, table.balance { float: right; width: 36%; }
	table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
	tr:hover .cut { opacity: 1; }
	@media print 
	{
		* { -webkit-print-color-adjust: exact; }
		html { background: none; padding: 0; }
		body { box-shadow: none; margin: 0; }
		span:empty { display: none; }
		.add, .cut { display: none; }
		th { background:white; color:black; border-color: gray; }
		article address { float: left; font-size: 125%; font-weight: normal; }
		header h1 { background:white; color:gray;  border-radius: 0.25em;  margin: 0 0 1em; padding: 0.5em 0; }
		th { background:white; color:black; border-color: gray; }
		article address { float: left; font-size: 125%; font-weight: normal; }
		header h1 { background:white; color:gray;  border-radius: 0.25em;  margin: 0 0 1em; padding: 0.5em 0; }
	}
	@page { margin: 0; }
	

</style>


<html>
	<head>
		<meta charset='utf-8'>
		<title>Purchase Order</title>
	</head>
	<body>
	 
		<header>
			<h1>Purchase Order</h1>
			<address style=' float:left;'>
				<p style='font-size:15px; font-weight:bold'><?php if(isset($com_name))echo $com_name;?></p>
				<p><?php if(isset($com_address1))echo $com_address1;?></p>
				<p><?php if(isset($com_email))echo $com_email;?></p>
				<p>GSTIN <?php echo $com_gst;?></p>
			</address>
			<span style=' float:right;'><img alt='' src='<?php echo $logo;?>' style="height:75; width:75"></span>
		</header>

		<article>
			<address style=' float:right; font-size:12px; margin-top:-40px;'>
				To,<br><br>
				<p><?php if(isset($sname))echo $sname;?>
				<br>			
				<br><?php if(isset($saddress))echo $saddress;?></p>			
				<br><?php if(isset($scity))echo $scity;?></p>
				<br>Contact Person Name: <?php if(isset($sper_name))echo $sper_name;?></p>
				<br>Mob	: <?php if(isset($sper_mob))echo $sper_mob;?></p>
				<br>Email: <?php if(isset($semail))echo $semail;?></p>
				<br>GSTIN: <?php if(isset($supplier_gst))echo $supplier_gst;?></p>
			</address>
			
			<table class='meta' style='float:left; margin-top:-40px;'>
				<tr>
					<th>P.O No.</th>
					<td><?php if(isset($po_no))echo $po_no;?></td>
				</tr>
				<tr>
					<th>P.O Date</th>
					<td><?php if(isset($po_date))echo $po_date;?></td>
				</tr>
				<tr>
					<th>P.O Validity</th>
					<td><?php if(isset($po_validity))echo $po_validity;?></td>
					
				</tr>
				<tr>
					<th>Vendor Code</th>
					<td><?php if(isset($approved_no))echo $approved_no;?></td>
					
				</tr>
				<tr>
					<th>Quotation Ref</th>
					<td><?php if(isset($quotation_ref))echo $quotation_ref;?></td>
				</tr>
				<tr>
					<th>Indent Ref</th>
					<td><?php if(isset($indent_ref))echo $indent_ref;?></td>
				</tr>
			</table>
			
			<table class='inventory' >
				<thead>
					<tr>
						<td style="border:none;" colspan="11"><?php if(isset($remarks))echo $remarks;?> </td>
					</tr>

					<tr>
						<td style="border:none;" colspan="2">
							<span style="font-size:14px; font-weight:bold;">
								<?php if(isset($text_edited) and $text_edited==2){echo "Revised";}?>
							</span>
						</td>
						<td colspan="7" style="border:none;"></td>
						<td style="border:none;" colspan="2"></td>
					</tr>
							
					<tr>
						<th width='20px'>S.No</th>
						<th style='width:200px'>Description of Goods</th>
						<th>HSN</th>
						<th>UOM</th>
						<th>Quantity</th>
						<th>Rate</th>
						<th>Dis(%)</th>
						<th>Net Rate</th>
						<th>Amount</th>
						<th><?php if(isset($res2[0]['gst_type'])){echo $res2[0]['gst_type'];}?></th>
						<th>GST</th>
					</tr>
				</thead>
				<tbody> 
					<?php
						$i=1;
						foreach($res3 as $in)
						{
							$product_id = $in['product_id'];
							$out =  $this->Productmodel->get_product_column_data_with_id($product_id,'name,details');
							$pro_name= $out[0]['name'];
							$product_details = $out[0]['details'];
							
							$unit_id = $in['unitname_id'];
							$unit_name = $this->Base->get_unit_name_from_id($unit_id);
							$hsn=$in['hsn'];
							$qunt=$in['qunt'];
							$rate=$in['rate'];
							$dic=$in['disc'];
							$net=$in['net'];
							$amt=$in['amount'];
							$goodsdetails=$in['goodsdetails'];
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td style=" width:200px;">
									<?php if(isset($pro_name)){echo $pro_name;}?>
									<?php if(strlen($product_details)>2){ ?><br><span style="font-size:11px;">(<?php echo $product_details;?>)</span><?php }?>
									<?php if(strlen($goodsdetails)>0){ ?><span style="font-size:11px;">(<?php echo $goodsdetails;?>)</span><?php }?>
								</td>
								<td><?php if(isset($hsn))echo $hsn;?></td>
								<td><?php if(isset($unit_name))echo $unit_name;?></td>
								<td><?php if(isset($qunt))echo $qunt;?></td>
								<td><?php if(isset($rate))echo $rate;?></td>
								<td><?php if(isset($dic))echo $dic;?></td>
								<td><?php if(isset($net))echo $net;?></td>
								<td><?php if(isset($amt))echo $amt;?></td>
								<td><?php if($in['itemigst']>0){echo $in['itemigst'].'%';}else{echo $in['itemsgst'].'%, '.$in['itemcgst'].'%';}?></td>
								<td><?php echo $in['itemgstrs'];?></td>
							</tr>
							<?php
							$i++;
						}//loop
					?>
				</tbody>
			</table>
			
			<address  style=' width:60%; font-size:13px; '>
				<table>
					<tr>
						<td>Payment Terms</td>
						<td><?php if(isset($payment_terms))echo $payment_terms;?></td>
					</tr>
					<tr>
						<td>Delivery Schedule</td>
						<td><?php if(isset($del_schedule))echo $del_schedule;?></td>
					</tr>
					<tr>
						<td>Place Of Delivery</td>
						<td><?php if(isset($del_place))echo $del_place;?></td>
					</tr>
					<tr>
						<td>Mode Of Dispatch</td>
						<td><?php if(isset($mod_of_dis))echo $mod_of_dis;?></td>
					</tr>
					<tr>
						<td>Loading & Packing Charge</td>
						<td><?php if(isset($loading_charge))echo $loading_charge;?></td>
					</tr>
					
					<tr>
						<td>Payment In Words</td>
						<td><?php if(isset($amount_word))echo $amount_word;?></td>
					</tr>
				</table>
			</address>		
						
			<table class='balance' style=' font-size:12px;'>
				<?php 
				if($total_old>0)
				{
					?>
						<tr>
							<th>Total</th>
							<td><?php if(isset($total_old))echo $total_old;?></td>
						</tr>
						
						<tr>
							<th>After <?php if($dis_per>0){echo $dis_per.' %';}?> Discount</th>
							<td><?php if(isset($total))echo $total;?></td>
						</tr>
					<?php
				}
				else
				{
					?>
						<tr>
							<th>Total</th>
							<td><?php if(isset($total))echo $total;?></td>
						</tr>
					<?php
				}
				?>
				<tr>
					<th>FFC</th>
					<td><?php if(isset($ffc_charge))echo $ffc_charge;?></td>
				</tr>
				<tr>
					<th>Total GST</th>
					<td><?php if(isset($gstcharge))echo $gstcharge;?></td>
				</tr>
				<tr>
					<th>Round Off</th>
					<td><?php if(isset($roundoff))echo $roundoff;?></td>
				</tr>
				
				<tr>
					<th>Grand Total</th>
					<td><?php if(isset($grandtotal))echo $grandtotal;?></td>
				</tr>
			</table>
		</article>
		
		<div style='font-size:11px; border-top:solid 1px black; margin-top:-30px;'>
			<?php if($po_print_details[0]['details5'] == 1){ echo $po_print_details[0]['details6'];}?>
			<p align='left' style="margin-top:5px;"> Notes: <br> 
				<?php if($po_print_details[0]['details8'] == 1){ echo $po_print_details[0]['details9'];}?>
			</p>
		</div>	
	  
	</body>
</html>




