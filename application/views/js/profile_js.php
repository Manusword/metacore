<script>



$(document).ready(function(e) {
    $('#save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			var old_pass=$('#old_pass').val();if(old_pass==''){$('#old_pass').focus();fun_message('warning','Warning','Enter Old Password','toast-bottom-right');return false;}
			var new_pass=$('#new_pass').val();if(new_pass==''){$('#new_pass').focus();fun_message('warning','Warning','Enter New Password','toast-bottom-right');return false;}
			var re_pass=$('#re_pass').val();if(re_pass==''){$('#re_pass').focus();fun_message('warning','Warning','Re-Enter Password','toast-bottom-right');return false;}
			
			if(new_pass.length < 6)
			{
				$('#new_pass').focus();fun_message('warning','Warning','Password should min 6 digit OR more.','toast-bottom-right');return false;
			}
			
			
			if(new_pass!=re_pass)
			{
				$('#re_pass').focus();fun_message('warning','Warning','Re-Enter Password Not Match','toast-bottom-right');return false;
			}
			
			//-------------------------------save
			  $('#wait').show();
			  $('#save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Welcome/password_update_save';?>", 
							  {
								  id:id,
								  new_pass:new_pass,
								  old_pass:old_pass,
								  re_pass:re_pass,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Password Change Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}

								$('#wait').hide();
								$('#save').show();
							});
					});
		});
		//-------------------------------save














});





</script>

   
 
       
 