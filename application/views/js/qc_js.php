<script>
	
$(function () {
	$( "#entry_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });

	$( "#invoice_date" ).datepicker({
       dateFormat: 'dd-mm-yy',
	   maxDate: 0,
    });

	$( "#search_date1" ).datepicker({ dateFormat: 'dd-mm-yy' });
	$( "#search_date2" ).datepicker({ dateFormat: 'dd-mm-yy' });
	
});


//from tc entry page
function fun_get_tc_details(size)
{
	var size2 = size.split(".");
	var sizeAlterDigit = size2[1];
	if(sizeAlterDigit.length != 3 ){
		$('#size').focus();fun_message('warning','Warning','Enter 3 digit size.','toast-bottom-right');return false;
	}
	
	$('#dis_span').html('');
	var product_type = $('#product_type').val();
	if(product_type==''){$('#product_type').focus();fun_message('warning','Warning','Select product_type','toast-bottom-right');return false;}

		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/get_tc_spec_data';?>", 
				{
					product_type:product_type,
					size:size,
				}, 
				
				function(data, textStatus)
				{	
					//alert(data);
					var out = data.split("~");
					$('#c_min').val(out[0]);$('#c_max').val(out[1]);
					$('#mn_min').val(out[2]);$('#mn_max').val(out[3]);
					$('#si_min').val(out[4]);$('#si_max').val(out[5]);
					$('#p_min').val(out[6]);$('#p_max').val(out[7]);
					$('#s_min').val(out[8]);$('#s_max').val(out[9]);
					//$('#heatno_1').val(out[10]);$('#heatno_2').val(out[11]);

					$('#coilnoId_1').val('Min');$('#coilnoId_2').val('Max');
					$('#diaId_1').val(out[10]);$('#diaId_2').val(out[11]);
					$('#utsId_1').val(out[12]);$('#utsId_2').val(out[13]);
					$('#tsId_1').val(out[14]);$('#tsId_2').val(out[15]);
					$('#raId_1').val(out[16]);$('#raId_2').val(out[17]);
					$('#zincId_1').val(out[18]);$('#zincId_2').val(out[19]);
					$('#bendId_1').val(out[20]);$('#bendId_2').val(out[21]);
					$('#sufId_1').val(out[22]);$('#sufId_2').val(out[23]);
					$('#remId_1').val(out[24]);$('#remId_2').val(out[25]);
					
					
					$('#dis_span').html('Chemical Composition & Physical & Mechanical Properties  : ' + out[26]);
			
					//$(goods_id).html(data);
					$('.loader').hide();
				});
		});
}



//TC 
function fun_check_c_obs(val)
{
	val = parseFloat(val);
	var minVal = parseFloat($('#c_min').val());
	var maxVal = parseFloat($('#c_max').val());
	if(val >= minVal && val <= maxVal){document.getElementById("c_obs").style.borderColor = "green";}else{document.getElementById("c_obs").style.borderColor = "red";}
}

function fun_check_mn_obs(val)
{
	val = parseFloat(val);
	var minVal = parseFloat($('#mn_min').val());
	var maxVal = parseFloat($('#mn_max').val());
	if(val >= minVal && val <= maxVal){document.getElementById("mn_obs").style.borderColor = "green";}else{document.getElementById("mn_obs").style.borderColor = "red";}
}

function fun_check_si_obs(val)
{
	val = parseFloat(val);
	var minVal = parseFloat($('#si_min').val());
	var maxVal = parseFloat($('#si_max').val());
	if(val >= minVal && val <= maxVal){document.getElementById("si_obs").style.borderColor = "green";}else{document.getElementById("si_obs").style.borderColor = "red";}
}

function fun_check_p_obs(val)
{
	val = parseFloat(val);
	var minVal = parseFloat($('#p_min').val());
	var maxVal = parseFloat($('#p_max').val());
	if(val >= minVal && val <= maxVal){document.getElementById("p_obs").style.borderColor = "green";}else{document.getElementById("p_obs").style.borderColor = "red";}
}

function fun_check_s_obs(val)
{
	val = parseFloat(val);
	var minVal = parseFloat($('#s_min').val());
	var maxVal = parseFloat($('#s_max').val());
	if(val >= minVal && val <= maxVal){document.getElementById("s_obs").style.borderColor = "green";}else{document.getElementById("s_obs").style.borderColor = "red";}
}



function fun_check_tc_dia(id)
{
	var id2 = id.split("_");
	var id_no = id2[1];
	//--------------------------------------------------cat
	var cat_id = "#diaId_".concat(id_no);
	var cat_val = parseFloat($(cat_id).val());
	
	
	var minVal = parseFloat($('#diaId_1').val());
	var maxVal = parseFloat($('#diaId_2').val());
	if(cat_val >= minVal && cat_val <= maxVal){$(cat_id).css("border-color", "green");}else{$(cat_id).css("border-color", "red");}
}


function fun_check_tc_uts(id)
{
	var id2 = id.split("_");
	var id_no = id2[1];
	//--------------------------------------------------cat
	var cat_id = "#utsId_".concat(id_no);
	var cat_val = parseFloat($(cat_id).val());
	
	var minVal = parseFloat($('#utsId_1').val());
	var maxVal = parseFloat($('#utsId_2').val());
	
	if(cat_val >= minVal && cat_val <= maxVal){$(cat_id).css("border-color", "green");}else{$(cat_id).css("border-color", "red");}
}












function fun_min_tole()
{
	var size = $('#size').val();
	var min_tole = $('#min_tole').val();

	//min size
	var min_size=(+size)-(+min_tole);
	var min_size=min_size.toFixed(3);
	$('#min_size').val(min_size);

	//max size
	$('#max_tole').val(min_tole);
	var max_size=(+size)+(+min_tole);
	var max_size=max_size.toFixed(3);
	$('#max_size').val(max_size);
}//function close

function fun_max_tole()
{
	var size = $('#size').val();
	var max_size = $('#max_tole').val();

	//max size
	var max_size=(+size)+(+max_size);
	var max_size=max_size.toFixed(3);
	$('#max_size').val(max_size);
}//function close

function fun_max_ovality()
{
	var size = $('#size').val();
	var ovality_max = $('#ovality_max').val();

	//max size
	var max_size=(+size)+(+ovality_max);
	var max_size=max_size.toFixed(3);
	$('#ovality_size_max').val(max_size);
}//function close




$(document).ready(function(e) {

	$('#spec1_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			
			var type1=$('#type1').val();
			var type2=$('#type2').val();
			var product_grade=$('#product_grade').val();
			var product_type=$('#product_type').val();
			
			var size=$('#size').val();
			var min_tole=$('#min_tole').val();
			var min_size=$('#min_size').val();
			var max_tole=$('#max_tole').val();
			var max_size=$('#max_size').val();
			var ovality_max=$('#ovality_max').val();
			var ovality_size_max=$('#ovality_size_max').val();
			
			var ts_min_ss1=$('#ts_min_ss1').val();
			var ts_max_ss1=$('#ts_max_ss1').val();
			var ts_min_ss2=$('#ts_min_ss2').val();
			var ts_max_ss2=$('#ts_max_ss2').val();
			var ts_min_ss3=$('#ts_min_ss3').val();
			var ts_max_ss3=$('#ts_max_ss3').val();
			var remarks=$('#remarks').val();
			
			//-----------------------------------------------------Validation 
			if(type1==''){$('#type1').focus();fun_message('warning','Warning','Select type1','toast-bottom-right');return false;}
			if(type2==''){$('#type2').focus();fun_message('warning','Warning','Select type2','toast-bottom-right');return false;}
			if(size==''){$('#size').focus();fun_message('warning','Warning','Enter size','toast-bottom-right');return false;}
			if(min_tole==''){$('#min_tole').focus();fun_message('warning','Warning','Enter min_tole','toast-bottom-right');return false;}
			if(min_size==''){$('#min_size').focus();fun_message('warning','Warning','Enter min_size','toast-bottom-right');return false;}
			if(max_tole==''){$('#max_tole').focus();fun_message('warning','Warning','Enter max_tole','toast-bottom-right');return false;}
			if(max_size==''){$('#max_size').focus();fun_message('warning','Warning','Enter max_size','toast-bottom-right');return false;}
			if(ovality_max==''){$('#ovality_max').focus();fun_message('warning','Warning','Enter ovality_max','toast-bottom-right');return false;}
			if(ovality_size_max==''){$('#ovality_size_max').focus();fun_message('warning','Warning','Enter ovality_size_max','toast-bottom-right');return false;}
			
			
			//-------------------------------save
			$('#wait').show();
			$('#spec1_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/spec1_save';?>", 
							  	{
									id:id,
									type1:type1,
									type2:type2,
									product_grade:product_grade,
									product_type:product_type,
									size:size,
									min_tole:min_tole,
									min_size:min_size,
									max_tole:max_tole,
									max_size:max_size,
									ovality_max:ovality_max,
									ovality_size_max:ovality_size_max,
									
									ts_min_ss1:ts_min_ss1,
									ts_max_ss1:ts_max_ss1,
									ts_min_ss2:ts_min_ss2,
									ts_max_ss2:ts_max_ss2,
									ts_min_ss3:ts_min_ss3,
									ts_max_ss3:ts_max_ss3,
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
								$('#spec1_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save



		$('#furnace_save').click(function() {
			let url = $('#url').val();
			let entry_date = $('#entry_date').val();
			let actual_size = $('#actual_size').val();
			let product_grade = $('#product_grade').val();
			let lotno = $('#lotno').val();
			

			// Create arrays for all table fields
			let rowID = [];
			let newCoilNo = [];
			let lotNo = [];
			let baseSize = [];
			let finishSize = [];
			let BreaklingLoad = [];
			let uts = [];
			let zinc = [];
			let raPer = [];
			let tempInC = [];
			let speed = [];
			let remarks = [];

			// Loop through each row and collect data
			$('.rowID').each(function(i) {rowID.push($(this).val());});
			$('.newCoilNo').each(function(i) {newCoilNo.push($(this).val());});
			$('.lotNo').each(function(i) {
				lotNo.push($(this).val());
			});
			$('.baseSize').each(function(i) {
				baseSize.push($(this).val());
			});
			$('.finishSize').each(function(i) {
				finishSize.push($(this).val());
			});
			$('.BreaklingLoad').each(function(i) {
				BreaklingLoad.push($(this).val());
			});
			$('.uts').each(function(i) {
				uts.push($(this).val());
			});
			$('.zinc').each(function(i) {
				zinc.push($(this).val());
			});
			$('.raPer').each(function(i) {
				raPer.push($(this).val());
			});
			$('.tempInC').each(function(i) {
				tempInC.push($(this).val());
			});
			$('.speed').each(function(i) {
				speed.push($(this).val());
			});
			$('.remarks').each(function(i) {
				remarks.push($(this).val());
			});

			// Show spinner
			$('#wait').show();
			$('#furnace_save').hide();

			// AJAX POST
			setTimeout(function() {
				$.post("<?php echo base_url().'index.php/Qc/furnace_save';?>", {
					entry_date: entry_date,
					actual_size:actual_size,
					product_grade:product_grade,
					lotno:lotno,
					rowID:rowID,
					newCoilNo: newCoilNo,
					lotNo: lotNo,
					baseSize: baseSize,
					finishSize: finishSize,
					BreaklingLoad: BreaklingLoad,
					uts: uts,
					zinc: zinc,
					raPer: raPer,
					tempInC: tempInC,
					speed: speed,
					remarks: remarks
				}, function(data, textStatus) {
					if (data == 'Save') {
						fun_message('success', data, 'Save Successfully', 'toast-bottom-right');
						showPage(url);
					}else {
						fun_message('error', 'Error', data, 'toast-bottom-right');
					}
					$('#wait').hide();
					$('#furnace_save').show();
				});
			});
		});





		$('#test1_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			let for_patt=$('#for_patt').val();
			//let lotno=$('#lotno').val();
			
			<!---------------------------------------------------row-------------------------------->
			var qcLogDetailsid="";
			var coilno="";
			var finishsize="";
			var breakingload="";
			var uts="";
			var torsiontest="";
			var bendtest="";
			var raper="";
			var scratchbrigitness="";
			var remarks="";
			var baseCoilId="";
			var coilweight="";
			
			$(".qcLogDetailsid").each(function(){			qcLogDetailsid=qcLogDetailsid.concat('~').concat($(this).val());		});
			$(".coilno").each(function(){			coilno=coilno.concat('~').concat($(this).val());		});
			$(".finishsize").each(function(){		finishsize=finishsize.concat('~').concat($(this).val());						});
			$(".breakingload").each(function(){		breakingload=breakingload.concat('~').concat($(this).val());						});
			$(".uts").each(function(){				uts=uts.concat('~').concat($(this).val());						});
			$(".torsiontest").each(function(){		torsiontest=torsiontest.concat('~').concat($(this).val());						});
			$(".bendtest").each(function(){			bendtest=bendtest.concat('~').concat($(this).val());						});
			$(".raper").each(function(){			raper=raper.concat('~').concat($(this).val());						});
			$(".scratchbrigitness").each(function(){	scratchbrigitness=scratchbrigitness.concat('~').concat($(this).val());						});
			$(".remarks").each(function(){			remarks=remarks.concat('~').concat($(this).val());						});
			$(".baseCoilId").each(function(){			baseCoilId=baseCoilId.concat('~').concat($(this).val());						});
			$(".coilweight").each(function(){			coilweight=coilweight.concat('~').concat($(this).val());						});


			//-------------------------------save
			$('#wait').show();
			$('#test1_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/test1_save';?>", 
							  	{
									id:id,
									for_patt:for_patt,
									// lotno:lotno,
									qcLogDetailsid:qcLogDetailsid,
									coilno:coilno,
									finishsize:finishsize,
									breakingload:breakingload,
									uts:uts,
									torsiontest:torsiontest,
									bendtest:bendtest,
									raper:raper,
									scratchbrigitness:scratchbrigitness,
									remarks:remarks,
									baseCoilId:baseCoilId,
									coilweight:coilweight,
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
								$('#test1_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save




		
	//-----------------------------------------------search
	$('#spec1_search').click(function(){
		var type1=$('#type1').val();
		var type2=$('#type2').val();
		var product_grade=$('#product_grade').val();
		var size=$('#size').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Qc/list_spec1';?>", 
				{
					type1:type1,
					type2:type2,
					product_grade:product_grade,
					size:size,
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
	$('#furnace_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var actual_size=$('#actual_size').val();
		var product_grade=$('#product_grade').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Qc/furnace_list';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					actual_size:actual_size,
					product_grade:product_grade,
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
	$('#pickling_production_search').click(function(){
		let search_date1=$('#search_date1').val();
		let search_date2=$('#search_date2').val();
		let actual_size=$('#actual_size').val();
		let product_grade=$('#product_grade').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Qc/pickling_production_list';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					actual_size:actual_size,
					product_grade:product_grade,
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
	$('#test1_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var shift=$('#shift').val();
		var size=$('#size').val();
		var product_grade=$('#product_grade').val();
		var dept=$('#dept').val();
		var mc_no=$('#mc_no').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Qc/list_test1';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					shift:shift,
					size:size,
					product_grade:product_grade,
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



	//------------------------------------------pickling
	$('#pickling_test_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			
			
			
			
			var entry_date=$('#entry_date').val(); if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select entry_date','toast-bottom-right');return false;}
			var shift=$('#shift').val(); if(shift==''){$('#shift').focus();fun_message('warning','Warning','Select Time','toast-bottom-right');return false;}
			var qc_person=$('#qc_person').val();if(qc_person==''){$('#qc_person').focus();fun_message('warning','Warning','Enter qc_person','toast-bottom-right');return false;}
			var tank1_connc=$('#tank1_connc').val();
			
			var tank1_fe=$('#tank1_fe').val();
			var tank2_connc=$('#tank2_connc').val();
			var tank2_fe=$('#tank2_fe').val();
			var tank3_connc=$('#tank3_connc').val();
			var tank3_fe=$('#tank3_fe').val();
			
			var gl_tank1_connc=$('#gl_tank1_connc').val();
			var gl_tank1_fe=$('#gl_tank1_fe').val();
			var gl_tank2_connc=$('#gl_tank2_connc').val();
			var gl_tank2_fe=$('#gl_tank2_fe').val();
			
			var flux_gravity=$('#flux_gravity').val();
			var flux_temp=$('#flux_temp').val();
			var water_ph=$('#water_ph').val();

			var phos_connc=$('#phos_connc').val();
			var phos_fe=$('#phos_fe').val();
			var phos_fa=$('#phos_fa').val();
			var phos_acc=$('#phos_acc').val();
			var phos_cl=$('#phos_cl').val();
			var phos_temp=$('#phos_temp').val();
			var borex_conc=$('#borex_conc').val();
			var borex_temp=$('#borex_temp').val();
			
			
			
			//-------------------------------save
			$('#wait').show();
			$('#pickling_test_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/pickling_test_save';?>", 
							  	{
									id:id,
									entry_date:entry_date,
									shift:shift,
									
									qc_person:qc_person,
									tank1_connc:tank1_connc,
									tank1_fe:tank1_fe,
									
									tank2_connc:tank2_connc,
									tank2_fe:tank2_fe,
									tank3_connc:tank3_connc,
									
									tank3_fe:tank3_fe,
									gl_tank1_connc:gl_tank1_connc,
									gl_tank1_fe:gl_tank1_fe,
									
									gl_tank2_connc:gl_tank2_connc,
									gl_tank2_fe:gl_tank2_fe,
									flux_gravity:flux_gravity,
									
									flux_temp:flux_temp,
									water_ph:water_ph,
									phos_connc:phos_connc,
									
									phos_fe:phos_fe,
									phos_fa:phos_fa,
									phos_acc:phos_acc,
									
									phos_cl:phos_cl,
									phos_temp:phos_temp,
									borex_conc:borex_conc,
									borex_temp:borex_temp,
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
								$('#pickling_test_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save






	$('#log_test_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			
			
			var entry_date=$('#entry_date').val();
			var shift=$('#shift').val();
			var base_size=$('#base_size').val();
			var dept=$('#dept').val();
			var mc_no=$('#mc_no').val();
			var product_grade=$('#product_grade').val();
			var batch_no=$('#batch_no').val();
			var product_type=$('#product_type').val();
			var finish_size=$('#finish_size').val();
			var coil_dia=$('#coil_dia').val();
			var coil_dia_from=$('#coil_dia_from').val();
			var coil_dia_to=$('#coil_dia_to').val();
			var total_coils=$('#total_coils').val();
			var total_pass_coils=$('#total_pass_coils').val();
			var total_nc_coils=$('#total_nc_coils').val();
			var operator1=$('#operator1').val();
			var customer_id=$('#customer_id').val();
			var nc_reason=$('#nc_reason').val();
			var diversion=$('#diversion').val();
			
			//-----------------------------------------------------Validation 
			if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select entry_date','toast-bottom-right');return false;}
			if(shift==''){$('#shift').focus();fun_message('warning','Warning','Select shift','toast-bottom-right');return false;}
			if(base_size==''){$('#base_size').focus();fun_message('warning','Warning','Select base_size','toast-bottom-right');return false;}
			if(mc_no==''){$('#mc_no').focus();fun_message('warning','Warning','Select mc_no','toast-bottom-right');return false;}
			if(product_grade==''){$('#product_grade').focus();fun_message('warning','Warning','Enter product_grade','toast-bottom-right');return false;}
			if(finish_size==''){$('#finish_size').focus();fun_message('warning','Warning','Enter finish_size','toast-bottom-right');return false;}
			
			
			//-------------------------------save
			$('#wait').show();
			$('#log_test_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/log_test_save';?>", 
							  	{
									id:id,
									
									entry_date:entry_date,
									shift:shift,
									base_size:base_size,
									dept:dept,
									mc_no:mc_no,

									product_grade:product_grade,
									batch_no:batch_no,
									product_type:product_type,
									finish_size:finish_size,

									coil_dia:coil_dia,
									coil_dia_from:coil_dia_from,
									coil_dia_to:coil_dia_to,
									total_coils:total_coils,

									total_pass_coils:total_pass_coils,
									total_nc_coils:total_nc_coils,
									operator1:operator1,
									customer_id:customer_id,
									nc_reason:nc_reason,
									diversion:diversion,
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
								$('#log_test_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save




		//-----------------------------------------------search
		$('#log_test_search').click(function(){
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var shift=$('#shift').val();
			var finish_size=$('#finish_size').val();
			var product_grade=$('#product_grade').val();
			var dept=$('#dept').val();
			var mc_no=$('#mc_no').val();
			var search1=1;
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/list_log_test';?>", 
					{
						search_date1:search_date1,
						search_date2:search_date2,
						shift:shift,
						finish_size:finish_size,
						product_grade:product_grade,
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


		//-----------------------------------------------search
		$('#pickling_test_search').click(function(){
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var shift=$('#shift').val();
			var show_type=$('#show_type').val();
			
			var search1=1;
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/list_pickling_test';?>", 
					{
						search_date1:search_date1,
						search_date2:search_date2,
						shift:shift,
						show_type:show_type,
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






		//TC
		$('#tc_save').click(function(){
	 		var url=$('#url').val();
			var tc_id=$('#tc_id').val();

			var customer_id=$('#customer_id').val();
			var entry_date=$('#entry_date').val();
			var invoice_no=$('#invoice_no').val();
			var certificate_no=$('#certificate_no').val();
			var no_coil=$('#no_coil').val();
			var size=$('#size').val(); 
			var product_name=$('#product_name').val();
			var product_type=$('#product_type').val();
			var weight=$('#weight').val();
			var invoice_date=$('#invoice_date').val();

			var c_min=$('#c_min').val();
			var mn_min=$('#mn_min').val();
			var si_min=$('#si_min').val();
			var p_min=$('#p_min').val();
			var s_min=$('#s_min').val();
			var heatno_1=$('#heatno_1').val();

			var c_max=$('#c_max').val();
			var mn_max=$('#mn_max').val();
			var si_max=$('#si_max').val();
			var p_max=$('#p_max').val();
			var s_max=$('#s_max').val();
			var heatno_2=$('#heatno_2').val();

			var c_obs=$('#c_obs').val();
			var mn_obs=$('#mn_obs').val();
			var si_obs=$('#si_obs').val();
			var p_obs=$('#p_obs').val();
			var s_obs=$('#s_obs').val();
			var heatno_3=$('#heatno_3').val();
			
			//-----------------------------------------------------Validation 
			if(customer_id==''){$('#customer_id').focus();fun_message('warning','Warning','Select Customer','toast-bottom-right');return false;}
			if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select entry_date','toast-bottom-right');return false;}
			if(invoice_no==''){$('#invoice_no').focus();fun_message('warning','Warning','Enter invoice_no','toast-bottom-right');return false;}
			if(certificate_no==''){$('#certificate_no').focus();fun_message('warning','Warning','Enter certificate_no','toast-bottom-right');return false;}
			if(no_coil==''){$('#no_coil').focus();fun_message('warning','Warning','Enter no_coil','toast-bottom-right');return false;}
			if(product_type==''){$('#product_type').focus();fun_message('warning','Warning','Select product_type','toast-bottom-right');return false;}
			if(product_name==''){$('#product_name').focus();fun_message('warning','Warning','Enter product_name','toast-bottom-right');return false;}
			if(size==''){$('#size').focus();fun_message('warning','Warning','Enter size','toast-bottom-right');return false;}
			if(weight==''){$('#weight').focus();fun_message('warning','Warning','Enter weight','toast-bottom-right');return false;}
			if(invoice_date==''){$('#invoice_date').focus();fun_message('warning','Warning','Enter invoice_date','toast-bottom-right');return false;}
			

		
			
			<!---------------------------------------------------row-------------------------------->
			var coilno="";
			var diameter="";
			var uts="";
			var torsiontest="";
			var raper="";
			var zinc="";
			var bend="";
			var surface="";
			var remarks="";
			
			$(".coilno").each(function(){			coilno=coilno.concat('~').concat($(this).val());		});
			$(".diameter").each(function(){		diameter=diameter.concat('~').concat($(this).val());						});
			$(".uts").each(function(){				uts=uts.concat('~').concat($(this).val());	
			$(".torsiontest").each(function(){		torsiontest=torsiontest.concat('~').concat($(this).val());						});					});
			$(".raper").each(function(){			raper=raper.concat('~').concat($(this).val());						});
			$(".zinc").each(function(){		zinc=zinc.concat('~').concat($(this).val());						});
			$(".bend").each(function(){			bend=bend.concat('~').concat($(this).val());						});
			$(".surface").each(function(){	surface=surface.concat('~').concat($(this).val());						});
			$(".remarks").each(function(){			remarks=remarks.concat('~').concat($(this).val());						});

			
			//-------------------------------save
			$('#wait').show();
			$('#tc_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/tc_save';?>", 
							  	{
									tc_id:tc_id,
									customer_id:customer_id,
									entry_date:entry_date,
									invoice_no:invoice_no,
									certificate_no:certificate_no,
									no_coil:no_coil,
									size:size,
									weight:weight,
									product_type:product_type,
									product_name:product_name,
									invoice_date:invoice_date,

									c_min:c_min,
									mn_min:mn_min,
									si_min:si_min,
									p_min:p_min,
									s_min:s_min,
									heatno_1:heatno_1,

									c_max:c_max,
									mn_max:mn_max,
									si_max:si_max,
									p_max:p_max,
									s_max:s_max,
									heatno_2:heatno_2,

									c_obs:c_obs,
									mn_obs:mn_obs,
									si_obs:si_obs,
									p_obs:p_obs,
									s_obs:s_obs,
									heatno_3:heatno_3,

									coilno:coilno,
									diameter:diameter,
									uts:uts,
									torsiontest:torsiontest,
									raper:raper,
									zinc:zinc,
									bend:bend,
									surface:surface,
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
								$('#tc_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save


		
		
		//-----------------------------------------------search
		$('#tc_search').click(function(){
			var search_date1=$('#search_date1').val();
			var search_date2=$('#search_date2').val();
			var customer_id=$('#customer_id').val();
			var product_type=$('#product_type').val();
			var product_name=$('#product_name').val();
			var invoice_no=$('#invoice_no').val();
			var certificate_no=$('#certificate_no').val();
			var size=$('#size').val();
			var search1=1;
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/list_tc';?>", 
					{
						search_date1:search_date1,
						search_date2:search_date2,
						customer_id:customer_id,
						product_type:product_type,
						product_name:product_name,
						invoice_no:invoice_no,
						certificate_no:certificate_no,
						size:size,
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





		



		//TC
		$('#in_row_save').click(function(){
	 		var url=$('#url').val();
			var invoice_deatils_id=$('#invoice_deatils_id').val();

			
			var entry_date=$('#entry_date').val();
			var product_grade=$('#product_grade').val();
			var product_type=$('#product_type').val();
			
			var finish_size=$('#finish_size').val();
			var total_coils=$('#total_coils').val(); 
			var min_bl=$('#min_bl').val();
			var max_bl=$('#max_bl').val();
			
			
			<!---------------------------------------------------row-------------------------------->  
			var qcheatId="";
			var heatnolist="";
			var cval="";
			var mnval="";
			var pval="";
			var sval="";
			var sival="";
			var totalal="";
			var crval="";
			var coval="";
			var nival="";
			var moval="";
			var ceqval="";
			var n2val="";
			var isgrade="";
			var equivalent="";
			
			var ysval="";
			var utsval="";
			var elval="";
			var raval="";

			$(".qcheatId").each(function(){			qcheatId=qcheatId.concat('~').concat($(this).val());		});
			$(".heatnolist").each(function(){			heatnolist=heatnolist.concat('~').concat($(this).val());		});
			$(".cval").each(function(){			cval=cval.concat('~').concat($(this).val());		});
			$(".mnval").each(function(){			mnval=mnval.concat('~').concat($(this).val());		});
			$(".pval").each(function(){			pval=pval.concat('~').concat($(this).val());		});
			$(".sval").each(function(){			sval=sval.concat('~').concat($(this).val());		});
			$(".sival").each(function(){			sival=sival.concat('~').concat($(this).val());		});
			$(".totalal").each(function(){			totalal=totalal.concat('~').concat($(this).val());		});
			$(".crval").each(function(){			crval=crval.concat('~').concat($(this).val());		});
			$(".coval").each(function(){			coval=coval.concat('~').concat($(this).val());		});
			$(".nival").each(function(){			nival=nival.concat('~').concat($(this).val());		});
			$(".moval").each(function(){			moval=moval.concat('~').concat($(this).val());		});
			$(".ceqval").each(function(){			ceqval=ceqval.concat('~').concat($(this).val());		});
			$(".n2val").each(function(){			n2val=n2val.concat('~').concat($(this).val());		});
			$(".isgrade").each(function(){			isgrade=isgrade.concat('~').concat($(this).val());		});
			$(".equivalent").each(function(){			equivalent=equivalent.concat('~').concat($(this).val());		});

			$(".ysval").each(function(){			ysval=ysval.concat('~').concat($(this).val());		});
			$(".utsval").each(function(){			utsval=utsval.concat('~').concat($(this).val());		});
			$(".elval").each(function(){			elval=elval.concat('~').concat($(this).val());		});
			$(".raval").each(function(){			raval=raval.concat('~').concat($(this).val());		});
			
			

			var qcTestId="";
			var heatno="";
			var coilno="";
			var finishsize="";
			var breakingload="";
			var uts="";
			var torsiontest="";
			var bendtest="";
			var raper="";
			var rdarea="";
			var remarks="";

			$(".qcTestId").each(function(){			qcTestId=qcTestId.concat('~').concat($(this).val());		});
			$(".heatno").each(function(){			heatno=heatno.concat('~').concat($(this).val());		});
			$(".coilno").each(function(){			coilno=coilno.concat('~').concat($(this).val());		});
			$(".finishsize").each(function(){		finishsize=finishsize.concat('~').concat($(this).val());						});
			$(".breakingload").each(function(){		breakingload=breakingload.concat('~').concat($(this).val());						});
			$(".uts").each(function(){				uts=uts.concat('~').concat($(this).val());						});
			$(".torsiontest").each(function(){		torsiontest=torsiontest.concat('~').concat($(this).val());						});
			$(".bendtest").each(function(){			bendtest=bendtest.concat('~').concat($(this).val());						});
			$(".raper").each(function(){			raper=raper.concat('~').concat($(this).val());						});
			$(".rdarea").each(function(){	rdarea=rdarea.concat('~').concat($(this).val());						});
			$(".remarks").each(function(){			remarks=remarks.concat('~').concat($(this).val());						});


			//-------------------------------save
			$('#wait').show();
			$('#in_row_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Qc/in_row_save';?>", 
							  	{
									invoice_deatils_id:invoice_deatils_id,
									entry_date:entry_date,
									product_grade:product_grade,

									product_type:product_type,
									finish_size:finish_size,
									total_coils:total_coils,
									min_bl:min_bl,
									max_bl:max_bl,
									
									qcheatId:qcheatId,
									heatnolist:heatnolist,
									cval:cval,
									mnval:mnval,
									pval:pval,
									sval:sval,
									sival:sival,
									totalal:totalal,
									crval:crval,
									coval:coval,
									nival:nival,
									moval:moval,
									ceqval:ceqval,
									n2val:n2val,
									isgrade:isgrade,
									equivalent:equivalent,
									ysval:ysval,
									utsval:utsval,
									elval:elval,
									raval:raval,
									

									qcTestId:qcTestId,
									coilno:coilno,
									heatno:heatno,
									finishsize:finishsize,
									breakingload:breakingload,
									uts:uts,
									torsiontest:torsiontest,
									bendtest:bendtest,
									raper:raper,
									rdarea:rdarea,
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
								$('#in_row_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save




	
		
		//pickling coll
		$('#pickling_coil_test_save').click(function(){
	 		var url=$('#url').val();
			var entry_date=$('#entry_date').val(); if(entry_date==''){$('#entry_date').focus();fun_message('warning','Warning','Select entry_date','toast-bottom-right');return false;}

			//var chk_arr =  document.getElementsByName("coilId[]");
			var allcheckBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilId]"), e => e.value);
			var checkedBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilId]:checked"), e => e.value);
			var usedcheckedBox = Array.from(document.querySelectorAll("input[type=checkbox][name=coilUsedId]:checked"), e => e.value);
			var search1='1';
			
			//-------------------------------save
			$('#wait').show();
			$('#in_row_save').hide();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/pickling_coil_test_save';?>", 
					{
						entry_date:entry_date,
						allcheckBox:allcheckBox,
						checkedBox:checkedBox,
						usedcheckedBox:usedcheckedBox,
						search1:search1,
					}, 
					function(data, textStatus)
					{	
						if(data=='Save')
						{
							fun_message('success',data,'Save Successfully','toast-bottom-right');
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
						$('#in_row_save').show();
						
						
					});
				});
			
			
			
		});//-------------------------------save


		//pickling coll
		$('#pickling_coil_test_save2').click(function () {
			let url = $('#url').val(); 
			let formData = {
				id: $('#id').val(),
				old_coil_test_d: $('#old_coil_test_d').val(),
				entry_date: $('#entry_date').val(),
				lotno: $('#lotno').val(),
				size: $('#size').val(),
				grade: $('#grade').val(),
				heat: $('#heat').val(),
				rod_id: $('#rod_id').val(),
				other_details: $('#other_details').val(),
				rank: $('#rank').val(),
				heater_on: $('#heater_on').val(),
				washing_time1: $('#washing_time1').val(),
				hcl_in: $('#hcl_in').val(),
				hcl_out: $('#hcl_out').val(),
				hcl_total_time: $('#hcl_total_time').val(),
				washing_time2: $('#washing_time2').val(),
				phos_in: $('#phos_in').val(),
				phos_out: $('#phos_out').val(),
				phos_total_time: $('#phos_total_time').val(),
				phos_in_temp: $('#phos_in_temp').val(),
				phos_out_temp: $('#phos_out_temp').val(),
				phos_temp_diff: $('#phos_temp_diff').val(),
				borax_in: $('#borax_in').val(),
				borax_out: $('#borax_out').val(),
				borax_total_time: $('#borax_total_time').val(),
				borax_in_temp: $('#borax_in_temp').val(),
				borax_out_temp: $('#borax_out_temp').val(),
				borax_temp_diff: $('#borax_temp_diff').val(),
				wash_to_borex_out_time: $('#wash_to_borex_out_time').val(),
				sup_id: $('#sup_id').val(),
				op_id: $('#op_id').val(),
				hel1_id: $('#hel1_id').val(),
				hel2_id: $('#hel2_id').val(),
				heater_off: $('#heater_off').val(),  // NEW ID for heater off
				remarks: $('#remarks').val(),
				search1: '1'
			};

			$('#wait').show();
			$('#pickling_coil_test_save2').hide();

			$.post("<?php echo base_url().'index.php/Qc/pickling_coil_test_save2';?>", formData, function (data) {
				if (data == 'Save') {
					fun_message('success', data, 'Save Successfully', 'toast-bottom-right');
				} else if (data == 'Update') {
					fun_message('success', data, 'Updated Successfully', 'toast-bottom-right');
					showPage(url);
				} else {
					fun_message('error', 'Error', data, 'toast-bottom-right');
				}
				$('#wait').hide();
				$('#pickling_coil_test_save2').show();
			});
		});






		
		//-----------------------------------------------search 2
		$('#track_finish_coil').click(function(){
			
			let fsize=$('#fsize').val();if(fsize==''){$('#fsize').focus();fun_message('warning','Warning','Enter Size','toast-bottom-right');return false;}
			let link=$('#link').val();
			let type=$('#type').val();
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Qc/get_track_from_finish_to_base_rod';?>", 
				{
					fsize:fsize,
					link:link,
					type:type,
					search_date1:search_date1,
					search_date2:search_date2,
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







});<!---------document--->






</script>

   
 
       
 