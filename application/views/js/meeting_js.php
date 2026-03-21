
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
	
	
	
	
	
});







$(document).ready(function(e) {
	
	
		$('#mom_save').click(function(){
			
				var url=$('#url').val();
				var id=$('#id').val();
				var entry_date=$('#entry_date').val();if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select Entry Date','toast-bottom-right');return false;}
				var chair_person=$('#chair_person').val();if(chair_person==''){$('#chair_person').focus();fun_message('warning','Warning','Enter Chair Person','toast-bottom-right');return false;}
				var participants=$('#participants').val();if(participants==''){$('#participants').focus();fun_message('warning','Warning','Enter participants','toast-bottom-right');return false;}
				var review_point=$('#review_point').val();if(review_point==''){$('#review_point').focus();fun_message('warning','Warning','Enter review_point','toast-bottom-right');return false;}
				var current_status=$('#current_status').val();if(current_status==''){$('#current_status').focus();fun_message('warning','Warning','Select','toast-bottom-right');return false;}
				var action_taken=$('#action_taken').val();if(action_taken==''){$('#action_taken').focus();fun_message('warning','Warning','Enter current_status','toast-bottom-right');return false;}
				var resp=$('#resp').val();if(resp==''){$('#resp').focus();fun_message('warning','Warning','Enter Resp','toast-bottom-right');return false;}
				var target_date=$('#target_date').val();if(target_date==''){$('#target_date').focus();fun_message('warning','Warning','Select Target Date','toast-bottom-right');return false;}
				var comp_date=$('#comp_date').val();
				var active=$('#active').val();
				var md_review=$('#md_review').val();
				//-------------------------------save
				$('#wait').show();
				$('#mom_save').hide();
				setTimeout(function() {
						jQuery.post("<?php echo base_url().'index.php/Meeting/save';?>", 
							{
								id:id,
								entry_date:entry_date,
								chair_person:chair_person,
								participants:participants,
								
								review_point:review_point,
								current_status:current_status,
								action_taken:action_taken,
								resp:resp,
								target_date:target_date,
								comp_date:comp_date,
								active:active,
								md_review:md_review,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									//showPage(url);
									$('#review_point').val('');
									$('#current_status').val('');
									$('#action_taken').val('');
									$('#resp').val('');
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
								$('#mom_save').show();
							});//jquery
				});//loader
		});//save





		//-----------------------------------------------search
		$('#mom_search').click(function(){
				var search_date1=$('#search_date1').val();
				var search_date2=$('#search_date2').val();
				var status=$('#status').val();
				var search1=1;
				//-------------------------------getting gst type
				$('.loader').show();
				setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Meeting/list_mom';?>", 
					{
						search_date1:search_date1,
						search_date2:search_date2,
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













		





});





</script>

   
 
       
 