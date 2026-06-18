<?php 
$design = $this->Company->design();
$company = $this->Company->profile();

//company details
$com_name = $company[0]['full_name'];
$com_gst = $company[0]['gstno'];
$com_address1 = $company[0]['full_address'];
$com_email = $company[0]['email'];
$logo = base_url().$company[0]['logo']; 

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

// Colors from company design
$primary_color = !empty($company[0]['design1_bg_color']) ? $company[0]['design1_bg_color'] : '#1e293b';
$font_color = !empty($company[0]['design1_ft_color']) ? $company[0]['design1_ft_color'] : '#ffffff';
?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Purchase Order - <?php echo $po_no; ?></title>
	<style>
		body {
			color: #1e293b;
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			font-size: 11px;
			line-height: 1.5;
			background: #ffffff;
			margin: 0;
			
		}
		.maindiv {
			width: 100%;
			background: #fff;
			padding: 0;
		}
		h1, h2, h3, h4, h5, h6 {
			margin: 0;
		}
		.inventory-table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
			font-size: 11px;
		}
		.inventory-table th, .inventory-table td {
			border: 1px solid #cbd5e1;
			padding: 8px 10px;
			text-align: left;
		}
		.inventory-table th {
			background: <?php echo $primary_color; ?> !important;
			color: <?php echo $font_color; ?> !important;
			font-weight: 600;
			text-transform: uppercase;
			font-size: 10px;
			letter-spacing: 0.5px;
			border: 1px solid <?php echo $primary_color; ?>;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}
		.inventory-table td {
			color: #334155;
		}
		.inventory-table tr:nth-child(even) {
			background-color: #f8fafc;
		}
		.meta-table {
			width: 100%;
			border-collapse: collapse;
			font-size: 11px;
		}
		.meta-table th {
			background: <?php echo $primary_color; ?> !important;
			color: <?php echo $font_color; ?> !important;
			font-weight: 600;
			text-align: left;
			padding: 6px 10px;
			border: 1px solid #cbd5e1;
			-webkit-print-color-adjust: exact;
			print-color-adjust: exact;
		}
		.meta-table td {
			padding: 6px 10px;
			border: 1px solid #cbd5e1;
			color: #334155;
		}
		
		@media print {
			body {
				padding: 0;
			}
			.maindiv {
				width: 100%;
			}
			.inventory-table th {
				background: <?php echo $primary_color; ?> !important;
				color: <?php echo $font_color; ?> !important;
				border: 1px solid <?php echo $primary_color; ?> !important;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
			.meta-table th {
				background: <?php echo $primary_color; ?> !important;
				color: <?php echo $font_color; ?> !important;
				border: 1px solid #cbd5e1 !important;
				-webkit-print-color-adjust: exact;
				print-color-adjust: exact;
			}
		}
		@page {
			margin: 1.5cm 1cm 1.5cm 1cm;
		}
	</style>
</head>
<body>
<div class="maindiv">
	 
		<!-- Header Block -->
		<div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid <?php echo $primary_color; ?>; padding-bottom: 15px; margin-bottom: 25px;">
			<div style="display: flex; align-items: center; gap: 15px;">
				<img alt='company logo' src='<?php echo $logo;?>' style="height: 70px; width: auto; object-fit: contain;">
				<div style="text-align: left;">
					<h2 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 4px;"><?php if(isset($com_name))echo $com_name;?></h2>
					<p style="font-size: 11px; color: #475569; line-height: 1.4; margin: 0; max-width: 450px;"><?php if(isset($com_address1))echo $com_address1;?></p>
					<p style="font-size: 11px; color: #475569; margin: 2px 0 0 0;"><strong>Email:</strong> <?php if(isset($com_email))echo $com_email;?> | <strong>GSTIN:</strong> <?php echo $com_gst;?></p>
				</div>
			</div>
			<div style="text-align: right;">
				<h1 style="font-size: 24px; font-weight: 800; color: <?php echo $primary_color; ?>; letter-spacing: 1px; text-transform: uppercase; margin: 0;">Purchase Order</h1>
				<?php if(isset($text_edited) && $text_edited==2){ ?>
					<div style="margin-top: 5px;"><span style="font-size: 11px; font-weight: 700; color: #dc2626; background: #fee2e2; padding: 2px 8px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Revised</span></div>
				<?php } ?>
			</div>
		</div>

		<!-- PO Info & Supplier Details Block -->
		<div style="display: flex; justify-content: space-between; align-items: stretch; margin-bottom: 25px; gap: 20px; width: 100%;">
			<!-- PO Details (Left) -->
			<div style="flex: 1; max-width: 48%;">
				<table class="meta-table">
					<tr>
						<th style="width: 120px;">P.O No.</th>
						<td style="font-weight: 700; color: #0f172a;"><?php if(isset($po_no))echo $po_no;?></td>
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
			</div>

			<!-- Supplier Address (Right) -->
			<div style="flex: 1; max-width: 48%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; background-color: #f8fafc; font-size: 11px; display: flex; flex-direction: column;">
				<div style="font-weight: 700; color: <?php echo $primary_color; ?>; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; margin-bottom: 6px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">To (Supplier Info)</div>
				<div style="font-size: 13px; font-weight: 700; color: #0f172a; margin-bottom: 4px;"><?php if(isset($sname))echo $sname;?></div>
				<div style="color: #475569; line-height: 1.4; flex-grow: 1;">
					<?php if(isset($saddress))echo $saddress;?><br>
					<?php if(isset($scity))echo $scity;?>
				</div>
				<div style="margin-top: 8px; font-size: 11px; border-top: 1px dashed #cbd5e1; padding-top: 8px; color: #334155; line-height: 1.5;">
					<strong>Contact Person:</strong> <?php if(isset($sper_name))echo $sper_name;?><br>
					<strong>Mobile:</strong> <?php if(isset($sper_mob))echo $sper_mob;?> | <strong>Email:</strong> <?php if(isset($semail))echo $semail;?><br>
					<strong>GSTIN:</strong> <span style="font-weight: 700; color: #0f172a;"><?php if(isset($supplier_gst))echo $supplier_gst;?></span>
				</div>
			</div>
		</div>
			
		<!-- Items Table -->
		<table class="inventory-table">
			<thead>
				<?php if(!empty($remarks)){ ?>
				<tr style="background-color: #f8fafc;">
					<td style="border: 1px solid #cbd5e1; padding: 8px 10px; font-style: italic; color: #475569;" colspan="11"><strong>Remarks/Instructions:</strong> <?php echo $remarks;?> </td>
				</tr>
				<?php } ?>
						
				<tr>
					<th style="width: 40px; text-align: center;">S.No</th>
					<th style="width: 250px;">Description of Goods</th>
					<th>HSN</th>
					<th>UOM</th>
					<th style="text-align: right;">Quantity</th>
					<th style="text-align: right;">Rate</th>
					<th style="text-align: right;">Dis(%)</th>
					<th style="text-align: right;">Net Rate</th>
					<th style="text-align: right;">Amount</th>
					<th style="text-align: right;"><?php if(isset($res2[0]['gst_type'])){echo $res2[0]['gst_type'];}?></th>
					<th style="text-align: right;">GST Amount</th>
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
							<td style="text-align: center;"><?php echo $i;?></td>
							<td>
								<div style="font-weight: 600; color: #0f172a;"><?php if(isset($pro_name)){echo $pro_name;}?></div>
								<?php if(strlen($product_details)>2){ ?><span style="font-size:10px; color: #64748b;">(<?php echo $product_details;?>)</span><?php }?>
								<?php if(strlen($goodsdetails)>0){ ?><br><span style="font-size:10px; color: #0284c7;">(<?php echo $goodsdetails;?>)</span><?php }?>
							</td>
							<td><?php if(isset($hsn))echo $hsn;?></td>
							<td><?php if(isset($unit_name))echo $unit_name;?></td>
							<td style="text-align: right;"><?php echo (isset($qunt) && is_numeric($qunt)) ? number_format($qunt, 2) : $qunt; ?></td>
							<td style="text-align: right;"><?php echo (isset($rate) && is_numeric($rate)) ? number_format($rate, 2) : $rate; ?></td>
							<td style="text-align: right;"><?php echo (isset($dic) && is_numeric($dic)) ? number_format($dic, 2) : $dic; ?></td>
							<td style="text-align: right;"><?php echo (isset($net) && is_numeric($net)) ? number_format($net, 2) : $net; ?></td>
							<td style="text-align: right;"><?php echo (isset($amt) && is_numeric($amt)) ? number_format($amt, 2) : $amt; ?></td>
							<td style="text-align: right;">
								<?php 
								if ($in['itemigst'] > 0) {
									echo (is_numeric($in['itemigst']) ? number_format($in['itemigst'], 2) : $in['itemigst']) . '%';
								} else {
									echo (is_numeric($in['itemsgst']) ? number_format($in['itemsgst'], 2) : $in['itemsgst']) . '%, ' . 
										 (is_numeric($in['itemcgst']) ? number_format($in['itemcgst'], 2) : $in['itemcgst']) . '%';
								}
								echo " : ";
								echo (isset($in['itemgstrs']) && is_numeric($in['itemgstrs'])) ? number_format($in['itemgstrs'], 2) : $in['itemgstrs']; ?></td>
						</tr>
						
						<?php
						$i++;
					}//loop
				?>
			</tbody>
		</table>
		
		<!-- Footer Calculations & Terms Block -->
		<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 25px; gap: 20px; width: 100%;">
			<!-- Left side: Terms & Conditions -->
			<div style="flex: 1; max-width: 48%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; background-color: #f8fafc; font-size: 11px;">
				<div style="font-weight: 700; color: <?php echo $primary_color; ?>; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; margin-bottom: 8px; border-bottom: 1px solid #cbd5e1; padding-bottom: 4px;">Terms & Schedule</div>
				<table style="width: 100%; border-collapse: collapse; font-size: 11px; line-height: 1.6;">
					<tr style="border-bottom: 1px dashed #cbd5e1;">
						<td style="padding: 5px 0; font-weight: 600; color: #475569; width: 150px;">Payment Terms</td>
						<td style="padding: 5px 0; color: #0f172a;"><?php if(isset($payment_terms))echo $payment_terms;?></td>
					</tr>
					<tr style="border-bottom: 1px dashed #cbd5e1;">
						<td style="padding: 5px 0; font-weight: 600; color: #475569;">Delivery Schedule</td>
						<td style="padding: 5px 0; color: #0f172a;"><?php if(isset($del_schedule))echo $del_schedule;?></td>
					</tr>
					<tr style="border-bottom: 1px dashed #cbd5e1;">
						<td style="padding: 5px 0; font-weight: 600; color: #475569;">Place Of Delivery</td>
						<td style="padding: 5px 0; color: #0f172a;"><?php if(isset($del_place))echo $del_place;?></td>
					</tr>
					<tr style="border-bottom: 1px dashed #cbd5e1;">
						<td style="padding: 5px 0; font-weight: 600; color: #475569;">Mode Of Dispatch</td>
						<td style="padding: 5px 0; color: #0f172a;"><?php if(isset($mod_of_dis))echo $mod_of_dis;?></td>
					</tr>
					<tr style="border-bottom: 1px dashed #cbd5e1;">
						<td style="padding: 5px 0; font-weight: 600; color: #475569;">Loading & Packing Charge</td>
						<td style="padding: 5px 0; color: #0f172a;"><?php if(isset($loading_charge))echo $loading_charge;?></td>
					</tr>
					
				</table>
			</div>

			<!-- Right side: Calculation Breakdown -->
			<div style="flex: 1; max-width: 48%;">
				<table class="meta-table">
					<?php if($total_old > 0) { ?>
						<tr style="border-bottom: 1px solid #cbd5e1;">
							<th style="width: 150px;">Total</th>
							<td style="text-align: right; font-weight: 600;"><?php echo is_numeric($total_old) ? number_format($total_old, 2) : $total_old;?></td>
						</tr>
						<tr style="border-bottom: 1px solid #cbd5e1;">
							<th>After <?php if($dis_per > 0){echo $dis_per.' %';}?> Discount</th>
							<td style="text-align: right; font-weight: 600;"><?php echo is_numeric($total) ? number_format($total, 2) : $total;?></td>
						</tr>
					<?php } else { ?>
						<tr style="border-bottom: 1px solid #cbd5e1;">
							<th style="width: 150px;">Total</th>
							<td style="text-align: right; font-weight: 600;"><?php echo is_numeric($total) ? number_format($total, 2) : $total;?></td>
						</tr>
					<?php } ?>
					<tr style="border-bottom: 1px solid #cbd5e1;">
						<th>FFC</th>
						<td style="text-align: right;"><?php echo is_numeric($ffc_charge) ? number_format($ffc_charge, 2) : $ffc_charge;?></td>
					</tr>
					<tr style="border-bottom: 1px solid #cbd5e1;">
						<th>Total GST</th>
						<td style="text-align: right;"><?php echo is_numeric($gstcharge) ? number_format($gstcharge, 2) : $gstcharge;?></td>
					</tr>
					<tr style="border-bottom: 1px solid #cbd5e1;">
						<th>Round Off</th>
						<td style="text-align: right;"><?php echo is_numeric($roundoff) ? number_format($roundoff, 2) : $roundoff;?></td>
					</tr>
					<tr style="background-color: <?php echo $primary_color; ?> !important; color: <?php echo $font_color; ?> !important;">
						<th style="font-weight: 700; color: <?php echo $font_color; ?> !important; border: 1px solid <?php echo $primary_color; ?>;">Grand Total</th>
						<td style="text-align: right; font-weight: 700; font-size: 13px; color: <?php echo $font_color; ?> !important; border: 1px solid <?php echo $primary_color; ?>;">₹<?php echo is_numeric($grandtotal) ? number_format($grandtotal, 2) : $grandtotal;?></td>
					</tr>
					<tr>
						<td colspan='2' style="padding: 5px 0; color: #0f172a; font-weight: 700;">Payment In Words: <br> <?php if(isset($amount_word))echo $amount_word;?></td>
					</tr>
				</table>
			</div>
		</div>

		<!-- Notes Block -->
		<div style="width: 100%; font-size: 10px; border-top: 1px solid #cbd5e1; margin-top: 30px; padding-top: 15px;">
			<div style="font-weight: 700; color: #1e293b; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.5px;">Notes & Conditions:</div>
			<ol style="margin: 0; padding-left: 15px; line-height: 1.6; color: #475569; list-style-type: decimal;">
				<li>Please mention the P.O. number and date on all your invoices and future correspondence.</li>
				<li>Material will be checked as per our standards at our works.</li>
				<li>Attach Inspection Report / Technical Specification details with every dispatch.</li>
				<li>Please ensure that there is no damage of the material during transportation.</li>
			</ol>
		</div>	

</div>
</body>
</html>
