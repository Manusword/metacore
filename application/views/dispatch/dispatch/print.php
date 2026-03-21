<?php 
	$com = $this->Company->profile();
	$com2 = $this->Company->dispatch_details();
	$com3 = $this->Company->our_gst_details();
	$last_line = $this->Company->dispatch_last_line_details();
	$line_12 = $this->Company->get_full_line_12();
	$line_13 = $this->Company->get_extra_dispatch_qty_per();
	
	
if(isset($_REQUEST['page_no']))
{	
	
	$o=$_REQUEST['page_no'];
	
	if($o==1){$page_type="Original For Recipient";}
	elseif($o==2){$page_type="Duplicate For Transporter";}
	elseif($o==3){$page_type="Triplicate For Supplier";}
	elseif($o==4){$page_type="Extra Copy";}
	else{$page_type="";}
}
else
{
	$page_type = "Original For Recipient";
}

$package=array();
$qty=array();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>Tax Invoice</title>
	<meta name="author" content="Keep codeing, keepcoding.in,Manorajan, Manu "/>
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p {font-family: Arial font-size:x-small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
		
	</style>
	
</head>
<body>
<table cellspacing="0" border="0">
	<colgroup width="39"></colgroup>
	<colgroup width="387"></colgroup>
	<colgroup width="70"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="84"></colgroup>
	<colgroup width="39"></colgroup>
	<colgroup width="70"></colgroup>
	<colgroup width="8"></colgroup>
	<colgroup width="101"></colgroup>
	
    <tr>
    		<td colspan=9>
            	<span style="float:left; margin-left:47%; font-size:20px; font-weight:bold"><?php echo $res2[0]['type_of_bill'];?></span>
            	<span style="float:right; margin-right:10px; font-weight:bold"><?php echo $page_type;?></span>
            </td>
    </tr>

    <?php /*
	<tr>
        <td colspan=9>
            <span style="float:left; margin-left:30%; font-size:14px;">( Issued Under Section 31 of GST ACT & Rule 7 of Invoice Rules )</span>
        </td>
	</tr>
	*/?>

    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 height="100" align="center" valign=top>
        
        
			<table style="width:100%; height:80;">
				<tr>
					<td style="width:25%"><img src="<?php echo base_url().$com[0]['details3'];?>" height="75" width="75"></td>
					<td>
						<table style="border:none; border:white; font-family: Arial">
							<tr>
								<td><p  align="center" style="font-size:26px; font-weight:bold; "><?php echo $com[0]['details1'];?></p></td>
							</tr>
							<tr><td align="center" style="font-size:18px;"><?php echo $com2[0]['details1'];?></td></tr>
							<tr><td align="center" style="font-size:14px;"><?php echo $com2[0]['details2'];?></td></tr>
							<tr><td align="center" style="font-size:14px;">Phone : <?php echo $com2[0]['details3'];?>, Email : <?php echo $com2[0]['details4'];?></td></tr>
							
							<tr>
								<td>
									<p  align="center" style="font-size:12px; font-weight:bold; margin-top:5px;">
										GST NO. : <?php echo $com3[0]['details1'];?>
										<br>
										State : <?php echo $com3[0]['details2'];?>, 
										State Code : <?php echo $com3[0]['details3'];?>
									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table> 
        
        </td>
    </tr>

    
    
    
    
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top:5px; font-size:14px;" colspan=9 height="24" align="left" valign=top>
            <b>
            	Invoice Number :   <span style=" margin-left:10px;">
										<?php if(isset($res2[0]['dispatch_id'])){ echo $this->Dispatchmodel->get_next_bill_no_display($res2[0]['dispatch_id']);}?>
                                   </span>
                
                <span style="float:right; margin-right:50x;">
                    Invoice Date :     
                    <span style=" margin-left:10px;">
                    	<?php if(isset($res2[0]['entry_date'])){ echo $this->Base->change_date_dmy($res2[0]['entry_date']);}?>
                    </span>
                </span>
            </b>
        </td>
	</tr>
	
    
    
    
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px; font-size:14px" colspan=2 height="50" align="left" valign=top>
            <font color="#000000">
			Vendor Code. :    <span style=" margin-left:10%;"><?php if(isset($cust[0]['vender_code']))echo $cust[0]['vender_code'];?></span> <br>
			P.O. No. & Date :  <span style=" margin-left:15%;"><?php if(isset($sch[0]['customer_po']))echo $sch[0]['customer_po'];?></span> <br>
			Payment Terms : <br> 
            Tax is Payable On Reverse Charge ( Yes / No ) :
            </font>
        </td>
		
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top:5px; font-size:14px;" colspan=7 align="left" valign=top>
            <font color="#000000">
                Transportation Mode :     <span style=" margin-left:7%;"><?php if(isset($res2[0]['transport_mode']))echo $res2[0]['transport_mode'];?></span><br> 
                Vehicle. No.   :           <span style=" margin-left:19%;"><?php if(isset($res2[0]['vehicle_no']))echo $res2[0]['vehicle_no'];?></span><br>
                Place of supply  :          	 <span style=" margin-left:15%;"> <?php if(isset($res2[0]['place_of_supply']))echo $res2[0]['place_of_supply'];?></span>
            </font>
        </td>
	</tr>
	
    
    
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px; " colspan=2 height="20" align="left" valign=top>
        	<p align="center" style="font-size:14px;">Details of Receiver ( Billed To )</p>
        </td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px; font-size:14px;" colspan=7 align="left" valign=top>
        	<p align="center" style="font-size:14px;">Details of Consignee ( Shipped To )</p>
       </td>
	</tr>
	
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000';padding-top:5px; " colspan=2 height="75" align="left" valign=top>
            <font color="#000000" style="font-size:14px; padding-top:5px;">
                <span style="font-weight:bold"><?php if(isset($cust[0]['name']))echo $cust[0]['name'];?></span><br>
                <?php if(isset($cust[0]['address']))echo $cust[0]['address'];?>
                <?php if(isset($cust[0]['city']))echo $cust[0]['city'];?>
                <br>
                 <?php 
					if(isset($cust[0]['state']))
					{
						$state1= explode('(',$cust[0]['state']);
						echo $state_name= $state1[0];
						$state2= explode(')',$state1[1]);
						$state_code= $state2[0];
					}
					else{$state_name='';$state_code='';}
				 ?>    
           
                <span style="float:right;">
                	State Code:     
                    <span style=" margin-left:50px; margin-right:20px;">
                    	 <?php echo $state_code;?>
                    </span>
                </span>      
                <br><br>
               
               
                GSTIN Number :         <span style=" margin-left:5%;"><?php if(isset($cust[0]['gst_no']))echo $cust[0]['gst_no'];?></span>
            </font>
        </td>
        
        
        
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top:5px; font-size:14px;" colspan=7 align="left" valign=top>
            <font color="#000000" style="font-size:14px; padding-top:5px;">
               <span style="font-weight:bold"> <?php if(isset($cust[0]['bill_name']) and strlen($cust[0]['bill_name'])>2){echo $cust[0]['bill_name'];}else{echo $cust[0]['name'];}?></span><br>
                 <?php if(isset($cust[0]['bill_address']) and strlen($cust[0]['bill_address'])>2){echo $cust[0]['bill_address'];}else{echo $cust[0]['address'];}?>
                <?php if(isset($cust[0]['bill_city']) and strlen($cust[0]['bill_city'])>2){echo $cust[0]['bill_city'];}else{echo $cust[0]['city'];}?>
                <br>
               
			   <?php 
					if(!empty($cust[0]['bill_state']) and strlen($cust[0]['state'])>2)
					{
						$state1= explode('(',$cust[0]['bill_state']);
						echo $state_name2= $state1[0];
						$state2= explode(')',$state1[1]);
						$state_code2= $state2[0];
					}
					else{$state_name2=$state_name;$state_code2=$state_code;}
				 ?> 
               
                <?php echo $state_name2;?>    
                <span style="float:right;">
                    State Code:     
                    <span style=" margin-left:50px; margin-right:20px;"><?php echo $state_code2;?></span>
                </span>      
                <br><br>
                GSTIN Number :        <span style=" margin-left:5%;"><?php if(isset($cust[0]['gst_no2']) and strlen($cust[0]['gst_no2'])>2){echo $cust[0]['gst_no2'];}else{echo $cust[0]['gst_no'];}?>  </span>
            </font>
        </td>
	</tr>
	
    
    
    
    
    
    
    
    
    <?php /*
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding:5px; font-size:14px;" colspan=2 height="21" align="left" valign=top>
        	    <span style=" margin-left:15%;"><?php //if(isset($sch[0]['customer_po']))echo $sch[0]['customer_po'];?></span>              
        				<span style=" margin-left:15%;"> <?php //if(isset($cust[0]['vender_code']))echo $cust[0]['vender_code'];?></span>
        </td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding:5px; font-size:14px;" colspan=7 align="left" valign=top><?php if(isset($cust[0]['electronic_ref_no']))echo $cust[0]['electronic_ref_no'];?></td>
	</tr>

	*/?>
	
    
    
    
    
    
    
    
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" height="20" align="left" valign=top>S.No</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top>Description of Goods</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top><font color="#000000">HSN Code</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top><?php echo $line_12[0]['details9'];?></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top>Quantity</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top>UOM</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;; " colspan=2 align="left" valign=top>Rate</td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:14px;" align="left" valign=top>Amount</td>
	</tr>
	
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="250" align="center" valign=top>
        	<font color="#000000">
            <span style=" font-size:14px;">
					<?php 
                    for($i=1;$i<=count($res3);$i++)
                    {
                        echo $i.'.';
                        echo "<br>";
                    }
                    ?>
                  </span>
            </font>
        </td>
		
        
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top>
        	<font color="#000000">
            <span style=" font-size:14px;">
            		<?php 
						$customer_id=$res2[0]['customer_id'];
						foreach($res3 as $d)
						{
							$product_id=$d['product_id'];
							$out4 = $this->Customermodel->get_customer_product_rate_detials($customer_id,$product_id); //$this->Mymodel->select_where('customer_rate',$where4);
							if(!empty($out4) and strlen($out4[0]['custname'])>0)
							{
								echo $out4[0]['custname'];
								echo "<br>";
							}
							else
							{
								$out2= $this->Productmodel->get_product_data_with_id($product_id);
								echo $out2[0]['name'];
								if(!empty($out2[0]['details'])){echo ' ('.$out2[0]['details'].')';}
								echo "<br>";
							}
						}
						
						 if(isset($res2[0]['remarks'])){echo '<br>'.$res2[0]['remarks'];} 
                    ?>
                   </span>
            </font>
        </td>
		
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top>
        	<font color="#000000">
            <span style=" font-size:14px;">
            	<?php 
						foreach($res3 as $d)
						{
							echo $d['hsn'];
							echo "<br>";
						}
                    ?>
                    </span>
            </font>
        </td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top>
        	<font color="#000000">
            <span style=" font-size:14px;">
            	<?php 
						foreach($res3 as $d)
						{
							echo $package[]= $d['package_no'];
							echo "<br>";
						}
                    ?>
                </span>
            </font>
        </td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top>
        	<font color="#000000">
            	<span style="float:right; font-size:14px;">
				<?php 
						foreach($res3 as $d)
						{
							echo $qty[]= $d['qty'];
							echo "<br>";
						}
                    ?>
                    </span>
            </font>
        </td>
		
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top>
        	<font color="#000000">
            <span style=" font-size:14px;">
            	<?php 
						foreach($res3 as $d)
						{
							echo $d['unit_name'];
							echo "<br>";
						}
                    ?>
                  </span>
            </font>
        </td>
		
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; " colspan=2 align="left" valign=top>
       	 <font color="#000000">
         	<span style="float:right; font-size:14px;">
			<?php 
						foreach($res3 as $d)
						{
							echo $d['rate'];
							echo "<br>";
						}
                    ?>
               </span>
         </font>
        </td>
		
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top>
        	<font color="#000000">
            	<span style="float:right; font-size:14px;">
				<?php 
						foreach($res3 as $d)
						{
							echo $d['total_amt'];
							echo "<br>";
						}
                    ?>
                    </span>
            </font>
        </td>
	</tr>














	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 rowspan=5 height="170" align="left" valign=top>
            <font color="#000000" style="font-size:14px;">
                                                                                   
                
				Total No. of <?php echo $line_12[0]['details9'];?> : <?php  if(!empty($package))echo array_sum($package);?>,
				<span style=" margin-left:50px;">Total Qty <?php echo $line_12[0]['details10'];?>: <?php  if(!empty($qty))echo round(array_sum($qty),3);?></span>
				<hr>
				<br>
				
				CGST in Words :         
               <?php 
			   		if(!empty($res2[0]['cgst_val']) and $res2[0]['cgst_val']>0)
					{
						$no2=explode('.',$res2[0]['cgst_val']);
						$no=$no2[0];
						echo $this->Mymodel->convert_number_to_words($no);
					}else{echo "--";}
			   ?>
               .<br>		
                
                SGST in Words :
                <?php 
			   		if(!empty($res2[0]['sgst_val']) and $res2[0]['sgst_val']>0)
					{
						$no2=explode('.',$res2[0]['sgst_val']);
						$no=$no2[0];
						echo $this->Mymodel->convert_number_to_words($no);
					}else{echo "--";}
			   ?>
                .<br>
                IGST in Words :
                <?php 
			   		if(!empty($res2[0]['igst_val']) and $res2[0]['igst_val']>0)
					{
						$no2=explode('.',$res2[0]['igst_val']);
						$no=$no2[0];
						echo $this->Mymodel->convert_number_to_words($no);
					}else{echo "--";}
			   ?>.<br>
                <br>

			
               
                Invoice Value ( In Words ) :
                <?php 
			   		if(!empty($res2[0]['grandtotal2']) and $res2[0]['grandtotal2']>0)
					{
						$no2=explode('.',$res2[0]['grandtotal2']);
						$no=$no2[0];
						echo $this->Mymodel->convert_number_to_words($no);
					}
					else
					{
						if(!empty($res2[0]['grandtotal']))
						{
							$no2=explode('.',$res2[0]['grandtotal']);
							$no=$no2[0];
							echo $this->Mymodel->convert_number_to_words($no);
						}else{echo "--";}
					}
				?>.
				<br>
				
				

				<hr>
				
				<?php if($line_13[0]['details10'] == 'Yes'){ ?>
					<span style="font-size:18px; font-weight:bold;font-family: Arial">Bank Details :</span> <br> 
					<span style="font-size:14px; font-family: Arial">
						<?php echo $line_13[0]['details7'].', '.$line_13[0]['details8'].', '.$line_13[0]['details9'];?>
					</span>
				<?php }?>
				
				
					
			   
            </font>
        </td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; padding-top:5px; " colspan=5 align="left" valign=top>
			
		<?php 
		// Amortisation Cost   enable or diable
		if($this->Company->dispatch_entry_charge_apply_amortisation() == 'TRUE')
		{
		?>
			Amortisation Cost 
				<span style="float:right; margin-right:20px; font-size:14px;"><?php if(isset($res2[0]['amortisation_cost_val']))echo$res2[0]['amortisation_cost_val'];?></span>
				<span style="float:right; margin-right:20px; font-size:14px;"><?php if(isset($res2[0]['amortisation_cost_per']))echo '('.$res2[0]['amortisation_cost_per'].')';?> </span>          
				
			<br>
			<br>
		<?php 
		}
		?>
			<spna style="font-size:14px;">Taxable Amount</span>   <span style="float:right; margin-right:20px; font-size:14px;"><?php if(isset($res2[0]['total']))echo $res2[0]['total'];?></span>
        </td>
	</tr>
	
    
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px;  height:40" colspan=5 align="left" valign=top>
        	<font color="#000000">
            		
                        Freight Charges
                        <span style="float:right; margin-right:20px;font-size:12px;;">
                            <?php if(isset($res2[0]['ffc_amt']))echo $res2[0]['ffc_amt'];?>
                        </span><br>
                        Labour Charges      
                        
                        <span style="float:right; margin-right:20px;font-size:12px;">
                            <?php if(isset($res2[0]['laber_charge']))echo $res2[0]['laber_charge'];?>
                        </span>
            		
            
            </font>
        </td>
		</tr>
	<tr>
		<td style="font-size:14px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px;  height:50" colspan=5 align="left" valign=top>
        <font color="#000000">
        	CGST		<span style=" margin-left:40%;"><?php if(!empty($res2[0]['cgst_per'])){echo $res2[0]['cgst_per']; echo "%";}else{echo "-";}?></span>         
						<span style="float:right; margin-right:20px;font-size:12px;"><?php if(!empty($res2[0]['cgst_val'])){echo $res2[0]['cgst_val'];}else{echo "-";}?></span>
						<br>
            SGST        <span style=" margin-left:40%;"><?php if(!empty($res2[0]['sgst_per'])){echo $res2[0]['sgst_per']; echo "%";}else{echo "-";}?></span>         
						<span style="float:right; margin-right:20px;font-size:12px;"><?php if(!empty($res2[0]['sgst_val'])){echo $res2[0]['sgst_val'];}else{echo "-";}?></span>
						<br>
            IGST        <span style=" margin-left:40%;"><?php if(!empty($res2[0]['igst_per'])){echo $res2[0]['igst_per']; echo "%";}else{echo "-";}?></span>         
						<span style="float:right; margin-right:20px;font-size:12px;"><?php if(!empty($res2[0]['igst_val'])){echo $res2[0]['igst_val'];}else{echo "-";}?></span>
						<br>
			
			
        </font>
        </td>
	</tr>
	
    
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px; font-size:14px;" colspan=5 align="left" valign=top>
        		Round OFF / Other Charges              <span style="float:right; margin-right:20px;font-size:12px;"><?php if(isset($res2[0]['roundoff'])){echo $res2[0]['roundoff'];}?></span>
        </td>
	</tr>
	
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;padding-top:5px; font-size:14px;" colspan=5 align="left" valign=top>
            <font color="#000000">
                Sub Total    <span style="float:right; margin-right:20px;font-size:12px;"><?php if(isset($res2[0]['grandtotal'])){echo $res2[0]['grandtotal'];}?></span>
            </font>
			 
			<br>
			TCS         <span style=" margin-left:40%;"><?php if(!empty($res2[0]['tds_per'])){echo $res2[0]['tds_per'];echo "%";}else{echo "-";}?></span>         
						<span style="float:right; margin-right:20px;font-size:12px;"><?php if(!empty($res2[0]['tds_val'])){echo $res2[0]['tds_val'];}else{echo "-";}?></span>
			<?php 
				if(!empty($res2[0]['grandtotal2']) and $res2[0]['grandtotal2']>0)
				{
					?>
					<br>
					<font color="#000000">
						GRAND TOTAL    <span style="float:right; margin-right:20px;font-size:12px;"><?php if(isset($res2[0]['grandtotal2'])){echo $res2[0]['grandtotal2'];}?></span>
					</font>
				<?php 
				}
			
			?>
			
        </td>
	</tr>

	

	<?php /*
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; font-size:10px;" colspan=9 height="10" align="left" valign=top>
        <font color="#000000">
			<?php if($last_line[0]['details2'] == 'Yes'){ ?>
				<?php echo $last_line[0]['details3'];?>
			<?php }?>
        </font>
        </td>
	</tr>
	*/?>
    
    
    
    <tr>
		<td style="font-size:12px;border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=9 height="20" align="left" valign=top>
        <font color="#000000" >
        	
            <span style="font-weight:bold; ">
            		Terms &amp; Conditions      
                    <span style="float:right; margin-right:0%; font-size:14px;">For <?php echo $com[0]['details1'];?></span>
            </span>
            
            <br>
            
            <?php if($last_line[0]['details5'] == 'Yes'){ ?>
				<?php echo $last_line[0]['details6'];?>
			<?php }?>
           
            <br>
            
            <span style="float:right; margin-right:0%; font-weight:bold">Auth. Signatory</span>
            
            E.&amp;O.E.			
        </font>
        </td>
	</tr>
</table>


<?php if($last_line[0]['details8'] == 'Yes'){ ?>
	<span style="font-size:14px; font-weight:bold"><?php echo $last_line[0]['details9'];?></span> 
<?php }?>


</body>
</html>






