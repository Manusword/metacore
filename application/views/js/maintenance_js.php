
<script>



$(function () {
	$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });
	
	$( "#event_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });
	
	
	
	$( "#target_date" ).datepicker({
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
	
	//--------------maintance
	
	$( "#break_down_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });
	
	
	
	
});







$(document).ready(function(e) {
    
	$('#breaksown_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Entry Date','toast-bottom-right');return false;}
			var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select Dept','toast-bottom-right');return false;}
			var type=$('#type').val();if(type==''){$('#type').focus();fun_message('warning','Warning','Select Type of Problem','toast-bottom-right');return false;}
			var type2=$('#type2').val();if(type2==''){$('#type2').focus();fun_message('warning','Warning','Select Problem Status','toast-bottom-right');return false;}
			var mc_no=$('#mc_no').val();if(mc_no==''){$('#mc_no').focus();fun_message('warning','Warning','Enter Mc No','toast-bottom-right');return false;}

			var type_of_problem=$('#type_of_problem').val();if(type_of_problem==''){$('#type_of_problem').focus();fun_message('warning','Warning','Select type_of_problem','toast-bottom-right');return false;}
			if(type_of_problem == 'Other')
			{
				var other_problem_type=$('#other_problem_type').val();if(other_problem_type==''){$('#other_problem_type').focus();fun_message('warning','Warning','Enter other_problem_type','toast-bottom-right');return false;}
			}
			else
			{
				var other_problem_type = '';
			}
			var problem=$('#problem').val();if(problem==''){$('#problem').focus();fun_message('warning','Warning','Enter problem','toast-bottom-right');return false;}
			
			var break_down_date=$('#break_down_date').val();if(break_down_date==''){$('#break_down_date').focus();fun_message('warning','Warning','Enter break_down_date','toast-bottom-right');return false;}
			var break_down_time=$('#break_down_time').val();if(break_down_time==''){$('#break_down_time').focus();fun_message('warning','Warning','Enter break_down_time','toast-bottom-right');return false;}
			var person=$('#person').val();if(person==''){$('#person').focus();fun_message('warning','Warning','Enter person','toast-bottom-right');return false;}
			var shift_incharge1=$('#shift_incharge1').val();if(shift_incharge1==''){$('#shift_incharge1').focus();fun_message('warning','Warning','Enter shift_incharge','toast-bottom-right');return false;}
			var action_taken=$('#action_taken').val();
			var part_change=$('#part_change').val();
			var attend_by=$('#attend_by').val();
			var active=$('#active').val();
			var comp_date=$('#comp_date').val();
			var comp_time=$('#comp_time').val();
			var checked_by=$('#checked_by').val();
			var shift_incharge2=$('#shift_incharge2').val();
			var md_review=$('#md_review').val();
			
			
			let shift=$('#shift').val();
			let root_cause=$('#root_cause').val();
			let priority=$('#priority').val();
			let rating=$('#rating').val();
			let type_of_work=$('#type_of_work').val();
			
			
			
			//-------------------------------save
			  $('#wait').show();
			  $('#breaksown_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Maintenance/breakdown_save';?>", 
							  {
								  id:id,
								  entry_date:entry_date,
								  dept:dept,
								  type:type,
								  type2:type2,
								  mc_no:mc_no,
								  type_of_problem:type_of_problem,
								  other_problem_type:other_problem_type,
								  problem:problem,
								  break_down_date:break_down_date,
								  break_down_time:break_down_time,
								  
								  person:person,
								  shift_incharge1:shift_incharge1,
								  
								  action_taken:action_taken,
								  part_change:part_change,
								  attend_by:attend_by,
								  
								  active:active,
								  comp_date:comp_date,
								  comp_time:comp_time,
								  
								  checked_by:checked_by,
								  shift_incharge2:shift_incharge2,
								  md_review:md_review,

								  shift:shift,
								  type_of_work:type_of_work,
								  root_cause:root_cause,
								  priority:priority,
								  rating:rating,
								  
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
								$('#breaksown_save').show();
							});//jquery
					});//loader
	});//save






 	$('#breakdown_search').click(function(){
	 	
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var type1=$('#type1').val();
		//var type2=$('#type2').val();
		var dept=$('#dept').val();
		var status=$('#status').val();
		var problem_type_id=$('#problem_type_id').val();

		let type_of_work=$('#type_of_work').val();
		let priority=$('#priority').val();
		let rating=$('#rating').val();
		let attend_by=$('#attend_by').val();
		
		


		
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Maintenance/list_breakdown';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				type1:type1,
				dept:dept,
				problem_type_id:problem_type_id,
				status:status,
				type_of_work:type_of_work,
				priority:priority,
				rating:rating,
				attend_by:attend_by,
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


	$('#list2_search').click(function(){
	 	
		 var search_date1=$('#search_date1').val();
		 var search_date2=$('#search_date2').val();
		 var search1=1;
		 
		 $('.loader').show();
		 setTimeout(function() {
			 jQuery.post("<?php echo base_url().'index.php/Maintenance/list2';?>", 
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





	$('#meter_reading_save').click(function(){
	 	
		var url=$('#url').val();
		var id=$('#id').val();
		
		var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Entry Date','toast-bottom-right');return false;}
	
		var deptclassid="";
		var deptclassval="";
		var machineclassid="";
		var machineclassval="";
		$(".deptclassid").each(function(){	deptclassid = deptclassid.concat('~').concat($(this).val());		});
		$(".deptclassval").each(function(){	deptclassval = deptclassval.concat('~').concat($(this).val());		});
		$(".machineclassid").each(function(){	machineclassid = machineclassid.concat('~').concat($(this).val());		});
		$(".machineclassval").each(function(){	machineclassval = machineclassval.concat('~').concat($(this).val());		});
		  
		 
		//-------------------------------save
		$('#wait').show();
		$('#meter_reading_save').hide();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Maintenance/meter_reading_save';?>", 
						{
							id:id,
							entry_date:entry_date,
							
							deptclassid:deptclassid,
							deptclassval:deptclassval,
							machineclassid:machineclassid,
							machineclassval:machineclassval,
							
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
						$('#meter_reading_save').show();
					});//jquery
			});//loader
 	});//save



	$('#meter_reading_search').click(function(){
	
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();
	
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Maintenance/list_meter_reading';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
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


	$('#meter_reading_search2').click(function(){
	
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();

		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Maintenance/list_meter_reading2';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				dept:dept,
				mc_no:mc_no,
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








	$('#reminder_save').click(function(){
	 	
		let url=$('#url').val();
		let reminder_id=$('#reminder_id').val();
		
		let task=$('#task').val();if(task==''){$('#task').focus();fun_message('warning','Warning','Select  Date','toast-bottom-right');return false;}
		let event_date=$('#event_date').val();if(event_date==''){$('#event_date').focus();fun_message('warning','Warning','Select  Date','toast-bottom-right');return false;}
		
		let repeat_status=$('#repeat_status').val();
		let dept=$('#dept').val();
		let mc_no=$('#mc_no').val();
		let status=$('#status').val();
		let priority=$('#priority').val();
		let show_to=$('#show_to').val();
		let remarks=$('#remarks').val();
		let location=$('#location').val();
		let customer_id=$('#customer_id').val();

		 
		//-------------------------------save
		$('#wait').show();
		$('#reminder_save').hide();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Maintenance/reminder_save';?>", 
						{
							reminder_id:reminder_id,
							task:task,
							event_date:event_date,
							repeat_status:repeat_status,
							dept:dept,
							mc_no:mc_no,
							status:status,
							priority:priority,
							show_to:show_to,
							location:location,
							customer_id:customer_id,
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
						$('#reminder_save').show();
					});//jquery
			});//loader
 	});//save




		



 	$('#reminder_search').click(function(){
	 	
		let search_date1=$('#search_date1').val();
		let search_date2=$('#search_date2').val();
		let priority=$('#priority').val();
		let dept=$('#dept').val();
		let status=$('#status').val();
		let location=$('#location').val();
		
		
		let search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Maintenance/list_reminder';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				priority:priority,
				dept:dept,
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








});//document





</script>

   
 
       
 