
<script>

/*
//-------------------------------getting product
function fun_cat(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	//--------------------------------------------------cat
	var cat_id = "#cat_".concat(id_no);
	var cat_val=$(cat_id).val();
	//-------------------------------------------------- goods
	var goods_id = "#goods_".concat(id_no);
	
		
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Ajex/get_goods_from_cat';?>", 
						{
							cat_val:cat_val,
						}, 
						
						function(data, textStatus)
						{	
							//alert(data);
							$(goods_id).html(data);
							$('.loader').hide();
						});
			 });
			 
}//function close

//-------------------------------getting product
function fun_goods_unit(id)
{
	 	
	
	var id2 = id.split("_");
	var id_no=id2[1];
	
	//--------------------------------------------------unit
	var goods_id = "#goods_".concat(id_no);
	var goods_val=$(goods_id).val();
	
	
	//-------------------------------------------------- goods
	var unitname_id = "#unitname_".concat(id_no);
	
		
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Ajex/get_unit_from_good';?>", 
						{
							product_id:goods_val,
						}, 
						
						function(data, textStatus)
						{	
							//alert(data);
							$(unitname_id).val(data);
							$('.loader').hide();
						});
			 });
			 
}//function close
*/


function fun_not_delete_msg()
{
	fun_message('error','Error','Not Able to delete. Becouse Qty is already received in this Order','toast-bottom-right');
	return false;
}//function close

function delete_item(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	var po_details_id2 = "#podetailsid_".concat(id_no);
	var po_details_val2=$(po_details_id2).val();
	if(po_details_val2>0)
	{
		var div_id = "#qunt_".concat(id_no);$(div_id).val(0);
		var div_id = "#rate_".concat(id_no);$(div_id).val(0);
		var div_id = "#disc_".concat(id_no);$(div_id).val(0);
		var div_id = "#amount_".concat(id_no);$(div_id).val(0);
		var div_id = "#itemsgst_".concat(id_no);$(div_id).val(0);
		var div_id = "#itemcgst_".concat(id_no);$(div_id).val(0);
		var div_id = "#itemigst_".concat(id_no);$(div_id).val(0);
		var div_id = "#itemgstrs_".concat(id_no);$(div_id).val(0);
	
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/delete_po_product';?>", 
			{
				po_details_val2:po_details_val2,
			}, 
			
			function(data, textStatus)
			{	
				//alert(data);
				if(data=='Deleted')
				{
					//fun_message('success',data,'Product Deleted To Save Permanent Click on Save Button. ','toast-bottom-right');
					fun_message_popup('info','Product Deleted!','To Save Permanent Click on Save Button.','btn btn-lg btn-info','');//popup box'
					showPage(url);
				}
				else
				{
					fun_message('error','Error',data,'toast-bottom-right');
				}
				$('.loader').hide();
			});//jquery
		});//loader
	}//database delete
	fun_gst(id);
}//function close




function fun_ffc_gst(str)
{
	var ffc_charge=$('#ffc_charge').val();
	var per=((+ffc_charge)/100)*(+str);
	var ffc_amt=per.toFixed(0);
	$('#ffc_gst_amt').val(ffc_amt);
	var total=(+ffc_charge)+(+ffc_amt);
	var total1=total.toFixed(0);
	$('#ffc_amt').val(total1);
	fun_grand_total();
}//function close
//-------------------------------getting price
function fun_net_total1(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	//--------------------------------------------------qty
	var qunt_id = "#qunt_".concat(id_no);
	var qunt_val=$(qunt_id).val();
	//-------------------------------------------------- rate
	var rate_id = "#rate_".concat(id_no);
	var rate_val=$(rate_id).val();
	//-------------------------------------------------- dis
	var disc_id = "#disc_".concat(id_no);
	var disc_val=$(disc_id).val();
	var total_dis=(+disc_val)/100;
	var total_dis=(+total_dis)*(+rate_val);
	//-------------------------------------------------- net
	var net_amount=(+rate_val)-(+total_dis)
	var net_id = "#net_".concat(id_no);
	var net_amount=net_amount.toFixed(3)
	$(net_id).val(net_amount);
	//-------------------------------------------------- total amount
	var total_amount=(+qunt_val)*(+net_amount);
	var amount_id = "#amount_".concat(id_no);
	var total_amount=total_amount.toFixed(2)
	$(amount_id).val(total_amount);
	fun_gst(id);
}//function close


function fun_gst(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	var amount_id = "#amount_".concat(id_no);
	var amount_val=$(amount_id).val();
	//--------------------------------------------------sgst
	var itemsgst_id = "#itemsgst_".concat(id_no);
	var itemsgst_val=$(itemsgst_id).val();
	//--------------------------------------------------cgst
	var itemcgst_id = "#itemcgst_".concat(id_no);
	var itemcgst_val=$(itemcgst_id).val();
	//--------------------------------------------------sgst
	var itemigst_id = "#itemigst_".concat(id_no);
	var itemigst_val=$(itemigst_id).val();
	if(itemigst_val>0)//IGST
	{
		var per=((+amount_val)/100)*(+itemigst_val);
		var gst_amount=per.toFixed(2);
	}
	else
	{
		var per=((+amount_val)/100)*(+itemsgst_val);
		var sgst_amount=per.toFixed(2);
		var per=((+amount_val)/100)*(+itemcgst_val);
		var cgst_amount=per.toFixed(2);
		var gst_amount=(+sgst_amount)+(+cgst_amount);
	}
	//--------------------------------------------------gst amount
	var itemgstrs_id = "#itemgstrs_".concat(id_no);
	$(itemgstrs_id).val(gst_amount);
	fun_net_total();
}//function close
//--------------------------------------total amount
function fun_net_total()
{
	var i=1
	var amount_sum=0;
	$(".total_amount").each(function(){
		
		if(this.value>0)
		{
			var val=this.value;
			amount_sum=(+amount_sum)+(+val);
			//alert(this.value);
		}
		i++;
	});
	//alert(amount_sum);
	var amount_sum2=amount_sum.toFixed(2)
	$("#total_old").val(amount_sum2);
	//-------------------------dis add
	new_dis();
	//-------------------------dis add
	var i=1
	var amount_sum21=0;
	$(".itemgstrs").each(function(){
		
		if(this.value>0)
		{
			var val=this.value;
			amount_sum21=(+amount_sum21)+(+val);
			//alert(this.value);
		}
		i++;
	});
	//alert(amount_sum);
	var amount_sum22=amount_sum21.toFixed(2)
	$("#gstcharge").val(amount_sum22);
	fun_grand_total();
}//function close


//---new discount
function new_dis()
{
	var old_total=$("#total_old").val();
	var dis_per=$("#dis_per").val();
	var dis_amt=(dis_per/100)*old_total;
	var dis_amt=dis_amt.toFixed(2)
	$("#dis_amt").val(dis_amt);
	var dis_amt2=(+old_total)-(+dis_amt);
	var dis_amt2=dis_amt2.toFixed(2)
	$("#total").val(dis_amt2);
	fun_grand_total();
}//function close
function fun_grand_total()
{
	var total=$("#total").val();
	var ffc_amt=$('#ffc_amt').val();
	var gstcharge=$("#gstcharge").val();
	var roundoff=$("#roundoff").val();
	var amount_sum3=(+total)+(+gstcharge)+(+ffc_amt);
	x=amount_sum3;
	int_part = Math.trunc(x); // returns 3
	var float_part = Number((x-int_part).toFixed(2)); // return 0.2
	if(float_part<0.50)
	{
		var roundoff_total=(+amount_sum3)-(+roundoff);
	}
	else
	{
		var roundoff_total=(+amount_sum3)+(+roundoff);
	}
	var roundoff_total2=roundoff_total.toFixed(2);
    $("#grandtotal").val(roundoff_total2);
	//-------------in words
	var roundoff_total3=roundoff_total.toFixed(0);
	jQuery.post("<?php echo base_url().'index.php/Etc/convert_number_to_words';?>", 
	{
		rs:roundoff_total3,
	}, 
	function(data, textStatus)
	{	
		//alert(data);
		document.getElementById('rs_word').value=data;
	});
}//function close

function get_supplier_basic_details(str)
{
	//-------------------------------getting supplier_details
	$('.loader').show();
	setTimeout(function() {
		jQuery.post("<?php echo base_url().'index.php/Supplier/get_supplier_basic_details';?>", 
		{
			id:str,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			var out = data.split("~");
			$('#gst_type').val(out[0]);
			$('#payment_terms').val(out[1]);
			$('#del_place').val(out[2]);
			$('#mod_of_dis').val(out[3]);
			$('.loader').hide();
		});
	});//loader
}//function close







function fun_check_product(str)
{
	 	var product_cat=$('#product_cat').val();
		
		jQuery.post("<?php echo base_url().'index.php/Ajex/fun_check_product';?>", 
			{
				name:str,
				category_id:product_cat,
			}, 
			
			function(data, textStatus)
			{	
				//alert(data);
				$('#product_dis_id').html(data);
				
			});
}//function close

//-----------------------------------------------------------save
$(document).ready(function(e) {
    
	$('#save_formet').hide();
	$("#search_date2").datepicker({dateFormat: 'dd-mm-yy'});  

	$("#search_date1").datepicker({ 
		dateFormat: 'dd-mm-yy', 
        /*onSelect: function($input){  $("#search_date2").val($input); }*/  
	}); 
	
	$( "#po_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });
	$( "#po_valid" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   //minDate: ,
	   maxDate: 31,
    });

	$( "#invoice_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });
	
	$( "#product_invoice_save_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
	});
	
	$( "#gate_entry_date" ).datepicker({
	   dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });

	

	$( "#rec_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });
   
   
   
   
    	$('#po_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			var po_no2=$('#po_no').val();
			var current_stage=$('#current_stage').val();
			
			
			var supplier_id=$('#supplier_id').val();if(supplier_id==''){$('#supplier_id').focus();fun_message('warning','Warning','Select Supplier','toast-bottom-right');return false;}
			var po_date=$('#po_date').val();if(po_date==''){$('#po_date').focus();fun_message('warning','Warning','Select PO Date','toast-bottom-right');return false;}
			var po_valid=$('#po_valid').val();if(po_valid==''){$('#po_valid').focus();fun_message('warning','Warning','Select PO valid Date','toast-bottom-right');return false;}
			
			
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
					var priceid="#net_".concat(inamount_str[1]);<!--concatenent id-->
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
				form_validation('Fill  Quantity, Rate, GST Amount and All Information.  ');
				$(a).focus();
				return false
			}
			
			//------------------------------------------------------------------amount validation
			
			
			
			var com_qut_ref=$('#com_qut_ref').val();
			var com_indent_ref=$('#com_indent_ref').val();
		
			
			<!---------------------------------------------------row-------------------------------->
			var po_details_id="";
			var goods="";
			var goodsdetails="";
			var hsn="";
			var unitname="";
			var qunt="";
			var rate="";
			var disc="";
			var net="";
			var total_amount="";
			var itemsgst="";
			var itemcgst="";
			var itemigst="";
			var itemgstrs="";
			
			$(".po_details_id").each(function(){	po_details_id=po_details_id.concat('~').concat($(this).val());		});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());						});
			$(".goodsdetails").each(function(){		goodsdetails=goodsdetails.concat('~').concat($(this).val());		});
			$(".hsn").each(function(){				hsn=hsn.concat('~').concat($(this).val());							});
			$(".unitname").each(function(){			unitname=unitname.concat('~').concat($(this).val());				});
			$(".qunt").each(function(){				qunt=qunt.concat('~').concat($(this).val());						});
			$(".rate").each(function(){				rate=rate.concat('~').concat($(this).val());						});
			$(".disc").each(function(){				disc=disc.concat('~').concat($(this).val());						});
			$(".net").each(function(){				net=net.concat('~').concat($(this).val());							});
			$(".total_amount").each(function(){		total_amount=total_amount.concat('~').concat($(this).val());		});
			$(".itemsgst").each(function(){			itemsgst=itemsgst.concat('~').concat($(this).val());				});
			$(".itemcgst").each(function(){			itemcgst=itemcgst.concat('~').concat($(this).val());				});
			$(".itemigst").each(function(){			itemigst=itemigst.concat('~').concat($(this).val());				});
			$(".itemgstrs").each(function(){		itemgstrs=itemgstrs.concat('~').concat($(this).val());				});
			
			<!---------------------------------------------------row-------------------------------->
			
			var total_old=$('#total_old').val();
			var dis_per=$('#dis_per').val();
			var dis_amt=$('#dis_amt').val();
			var total=$('#total').val();
			var ffc_charge=$('#ffc_charge').val();
			var ffc_gst_per=$('#ffc_gst_per').val();
			var ffc_gst_amt=$('#ffc_gst_amt').val();
			var ffc_amt=$('#ffc_amt').val();
			var gst_type=$('#gst_type').val();
			var gstcharge=$('#gstcharge').val();
			var roundoff=$('#roundoff').val();
			var rs_word=$('#rs_word').val();
			var grandtotal=$('#grandtotal').val();
			var remarks=$('#remarks').val();
			var del_schedule=$('#del_schedule').val();
			var payment_terms=$('#payment_terms').val();
			var del_place=$('#del_place').val();
			var mod_of_dis=$('#mod_of_dis').val();
			var loading_charge=$('#loading_charge').val();
			var order_by=$('#order_by').val();if(order_by==''){$('#order_by').focus();fun_message('warning','Warning','Enter Order By name','toast-bottom-right');return false;}
			var department=$('#department').val();if(department==''){$('#department').focus();fun_message('warning','Warning','Enter department name','toast-bottom-right');return false;}
			var mc_no=$('#mc_no').val();

			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			//-------------------------------save
			  	$('#wait').show();
			  	$('#po_save').hide();
			  	setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Po/save';?>", 
							{
								id:id,
								po_no2:po_no2,
								current_stage:current_stage,
								supplier_id:supplier_id,
								po_date:po_date,
								po_valid:po_valid,
								com_qut_ref:com_qut_ref,
								com_indent_ref:com_indent_ref,
								
								total_old:total_old,
								dis_per:dis_per,
								dis_amt:dis_amt,
								total:total,
								ffc_charge:ffc_charge,
								ffc_gst_per:ffc_gst_per,
								ffc_gst_amt:ffc_gst_amt,
								ffc_amt:ffc_amt,
								gst_type:gst_type,
								gstcharge:gstcharge,
								roundoff:roundoff,
								rs_word:rs_word,
								grandtotal:grandtotal,
								remarks:remarks,
								del_schedule:del_schedule,
								payment_terms:payment_terms,
								del_place:del_place,
								mod_of_dis:mod_of_dis,
								loading_charge:loading_charge,
								order_by:order_by,
								department:department,
								mc_no:mc_no,
								po_details_id:po_details_id,
								goods:goods,
								goodsdetails:goodsdetails,
								hsn:hsn,
								unitname:unitname,
								qunt:qunt,
								rate:rate,
								disc:disc,
								net:net,
								total_amount:total_amount,
								itemsgst:itemsgst,
								itemcgst:itemcgst,
								itemigst:itemigst,
								itemgstrs:itemgstrs,
						}, 
						function(data, textStatus)
						{	
							if(data=='Save')
							{
									//fun_message('success',data,'Save Successfully','toast-bottom-right');
									fun_message_popup('success','Save Successfully','','btn btn-lg btn-success','');
									showPage(url);
							}
							else if(data=='Update')
							{
									//fun_message('success',data,'Updated Successfully','toast-bottom-right');
									fun_message_popup('success','Updated Successfully','','btn btn-lg btn-success','');
									showPage(url);
							}
							else
							{
									fun_message('error','Error',data,'toast-bottom-right');
							}
							$('#wait').hide();
							$('#po_save').show();
					
					});//jquery
				});//loader
		});//save




















	//-----------------------------------------------search
 	$('#po_list_search').click(function(){
		var po_search_stage=$('#po_search_stage').val();
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var name=$('#name').val();
		var pono=$('#pono').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/po_search';?>", 
			{
				po_search_stage:po_search_stage,
				search_date1:search_date1,
				search_date2:search_date2,
				name:name,
				pono:pono,
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
 	$('#po_product_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var supplier=$('#supplier').val();
		var product=$('#name_').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/po_product_status';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				supplier:supplier,
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



































<!------------------------------------------------------------Accept PO ------------------------------>

	$('#po_accept').click(function(){
	 	
			var url=$('#url').val();
			var po_id=$('#po_id').val();
			var current_status=$('#current_status').val();
			var comment=$('#comment').val();
			var action='accept';

			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Po/po_action_save';?>", 
					{
						po_id:po_id,
						current_status:current_status,
						comment:comment,
						action:action,
					}, 
					function(data, textStatus)
					{	
						if(data=='Save')
						{
						fun_message('success',data,'PO Approved Successfully','toast-bottom-right');
						$('#take_action').hide();
						}
						else
						{
							fun_message('error','Error',data,'toast-bottom-right');
						}
						$('.loader').hide();
					});//jquery
			});//loader
	});//accept PO 


	$('#po_reject').click(function(){
	 	
			var url=$('#url').val();
			var po_id=$('#po_id').val();
			var current_status=$('#current_status').val();
			var comment=$('#comment').val();
			var action='reject';

			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Po/po_action_save';?>", 
					{
						po_id:po_id,
						current_status:current_status,
						comment:comment,
						action:action,
					}, 
					function(data, textStatus)
					{	
						if(data=='Save')
							{
							fun_message('success',data,'PO Rejected Successfully','toast-bottom-right');
							$('#take_action').hide();
						}
						else
						{
							fun_message('error','Error',data,'toast-bottom-right');
						}
						$('.loader').hide();
					});//jquery
			});//loader
	});//reject PO 


	//----------------------------------Invoice save
	$('#po_invoice_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			var invoice_no=$('#invoice_no').val();
			var old_invoice_no=$('#old_invoice_no').val();
			var old_entry_date=$('#old_entry_date').val();
			
			
			var product_invoice_save_date=$('#product_invoice_save_date').val();if(product_invoice_save_date==''){$('#product_invoice_save_date').focus();fun_message('warning','Warning','Select Recive Date','toast-bottom-right');return false;}
			var supplier_id=$('#supplier_id').val();if(supplier_id==''){$('#supplier_id').focus();fun_message('warning','Warning','Select Supplier','toast-bottom-right');return false;}
			var type=$('#type').val();if(type==''){$('#type').focus();fun_message('warning','Warning','Enter type','toast-bottom-right');return false;}
			var invoice_no=$('#invoice_no').val();if(invoice_no==''){$('#invoice_no').focus();fun_message('warning','Warning','Enter Invoice / Challan No.','toast-bottom-right');return false;}
			var invoice_date=$('#invoice_date').val();if(invoice_date==''){$('#invoice_date').focus();fun_message('warning','Warning','Date Of Invoice / Challan','toast-bottom-right');return false;}
			var transport_mode=$('#transport_mode').val();
			var vehicle_no=$('#vehicle_no').val();
			var gate_pass_no=$('#gate_pass_no').val();
			var same_company=$('#same_company').val();if(same_company==''){$('#same_company').focus();fun_message('warning','Warning','Select same_company','toast-bottom-right');return false;}
			
			var raw_material_from=$('#raw_material_from').val();
			
			
			//------------------------------------------------------------------Row Validation
			  var taxamountid;
			  var a;
			  $(".goods").each(function(){<!--geting each value-->
				  var goods_val=$(this).val();
				  if(goods_val>0)
				  {
					  var goods_id=$(this).attr('id');<!--geting each id-->
					  var inamount_str = goods_id.split("_");<!--splid id-->
					  //alert(inamount_str[1]);
					  var priceid="#net_".concat(inamount_str[1]);<!--concatenent id-->
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
				  //alert("Fill Net Weight, Price, and all information.  ");
				  $(a).focus();
				  fun_message('warning','Warning','Fill Net Weight, Price, and all information.  ','toast-bottom-right');
				  return false;
				  
			  }
			
			<!---------------------------------------------------row-------------------------------->
			var details_id="";
			var oldqty="";
			var oldamt="";
			var oldlot="";
			var oldgrade="";
			var oldpoid="";
			var oldqc="";
			var oldproduct="";
			var oldpkg="";
			var goods="";
			var poid="";
			var totalqty="";
			var recqty="";
			var remqty="";
			var amount_weight="";
			var unitname="";
			var hsn="";
			var package="";
			var discount="";
			var prePrice="";
			var price="";
			var total_amount="";
			var itemsgst="";
			var itemcgst="";
			var itemigst="";
			var itemgstrs="";
			var notrepeat="";
			
			$(".details_id").each(function(){		details_id=details_id.concat('~').concat($(this).val());			});
			$(".oldqty").each(function(){			oldqty=oldqty.concat('~').concat($(this).val());					});
			$(".oldamt").each(function(){			oldamt=oldamt.concat('~').concat($(this).val());					});
			$(".oldlot").each(function(){			oldlot=oldlot.concat('~').concat($(this).val());					});
			$(".oldgrade").each(function(){			oldgrade=oldgrade.concat('~').concat($(this).val());				});
			$(".oldpoid").each(function(){			oldpoid=oldpoid.concat('~').concat($(this).val());					});
			$(".oldqc").each(function(){			oldqc=oldqc.concat('~').concat($(this).val());						});
			$(".oldproduct").each(function(){		oldproduct=oldproduct.concat('~').concat($(this).val());			});
			$(".oldpkg").each(function(){			oldpkg=oldpkg.concat('~').concat($(this).val());					});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());						});
			$(".poid").each(function(){				poid=poid.concat('~').concat($(this).val());						});
			$(".totalqty").each(function(){			totalqty=totalqty.concat('~').concat($(this).val());				});
			$(".recqty").each(function(){			recqty=recqty.concat('~').concat($(this).val());					});
			$(".remqty").each(function(){			remqty=remqty.concat('~').concat($(this).val());					});
			$(".amount_weight").each(function(){	amount_weight=amount_weight.concat('~').concat($(this).val());		});
			$(".unitname").each(function(){			unitname=unitname.concat('~').concat($(this).val());				});
			$(".hsn").each(function(){				hsn=hsn.concat('~').concat($(this).val());							});
			$(".package").each(function(){			package=package.concat('~').concat($(this).val());					});
			
			$(".prePrice").each(function(){			prePrice=prePrice.concat('~').concat($(this).val());						});
			$(".discount").each(function(){			discount=discount.concat('~').concat($(this).val());						});
			$(".price").each(function(){			price=price.concat('~').concat($(this).val());						});
			
			$(".total_amount").each(function(){		total_amount=total_amount.concat('~').concat($(this).val());		});
			$(".itemsgst").each(function(){			itemsgst=itemsgst.concat('~').concat($(this).val());				});
			$(".itemcgst").each(function(){			itemcgst=itemcgst.concat('~').concat($(this).val());				});
			$(".itemigst").each(function(){			itemigst=itemigst.concat('~').concat($(this).val());				});
			$(".itemgstrs").each(function(){		itemgstrs=itemgstrs.concat('~').concat($(this).val());				});
			$(".notrepeat").each(function(){		notrepeat=notrepeat.concat('~').concat($(this).val());				});
			<!---------------------------------------------------row-------------------------------->
			
			var total_old=$('#total_old').val();
			var dis_per=$('#dis_per').val();
			var dis_amt=$('#dis_amt').val();
			var total=$('#total').val();
			var ffc_charge=$('#ffc_charge').val();
			var ffc_gst_per=$('#ffc_gst_per').val();
			var ffc_gst_amt=$('#ffc_gst_amt').val();
			var ffc_amt=$('#ffc_amt').val();
			var gst_type=$('#gst_type').val();
			var gstcharge=$('#gstcharge').val();
			var roundoff=$('#roundoff').val();
			var amount_weight_sum=$('#amount_weight_sum').val();
			var grandtotal=$('#grandtotal').val();
			var remarks=$('#remarks').val();

			var ext_weight_bridge=$('#ext_weight_bridge').val();
			var int_weight_bridge=$('#int_weight_bridge').val();
			var diff_weight_bridge=$('#diff_weight_bridge').val();
			var coil_wise_details=$('#coil_wise_details').val();

			

			
			
			if (!jQuery("#chk").is(":checked")) {
				fun_message('warning','Warning','Select Checkbox','toast-bottom-right');
				return false;
			}
			
			//-------------------------------save
			  $('#wait').show();
			 $('#po_invoice_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Po/add_invoice_save';?>", 
							  {
									id:id,
									invoice_no:invoice_no,
									old_entry_date:old_entry_date,
									old_invoice_no:old_invoice_no,
									product_invoice_save_date:product_invoice_save_date,
									supplier_id:supplier_id,
									type:type,
									raw_material_from:raw_material_from,
									invoice_no:invoice_no,
									invoice_date:invoice_date,
									transport_mode:transport_mode,
									vehicle_no:vehicle_no,
									gate_pass_no:gate_pass_no,
									same_company:same_company,
									details_id:details_id,
									oldqty:oldqty,
									oldamt:oldamt,
									oldlot:oldlot,
									oldgrade:oldgrade,
									oldpoid:oldpoid,
									oldqc:oldqc,
									oldproduct:oldproduct,
									oldpkg:oldpkg,
									poid:poid,
									goods:goods,
									totalqty:totalqty,
									recqty:recqty,
									remqty:remqty,
									amount_weight:amount_weight,
									unitname:unitname,
									hsn:hsn,
									package:package,
									prePrice:prePrice,
									discount:discount,
									price:price,
									total_amount:total_amount,
									itemsgst:itemsgst,
									itemcgst:itemcgst,
									itemigst:itemigst,
									itemgstrs:itemgstrs,
									notrepeat:notrepeat,
									total_old:total_old,
								  	dis_per:dis_per,
								  	dis_amt:dis_amt,
									total:total,
									ffc_charge:ffc_charge,
									ffc_gst_per:ffc_gst_per,
									ffc_gst_amt:ffc_gst_amt,
									ffc_amt:ffc_amt,
									gst_type:gst_type,
									gstcharge:gstcharge,
									roundoff:roundoff,
									amount_weight_sum:amount_weight_sum,
									grandtotal:grandtotal,
									remarks:remarks,
									ext_weight_bridge:ext_weight_bridge,
									int_weight_bridge:int_weight_bridge,
									diff_weight_bridge:diff_weight_bridge,
									coil_wise_details:coil_wise_details,
								 
							}, 
							  function(data, textStatus)
							  {	
									if(data=='Save')
									{
											//fun_message('success',data,'Save Successfully','toast-bottom-right');
											fun_message_popup('success','Save Successfully','','btn btn-lg btn-success','');
											showPage(url);
									}
									else if(data=='Update')
									{
											//fun_message('success',data,'Updated Successfully','toast-bottom-right');
											fun_message_popup('success','Updated Successfully','','btn btn-lg btn-success','');
											showPage(url);
									}
									else
									{
											fun_message('error','Error',data,'toast-bottom-right');
									}
									$('#wait').hide();
									$('#po_invoice_save').show();
								
								
								 
								});
					});
			 //-------------------------------save
		});




		
	//-----------------------------------------------search
	$('#po_invoice_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var supplier=$('#supplier').val();
		var invoice_no=$('#invoice_no').val();
		var gate_pass=$('#gate_pass').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/invoice_list';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				supplier:supplier,
				invoice_no:invoice_no,
				gate_pass:gate_pass,
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
	$('#po_invoice_product_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var supplier=$('#supplier').val();
		var product=$('#name_').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/invoice_list_product';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				supplier:supplier,
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
	$('#po_invoice_rod_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var supplier=$('#supplier').val();
		var product=$('#name_').val();
		var issue=$('#issue').val();
		
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/invoice_list_product_for_rod';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				supplier:supplier,
				product:product,
				issue:issue,
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







});//Document 









































//---------------------------------------------------------INVOICE
function fun_gst_type_and_po_product_invoice_entry(supplier_id)
{
	//gst type
	jQuery.post("<?php echo base_url().'index.php/Supplier/get_supplier_basic_details';?>", 
	{
		id:supplier_id,
	}, 
	function(data, textStatus)
	{	
		var out = data.split("~");
		$('#gst_type').val(out[0]);
	});
	

	//get product list form po
	jQuery.post("<?php echo base_url().'index.php/Po/get_product_form_po_details_with_supplier_id';?>", 
	{
		id:supplier_id,
	}, 
	function(data, textStatus)
	{	
		$('.goods').html(data);
	});
}//function close



function get_po_no_form_supplier_and_product_invoice_entry(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	//product
	var goods_id = "#goods_".concat(id_no);
	var goods_val=$(goods_id).val();
	
	var supplier_id=$('#supplier_id').val();
	if(supplier_id=='')
	{
		fun_message('warning','Warning','Select Supplier','toast-bottom-right');
		$('#supplier_id').focus();
		$(goods_id).val('');
		return false;
	}
	
	//po no selectbox
	var poid = "#poid_".concat(id_no);
	
		
	$('.loader').show();
	setTimeout(function() {
	jQuery.post("<?php echo base_url().'index.php/Po/get_pono_form_po_details_with_supplier_id_and_product_id';?>", 
			{
				supplier_id:supplier_id,
				product_id:goods_val,
			}, 
			
			function(data, textStatus)
			{	
				$(poid).html(data);
				$('.loader').hide();
			});
	});
			 
}//function close



//--------------------------------------------po details
function fun_po_details(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	
	//po row details
	var poid_id = "#poid_".concat(id_no);
	var poid_details_id=$(poid_id).val();
	
	var totalqty = "#totalqty_".concat(id_no);  
	var recqty = "#recqty_".concat(id_no);
	var remqty = "#remqty_".concat(id_no);
	var unitname = "#unitname_".concat(id_no);
	var hsn = "#hsn_".concat(id_no);
	var price = "#price_".concat(id_no);
	
	$('.loader').show();
	setTimeout(function() {
		jQuery.post("<?php echo base_url().'index.php/Po/get_po_details';?>", 
		{
			poid_details_id:poid_details_id,
		}, 
		
		function(data, textStatus)
		{	
			//alert(data);
			var data2 = data.split("~");
			$(totalqty).val(data2[0]);
			$(recqty).val(data2[1]);
			$(remqty).val(data2[2]);
			
			$(unitname).val(data2[3]);
			$(hsn).val(data2[4]);
			$(price).val(data2[5]);
			
			$('.loader').hide();
		});
	});

}//fucntion close





function fun_invoice_price(id)
{
	
	var id2 = id.split("_");
	var id_no=id2[1]
	
	//--------------------------------------------------net weight or qty
	var net_weight_val=$(`#net_${id_no}`).val();
	
	//-------------------------------------------------- price
	var prePrice_id_val=$(`#prePrice_${id_no}`).val();
	var discount_id_val=$(`#discount_${id_no}`).val();
	
	
	let price_id_val = (+prePrice_id_val-((+prePrice_id_val)*((+discount_id_val)/100))).toFixed(2);
	//var price_id_val=$(`#price_${id_no}`).val();
	$(`#price_${id_no}`).val(price_id_val);
	//console.log(price_id_val);
	
	//-------------------------------------------------- amount
	var amount_val = ((+net_weight_val)*(+price_id_val)).toFixed(2);
	$(`#amount_${id_no}`).val(amount_val);
	


	fun_invoice_gst(id);
	fun_invoice_net_weight();
}


function fun_invoice_gst(id)
{
	
	var id2 = id.split("_");
	var id_no=id2[1];
	
	var amount_id = "#amount_".concat(id_no);
	var amount_val=$(amount_id).val();
	
	
	//--------------------------------------------------sgst
	var itemsgst_id = "#itemsgst_".concat(id_no);
	var itemsgst_val=$(itemsgst_id).val();
	
	
	//--------------------------------------------------cgst
	var itemcgst_id = "#itemcgst_".concat(id_no);
	var itemcgst_val=$(itemcgst_id).val();
	
	//--------------------------------------------------sgst
	var itemigst_id = "#itemigst_".concat(id_no);
	var itemigst_val=$(itemigst_id).val();
	
	if(itemigst_val>0)//IGST
	{
		var per=((+amount_val)/100)*(+itemigst_val);
		var gst_amount=per.toFixed(2);
	}
	else
	{
		var per=((+amount_val)/100)*(+itemsgst_val);
		var sgst_amount=per.toFixed(2);
		
		var per=((+amount_val)/100)*(+itemcgst_val);
		var cgst_amount=per.toFixed(2);
		
		var gst_amount=(+sgst_amount)+(+cgst_amount);
		
	}
	
	
	//--------------------------------------------------gst amount
	var itemgstrs_id = "#itemgstrs_".concat(id_no);
	$(itemgstrs_id).val(gst_amount);
	
	fun_invoice_net_total();
}



//-----------------------------------------------total weight
function fun_invoice_net_weight()
{
	 		var i=1
			var amount_weight_sum=0;
			$(".amount_weight").each(function(){
            	
				if(this.value>0)
				{
					var val=this.value;
					amount_weight_sum=(+amount_weight_sum)+(+val);
					//alert(this.value);
				}
				i++;
			});
			//alert(amount_sum);
			var amount_weight_sum2=amount_weight_sum.toFixed(2)
			$("#amount_weight_sum").val(amount_weight_sum2);
			
			fun_invoice_grand_total();
			
}


//--------------------------------------------total amount
function fun_invoice_net_total()
{
	 		var i=1
			var amount_sum=0;
			$(".total_amount").each(function(){
            	
				if(this.value>0)
				{
					var val=this.value;
					amount_sum=(+amount_sum)+(+val);
					//alert(this.value);
				}
				i++;
			});
			//alert(amount_sum);
			var amount_sum2=amount_sum.toFixed(2)
			$("#total_old").val(amount_sum2);
			
			//-------------------------dis add
			fun_invoice_dis();
			//-------------------------dis add
			
				
			var i=1
			var amount_sum21=0;
			$(".itemgstrs").each(function(){
            	
				if(this.value>0)
				{
					var val=this.value;
					amount_sum21=(+amount_sum21)+(+val);
					//alert(this.value);
				}
				i++;
			});
			//alert(amount_sum);
			var amount_sum22=amount_sum21.toFixed(2)
			$("#gstcharge").val(amount_sum22);
			
			
			fun_invoice_grand_total();
			
}

//---new discount
function fun_invoice_dis()
{
	var old_total=$("#total_old").val();
	var dis_per=$("#dis_per").val();
	
	var dis_amt=(dis_per/100)*old_total;
	var dis_amt=dis_amt.toFixed(2)
	$("#dis_amt").val(dis_amt);
	
	var dis_amt2=(+old_total)-(+dis_amt);
	var dis_amt2=dis_amt2.toFixed(2)
	$("#total").val(dis_amt2);
	
	fun_invoice_grand_total();
}
//---new discount

function fun_invoice_grand_total()
{
	var total=$("#total").val();
	var ffc_amt=$('#ffc_amt').val();
	var gstcharge=$("#gstcharge").val();
	var roundoff=$("#roundoff").val();
	
	var amount_sum3=(+total)+(+gstcharge)+(+ffc_amt);
	x=amount_sum3;
	int_part = Math.trunc(x); // returns 3
	var float_part = Number((x-int_part).toFixed(2)); // return 0.2
	
	if(float_part<0.50)
	{
		var roundoff_total=(+amount_sum3)-(+roundoff);
		
	}
	else
	{
		var roundoff_total=(+amount_sum3)+(+roundoff);
		//alert(float_part);
	}
	
	
	
	var roundoff_total2=roundoff_total.toFixed(2);
	$("#grandtotal").val(roundoff_total2);
}//function close


function fun_invoice_product_not_delete_msg()
{
	fun_message('warning','Warning','Not Able to delete. contact admin.','toast-bottom-right');
	return false;
}





</script>
  
  
  
