<script>


	//-----------stock finish / dispatch entry
	function getAllWdCoils()
	{
		var productid=$('#goods_').val();
		var dept=$('#dept').val();
		var grade=$('#grade').val();
		var dia=$('#dia').val();
		var oil=$('#oil').val();
		
		var search1='1';
		$('#wait').show();
		$('#dis_output').html('please wait...');
		jQuery.post("<?php echo base_url().'index.php/Qc/getAllWdCoils';?>", 
			{
				productid:productid,
				dept:dept,
				grade:grade,
				dia:dia,
				oil:oil,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				$('#dis_output').html(data);
				$('#wait').hide();
				//getAllWdCoilsList(productid,grade,dia);
			});
			
			
	}//function close

	function getAllWdCoilsList()
	{
		var productid=$('#goods_').val();
		var dept=$('#dept').val();
		var grade=$('#grade').val();
		var dia=$('#dia').val();
		let search1='1';
		$('#wait').show();
		$('#dis_output2').html('please wait...');
		jQuery.post("<?php echo base_url().'index.php/Qc/getAllWdCoilsList';?>", 
			{
				productid:productid,
				grade:grade,
				dia:dia,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				$('#dis_output2').html(data);
				$('#wait').hide();
			});
	}//function close

	
	function stockDelete(stockid)
	{
		if (confirm("Confirm to Delete!") == true) {
			let search1='1';
			$('#wait').show();
			jQuery.post("<?php echo base_url().'index.php/Store/stockDelete';?>", 
				{
					stockid:stockid,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					alert(data + ', '+ 'Reload to see change');
					$('#wait').hide();
				});
		} 
	}//function close






$(function () {
	$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: -0,
	});
	
	$( "#search_date1" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });


	$( "#search_date2" ).datepicker({
       dateFormat: 'dd-mm-yy',
	});
	
});



function fun_update_stock_row(id)
{
	var id2 = id.split("_");
	var id_no=id2[1];
	var productid_id = "#productid_".concat(id_no);var productid_id = $(productid_id).val();
	var totalgrade_id = "#totalgrade_".concat(id_no);var totalgrade_val = $(totalgrade_id).val();
	var totalqty_id = "#totalqty_".concat(id_no);var totalqty_val = $(totalqty_id).val();
	var totalcost_id = "#totalcost_".concat(id_no);var totalcost_val = $(totalcost_id).val();
	var totalpkg_id = "#totalpkg_".concat(id_no);var totalpkg_val = $(totalpkg_id).val();
	var status_id = "#status_".concat(id_no);var status_val = $(status_id).val();

	var fullrowid_id = "#fullrowid_".concat(id_no);

	jQuery.post("<?php echo base_url().'index.php/Store/stock_update_direct_save';?>", 
	{
		productid_id:productid_id,
		totalgrade_val:totalgrade_val,
		totalqty_val:totalqty_val,
		totalcost_val:totalcost_val,
		totalpkg_val:totalpkg_val,
		status_val:status_val,
	}, 
	function(data, textStatus)
	{	
		//alert(data);
		if(data == "Save")
		{
			$(fullrowid_id).css('backgroundColor', '#92d1a3');
		}
		else
		{
			$(fullrowid_id).css('backgroundColor', '#b88482');
			alert(data);
		}
		
	});//query
}//function close




$(document).ready(function(e) {
    $('#product_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			
			
			var product_cat=$('#product_cat').val();if(product_cat==''){$('#product_cat').focus();fun_message('warning','Warning','Select Category','toast-bottom-right');return false;}
			var name=$('#productname_').val();if(name==''){$('#productname_').focus();fun_message('warning','Warning','Enter Name','toast-bottom-right');return false;}
			var details=$('#details').val();
		
			var no_of_days=$('#no_of_days').val();if(no_of_days==''){$('#no_of_days').focus();fun_message('warning','Warning','Enter No of Days For Min Level','toast-bottom-right'); return false;}
			var economic=$('#economic').val();if(economic==''){$('#economic').focus(); fun_message('warning','Warning','Enter Min Level','toast-bottom-right');return false;}
			var reorder=$('#reorder').val();if(reorder==''){$('#reorder').focus();fun_message('warning','Warning','Enter Reorder Level','toast-bottom-right');return false;}
			var max_level=$('#max_level').val();if(max_level==''){$('#max_level').focus();fun_message('warning','Warning','Enter Max Level','toast-bottom-right'); return false;}
			
			var unit1=$('#unit1').val();if(unit1==''){$('#unit1').focus(); fun_message('warning','Warning','Select Unit','toast-bottom-right');return false;}
			var size=$('#size').val();

			var is_repeated=$('#is_repeated').val();if(is_repeated==''){$('#is_repeated').focus(); fun_message('warning','Warning','Select is_repeated','toast-bottom-right'); return false;}
			var product_type=$('#product_type').val();if(product_type==''){$('#product_type').focus();fun_message('warning','Warning','Select Product Type','toast-bottom-right');return false;}
			var hsn_code=$('#hsn_code').val();
			var brand=$('#brand').val();
			var purchase_rate=$('#purchase_rate').val();
			var sales_rate=$('#sales_rate').val();
			var cgst=$('#cgst').val();
			var sgst=$('#sgst').val();
			var igst=$('#igst').val();
			var active=$('#active').val();
			
			 
			
			//-------------------------------save
			  $('#wait').show();
			  $('#product_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Product/save';?>", 
							  {
								  id:id,
								  product_cat:product_cat,
								  name:name,
								  
								  details:details,
								  
								  no_of_days:no_of_days,
								  economic:economic,
								  reorder:reorder,
								  max_level:max_level,
								  
								  size:size,
								  is_repeated:is_repeated,
								  product_type:product_type,
								  hsn_code:hsn_code,
								  brand:brand,
								  purchase_rate:purchase_rate,
								  sales_rate:sales_rate,
								  cgst:cgst,
								  sgst:sgst,
								  igst:igst,
								  
								  unit1:unit1,
								  active:active,
								 
							}, 
							  function(data, textStatus)
							  {	
									if(data=='Save')
									{
										fun_message('success',data,'Save Successfully','toast-bottom-right');
										// showPage(url);
										$('#productname_').val('');
										$('#details').val('');
										//$('#no_of_days').val('');
										//$('#economic').val('');
										//$('#reorder').val('');
										//$('#max_level').val('');
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
									$('#product_save').show();
								  
								  
							  });
						
							  
				   });
			 //-------------------------------save
			
		});






	//-----------------------------------------------search
 	$('#product_search').click(function(){
	 	
		var product_id=$('#name_').val();
		var cat=$('#cat').val();
		var search1=1;
		
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Product/list';?>", 
				{
					product_id:product_id,
					cat:cat,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//query
		});//loader
	});//search close







	//-----------------------------------------------search
	$('#store_product_search').click(function(){
	 	
		 var product_id=$('#name_').val();
		 var cat=$('#cat').val();
		 var search1=1;
		 
		 $('.loader').show();
		 setTimeout(function() {
				 jQuery.post("<?php echo base_url().'index.php/Store/list_stock';?>", 
				 {
					product_id:product_id,
					cat:cat,
					search1:search1,
				 }, 
				 function(data, textStatus)
				 {	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				 });//query
		 });//loader
	 });//search close




	//-----------------------------------------------search
	$('#store_product_update_search').click(function(){
	 	
		 var product_id=$('#name_').val();
		 var cat=$('#cat').val();
		 var search1=1;
		 
		 $('.loader').show();
		 setTimeout(function() {
				 jQuery.post("<?php echo base_url().'index.php/Store/list_stock_update';?>", 
				 {
					product_id:product_id,
					cat:cat,
					search1:search1,
				 }, 
				 function(data, textStatus)
				 {	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				 });//query
		 });//loader
	 });//search close









	 	//new stock issue
		$('#stock_issue_save').click(function(){
	 		
			var url=$('#url').val();
			var id=$('#id').val();
			var current_stage=$('#current_stage').val();
			
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select dept','toast-bottom-right');return false;}
			var mc_no=$('#mc_no').val();

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
					//alert(itemval);
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
			
			
			
			<!---------------------------------------------------row-------------------------------->
			var oldproductid="";
			var oldlotno="";
			var oldgrade="";
			var oldqty="";
			var oldamt="";
			var oldpkg="";
			var detailsid="";
			var goods="";
			var goods2="";
			var grade="";
			var lotno="";
			var issueqty="";
			var receivedby="";
			var issuepkg="";
			
			
			$(".oldproductid").each(function(){		oldproductid=oldproductid.concat('~').concat($(this).val());		});
			$(".oldlotno").each(function(){		oldlotno=oldlotno.concat('~').concat($(this).val());		});
			$(".oldgrade").each(function(){		oldgrade=oldgrade.concat('~').concat($(this).val());		});
			$(".oldqty").each(function(){		oldqty=oldqty.concat('~').concat($(this).val());		});
			$(".oldamt").each(function(){		oldamt=oldamt.concat('~').concat($(this).val());						});
			$(".oldpkg").each(function(){		oldpkg=oldpkg.concat('~').concat($(this).val());						});
			$(".detailsid").each(function(){		detailsid=detailsid.concat('~').concat($(this).val());		});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());						});
			$(".goods2").each(function(){			goods2=goods2.concat('~').concat($(this).val());						});
			$(".grade").each(function(){			grade=grade.concat('~').concat($(this).val());				});
			$(".lotno").each(function(){			lotno=lotno.concat('~').concat($(this).val());						});
			$(".issueqty").each(function(){			issueqty=issueqty.concat('~').concat($(this).val());						});
			$(".receivedby").each(function(){		receivedby=receivedby.concat('~').concat($(this).val());						});
			$(".issuepkg").each(function(){		issuepkg=issuepkg.concat('~').concat($(this).val());						});
			
			
			<!---------------------------------------------------row-------------------------------->
			
			var comment=$('#comment').val();
			var indentor=$('#indentor').val();if(indentor==''){$('#indentor').focus();fun_message('warning','Warning','Enter indentor','toast-bottom-right');return false;}
			var request_by=$('#request_by').val();if(request_by==''){$('#request_by').focus();fun_message('warning','Warning','Enter request_by','toast-bottom-right');return false;}
			
			
			
			
			 
				//-------------------------------save								
			$('#wait').show();						
			$('#stock_issue_save').hide();						
			setTimeout(function() {						
					jQuery.post("<?php echo base_url().'index.php/Store/stock_issue_save';?>", 				
						{		
							id:id,	
							current_stage:current_stage,	
							entry_date:entry_date,	
							dept:dept,	
							mc_no:mc_no,
							comment:comment,	
							indentor:indentor,	
							request_by:request_by,	
							
							oldproductid:oldproductid,
							oldlotno:oldlotno,
							oldgrade:oldgrade,
							oldqty:oldqty,
							oldamt:oldamt,
							oldpkg:oldpkg,
							detailsid:detailsid,	
							goods:goods,	
							goods2:goods2,	
							grade:grade,	
							lotno:lotno,	
							issueqty:issueqty,
							issuepkg:issuepkg,		
							receivedby:receivedby,
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
							$('#stock_issue_save').show();	
						});		
			});					
		}); //-------------------------------save
 



		//-----------------------------------------------search
		$('#store_issue_search').click(function(){
			
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var issue_no=$('#issue_no').val();
			var dept=$('#dept').val();
			var mc_no=$('#mc_no').val();
			var grade=$('#grade').val();
			var product_id=$('#name_').val();
			var req_by=$('#req_by').val();
			var cat=$('#cat').val();
			var status=$('#status').val();
			var search1=1;
			
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Store/issue_list';?>", 
					{
						search_date1:search_date1,
						search_date2:search_date2,
						issue_no:issue_no,
						dept:dept,
						mc_no:mc_no,
						grade:grade,
						product_id:product_id,
						req_by:req_by,
						cat:cat,
						status:status,
						search1:search1,
					}, 
					function(data, textStatus)
					{	
						//alert(data);
						$('#table_show').html(data);
						$('.loader').hide();
					});//query
			});//loader
		});//search close


		

	//-----------------------------------------------search
	$('#stock_search').click(function(){
	 	
		 var dept=$('#dept').val();
		 var size=$('#goods_').val();
		 var dia=$('#dia').val();
		 var oil=$('#oil').val();
		 var grade=$('#grade').val();
		 var unit=$('#unit').val();
		 var search1=1;
		 
		 $('.loader').show();
		 setTimeout(function() {
				 jQuery.post("<?php echo base_url().'index.php/Store/stocklist';?>", 
				 {
					dept:dept,
					size:size,
					dia:dia,
					oil:oil,
					grade:grade,
					unit:unit,
					 search1:search1,
				 }, 
				 function(data, textStatus)
				 {	
					 //alert(data);
					 $('#table_show').html(data);
					 $('.loader').hide();
				 });//query
		 });//loader
	 });//search close



	 //new stock inout receive entry
	 $('#receive_stock_save').click(function(){
	 		
			var url=$('#url').val();
			var stock_inout_id=$('#stock_inout_id').val();
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select dept','toast-bottom-right');return false;}

			var in_from=$('#in_from').val();if(in_from==''){$('#in_from').focus();fun_message('warning','Warning','Select Receive From','toast-bottom-right');return false;}
			//var size=$('#size').val();if(size==''){$('#size').focus();fun_message('warning','Warning','Enter Size','toast-bottom-right');return false;}
			var size=$('#goods_').val();if(size==''){$('#goods2_').focus();fun_message('warning','Warning','Reselect Size','toast-bottom-right');return false;}
			
			var dia=$('#dia').val();if(dia==''){$('#dia').focus();fun_message('warning','Warning','Enter dia','toast-bottom-right');return false;}
			var oil=$('#oil').val();if(oil==''){$('#oil').focus();fun_message('warning','Warning','Select Oil','toast-bottom-right');return false;}
			var grade=$('#grade').val();if(grade==''){$('#grade').focus();fun_message('warning','Warning','Select grade','toast-bottom-right');return false;}
			var no_of_coils=$('#no_of_coils').val();if(no_of_coils==''){$('#no_of_coils').focus();fun_message('warning','Warning','Enter no_of_coils','toast-bottom-right');return false;}
			var weight=$('#weight').val();if(weight==''){$('#weight').focus();fun_message('warning','Warning','Enter weight','toast-bottom-right');return false;}
			var unit=$('#unit').val();if(unit==''){$('#unit').focus();fun_message('warning','Warning','Select unit','toast-bottom-right');return false;}
 			var remarks=$('#remarks').val();

			//var chk_arr =  document.getElementsByName("coilId[]");
			var allcheckBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilId]"), e => e.value);
			var checkedBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilId]:checked"), e => e.value);
			 
			  
			//-------------------------------save								
			 $('#wait').show();						
			 $('#receive_stock_save').hide();						
			 setTimeout(function() {						
					 jQuery.post("<?php echo base_url().'index.php/Store/receive_stock_save';?>", 				
						 {		
								stock_inout_id:stock_inout_id,	
								dept:dept,	
								in_from:in_from,
								entry_date:entry_date,	
								
								size:size,
								dia:dia,	
								oil:oil,	
								grade:grade,	
								no_of_coils:no_of_coils,
								weight:weight,
								unit:unit,
								remarks:remarks,
								allcheckBox:allcheckBox,
								checkedBox:checkedBox,
						 }, 		
						 function(data, textStatus)		
						 {		
							 if(data=='Save')
							 {
								 fun_message('success',data,'Save Successfully','toast-bottom-right');
								 $('#size').val('');
								 $('#dia').val('');
								 $('#oil').val('');
								 $('#grade').val('');
								 $('#no_of_coils').val('');
								 $('#weight').val('');
								 $('#unit').val('');
								 $('#remarks').val('');
								 //showPage(url);
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
							 $('#receive_stock_save').show();	
						 });		
			 });					
		 }); //-------------------------------save



		//-----------------------------------------------search
		$('#inout_stock_search').click(function(){
				
				var dept=$('#dept').val();
				var in_from=$('#in_from').val();
				var inout=$('#inout').val();
				var search_date1=$('#search_date1').val();
				var search_date2=$('#search_date2').val();
				var inout=$('#inout').val();
				var size=$('#goods_').val();
				var dia=$('#dia').val();
				var oil=$('#oil').val();
				var grade=$('#grade').val();
				var unit=$('#unit').val();
				var search1=1;
				
				$('.loader').show();
				setTimeout(function() {
						jQuery.post("<?php echo base_url().'index.php/Store/stockinoutlist';?>", 
						{
							dept:dept,
							inout:inout,
							in_from:in_from,
							search_date1:search_date1,
							search_date2:search_date2,
							inout:inout,
							size:size,
							dia:dia,
							oil:oil,
							grade:grade,
							unit:unit,
							search1:search1,
						}, 
						function(data, textStatus)
						{	
							//alert(data);
							$('#table_show').html(data);
							$('.loader').hide();
						});//query
				});//loader
			});//search close




			 //new stock inout receive entry
	 $('#despatch_stock_save').click(function(){
	 		
			 var url=$('#url').val();
			 var stock_inout_id=$('#stock_inout_id').val();
			 
			 var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			 var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select dept','toast-bottom-right');return false;}
			 
			 var out_to=$('#out_to').val();if(out_to==''){$('#out_to').focus();fun_message('warning','Warning','Select Despatch to','toast-bottom-right');return false;}
			
			 //var size=$('#size').val();if(size==''){$('#size').focus();fun_message('warning','Warning','Enter Size','toast-bottom-right');return false;}
			 var size=$('#goods_').val();if(size==''){$('#goods2_').focus();fun_message('warning','Warning','Reselect Size','toast-bottom-right');return false;}
			 var dia=$('#dia').val();if(dia==''){$('#dia').focus();fun_message('warning','Warning','Enter dia','toast-bottom-right');return false;}
 
			 var oil=$('#oil').val();if(oil==''){$('#oil').focus();fun_message('warning','Warning','Select Oil','toast-bottom-right');return false;}
 
			 var grade=$('#grade').val();if(grade==''){$('#grade').focus();fun_message('warning','Warning','Select grade','toast-bottom-right');return false;}
 
			 var no_of_coils=$('#no_of_coils').val();if(no_of_coils==''){$('#no_of_coils').focus();fun_message('warning','Warning','Enter no_of_coils','toast-bottom-right');return false;}
 
			 var weight=$('#weight').val();if(weight==''){$('#weight').focus();fun_message('warning','Warning','Enter weight','toast-bottom-right');return false;}
 
			 var unit=$('#unit').val();if(unit==''){$('#unit').focus();fun_message('warning','Warning','Select unit','toast-bottom-right');return false;}
  
			 var remarks=$('#remarks').val();
			
			   
			 //-------------------------------save								
			  $('#wait').show();						
			  $('#despatch_stock_save').hide();						
			  setTimeout(function() {						
					  jQuery.post("<?php echo base_url().'index.php/Store/despatch_stock_save';?>", 				
						  {		
							 stock_inout_id:stock_inout_id,	
							  dept:dept,	
							  out_to:out_to,
							  entry_date:entry_date,	
							  
							  size:size,
							  dia:dia,	
							  oil:oil,	
							  grade:grade,	
							  no_of_coils:no_of_coils,
							  weight:weight,
							  unit:unit,
							  remarks:remarks,
						  }, 		
						  function(data, textStatus)		
						  {		
							  if(data=='Save')
							  {
								  fun_message('success',data,'Save Successfully','toast-bottom-right');
								  $('#size').val('');
								  $('#dia').val('');
								  $('#oil').val('');
								  $('#grade').val('');
								  $('#no_of_coils').val('');
								  $('#weight').val('');
								  $('#unit').val('');
								  $('#remarks').val('');
								  //showPage(url);
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
							  $('#despatch_stock_save').show();	
						  });		
			  });					
		  }); //-------------------------------save

});
</script>

   
 
       
 