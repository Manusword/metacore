<script>


$(function () {
	//$( "#invoice_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: -1,
    });

	$( "#entry_date2" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   
    });

	$( "#search_date1" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });

	$( "#search_date2" ).datepicker({
       dateFormat: 'dd-mm-yy',
    });
});


















$(document).ready(function(e) {
	
	/*
	$('#finish_size').autocomplete({
		source: '<?php echo base_url().'index.php';?>/Ajex/rope_config_finish_size/',
		autoFocus:true,
	});
	
	
	$('#size1').autocomplete({
		source: '<?php echo base_url().'index.php';?>/Ajex/rope_config_finish_size/',
		autoFocus:true,
	});
	
	
	$('#size2').autocomplete({
		source: '<?php echo base_url().'index.php';?>/Ajex/rope_config_finish_size/',
		autoFocus:true,
	});

	$('#size3').autocomplete({
		source: '<?php echo base_url().'index.php';?>/Ajex/rope_config_finish_size/',
		autoFocus:true,
	});
	*/
	
	
    	$('#machine_save').click(function(){
	 		
			var url=$('#url').val();
			var id=$('#id').val();
			var dept=$('#dept').val();if(dept==''){$('#dept').focus();fun_message('warning','Warning','Select Dept.','toast-bottom-right');return false;}
			var name=$('#name').val();if(name==''){$('#name').focus();fun_message('warning','Warning','Select Name','toast-bottom-right');return false;}
			var capstan=$('#capstan').val();
			var max_speed=$('#max_speed').val();
			var min_base_size=$('#min_base_size').val();
			var max_base_size=$('#max_base_size').val();
			var min_finish_size=$('#min_finish_size').val();
			var max_finish_size=$('#max_finish_size').val();

			

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
			<!---------------------------------------------------row-------------------------------->
			var details_id="";
			var goods="";
			var hours="";
			var qunt="";
			var eff="";
			
			$(".details_id").each(function(){		details_id=details_id.concat('~').concat($(this).val());		});
			$(".goods").each(function(){			goods=goods.concat('~').concat($(this).val());						});
			$(".hours").each(function(){			hours=hours.concat('~').concat($(this).val());				});
			$(".qunt").each(function(){				qunt=qunt.concat('~').concat($(this).val());						});
			$(".eff").each(function(){				eff=eff.concat('~').concat($(this).val());						});
			<!---------------------------------------------------row-------------------------------->
			<!---------------------------------------------------row-------------------------------->
			var rope_mc_details_id="";
			var tool_id="";
			var lenght="";
			
			$(".rope_mc_details_id").each(function(){			rope_mc_details_id=rope_mc_details_id.concat('~').concat($(this).val());		});
			$(".tool_id").each(function(){						tool_id=tool_id.concat('~').concat($(this).val());		});
			$(".lenght").each(function(){						lenght=lenght.concat('~').concat($(this).val());		});
			<!---------------------------------------------------row-------------------------------->
			var status=$('#status').val();if(status==''){$('#status').focus();fun_message('warning','Warning','Select status','toast-bottom-right');return false;}
			var hide_status=$('#hide_status').val();if(hide_status==''){$('#hide_status').focus();fun_message('warning','Warning','Select Hide Status','toast-bottom-right');return false;}
			//-------------------------------save
			 $('#wait').show();
			 $('#machine_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Machine/save';?>", 
							  {
									id:id,
									dept:dept,
									name:name,
									capstan:capstan,
									max_speed:max_speed,
									min_base_size:min_base_size,
									max_base_size:max_base_size,
									min_finish_size:min_finish_size,
									max_finish_size:max_finish_size,
									status:status,
									hide_status:hide_status,
									
									details_id:details_id,
									goods:goods,
									hours:hours,
									qunt:qunt,
									eff:eff,
								  
									tool_id:tool_id,
									lenght:lenght,
									machine_pro_tool_target_id:rope_mc_details_id,
							}, 
							function(data, textStatus)
							{	
								
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									//showPage(url);
									$('#name').val('');
									$('#status').val();
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
								$('#machine_save').show();
								
							});//jquery
					});//loader
		});//save




		

	//-----------------------------------------------search
	$('#machine_search').click(function(){
		var dept=$('#dept').val();
		var name=$('#name').val();
		var status=$('#status').val();
		var hide_status=$('#hide_status').val();
		var search1=1;
		
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Machine/list';?>", 
				{
					dept:dept,
					name:name,
					status:status,
					hide_status:hide_status,
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



});//document close





</script>

   
 
       
 