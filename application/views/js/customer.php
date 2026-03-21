<script>
$("#search_mail_all_check").click(function(){
    $('.all_mall_id:checkbox').not(this).prop('checked', this.checked);
});










//----------------------------------entry of receive payment
function get_row_balance_amt(id,val)
{
						
	var id2 = id.split("_");
	var id_no=id2[1]
	
	//bill amt
	var billAmt = "#amountid_".concat(id_no);
	var billAmt_val=$(billAmt).val();

	//paid amt
	var paidAmt = "#paidamountid_".concat(id_no);
	var paidAmt_val=$(paidAmt).val();

	var bal_amt = (+billAmt_val) -((+paidAmt_val)+(+val));
	var bal_amt2 = bal_amt.toFixed();

	var balAmtID = "#balanceamount_".concat(id_no);
	$(balAmtID).val(bal_amt2);

	fun_get_total_row_amt_display();	

}//function close


function fun_get_total_row_amt_display()
{
	
	var i=1
	var amount_sum=0;
	$(".all_paid_amount").each(function(){
		
		if(this.value>0)
		{
			var val=this.value;
			amount_sum=(+amount_sum)+(+val);
			//alert(this.value);
		}
		i++;
	});
	$('#total_row_amt_display').html(amount_sum);
}//fucntion close 


//----------------------------------entry of receive payment
function fun_get_payment_entry_block_details(customer_id)
{
	var search = 1
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/fun_get_payment_entry_block_details';?>", 
			{
				customer_id:customer_id,
				search:search,
			}, 
			function(data, textStatus)
			{	
				$('#fun_pyment_entry_display_box').html(data);
				$('.loader').hide();
			});
	 });
	
}//fucntion close 




//----------------------------------get today die history list
function fun_get_cust_details(customer_id,all_value)
{
	$('#fun_get_cust_details_display_box').html('');
	var search = 1
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/fun_get_cust_details';?>", 
			{
				customer_id:customer_id,
				all_value:all_value,
				search:search,
			}, 
			function(data, textStatus)
			{	
				$('#fun_get_cust_details_display_box').html(data);
				$('.loader').hide();
			});
	 });
	
}//fucntion close 



//--------------------------------------------die no check
function fun_check_customer_code(val)
{
	//if(id.length>=3)
	//{
	 	//$('.loader').show();
			//setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Customer/fun_check_customer_code';?>", 
							{
								customer_code:val,
							}, 
							
							function(data, textStatus)
							{	
								$('#customer_code_span').html(data);
								//$('.loader').hide();
							});
				// });
	//}
}//fucntion close




$(function () {
		//$( "#invoice_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
		
		$("#complain_date").datepicker({dateFormat: 'dd-mm-yy'});
		$("#tag_date1").datepicker({dateFormat: 'dd-mm-yy'});
		$("#tag_date2").datepicker({dateFormat: 'dd-mm-yy'});
		$("#resolution").datepicker({dateFormat: 'dd-mm-yy'});

		$("#receive_date").datepicker({dateFormat: 'dd-mm-yy'});
		$("#expiry_date").datepicker({dateFormat: 'dd-mm-yy'});
		
		
		$( "#recp_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});
		
		$( "#closure_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});
		
		$( "#imm_action_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});
		
		$( "#currt_act_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});
		
		$( "#comp_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});


		$( "#search_date1" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});


		$( "#search_date2" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});


		$( "#qut_sub_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});


		$( "#sample_sub_target_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});


		$( "#sample_sub_date" ).datepicker({
		dateFormat: 'dd-mm-yy',
		});

		$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: -0,
    });
		
		
		
	});
 



$(document).ready(function(e) {
    $('#customer_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			
			var type=$('#type').val();if(type==''){$('#type').focus();fun_message('warning','Warning','Select Type','toast-bottom-right');return false;}
			var name=$('#name').val();if(name==''){$('#name').focus();fun_message('warning','Warning','Enter Name','toast-bottom-right');return false;}
			var telphone=$('#telphone').val();if(telphone==''){$('#telphone').focus();fun_message('warning','Warning','Enter Telephone No','toast-bottom-right');return false;}
			var email=$('#email').val();
			var customer_code=$('#customer_code').val();
			var address=$('#address').val();if(address==''){$('#address').focus();fun_message('warning','Warning','Enter Address','toast-bottom-right');return false;}
			var city=$('#city').val();if(city==''){$('#city').focus();fun_message('warning','Warning','Enter City','toast-bottom-right');return false;}
			var state=$('#state').val();if(state==''){$('#state').focus();fun_message('warning','Warning','Select State','toast-bottom-right');return false;}
			var country=$('#country').val();if(country==''){$('#country').focus();fun_message('warning','Warning','Enter Country','toast-bottom-right');return false;}
			var zip=$('#zip').val();
			var vender_code=$('#vender_code').val();
			//bill
			var bill_name=$('#bill_name').val();
			var bill_address=$('#bill_address').val();
			var bill_city=$('#bill_city').val();
			var bill_state=$('#bill_state').val();
			var bill_country=$('#bill_country').val();
			var bill_zip=$('#bill_zip').val();
			var con_name1=$('#con_name1').val();
			var con_mob1=$('#con_mob1').val();
			var con_email1=$('#con_email1').val();
			var designation1=$('#designation1').val();
			var con_name2=$('#con_name2').val();
			var con_mob2=$('#con_mob2').val();
			var con_email2=$('#con_email2').val();
			var designation2=$('#designation2').val();
			var limit_of_dis=$('#limit_of_dis').val();
			var limit_of_days=$('#limit_of_days').val();
			var gst=$('#gst').val();if(gst==''){$('#gst').focus();fun_message('warning','Warning','Enter GST','toast-bottom-right');return false;}
			var gst2=$('#gst2').val();
			var is_tcs=$('#is_tcs').val();
			var show_in_follow_up=$('#show_in_follow_up').val();
			let disputed_issue=$('#disputed_issue').val();
			
			
			
			//------------------------------------------------------------------product validation
			var taxamountid;
			var b;
			$(".goods2").each(function(){<!--geting each value-->
				var goods2_val=$(this).val();
				if(goods2_val.length>0)
				{
					var goods2_id=$(this).attr('id');<!--geting each id-->
					var inamount_str = goods2_id.split("_");<!--splid id-->
					var good2_id="#goods2_".concat(inamount_str[1]);<!--concatenent id-->
					var itemid="#goods_".concat(inamount_str[1]);<!--concatenent id-->
					var itemval=$(itemid).val();<!--geting value-->
					if(itemval=='' && itemval==0)
					{
						b=good2_id;
						return false;
					}
				}//if
			});//foreach
		
			if(b!=null)
			{
				form_validation('Product Not Found. please Type To select ');
				$(b).focus();
				return false
			}
			//--------------------------------------------------------------------product

			
			var scheme1=$('#scheme1').val();
			
			var dis_val1=$('#dis_val1').val();
			var dis_day1=$('#dis_day1').val();
			
			var dis_val2=$('#dis_val2').val();
			var dis_day2=$('#dis_day2').val();
			
			var dis_val3=$('#dis_val3').val();
			var dis_day3=$('#dis_day3').val();
			
			var sales_person=$('#sales_person').val();
			var area_location=$('#area_location').val();
			var active=$('#active').val();
			
			
			<!---------------------------------------------------row-------------------------------->
			var details_id="";
			var goods="";
			var rate="";
			var custname="";
			
			
			
			$(".details_id").each(function(){		details_id=details_id.concat('~').concat($(this).val());		});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());						});
			$(".rate").each(function(){				rate=rate.concat('~').concat($(this).val());						});
			$(".custname").each(function(){			custname=custname.concat('~').concat($(this).val());						});
			
			
			//-------------------------------save
			  $('#wait').show();
			  $('#customer_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Customer/save';?>", 
							  {
								  id:id,
								  type:type,
								  name:name,
								  customer_code:customer_code,
								  telphone:telphone,
								  email:email,
								  address:address,
								  city:city,
								  state:state,
								  country:country,
								  zip,zip,
								  vender_code:vender_code,
								  con_name1:con_name1,
								  con_mob1:con_mob1,
								  con_email1:con_email1,
								  designation1:designation1,
								  
								  bill_name:bill_name,
								  bill_address:bill_address,
								  bill_city:bill_city,
								  bill_state:bill_state,
								  bill_country:bill_country,
								  bill_zip:bill_zip,
								  
								  con_name2:con_name2,
								  con_mob2:con_mob2,
								  con_email2:con_email2,
								  designation2:designation2,
								  
								  limit_of_dis:limit_of_dis,
								  limit_of_days:limit_of_days,

								  scheme1:scheme1,
								  dis_val1:dis_val1,
								  dis_day1:dis_day1,
								  dis_val2:dis_val2,
								  dis_day2:dis_day2,
								  dis_val3:dis_val3,
								  dis_day3:dis_day3,
								  
								  gst:gst,
								  gst2:gst2,
								  active:active,
								  sales_person:sales_person,
								  area_location:area_location,
								  is_tcs:is_tcs,
								  show_in_follow_up:show_in_follow_up,
								  disputed_issue:disputed_issue,
								  
								  details_id:details_id,
								  goods:goods,
								  rate:rate,
								  custname:custname,
								  
							  }, 
							  function(data, textStatus)
							  {	
								  //alert(data);
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
								  $('#customer_save').show();
								  
							  });
						
							  
				   });
			 //-------------------------------save
		});











		$('#debit_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			
			var entry_date = $('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			var invoice_no = $('#invoice_no').val();if(invoice_no==''){$('#invoice_no').focus();fun_message('warning','Warning','Enter invoice_no','toast-bottom-right');return false;}
			var customer_id = $('#customer_id').val();if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
			var debit_amount = $('#debit_amount').val();if(debit_amount==''){$('#debit_amount').focus();fun_message('warning','Warning','Enter Amount','toast-bottom-right');return false;}
			var fin_year = $('#fin_year').val();
			var remarks = $('#remarks').val();
	
		 	//-------------------------------save
		   $('#wait').show();
		   $('#debit_save').hide();
		   setTimeout(function() {
				   jQuery.post("<?php echo base_url().'index.php/Customer/customer_debit_save';?>", 
						   {
							   id:id,
							   entry_date:entry_date,
							   invoice_no:invoice_no,
							   fin_year:fin_year,
							   customer_id:customer_id,
							   debit_amount:debit_amount,
							   remarks:remarks,
							}, 
						   function(data, textStatus)
						   {	
							   //alert(data);
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
							   $('#debit_save').show();
							   
						   });
					 
						   
				});
		  //-------------------------------save
		 
	 });



	 $('#credit_save').click(function(){
	 	
		 var url=$('#url').val();
		 var id=$('#id').val();
		 
		 var entry_date = $('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
		 var customer_id = $('#customer_id').val();if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
		 
		 //var credit_amount = $('#credit_amount').val();if(credit_amount==''){$('#credit_amount').focus();fun_message('warning','Warning','Enter Amount','toast-bottom-right');return false;}
		 //var remarks = $('#remarks').val();


		<!---------------------------------------------------row-------------------------------->
			var all_cr_dr_id="";
			var all_paid_amount="";
			
			$(".all_cr_dr_id").each(function(){		all_cr_dr_id=all_cr_dr_id.concat('~').concat($(this).val());						});
			$(".all_paid_amount").each(function(){			    all_paid_amount=all_paid_amount.concat('~').concat($(this).val());						});
		<!---------------------------------------------------row-------------------------------->
		

		if (!jQuery("#chk").is(":checked")) {
			fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
			return false;
		}
 
		  //-------------------------------save
		$('#wait').show();
		$('#credit_save').hide();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Customer/customer_credit_save';?>", 
						{
							id:id,
							entry_date:entry_date,
							customer_id:customer_id,
							all_cr_dr_id:all_cr_dr_id,
							all_paid_amount:all_paid_amount,
						 }, 
						function(data, textStatus)
						{	
							//alert(data);
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
							$('#credit_save').show();
							
						});
				  
						
			 });
	   //-------------------------------save
	  
  });



  	$('#credit_save2').click(function(){
	 	
		var url=$('#url').val();
		var id=$('#id').val();
		
		var payment_date = $('#entry_date').val();if(payment_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
		var customer_id = $('#customer_id').val();if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
		
		var credit_amount = $('#credit_amount').val();if(credit_amount==''){$('#credit_amount').focus();fun_message('warning','Warning','Enter Amount','toast-bottom-right');return false;}
		//var remarks = $('#remarks').val();


		  //-------------------------------save
		$('#wait').show();
		$('#credit_save2').hide();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Customer/customer_credit_save2';?>", 
						{
							id:id,
							payment_date:payment_date,
							customer_id:customer_id,
							credit_amount:credit_amount,
						}, 
						function(data, textStatus)
						{	
							//alert(data);
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
							$('#credit_save2').show();
							
						});
				  
						
			 });
	   //-------------------------------save
	  
  	});




	$('#cheque_save').click(function(){
	
		var url=$('#url').val();
		var id=$('#id').val();
		
		var customer_id = $('#customer_id').val();if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
		var receive_date = $('#receive_date').val();
		//if(receive_date==''){$('#receive_date').focus();fun_message('warning','Warning','Select Receive Date','toast-bottom-right');return false;}
		var bank_name = $('#bank_name').val();if(bank_name==''){$('#bank_name').focus();fun_message('warning','Warning','Enter bank_name','toast-bottom-right');return false;}
		var account_no = $('#account_no').val();
		var ifsc_code = $('#ifsc_code').val();
		var bank_address = $('#bank_address').val();
		var cheque_no = $('#cheque_no').val();if(cheque_no==''){$('#cheque_no').focus();fun_message('warning','Warning','Enter cheque_no','toast-bottom-right');return false;}
		var authorized_person = $('#authorized_person').val();if(authorized_person==''){$('#authorized_person').focus();fun_message('warning','Warning','Enter authorized_person','toast-bottom-right');return false;}
		
		var amount_status = $('#amount_status').val();if(amount_status==''){$('#amount_status').focus();fun_message('warning','Warning','Enter amount_status','toast-bottom-right');return false;}

		var cheque_amount = $('#cheque_amount').val();
		var expiry_date = $('#expiry_date').val();
		var remarks = $('#remarks').val();


		//-------------------------------save
		$('#wait').show();
		$('#cheque_save').hide();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Customer/cheque_entry_save';?>", 
						{
							id:id,
							customer_id:customer_id,
							receive_date:receive_date,
							cheque_no:cheque_no,
							
							authorized_person:authorized_person,
							bank_name:bank_name,
							account_no:account_no,
							ifsc_code:ifsc_code,
							bank_address:bank_address,
							amount_status:amount_status,

							cheque_amount:cheque_amount,
							expiry_date:expiry_date,
							remarks:remarks,
						}, 
						function(data, textStatus)
						{	
							//alert(data);
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
							$('#cheque_save').show();
							
						});
			});
		//-------------------------------save
	   
	   });





		







	//-----------------------------------------------search
	$('#cust_compl_search').click(function(){
			var type=$('#type').val();
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var search_customer=$('#search_customer').val();
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Customer/comp_list';?>", 
				{
					search1:1,
					type:type,
					search_date1:search_date1,
					search_date2:search_date2,
					search_customer:search_customer,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});
			});//loader
		});//search close



	
	//-----------------------------------------------search
	$('#customer_search').click(function(){
	 	var type=$('#type').val();
		var name=$('#name').val();
		var city=$('#city').val();
		var sales_person=$('#sales_person').val();
		var area_location=$('#area_location').val();
		var show_in_follow_up=$('#show_in_follow_up').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/list';?>", 
			{
				search1:1,
				type:type,
				name:name,
				city:city,
				sales_person:sales_person,
				area_location:area_location,
				show_in_follow_up:show_in_follow_up,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close



	//-----------------------------------------------search
	$('#debit_search').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var search_customer=$('#search_customer').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/debit_list';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_date2:search_date2,
				search_customer:search_customer,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close

	//-----------------------------------------------search
	$('#cheque_search').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var search_customer=$('#search_customer').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/cheque_list';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_date2:search_date2,
				search_customer:search_customer,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close

	//-----------------------------------------------search
	$('#credit_search').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var search_customer=$('#search_customer').val();
		var search_from_history=$('#search_from_history').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/credit_list';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_date2:search_date2,
				search_customer:search_customer,
				search_from_history:search_from_history,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close

	//-----------------------------------------------search
	$('#cr_dr_search').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var search_customer=$('#search_customer').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/cr_dr_list';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_date2:search_date2,
				search_customer:search_customer,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close

	//-----------------------------------------------search
	$('#cus_flowup_search').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_color=$('#search_color').val();
		var search_customer=$('#search_customer').val();
		var search_sales=$('#search_sales').val();
		var show_in_follow_up=$('#show_in_follow_up').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/cus_payment_flowup_list';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_color:search_color,
				search_customer:search_customer,
				search_sales:search_sales,
				show_in_follow_up:show_in_follow_up,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close


	//-----------------------------------------------search
	$('#cus_flowup_search2').click(function(){
	 	var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var search_customer=$('#search_customer').val();
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/cus_payment_flowup_list2';?>", 
			{
				search1:1,
				search_date1:search_date1,
				search_date2:search_date2,
				search_customer:search_customer,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close


	//-----------------------------------------------search
	$('#cus_send_mail').click(function(){
	 	
		
		var search_mail_type=$('#search_mail_type').val();
		
		<!---------------------------------------------------row-------------------------------->
		var all_check_id="";
		$("input:checkbox[name=all_mall_name]:checked").each(function(){	all_check_id = all_check_id.concat('~').concat($(this).val());						});
		<!---------------------------------------------------row-------------------------------->
		
		//$('.loader').show();
		fun_message('warning','Warning',"Sending...",'toast-bottom-right');
		$('#cus_send_mail').hide();
		setTimeout(()=>{
			$('#cus_send_mail').show();
		},3000)

		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/cus_send_mail';?>", 
			{
				search1:1,
				search_mail_type:search_mail_type,
				all_check_id:all_check_id,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				
				if(data=='Save'){
					fun_message('success',data,'Send Successfully','toast-bottom-right');
					//showPage(url);
				}
				else{
					fun_message('error','Error',data,'toast-bottom-right');
				}

				//$('.loader').hide();
				
			});
		});//loader
		
	});//search close


	










	
	//-------------------------------------------CUSTOMER COMPLAINT RECORD
 	$('#complaint_save').click(function(){
	 	
		 var url=$('#url').val();
		 var id=$('#id').val();
		 
		var type = $('#type').val();
		var complain_date = $('#complain_date').val();
		var customer_name = $('#customer_name').val();
		
		var defect_qty = $('#defect_qty').val();
		var defect_amount = $('#defect_amount').val();
		var defect_unit = $('#defect_unit').val();

		var defect_bobbin = $('#defect_bobbin').val();
		var type_of_wire1 = $('#type_of_wire1').val();
		var tag_size1 = $('#tag_size1').val();
		var tag_grade1 = $('#tag_grade1').val();

		var tag_coil_no1 = $('#tag_coil_no1').val();
		var tag_date1 = $('#tag_date1').val();
		var tag_shift1 = $('#tag_shift1').val();
		var type_of_wire2 = $('#type_of_wire2').val();

		var tag_size2 = $('#tag_size2').val();
		var tag_date1 = $('#tag_date1').val();
		var tag_shift1 = $('#tag_shift1').val();
		var type_of_wire2 = $('#type_of_wire2').val();

		var tag_size2 = $('#tag_size2').val();
		var tag_grade2 = $('#tag_grade2').val();
		var tag_coil_no2 = $('#tag_coil_no2').val();
		var tag_date2 = $('#tag_date2').val();

		var tag_shift2 = $('#tag_shift2').val();
		var desc_problem = $('#desc_problem').val();
		var scope = $('#scope').val();
		var comp_by = $('#comp_by').val();

		var rece_by = $('#rece_by').val();
		var priority = $('#priority').val();
		var department = $('#department').val();

		
		var assigned_to = $('#assigned_to').val();
		var root_cause = $('#root_cause').val();
		var corrective_action = $('#corrective_action').val();

		var preventive_action = $('#preventive_action').val();
		var verification = $('#verification').val();
		var status = $('#status').val();
		var resolution = $('#resolution').val();
		var followup_req = $('#followup_req').val();
		var remarks = $('#remarks').val();
		
		var fileInput = document.getElementById('img1').files[0]; // ✅ Correct DOM access

        var formData = new FormData();
        formData.append('remarks', remarks);
        if (fileInput) {
            formData.append('img1', fileInput);
        }

 
		   //-------------------------------save
		$('#wait').show();
		$('#complaint_save').hide();
		setTimeout(function () {
				var formData = new FormData();
				formData.append('id', id);
				formData.append('type', type);
				formData.append('complain_date', complain_date);
				formData.append('customer_name', customer_name);
				formData.append('defect_qty', defect_qty);
				formData.append('defect_amount', defect_amount);
				formData.append('defect_unit', defect_unit);
				formData.append('defect_bobbin', defect_bobbin);
				formData.append('type_of_wire1', type_of_wire1);
				formData.append('tag_size1', tag_size1);
				formData.append('tag_grade1', tag_grade1);
				formData.append('tag_coil_no1', tag_coil_no1);
				formData.append('tag_date1', tag_date1);
				formData.append('tag_shift1', tag_shift1);
				formData.append('type_of_wire2', type_of_wire2);
				formData.append('tag_size2', tag_size2);
				formData.append('tag_grade2', tag_grade2);
				formData.append('tag_coil_no2', tag_coil_no2);
				formData.append('tag_date2', tag_date2);
				formData.append('tag_shift2', tag_shift2);
				formData.append('desc_problem', desc_problem);
				formData.append('scope', scope);
				formData.append('comp_by', comp_by);
				formData.append('rece_by', rece_by);
				formData.append('priority', priority);
				formData.append('department', department);
				formData.append('assigned_to', assigned_to);
				formData.append('root_cause', root_cause);
				formData.append('corrective_action', corrective_action);
				formData.append('preventive_action', preventive_action);
				formData.append('verification', verification);
				formData.append('status', status);
				formData.append('resolution', resolution);
				formData.append('followup_req', followup_req);
				formData.append('remarks', remarks);

				// ✅ Append file if selected
				// var fileInput = document.getElementById('img1').files[0];
				// if (fileInput) {
				// 	formData.append('img1', fileInput);
				// }
				var files = document.getElementById('img1').files;
				// append each selected file
				for (var i = 0; i < files.length; i++) {
					formData.append('img1[]', files[i]);  // note: use same name "img1[]"
				}


				$.ajax({
					url: "<?php echo base_url().'index.php/Customer/complaint_save'; ?>",
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function (data) {
						if (data == 'Save') {
							fun_message('success', data, 'Save Successfully', 'toast-bottom-right');
							showPage(url);
						} else if (data == 'Update') {
							fun_message('success', data, 'Updated Successfully', 'toast-bottom-right');
							showPage(url);
						} else {
							fun_message('error', 'Error', data, 'toast-bottom-right');
						}
						$('#wait').hide();
						$('#complaint_save').show();
					},
					error: function () {
						fun_message('error', 'Error', 'Something went wrong!', 'toast-bottom-right');
						$('#wait').hide();
						$('#complaint_save').show();
					}
				});
			});

		//-------------------------------save
	   
	});



	
	/*

	//-----------------------------------------------search
 	$('#cos_comp_search').click(function(){
		
			var con=doesConnectionExist();if(con==0){ error('No Internet Connection.');return false;}
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();

			var status=$('#status').val();
			var customer=$('#customer').val();
			var part_no=$('#part_no').val();
			
			var search1=1;
			
			
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Customer/comp_list';?>", 
							{
								search_date1:search_date1,
								search_date2:search_date2,

								customer:customer,
								part_no:part_no,
								status:status,
								
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
	
	
	

	*/





});






</script>

   
 
       
 