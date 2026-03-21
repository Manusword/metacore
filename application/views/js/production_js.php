<script>

//get machine current running plan
function fun_machine_plan_production_entry(mc_id){
	$('#CurrentRuningDis2').html('');
					
	jQuery.post("<?php echo base_url().'index.php/Production/fun_machine_plan';?>", {mc_id:mc_id}, function(data) {
		$('#CurrentRuningDis2').html(data);
		radio_function_for_startdate();
	});
}//function close



//-------------------------------getting product
function fun_get_last_machine_details(mc_id)
{
	
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/fun_get_last_machine_details';?>", 
					{
						mc_id:mc_id,
					}, 
					function(data, textStatus)
					{	
						//alert(data);
						var out = data.split("~");
						$('#mc_speed').val(out[0]);
						$('#goods_').val(out[1]);
						$('#grade').val(out[2]);
						$('#product_type').val(out[3]);
						$('#goods32_').val(out[4]);
						$('#unit1').val(out[5]);
						$('#goods2_').val(out[6]);
						$('#goods31_').val(out[7]);

						fun_machine_plan_production_entry(mc_id);
						$('.loader').hide();
					});
			});
			 
}//function close


//-------------------------------getting product
function fun_get_last_machine_details_rope()
{
	let mc_id = $('#mc_no').val();
	let size = $('#size').val();

	//change shift hours
	let shift1 = $('#shift1').val();
	if(shift1 == 'B'){
		$('#shift_hours1').val(12);
		$('#running_hours_1').val(12);
	}else{
		if(shift1 == 'A'){
		$('#shift_hours1').val(11.5);
		$('#running_hours_1').val(11.5);
	}
	}

	$('#operation').val("");
	$('#construction').val("");
	$('#grade').val("");
	$('#wt_mt').val("");
	$('#mc_speed').val("");
	$('#pitch').val("");
	$('#line_speed').val("");
	$('#mc_capacity').val("");
	$('#target').val("");
	
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/fun_get_last_machine_details_rope';?>", 
					{
						mc_id:mc_id,
						size:size,
					}, 
					function(data, textStatus)
					{	
						//alert(data);
						var out = data.split("~");
						$('#operation').val(out[1]);
						$('#construction').val(out[2]);
						$('#grade').val(out[3]);
						$('#wt_mt').val(out[4]);
						$('#mc_speed').val(out[5]);
						$('#pitch').val(out[6]);
						$('#line_speed').val(out[7]);
						$('#mc_capacity').val(out[8]);
						$('#target').val(out[9]);

						$('.loader').hide();
					});
			});
			 
}//function close

/*
//-------------------------------getting product
function fun_check_qty_in_wip(lotno)
{
	var in_item=$('#goods_1').val();

	$('#out_lotno').val(lotno);
	
	//$('.loader').show();
	//setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Ajex/fun_check_qty_in_wip';?>", 
					{
						in_item:in_item,
						lotno:lotno,
					}, 
					
					function(data, textStatus)
					{	
						//alert(data);
						$(current_qty).html(data);
						$('.loader').hide();
					});
			//});
			 
}//function close
*/





$(function () {
	//$( "#invoice_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: -1,
    });

	$( "#search_date1" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });

	$( "#search_date2" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });
});




$(document).ready(function(e) {
    


	 $('#production_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			
			var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select Dept','toast-bottom-right');return false;}
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
			var mc_no=$('#mc_no').val();if(mc_no==''){$('#mc_no').focus();fun_message('warning','Warning','Select M/C No','toast-bottom-right');return false;}
			var mc_speed=$('#mc_speed').val();if(mc_speed==''){$('#mc_speed').focus();fun_message('warning','Warning','Enter speed','toast-bottom-right');return false;}
			
			var in_item=$('#goods_').val();
			var grade=$('#grade').val();if(grade==''){$('#grade').focus();fun_message('warning','Warning','Select Grade','toast-bottom-right');return false;}
			var product_type=$('#product_type').val();if(product_type==''){$('#product_type').focus();fun_message('warning','Warning','Select Product Type','toast-bottom-right');return false;}
			var out_item=$('#goods32_').val();if(out_item==''){$('#goods31_').focus();fun_message('warning','Warning','Enter Finish Size','toast-bottom-right');return false;}
			var unit1=$('#unit1').val();if(unit1==''){$('#unit1').focus();fun_message('warning','Warning','Select unit','toast-bottom-right');return false;}
			var remarks=$('#remarks').val();
			var stage1=$('#stage1').val();
			
			var shift1=$('#shift1').val();
			var shift_hours1=$('#shift_hours1').val();if(shift_hours1==''){$('#shift_hours1').focus();fun_message('warning','Warning','Select shift_hours in A Shift','toast-bottom-right');return false;}
			var no_of_spool1=$('#no_of_spool1').val();if(no_of_spool1==''){$('#no_of_spool1').focus();fun_message('warning','Warning','Enter no_of_coil in A shift','toast-bottom-right');;return false;}
			var qty1=$('#qty1').val();if(qty1==''){$('#qty1').focus();fun_message('warning','Warning','Enter qty in A shift','toast-bottom-right');return false;}
			var operator1=$('#operator1').val();
			var down_type1=$('#down_type1').val();
			var down_reason1=$('#down_reason1').val();
			var down_total_time1=$('#down_total_time1').val();
			var remarks=$('#remarks').val();
			var stage2=$('#stage2').val();
			
			

			var shift2=$('#shift2').val();
			var shift_hours2=$('#shift_hours2').val();
			var no_of_spool2=$('#no_of_spool2').val();
			var qty2=$('#qty2').val();
			var operator2=$('#operator2').val();
			var down_type2=$('#down_type2').val();
			var down_reason2=$('#down_reason2').val();
			var down_total_time2=$('#down_total_time2').val();

			var helper1=$('#helper1').val();
			var running_hours_1=$('#running_hours_1').val();
			

			var helper2=$('#helper2').val();
			var running_hours_2=$('#running_hours_2').val();
			
			
			
			
			//-------------------------------save
			$('#wait').show();
			 $('#production_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Production/save';?>", 
							  {
								  	id:id,
								  	dept:dept,
									entry_date:entry_date,
									mc_no:mc_no,
									mc_speed:mc_speed,
									
									in_item:in_item,
									grade:grade,
									product_type:product_type,
									out_item:out_item,
									unit1:unit1,
									remarks:remarks,
									
									shift1:shift1,
									shift_hours1:shift_hours1,
									no_of_spool1:no_of_spool1,
									qty1:qty1,
									operator1:operator1,
									down_type1:down_type1,
									down_reason1:down_reason1,
									down_total_time1:down_total_time1,
									
									shift2:shift2,
									shift_hours2:shift_hours2,
									no_of_spool2:no_of_spool2,
									qty2:qty2,
									operator2:operator2,
									down_type2:down_type2,
									down_reason2:down_reason2,
									down_total_time2:down_total_time2,

									helper1:helper1,
									running_hours_1:running_hours_1,
									helper2:helper2,
									running_hours_2:running_hours_2,

									stage1:stage1,
									stage2:stage2,
									
									
							}, 
								function(data, textStatus)
								{	
								 
									if(data=='Save')
									{
										fun_message('success',data,'Save Successfully','toast-bottom-right');
										//showPage(url);
										
										$('#mc_no').val('');
										
										$('#goods2_').val('');
										$('#goods_').val('');
										$('#grade').val('');
										$('#product_type').val('');
										$('#goods31_').val('');
										$('#goods32_').val('');
										$('#unit1').val('');
										$('#remarks').val('');
										
										$('#no_of_spool1').val('');
										$('#qty1').val('');
										$('#operator1').val('');
										$('#helper1').val('');
										$('#down_type1').val('');
										$('#down_reason1').val('');
										$('#down_total_time1').val('');
										$('#running_hours_1').val(11.5);

										$('#no_of_spool2').val('');
										$('#qty2').val('');
										$('#operator2').val('');
										$('#helper2').val('');
										$('#down_type2').val('');
										$('#down_reason2').val('');
										$('#down_total_time2').val('');
										$('#running_hours_2').val(12);
										
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
									$('#production_save').show();
								  
								  
							  });
						
				   });
			
		});//wet_pro_save



		$('#production_save2').click(function(){
	 	
		var url=$('#url').val();
		var id=$('#id').val();
		
		var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
		var mc_no=$('#mc_no').val();if(mc_no==''){$('#mc_no').focus();fun_message('warning','Warning','Select M/C No','toast-bottom-right');return false;}
		
		var shift1=$('#shift1').val();
		var size=$('#size').val();
		var operation=$('#operation').val();
		var construction=$('#construction').val();

		var grade=$('#grade').val();
		var wt_mt=$('#wt_mt').val();
		var mc_speed=$('#mc_speed').val();
		var pitch=$('#pitch').val();

		
		var line_speed=$('#line_speed').val();
		var mc_capacity=$('#mc_capacity').val();
		var target=$('#target').val();
		
		var qty_in_meter=$('#qty_in_meter').val();if(qty_in_meter==''){$('#qty_in_meter').focus();fun_message('warning','Warning','Enter Qty in Mtr','toast-bottom-right');return false;}

		var qty_in_kg=$('#qty_in_kg').val();
		var shift_hours1=$('#shift_hours1').val();
		
		var operator1=$('#operator1').val();
		var helper1=$('#helper1').val();

		var down_type1=$('#down_type1').val();
		var down_reason1=$('#down_reason1').val();
		var down_total_time1=$('#down_total_time1').val();
		var running_hours_1=$('#running_hours_1').val();
		var remarks=$('#remarks').val();
		var scrap=$('#scrap').val();
		var eff1=$('#eff1').val();
		var type=$('#type').val();
		
		 
		 //-------------------------------save
		 $('#wait').show();
		  $('#production_save2').hide();
		   setTimeout(function() {
				   jQuery.post("<?php echo base_url().'index.php/Production/rope_save';?>", 
						   {
								id:id,
								
								entry_date:entry_date,
								mc_no:mc_no,
								
								shift1:shift1,
								size:size,
								operation:operation,

								construction:construction,
								grade:grade,
								wt_mt:wt_mt,

								mc_speed:mc_speed,
								pitch:pitch,
								type:type,
								line_speed:line_speed,
								mc_capacity:mc_capacity,
								target:target,
								qty_in_meter:qty_in_meter,
								qty_in_kg:qty_in_kg,

								shift_hours1:shift_hours1,
								
								operator1:operator1,
								helper1:helper1,
								down_type1:down_type1,
								down_reason1:down_reason1,
								down_total_time1:down_total_time1,
								running_hours_1:running_hours_1,
								remarks:remarks,
								scrap:scrap,
								eff1:eff1,
						}, 
							 function(data, textStatus)
							 {	
							  
								 if(data=='Save')
								 {
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									//showPage(url);
									 
									$('#mc_no').val("");
									$('#size').val("");
									 
									$('#operation').val("");
									$('#construction').val("");
									$('#grade').val("");
									$('#wt_mt').val("");
									$('#mc_speed').val("");
									$('#pitch').val("");
									$('#line_speed').val("");
									$('#mc_capacity').val("");
									$('#target').val("");


									$('#qty_in_meter').val("");
									$('#qty_in_kg').val("");
									$('#operator1').val("");

									$('#helper1').val("");
									$('#down_type1').val("");
									$('#down_reason1').val("");

									$('#running_hours_1').val(shift_hours1);
									
									$('#remarks').val("");
									$('#scrap').val("");
									
									
									 
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
								 $('#production_save2').show();
							   
							   
						   });
					 
				});
		 
	 });//rope pro save














		
	//-----------------------------------------------search
 	$('#production_search').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();

		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();
		var base_id=$('#goods_').val();
		var finish_id=$('#goods32_').val();
		var grade=$('#grade').val();
		var product_type=$('#product_type').val();
		var down_type=$('#down_type').val();
		//var operator=$('#operator').val();
		
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/list';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
				base_id:base_id,
				finish_id:finish_id,
				grade:grade,
				product_type:product_type,
				down_type:down_type,
				
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



	
		
	//-----------------------------------------------search
	$('#plan_search').click(function(){
		
		let search_date1=$('#search_date1').val();
		let search_date2=$('#search_date2').val();
		let status=$('#status').val();
		let dept=$('#dept').val();
		let mc_no=$('#mc_no').val();
		let base_id=$('#goods_').val();
		let finish_id=$('#goods32_').val();
		let grade=$('#grade').val();
		let product_type=$('#product_type').val();
		
		let search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/planlist';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
				base_id:base_id,
				finish_id:finish_id,
				grade:grade,
				product_type:product_type,
				status:status,
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

	//-----------------------------------------------search
	$('#production_search_rope').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var shift1=$('#shift1').val();
		var dept_type=$('#dept_type').val();

		var operation=$('#operation').val();
		var construction=$('#construction').val();
		
		var mc_no=$('#mc_no').val();
		var size=$('#size').val();
		var grade=$('#grade').val();
		var down_type=$('#down_type').val();
		var operator=$('#operator').val();
		var type=$('#type').val();
		
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/ropelist';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				shift1:shift1,
				dept_type:dept_type,
				operation:operation,
				construction:construction,
				mc_no:mc_no,
				size:size,
				grade:grade,
				down_type:down_type,
				operator:operator,
				type:type,
				
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
	



	//-----------------------------------------------search 2
	$('#production_search2').click(function(){
		
		var search_date1=$('#search_date1').val();
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/list2';?>", 
			{
				search_date1:search_date1,
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


	//-----------------------------------------------search 3
	$('#production_search3').click(function(){
		
		var dept=$('#dept').val();
		var year=$('#year').val();
		var month=$('#month').val();
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/list3';?>", 
			{
				dept:dept,
				year:year,
				month:month,
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


	//-----------------------------------------------search 3
	$('#production_search4').click(function(){
		
		var dept=$('#dept').val();
		var year=$('#year').val();
		var month=$('#month').val();
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/list4';?>", 
			{
				dept:dept,
				year:year,
				month:month,
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

	//-----------------------------------------------search 3
	$('#production_search5').click(function(){
		
		var dept=$('#dept').val();
		var year=$('#year').val();
		var month=$('#month').val();
		var date=$('#date').val();
		var show_details=$('#show_details').val();
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/list5';?>", 
			{
				dept:dept,
				year:year,
				month:month,
				date:date,
				show_details:show_details,
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



	




	$('#scrap_save').click(function(){
	 	
		var url=$('#url').val();
		var id=$('#id').val();
		 
		var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
		var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select Dept','toast-bottom-right');return false;}
		var mc_no=$('#mc_no').val();
		var grade=$('#grade').val();
		
		var qty1=$('#qty1').val();
		var person1=$('#person1').val();
		var unit1=$('#unit1').val();
		var shift_inchage1=$('#shift_inchage1').val();

		var qty2=$('#qty2').val();
		var person2=$('#person2').val();
		var unit2=$('#unit2').val();
		var shift_inchage2=$('#shift_inchage2').val();
		 
		 
		 
		 //-------------------------------save
		 $('#wait').show();
		  $('#scrap_save').hide();
		   setTimeout(function() {
				   jQuery.post("<?php echo base_url().'index.php/Production/scrap_save';?>", 
						   {
								id:id,
								entry_date:entry_date,
								dept:dept,
								mc_no:mc_no,
								grade:grade,
								 
								qty1:qty1,
								person1:person1,
								unit1:unit1,
								shift_inchage1:shift_inchage1,

								qty2:qty2,
								person2:person2,
								unit2:unit2,
								shift_inchage2:shift_inchage2,
							}, 
							 function(data, textStatus)
							 {	
							  
								 if(data=='Save')
								 {
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									//showPage(url);
									
									$('#dept').val('');
									$('#mc_no').val('');
									$('#grade').val('');

									$('#qty1').val('');
									$('#person1').val('');
									$('#unit1').val('');
									$('#shift_inchage1').val('');
									
									$('#qty2').val('');
									$('#person2').val('');
									$('#unit2').val('');
									$('#shift_inchage2').val('');
									 
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
								 $('#scrap_save').show();
							   
							   
						   });
					 
				});
		 
	 });//scrap entry


	 
	//-----------------------------------------------search
	$('#scrap_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();
		var grade=$('#grade').val();
		
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/scrap_list';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
				grade:grade,
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







	$('#short_save').click(function(){
	 	
		 var url=$('#url').val();
		 var id=$('#id').val();
		  
		 var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Date','toast-bottom-right');return false;}
		 var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select Dept','toast-bottom-right');return false;}
		 var mc_no=$('#mc_no').val();
		 var grade=$('#grade').val();
		 
		 var qty1=$('#qty1').val();
		 var person1=$('#person1').val();
		 var unit1=$('#unit1').val();
		 var shift_inchage1=$('#shift_inchage1').val();
 
		 var qty2=$('#qty2').val();
		 var person2=$('#person2').val();
		 var unit2=$('#unit2').val();
		 var shift_inchage2=$('#shift_inchage2').val();
		  
		  
		  
		  //-------------------------------save
		  $('#wait').show();
		   $('#short_save').hide();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Production/short_save';?>", 
							{
								 id:id,
								 entry_date:entry_date,
								 dept:dept,
								 mc_no:mc_no,
								 grade:grade,
								  
								 qty1:qty1,
								 person1:person1,
								 unit1:unit1,
								 shift_inchage1:shift_inchage1,
 
								 qty2:qty2,
								 person2:person2,
								 unit2:unit2,
								 shift_inchage2:shift_inchage2,
							 }, 
							  function(data, textStatus)
							  {	
							   
								  if(data=='Save')
								  {
									 fun_message('success',data,'Save Successfully','toast-bottom-right');
									 //showPage(url);
									 
									 $('#dept').val('');
									 $('#mc_no').val('');
									 $('#grade').val('');
 
									 $('#qty1').val('');
									 $('#person1').val('');
									 $('#unit1').val('');
									 $('#shift_inchage1').val('');
									 
									 $('#qty2').val('');
									 $('#person2').val('');
									 $('#unit2').val('');
									 $('#shift_inchage2').val('');
									  
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
								  $('#short_save').show();
								
								
							});
					  
				 });
		  
	  });//scrap entry
 



	//-----------------------------------------------search
	$('#short_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();
		var grade=$('#grade').val();
		
		var search1='1';
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Production/short_list';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
				grade:grade,
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




























});//document close





</script>

   
 
       
 