<script>


$(document).ready(function(e) {
    $('#supplier_save').click(function(){
	 	
			var url=$('#url').val();
			var id=$('#id').val();
			var approved_no=$('#approved_no').val();
			var type=$('#type').val();if(type==''){$('#type').focus();fun_message('warning','Warning','Select Type','toast-bottom-right');return false;}
			var product_type=$('#product_type').val();if(product_type==''){$('#product_type').focus();fun_message('warning','Warning','Select product_type','toast-bottom-right');return false;}
			var name=$('#name').val();if(name==''){$('#name').focus();fun_message('warning','Warning','Enter Name','toast-bottom-right');return false;}
			var telphone=$('#telphone').val();if(telphone==''){;fun_message('warning','Warning','Enter Telephone No','toast-bottom-right');return false;}
			var address=$('#address').val();if(address==''){$('#address').focus();fun_message('warning','Warning','Enter Address','toast-bottom-right');return false;}
			var city=$('#city').val();if(city==''){$('#city').focus();fun_message('warning','Warning','Enter City','toast-bottom-right');return false;}
			var state=$('#state').val();if(state==''){$('#state').focus();fun_message('warning','Warning','Select State','toast-bottom-right');return false;}
			var country=$('#country').val();if(country==''){$('#country').focus();fun_message('warning','Warning','Enter Country','toast-bottom-right');return false;}
			var zip=$('#zip').val();
			var con_name1=$('#con_name1').val();
			var con_mob1=$('#con_mob1').val();
			var con_email1=$('#con_email1').val();
			var designation1=$('#designation1').val();
			var con_name2=$('#con_name2').val();
			var con_mob2=$('#con_mob2').val();
			var con_email2=$('#con_email2').val();
			var designation2=$('#designation2').val();
			var gst=$('#gst').val();if(gst==''){$('#gst').focus();fun_message('warning','Warning','Select Unit','toast-bottom-right');return false;}
			var payment_terms=$('#payment_terms').val();
			var del_place=$('#del_place').val();
			var mod_of_dis=$('#mod_of_dis').val();
			var active=$('#active').val();
			
			/*
			var id="";
			$(".id").each(function(){
				id=id.concat('~').concat($(this).val());
			});
			*/
			
			//-------------------------------save
			  $('#wait').show();
			  $('#supplier_save').hide();
			  setTimeout(function() {
					  jQuery.post("<?php echo base_url().'index.php/Supplier/save';?>", 
							  {
								  id:id,
								  type:type,
								  product_type:product_type,
								  approved_no:approved_no,
								  name:name,
								  telphone:telphone,
								  address:address,
								  city:city,
								  state:state,
								  country:country,
								  zip,zip,
								  con_name1:con_name1,
								  con_mob1:con_mob1,
								  con_email1:con_email1,
								  designation1:designation1,
								  con_name2:con_name2,
								  con_mob2:con_mob2,
								  con_email2:con_email2,
								  designation2:designation2,
								  gst:gst,
								  payment_terms:payment_terms,
								  del_place:del_place,
								  mod_of_dis:mod_of_dis,
								  active:active,
								  
							  }, 
							  function(data, textStatus)
							  {	
								  //alert(data);
								  <!--define on home page-->
								  if(data=='Save')
								  {
										fun_message('success',data,'Save Successfully','toast-bottom-right');
										$('#name').val('');
										$('#details').val('');
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
								  $('#supplier_save').show();
							  });
					});
			 //-------------------------------save
		});







	//-----------------------------------------------search
	$('#supplier_search').click(function(){
		var type=$('#type').val();
		var name=$('#name').val();
		var city=$('#city').val();
		

		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Supplier/list';?>", 
			{
				search1:1,
				type:type,
				name:name,
				city:city,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});//loader
	});//search close





});<!----document--->






</script>

   
 
       
 