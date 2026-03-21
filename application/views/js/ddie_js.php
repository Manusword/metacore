
<script>



//--------------------------------------------die no check
function fun_die_no_check(id)
{
	$('#ddie_out').html('');
	if(id.length>=3)
	{
	 	//$('.loader').show();
			//setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/ddie_no_check';?>", 
							{
								die_no:id,
							}, 
							
							function(data, textStatus)
							{	
								$('#ddie_out').html(data);
								//$('.loader').hide();
							});
				// });
	}
}//fucntion close



//--------------------------------------------issue
function fun_die_no_check_issue(id)
{
	
	if(id.length>=3)
	{
	
		//$('.loader').show();
			//setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/ddie_no_check2';?>", 
							{
								die_no:id,
							}, 
							
							function(data, textStatus)
							{	
								//$('#ddie_out').html(data);
								var data2 = data.split("~");
								$('#id').val(data2[0]);
								$('#menu_no').val(data2[1]);
								$('#pallet').val(data2[3]);
								$('#old_location').val(data2[4]);
								$('#old_size').val(data2[2]);
								//$('#mc').val(data2[5]);
								$('#old_mc').val(data2[6]);

								//new loaction
								var new_location = '';
								if(data2[4] == 'Stock')
								{
									new_location = "M/C";
									$('#mc_list').show();
									$('#new_size_list').hide();
								}
								else if(data2[4] == 'M/C')
								{
									new_location = "Repair";
									$('#mc_list').hide();
									$('#new_size_list').show();
								}
								else if(data2[4] == 'Repair')
								{
									new_location = "Stock";
									$('#mc_list').hide();
									$('#new_size_list').show();
								}
								else
								{
									new_location = "";
									$('#mc_list').hide();
									$('#new_size_list').hide();
								}

								$('#new_location').val(new_location);

								$('.loader').hide();
							});
				// });
	}
	else
	{
		$('#id').val(0);
		$('#menu_no').val('');
		$('#size').val('');
		$('#pallet').val('');
		$('#location').val('');
		$('#location').val('');
		//$('#mc').val(data2[5]);
		$('#old_mc').val('');
		$('#new_location').val('');
		$('#mc').val('');
		$('#new_size').val('');

		//hide box
		$('#new_size_list').hide();
		$('#mc_list').hide();
	}
}//fucntion close



//----------------------------------get today die history list
function get_today_die_history_list()
{
	var search = 1
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Ddie/get_today_die_history_list';?>", 
			{
				search:search,
			}, 
			function(data, textStatus)
			{	
				$('#today_die_history_list').html(data);
				$('.loader').hide();
			});
	 });
	
}//fucntion close 








//--------------------------------------------machie list show / hide
function fun_loaction(id)
{
	if(id=='M/C')
	{
		$('#mc_out').show();
	}
	else
	{
		$('#mc_out').hide();
		$('#mc').val('');
	}
}//fucntion close









$(document).ready(function(e) {
	
	
	
	
	
	//-----------------------------------------------die ledger search
 	$('#die_ladger').click(function(){
		
	 	
			var con=doesConnectionExist();if(con==0){ error('No Internet Connection.');return false;}
			var die_no=$('#die_no').val();
		
			var search1=1;
			
			
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/ladger';?>", 
							{
								die_no:die_no,
								search1:search1,
							}, 
							
							function(data, textStatus)
							{	
								//alert(data);
								$('#table_show').html(data);
								$('.loader').hide();
							});
			});
			
		
	});//die ledger search



	
	
	
	
	
	
	
	
	
	
	//$('#mc_out').hide();
	
	$("#entry_date").datepicker({dateFormat: 'dd-mm-yy'});  
	$("#search_date2").datepicker({dateFormat: 'dd-mm-yy'});  
	$("#search_date1").datepicker({ dateFormat: 'dd-mm-yy'});
	
	  
	
	
    $('#new_die_save').click(function(){
			
	 		var url=$('#url').val();
			var id=$('#id').val();
			
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Issue Date','toast-bottom-right');return false;}
			var die_type=$('#die_type').val();if(die_type==''){$('#die_type').focus();fun_message('warning','Warning','Select Die Type','toast-bottom-right');return false;}
			var die_no=$('#die_no').val();if(die_no==''){$('#die_no').focus();fun_message('warning','Warning','Select Die No','toast-bottom-right');return false;}
			var menu_no=$('#menu_no').val();if(menu_no==''){$('#menu_no').focus();fun_message('warning','Warning','Select Manufacturing No','toast-bottom-right');return false;}
			var size=$('#size').val();if(size==''){$('#size').focus();fun_message('warning','Warning','Select Size','toast-bottom-right');return false;}
			var pallet=$('#pallet').val();if(pallet==''){$('#pallet').focus();fun_message('warning','Warning','Select Pallet','toast-bottom-right');return false;}
			
			var location=$('#location').val();
			var mc=$('#mc').val();

			if(location=='')
			{
				$('#location').focus();
				form_validation('Select Location');
				return false;
			}
			else if(location=='M/C')
			{
				if(mc=='')
				{
					$('#mc').focus();
					form_validation('Select Location');
					return false;
				}
			}
			
			
			//-------------------------------save
			  $('#wait').show();
			  $('#new_die_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/ddie/new_die_save';?>", 
							{
								  id:id,
								  entry_date:entry_date,
								  die_type:die_type,
								  die_no:die_no,
								  menu_no:menu_no,
								  size:size,
								  pallet:pallet,
								  location:location,
								  mc:mc,
							}, 
							  function(data, textStatus)
							  {	
								  if(data=='Save')
								  {
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									 // showPage(url);
									 $('#die_no').val('');
									 $('#menu_no').val('');
									 $('#size').val('');
									 $('#pallet').val('');
									 $('#location').val('');
									 $('#mc').val('');
									 //$('#mc_out').hide();
								  }
								  else if(data=='Update')
								  {
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								  }
								  else
								  {
									fun_message('error','Error',data,'toast-bottom-right');
								  }
								  $('#wait').hide();
								  $('#new_die_save').show();
							  });
				   });
		});//save




























	    $('#issue_return_save').click(function(){
			var id=$('#id').val();
			var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Issue Date','toast-bottom-right');return false;}
			var die_no=$('#die_no').val();if(die_no==''){$('#die_no').focus();fun_message('warning','Warning','Select Issue Date','toast-bottom-right');return false;}
			var menu_no=$('#menu_no').val();
			var pallet=$('#pallet').val();
			var old_location=$('#old_location').val();
			if(old_location == '')
			{
				$('#old_location').focus();
				fun_message('warning','Warning','Die is in Wrong place. Please chnage location before issue','toast-bottom-right');
				return false;
			}
			var old_size=$('#old_size').val();
			var new_location=$('#new_location').val();
			var new_size=$('#new_size').val();
			var new_mc=$('#mc').val();

			
			if(new_location == 'Stock')
			{
				if(new_size == ''){fun_message('warning','Warning','Enter New Size','toast-bottom-right');return false;}
			}
			else if(new_location == 'M/C')
			{
				if(new_mc == ''){fun_message('warning','Warning','Select Machine No','toast-bottom-right');return false;}
			}
			else if(new_location == 'Repair')
			{
				if(new_size == ''){fun_message('warning','Warning','Enter Current Size','toast-bottom-right');return false;}
			}
			else
			{
				fun_message('warning','Warning','Die is in Wrong place. Please chnage location before issue','toast-bottom-right');
				return false;
			}

			
			//-------------------------------save
			  $('#wait').show();
			  $('#issue_return_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Ddie/die_issue_save';?>", 
							  {
								  id:id,
								  entry_date:entry_date,
								  die_no:die_no,
								  old_location:old_location,
								  old_size:old_size,
								  new_location:new_location,
								  new_size:new_size,
								  new_mc:new_mc,
							}, 
							  function(data, textStatus)
							  {	
									if(data=='Save')
								  	{
										fun_message('success',data,'Save Successfully','toast-bottom-right');
										$('#id').val('');
										$('#die_no').val('');
										$('#menu_no').val('');
										$('#pallet').val('');
										$('#old_location').val('');
										$('#old_mc').val('');
										$('#old_size').val('');
										$('#new_location').val('');
										$('#new_size').val('');
										$('#mc').val('');
										
										//hide box
										$('#new_size_list').hide();
										$('#mc_list').hide();
										get_today_die_history_list();
									}
								 	else
								  	{
										fun_message('error','Error',data,'toast-bottom-right');
								  	}
								  $('#wait').hide();
								  $('#issue_return_save').show();
							});
					});
					
					
		});//issue



























	//-----------------------------------------------new_die_search
 	$('#new_die_search').click(function(){
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var mc=$('#mc').val();
			var pallet=$('#pallet').val();
			var die_no=$('#die_no').val();
			var size=$('#size').val();
			var menu_no=$('#menu_no').val();

			var search1 = 1;
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/new_die_list';?>", 
							{
								search_date1:search_date1,
								search_date2:search_date2,
								mc:mc,
								pallet:pallet,
								die_no:die_no,
								size:size,
								menu_no:menu_no,
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








	//-----------------------------------------------issue return search
 	$('#issue_return_search').click(function(){
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var mc=$('#mc').val();
			var pallet=$('#pallet').val();
			var die_no=$('#die_no').val();
			var size=$('#size').val();
			var menu_no=$('#menu_no').val();
			var location=$('#location').val();
			var is_it_new=$('#is_it_new').val();

			var search1 = 1;
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/issue_return_search_list';?>", 
							{
								search_date1:search_date1,
								search_date2:search_date2,
								mc:mc,
								pallet:pallet,
								die_no:die_no,
								size:size,
								menu_no:menu_no,
								location:location,
								is_it_new:is_it_new,
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


	//-----------------------------------------------group_wise_search search
 	$('#group_wise_search').click(function(){
			var location=$('#location').val();
			var group_wise=$('#group_wise').val();
			
			var search1 = 1;
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/new_die_list_size_machine_wise';?>", 
							{
								location:location,
								group_wise:group_wise,
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


	//-----------------------------------------------group_wise_search search
	$('#die_ledger_search').click(function(){
			var die_no=$('#die_no').val();
			var search1 = 1;
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Ddie/die_ledger';?>", 
							{
								die_no:die_no,
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
	






























	


});//document close





























</script>

   
 
       
 