<script type="text/javascript">




	function fun_save_schedule_remarks2(id,val)
	{
		var id2 = id.split("_");
		var id_no=id2[1];
		
		jQuery.post("<?php echo base_url().'index.php/Dispatch/fun_save_schedule_remarks2';?>", 
			{
				id_no:id_no,
				val:val,
			}, 
			
			function(data, textStatus)
			{	
				//alert(data);
			});
			
		
	}//function close

	function popup_product_his_fun(id)
	{
		$('#popup_product_his_dis').html('');
		
		var id2 = id.split("_");
		var id_no=id2[1];
		
		jQuery.post("<?php echo base_url().'index.php/Dispatch/popup_product_his_fun';?>", 
		{
			id_no:id_no,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			$('#popup_product_his_dis').html(data);
		});
	}//function close





	function fun_get_product_from_schedule_id(schedule_id)
	{
		var customer_id=$('#customer_id').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_get_product';?>", 
			{
				customer_id:customer_id,
				schedule_id:schedule_id,
				
			}, 
			
			function(data, textStatus)
			{	
				$('.goods').html(data);
				$('.loader').hide();
			});
		});
	}//function close


	function fun_get_product_from_schedule_id2(customer_id)
	{
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_get_product2';?>", 
			{
				customer_id:customer_id,
			}, 
			function(data, textStatus)
			{	
				$('.goods').html(data);
				$('.loader').hide();
			});
		});
	}//function close


	function fun_cal_cost(id)
	{
		var id2 = id.split("_");
		var id_no=id2[1]
		
		var rate_id = "#rate_".concat(id_no);
		var rate_val=$(rate_id).val();

		var order_id = "#order_".concat(id_no);
		var order_val=$(order_id).val();

		var cost=(+rate_val)*(+order_val);
		var cost2=cost.toFixed(2);
		
		var cost_id = "#cost_".concat(id_no);
		$(cost_id).val(cost2);
		
		
		var i=1
		var amount_weight_sum=0;
		$(".cost").each(function(){
			
			if(this.value>0)
			{
				var val=this.value;
				amount_weight_sum=(+amount_weight_sum)+(+val);
				//alert(this.value);
			}
			i++;
		});
		//alert(amount_sum);
		var amount_weight_sum2=amount_weight_sum.toFixed(2);
		$("#total_amt").val(amount_weight_sum2);
				

	}//function close




	

	//--------------------------------------------dispatch
	function fut_get_pono(customer_id)
	{
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_get_po_no';?>", 
			{
				customer_id:customer_id,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#po_no').html(data);
				fut_get_cust_gst(customer_id);//------------------------geting place of delivery or gst type of customer
				$('.loader').hide();
			});
		});
	}//function close

	
	function fut_get_cust_gst(customer_id)
	{
		jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_get_cust_gst';?>", 
		{
			customer_id:customer_id,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			var id2 = data.split("~");
			$('#place_of_supply').val(id2[0]);
			$('#sgst_per').val(id2[1]);
			$('#cgst_per').val(id2[2]);
			$('#igst_per').val(id2[3]);
			$('#tds_per').val(id2[4]);
		});
	}//function close


	


	//get qty rate details from product and schedule
	function fun_product_in_dispatch(id,bill_type)
	{
		var customer_id=$('#customer_id').val();
		var po_no=$('#po_no').val();
		var discount_offer=$('#discount_offer').val();
		
		var id2 = id.split("_");
		var id_no=id2[1];
		
		var product_id = "#goods_".concat(id_no);
		var cust_sech_details_id2=$(product_id).val();
		var cust_sech_details_id=cust_sech_details_id2.toUpperCase();
		$(product_id).val(cust_sech_details_id);
		var totalqty_id = "#totalqty_".concat(id_no);
		var recqty_id = "#recqty_".concat(id_no);
		var net_id = "#net_".concat(id_no);
		var package_id = "#package_".concat(id_no);
		var price_id = "#price_".concat(id_no);
		var amount_id = "#amount_".concat(id_no);
		var hsn_id = "#hsn_".concat(id_no);
		var unitname_id = "#unitname_".concat(id_no);
		var discountdetails_id = "#discountdetails_".concat(id_no);
		
		if(bill_type==1 || bill_type==3 || cust_sech_details_id.length>6)
		{
			
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_get_product_details';?>", 
					{
						cust_sech_details_id:cust_sech_details_id,
						customer_id:customer_id,
						po_no:po_no,
						bill_type:bill_type,
						discount_offer:discount_offer,
					}, 
					function(data, textStatus)
					{	
						//alert(data);
						var data2 = data.split("~");
						$(totalqty_id).val(data2[0]);
						$(recqty_id).val(data2[1]);
						$(price_id).val(data2[2]);
						$(hsn_id).val(data2[3]);
						$(unitname_id).val(data2[4]);
						
						////--------calling total funtion same funtion in add button delete button
						fun_get_total();	 
						$('.loader').hide();
					});
			});
		}
			
	}//function close




		
	function fun_price_dispatch(id)
	{
		var id2 = id.split("_");
		var id_no=id2[1]
		var qty = "#net_".concat(id_no);
		var qty_val=$(qty).val();
		var rate = "#price_".concat(id_no);
		var rate_val=$(rate).val();
		var amount = "#amount_".concat(id_no);
		var total_amt_sum=(+rate_val)*(+qty_val);
		var total_amt_sum2=total_amt_sum.toFixed(2);
		$(amount).val(total_amt_sum2);
		fun_get_total();	
	}//function close

	function fun_get_total()
	{
		var i=1
		var amount_sum=0;
		$(".total_amount").each(function(){
			if(this.value>0)
			{
				var val=this.value;
				amount_sum=(+amount_sum)+(+val);
			}
			i++;
		});
		var amount_sum2=amount_sum.toFixed(2)
		$("#total_old").val(amount_sum2);
		fun_grand_total();
	}//function close

	function fun_grand_total()
	{
		fun_get_discount_amt();	
		fun_sgst();
		fun_cgst();
		fun_igst();	
		fun_grand_total2();
	}//function close

	function fun_get_discount_amt()	
	{
		var total2=$("#total_old").val();
		//-----------------Extra discount
		var other_discount_per=$("#other_discount_per").val();
		if(other_discount_per>0)
		{
			//alert(other_discount_per);
			var dis_amt=((+total2)*(+other_discount_per)/100);
			
			var amount_sum2=dis_amt.toFixed(2);
			$("#discount").val(amount_sum2);
			
			var taxable_amt=(+total2)-(+amount_sum2);
			var taxable_amt=taxable_amt.toFixed(2)
			//$("#taxable_amt").val(taxable_amt);
		}
		else
		{
			var taxable_amt = total2;
			$("#discount").val(0.00);
			//$("#taxable_amt").val(taxable_amt);
		}
		
		//-----------------Tod cost
		var tod_per = $("#tod_per").val();
		if(tod_per>0)
		{
			//getting total qty
			var sum_weight = 0;        
			
			var tds_amt1=((+taxable_amt)*(+tod_per)/100);
			var tds_amt2=tds_amt1.toFixed(2);
			$("#tod_cost_val").val(tds_amt2);
			
			var taxable_amt=(+taxable_amt)-(+tds_amt2);
			var taxable_amt=taxable_amt.toFixed(2)
		}
		else
		{
			var taxable_amt = taxable_amt;
			$("#tod_cost_val").val(0.00);
		}

		//-----------------Amortisation cost
		var amortisation_cost_per = $("#amortisation_cost_per").val();
		if(amortisation_cost_per>0)
		{
			//getting total qty
			var sum_weight = 0;        
			$(".amount_weight").each(function() 
			{ 
				if(!isNaN(this.value) && this.value.length!=0) 
				{
					sum_weight += parseFloat(this.value);            
				}         
			});

			var mult_amort_cost  = (((+sum_weight)*(+amortisation_cost_per))).toFixed(2);
			var mult_amort_cost2  = ((+mult_amort_cost)+(+taxable_amt)).toFixed(2);
			
			$("#amortisation_cost_val").val(mult_amort_cost);
			$("#taxable_amt").val(mult_amort_cost2);
		}
		else
		{
			$("#amortisation_cost_val").val(0.00);
			$("#taxable_amt").val(taxable_amt);
		}
		fun_grand_total2();
	}//funtion close

	//GST Calculate
	function fun_sgst()	
	{
		var total2=$("#taxable_amt").val();
		var ffc_amt=$('#ffc_amt').val();
		var laber_charge=$('#laber_charge').val();
		var total=(+total2)+(+ffc_amt)+(+laber_charge);
		var per=$("#sgst_per").val();
		var amount_sum=((+total)/100)*(+per);
		var amount_sum2=amount_sum.toFixed(2)
		$("#sgst_val").val(amount_sum2);
		fun_grand_total2();
	}//funtion close

	
	function fun_cgst()	
	{
		var total2=$("#taxable_amt").val();
		var ffc_amt=$('#ffc_amt').val();
		var laber_charge=$('#laber_charge').val();
		var total=(+total2)+(+ffc_amt)+(+laber_charge);
		var per=$("#cgst_per").val();
		var amount_sum=((+total)/100)*(+per);
		var amount_sum2=amount_sum.toFixed(2)
		$("#cgst_val").val(amount_sum2);
		fun_grand_total2();
	}//funtion close

	function fun_igst()	
	{
		var total2=$("#taxable_amt").val();
		var ffc_amt=$('#ffc_amt').val();
		var laber_charge=$('#laber_charge').val();
		var total=(+total2)+(+ffc_amt)+(+laber_charge);
		var per=$("#igst_per").val();
		var amount_sum=((+total)/100)*(+per);
		var amount_sum2=amount_sum.toFixed(2)
		$("#igst_val").val(amount_sum2);
		fun_grand_total2();
	}//funtion close

	//grand total
	function fun_grand_total2()
	{
		var total_old=$("#total_old").val();
		var ffc_amt=$('#ffc_amt').val();
		var ffc_amt=$('#ffc_amt').val();
		var laber_charge=$('#laber_charge').val();
		var discount=$('#discount').val();
		var tod_cost_val=$('#tod_cost_val').val();
		var sgst_val=$("#sgst_val").val();
		var cgst_val=$("#cgst_val").val();
		var igst_val=$("#igst_val").val();
		var tds_val=$("#tds_val").val();
		var roundoff=$("#roundoff").val();
		var amount_sum3=(+total_old)+(+ffc_amt)+(+laber_charge)+(+sgst_val)+(+cgst_val)+(+igst_val)+(+roundoff);
		amount_sum3=(+amount_sum3)-(+discount)-(+tod_cost_val);
		var amount_sum4=amount_sum3.toFixed(0);
		$("#grandtotal").val(amount_sum4);
		//tcs amt
		var per=$("#tds_per").val();
		var amount_sum5=((+amount_sum4)/100)*(+per);
		var tcs=amount_sum5.toFixed(0);
		$("#tds_val").val(tcs);
		var grandtotal2 = ((+amount_sum4)+(+tcs));
		var grandtotal3 =grandtotal2.toFixed(0);
		$("#grandtotal2").val(grandtotal3);
	}//function close













//-----------------------------------------------------------save
$(document).ready(function(e) {
    
	$("#search_date1").datepicker({ dateFormat: 'dd-mm-yy'});  
	$("#search_date2").datepicker({dateFormat: 'dd-mm-yy'});  
	$("#entry_date").datepicker({dateFormat: 'dd-mm-yy'}); 
	$("#po_date").datepicker({dateFormat: 'dd-mm-yy'});  
	$(".fromdate").datepicker({dateFormat: 'dd-mm-yy'});  
	$(".todate").datepicker({dateFormat: 'dd-mm-yy'});  
	
   
   
    $('#schedule_save').click(function(){

			var url=$('#url').val();
			var id=$('#id').val();
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Schedule Date','toast-bottom-right');return false;}
			var supply=$('#supply').val();if(supply==''){$('#supply').focus();fun_message('warning','Warning','Select Supply','toast-bottom-right');return false;}
			var customer=$('#customer').val();if(customer==''){$('#customer').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
			var actual_month=$('#actual_month').val();if(actual_month==''){$('#actual_month').focus();fun_message('warning','Warning','Enter Po Date','toast-bottom-right');return false;}
			var po_no=$('#po_no').val();if(po_no==''){$('#po_no').focus();fun_message('warning','Warning','Enter PO NO','toast-bottom-right');return false;}
			var po_date=$('#po_date').val();if(po_date==''){$('#po_date').focus();fun_message('warning','Warning','Enter Po Date','toast-bottom-right');return false;}
			var type_of_bill=$('#type_of_bill').val();if(type_of_bill==''){$('#type_of_bill').focus();fun_message('warning','Warning','Select Type Of Bill','toast-bottom-right');return false;}
			
			
			//------------------------------------------------------------------amount validation
			var taxamountid;
			var a;
			$(".goods").each(function(){<!--geting each value-->
				var goods_val=$(this).val();
				if(goods_val>0)
				{
					var goods_id=$(this).attr('id');<!--geting each id-->
					var inamount_str = goods_id.split("_");<!--splid id-->
					//alert(inamount_str[1]);
					var priceid="#order_".concat(inamount_str[1]);<!--concatenent id-->
					var pricevalue=$(priceid).val();<!--geting value-->
					//alert(intaxtypevalue);
					if(pricevalue=='')
					{
						a=priceid;
						//alert("Select Tax Type");
						//$(taxamountid).focus();
						return false;
					}
				}//if
			});//foreach
		
			if(a!=null)
			{
				form_validation('Fill  Order qty.  ');
				$(a).focus();
				return false
			}
			
			//------------------------------------------------------------------amount validation
			
			    
			
       
			
			
			
			
			<!---------------------------------------------------row-------------------------------->
			var details_id="";
			var goods="";
			var grade="";
			var rate="";
			var order="";
			var unit="";
			var forecast="";
			var cost="";
			var fromdate="";
			var todate="";
			var oil="";
			var proremarks="";
			
			$(".details_id").each(function(){		details_id=details_id.concat('~').concat($(this).val());						});
			$(".goods").each(function(){			    goods=goods.concat('~').concat($(this).val());						});
			$(".grade").each(function(){			    grade=grade.concat('~').concat($(this).val());						});
			$(".rate").each(function(){				rate=rate.concat('~').concat($(this).val());						});
			$(".order").each(function(){			    order=order.concat('~').concat($(this).val());						});
			$(".unit").each(function(){			    unit=unit.concat('~').concat($(this).val());						});
			$(".forecast").each(function(){			    forecast=forecast.concat('~').concat($(this).val());						});
			$(".cost").each(function(){				cost=cost.concat('~').concat($(this).val());						});
			$(".fromdate").each(function(){			fromdate=fromdate.concat('~').concat($(this).val());				});
			$(".todate").each(function(){			todate=todate.concat('~').concat($(this).val());					});
			$(".oil").each(function(){			oil=oil.concat('~').concat($(this).val());					});
			$(".proremarks").each(function(){			proremarks=proremarks.concat('~').concat($(this).val());					});
			
			<!---------------------------------------------------row-------------------------------->
			
			var comment=$('#comment').val();
			
			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			
			
			//-------------------------------save
			$('#wait').show();
			$('#schedule_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Dispatch/add_schedule_save';?>", 
							  {
								    id:id,
								    supply:supply,
								    entry_date:entry_date,
									customer:customer,
									po_no:po_no,
									actual_month:actual_month,
									po_date:po_date,
									type_of_bill:type_of_bill,
									details_id:details_id,
									goods:goods,
									grade:grade,
									rate:rate,
									order:order,
									unit:unit,
									forecast:forecast,
									oil:oil,
									proremarks:proremarks,
									cost:cost,
									fromdate:fromdate,
									todate:todate,
								  	comment:comment,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('#wait').hide();
								$('#schedule_save').show();
							});
					});
		});
	//-------------------------------save







		
	//-----------------------------------------------search
	$('#schedule_search').click(function(){
		
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var type_of_bill=$('#type_of_bill').val();
		var customer=$('#customer').val();
		var product=$('#name_').val();
		var po_no=$('#po_no').val();
		var oil=$('#oil').val();
		var actual_month2=$('#actual_month2').val();
		var grade=$('#grade').val();
		var sales_person=$('#sales_person').val();
		var area_location=$('#area_location').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Dispatch/schedule_list';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					customer:customer,
					type_of_bill:type_of_bill,
					product:product,
					po_no:po_no,
					actual_month2:actual_month2,
					oil:oil,
					grade:grade,
					area_location:area_location,
					sales_person:sales_person,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});
		});
	});//search close




	

	//----------------------------------------------------DISPATCH SAVE
	$('#dispatch_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			var old_grand_total_amt=$('#old_grand_total_amt').val();
			
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			var type_of_bill=$('#type_of_bill').val();if(type_of_bill==''){$('#type_of_bill').focus();fun_message('warning','Warning','Select type Of Bill','toast-bottom-right');return false;}
			var discount_offer=$('#discount_offer').val();
			var invoice_no=$('#invoice_no').val();if(invoice_no==''){$('#invoice_no').focus();fun_message('warning','Warning','Enter invoice_no','toast-bottom-right');return false;}
			var customer_id=$('#customer_id').val();if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
			//var po_no=$('#po_no').val();if(po_no==''){$('#po_no').focus();fun_message('warning','Warning','Enter PO NO','toast-bottom-right');return false;}
			var po_no= "";
			var transport_mode=$('#transport_mode').val();if(transport_mode==''){$('#transport_mode').focus();fun_message('warning','Warning','Enter transport_mode','toast-bottom-right');return false;}
			var vehicle_no=$('#vehicle_no').val();if(vehicle_no==''){$('#vehicle_no').focus();fun_message('warning','Warning','Enter vehicle_no','toast-bottom-right');return false;}
			var place_of_supply=$('#place_of_supply').val();if(place_of_supply==''){$('#place_of_supply').focus();fun_message('warning','Warning','Enter place_of_supply','toast-bottom-right');return false;}
			var isexport=$('#isexport').val();
			
			<!---------------------------------------------------row-------------------------------->
			var dispatch_details_id="";
			var oldgoodsid="";
			var oldqty="";
			var oldamt="";
			var goods="";
			var amount_weight="";
			var unitname="";
			var hsn="";
			var package="";
			var price="";
			var total_amount="";
			
			$(".dispatch_details_id").each(function(){			dispatch_details_id=dispatch_details_id.concat('~').concat($(this).val());		});
			$(".oldgoodsid").each(function(){					oldgoodsid=oldgoodsid.concat('~').concat($(this).val());		});
			$(".oldqty").each(function(){						oldqty=oldqty.concat('~').concat($(this).val());		});
			$(".oldamt").each(function(){						oldamt=oldamt.concat('~').concat($(this).val());		});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());					});
			$(".amount_weight").each(function(){	amount_weight=amount_weight.concat('~').concat($(this).val());						});
			$(".unitname").each(function(){			unitname=unitname.concat('~').concat($(this).val());			});
			$(".hsn").each(function(){				hsn=hsn.concat('~').concat($(this).val());						});
			$(".package").each(function(){			package=package.concat('~').concat($(this).val());				});
			$(".price").each(function(){			price=price.concat('~').concat($(this).val());					});
			$(".total_amount").each(function(){		total_amount=total_amount.concat('~').concat($(this).val());	});
			
			<!---------------------------------------------------row-------------------------------->
			
			var total_old=$('#total_old').val();if(total_old==''){$('#total_old').focus();fun_message('warning','Warning','Enter Total','toast-bottom-right');return false;}
			var other_discount_per=$('#other_discount_per').val();
			var discount=$('#discount').val();if(discount==''){$('#discount').focus();fun_message('warning','Warning','Enter discount','toast-bottom-right');return false;}
			var tod_per=$('#tod_per').val();
			var tod_cost_val=$('#tod_cost_val').val();
			var amortisation_cost_per=$('#amortisation_cost_per').val();
			var amortisation_cost_val=$('#amortisation_cost_val').val();
			var taxable_amt=$('#taxable_amt').val();if(taxable_amt==''){$('#taxable_amt').focus();fun_message('warning','Warning','Enter taxable_amt','toast-bottom-right');return false;}
			var ffc_amt=$('#ffc_amt').val();if(ffc_amt==''){$('#ffc_amt').focus();fun_message('warning','Warning','Enter ffc_amt','toast-bottom-right');return false;}
			var laber_charge=$('#laber_charge').val();if(laber_charge==''){$('#laber_charge').focus();fun_message('warning','Warning','Enter laber_charge','toast-bottom-right');return false;}
			var sgst_per=$('#sgst_per').val();
			var cgst_per=$('#cgst_per').val();
			var igst_per=$('#igst_per').val();
			var sgst_val=$('#sgst_val').val();
			var cgst_val=$('#cgst_val').val();
			var igst_val=$('#igst_val').val();
			var tds_per=$('#tds_per').val();
			var tds_val=$('#tds_val').val();
			var total_gst_value=(+sgst_val)+(+cgst_val)+(+igst_val);
			
			if(total_gst_value>1)
			{
				//do noting
			}
			else
			{
				///checking export or not
				if(isexport == 'No')
				{
					fun_message('warning','Warning','Enter GST % and GST Value','toast-bottom-right');
					return false;
				}
			}			
			var roundoff=$('#roundoff').val();
			var grandtotal=$('#grandtotal').val();if(grandtotal==''){$('#grandtotal').focus();fun_message('warning','Warning','Enter grandtotal','toast-bottom-right');return false;}
			var grandtotal2=$('#grandtotal2').val();
			var remarks=$('#remarks').val();
			
			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			//-------------------------------save
			$('#wait').show();
			$('#dispatch_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Dispatch/add_dispatch_save';?>", 
							  {
								    id:id,
									old_grand_total_amt:old_grand_total_amt,
								   
								    entry_date:entry_date,
									type_of_bill:type_of_bill,
									invoice_no:invoice_no,
									customer_id:customer_id,
									po_no:po_no,
									transport_mode:transport_mode,
									vehicle_no:vehicle_no,
									place_of_supply:place_of_supply,
									discount_offer:discount_offer,
									isexport:isexport,
									
									dispatch_details_id:dispatch_details_id,
									oldgoodsid:oldgoodsid,
									oldqty:oldqty,
									oldamt:oldamt,
									goods:goods,
									amount_weight:amount_weight,
									unitname:unitname,
									hsn:hsn,
									package:package,
									price:price,
									total_amount:total_amount,
								  	
									total_old:total_old,
									other_discount_per:other_discount_per,
									discount:discount,
									tod_per:tod_per,
									tod_cost_val:tod_cost_val,
									amortisation_cost_per:amortisation_cost_per,
									amortisation_cost_val:amortisation_cost_val,
									taxable_amt:taxable_amt,
									
									ffc_amt:ffc_amt,
									laber_charge:laber_charge,
									
									sgst_per:sgst_per,
									cgst_per:cgst_per,
									igst_per:igst_per,
									
			
									sgst_val:sgst_val,
									cgst_val:cgst_val,
									igst_val:igst_val,

									tds_per:tds_per,
									tds_val:tds_val,
			
									roundoff:roundoff,
									grandtotal:grandtotal,
									grandtotal2:grandtotal2,
								  	remarks:remarks,
								 
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('#wait').hide();
								$('#dispatch_save').show();
							});
					});
	});
	//-------------------------------save





	//-----------------------------------------------search
	$('#dispatch_search').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var customer=$('#customer').val();
		var product=$('#name_').val();
		var no=$('#no').val();
		var type_of_bill=$('#type_of_bill').val();
		var cancel_status=$('#cancel_status').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_list';?>", 
			{
				type_of_bill:type_of_bill,
				search_date1:search_date1,
				search_date2:search_date2,
				customer:customer,
				product:product,
				no:no,
				cancel_status:cancel_status,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close


	//-----------------------------------------------search
	$('#dispatch_search2').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var customer=$('#customer').val();
		var product=$('#name_').val();
		//var grade=$('#grade').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_list2';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				customer:customer,
				product:product,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close


	//-----------------------------------------------search
	$('#dispatch_search3').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		//var grade=$('#grade').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_list3';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close

	//-----------------------------------------------search
	$('#dispatch_search4').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		//var grade=$('#grade').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/dispatch_list4';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close





	//-----------------------------------------------search 3
	$('#supply_grade_wise').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var sales_person=$('#sales_person').val();
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Dispatch/supply_grade_wise';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				sales_person:sales_person,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});//jquery
		});//loader
	});//search close







});//Document 



</script>




