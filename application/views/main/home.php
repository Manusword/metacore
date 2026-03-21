

	<div class="main-content-wrap d-flex flex-column"  id="page_show">
        <?php //$this->load->view('main/blank');?>
	</div>

	
    <?php $this->load->view('main/link_bottom'); ?>
 









<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

 
<script>



	//---------------------------------------------------------Creating url
	$(document).ready(function(e) {
		
		var pageURL = $(location). attr("href");
		var id2 = pageURL.split("?");
		var url2=id2[1];
		//alert(pageURL);
		if(url2 === undefined)
		{
			showPage('<?php echo $go_to_dashbord;?>');//from Welcome->home()
		}
		else
		{
			showPage(url2);
		}
		
	});//document



	//----------------------------------------------------Page loder function--------------------------------
	function showPage(name)
	{
			var base="<?php echo base_url().'index.php/Welcome/home?';?>";
			var url=base.concat(name);
			
			//-------------------------------json loder
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Page/pagename';?>", 
							{
								name:name,
								url:url
							}, 
							
							function(data, textStatus)
							{	
								//alert(data);
								window.history.pushState('page2', 'Title', url);
								$('#page_show').html(data);
								$('.loader').hide();
							});
				});
	}//function close


	



	//----------------------------------------------------------------------notification
	function fun_message_popup(type,title,text,confirmButtonClass,msg)
	{	
		
		swal({
				type: type,
				title: title,
				text: text,
				html: msg,
				buttonsStyling: false,
				confirmButtonClass: confirmButtonClass
		});
		/*
		var timerInterval;
		swal({
			type: type,
			title: title,
			text: text,
			html: 'I will close in <strong>2</strong> seconds.',
			buttonsStyling: false,
			confirmButtonClass: confirmButtonClass,
			timer: 2000
		}).then(function (result) {
		if (result.dismiss === swal.DismissReason.timer) {
			console.log('I was closed by the timer');
		}
		});
		*/
		
	}//function close

	
	function fun_message(type,data,msg,position)
	{			
		if(type == 'success')
		{
			toastr.success(msg,data,
			{
				showMethod: "fadeIn",
				hideMethod: "fadeOut",
				positionClass: position,
				timeOut: 2e3
			});
		}
		else if(type == 'error')
		{
			toastr.error(msg,data,
			{
				showMethod: "fadeIn",
				hideMethod: "fadeOut",
				positionClass: position,
				timeOut: 2e3
			});
		}
		else if(type == 'warning')
		{
			toastr.warning(msg,data,
			{
				showMethod: "fadeIn",
				hideMethod: "fadeOut",
				positionClass: position,
				timeOut: 2e3
			});
		}//type
		
		
	}//function close



	//------------------------------op_search Auto Complate
	function op_search(id)
	{
		var cat_id = "#".concat(id);
		var cat_val=$(cat_id).val();
			
			$(cat_id).autocomplete({

				open: function(){
					setTimeout(function () {
						$('.ui-autocomplete').css('z-index', 99999999999999);
					}, 0);
				},
			
				source: '<?php echo base_url().'index.php';?>/Hr/op_autocomplate_search/',
				autoFocus:true,
				select: function(event, ui) {
						event.preventDefault();
						//$('#name2').val(ui.item.label);
						
						$(cat_id).val(ui.item.value);

					},
			});
	}//function close


	//-----------------------------Product check
	function fun_check_product(product_name)
	{
		var product_cat=$('#product_cat').val();
		jQuery.post("<?php echo base_url().'index.php/Product/fun_check_product';?>", 
		{
			name:product_name,
			category_id:product_cat,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			//$('#product_dis_id').html(data);
			if(data == 'TRUE'){fun_message('error','"'+product_name+'"','Product Already Exits.','toast-bottom-right');}
		});
	}//function close


	//-------------------------get customer product rate in schedule
	function get_customer_product_rate(id)
	{
		var id2 = id.split("_");
		var id_no=id2[1];

		var goods_id = "#goods_".concat(id_no);
		var goods_val=$(goods_id).val();
		var customer_id=$('#customer').val();
		var rate_id = "#rate_".concat(id_no);
		
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Customer/get_customer_product_rate';?>", 
			{
				customer_id:customer_id,
				product_id:goods_val,
			}, 
			function(data, textStatus)
			{	
				//alert(data);
				$(rate_id).val(data);
				$('.loader').hide();
			});
		});
	}//function close


	//-----------------------Get all Customer Product for eg. schedule entry 
	function get_all_product_of_this_customer(customer_id)
	{
		$('.loader').show();
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Customer/get_all_product_of_this_customer';?>", 
				{
					customer_id:customer_id,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('.goods').html(data);
					$('.loader').hide();
				});
			});
	}//function close



	//-----------------------------Product Type to Search 
	function fun_get_product(id,source_id,dest_id,msg)
	{
		var id2 = id.split("_");
		var id_no=id2[1];
		var source_id2 = '#'+source_id.concat(id_no);
		var source_val=$(source_id2).val();
		var dest_id2 = '#'+dest_id.concat(id_no);
		
		//-------------------------------------------------- msg
		if(msg == 'same_id_one_search') 
		{
			//do nothing	
		}
		else if(msg == 'diff_id_one_search')
		{
			$(dest_id2).val('');	//use into produc search query select via only mouse
		}
		else if(msg == 'diff_id_one_search2')
		{
			//$(dest_id2).val('');	//do nothing use in production entry select via keyboard
		}
		else if(msg == 'get_grade_lotno_list')
		{
			//$(dest_id2).val('');	//do nothing use in production entry select via keyboard
		}
		else if(msg == 'get_rate')
		{
			var rate_id = "#rate_".concat(id_no);	
		}
		else if(msg == 'new_po')
		{
			var supplier_id = $('#supplier_id').val();
			var rate_id = "#rate_".concat(id_no);
			var unitname_id = "#unitname_".concat(id_no);
			var hsn_id = "#hsn_".concat(id_no);
			var rowdiv_id = "#rowdiv_".concat(id_no);
			var itemsgst_id = "#itemsgst_".concat(id_no);
			var itemcgst_id = "#itemcgst_".concat(id_no);
			var itemigst_id = "#itemigst_".concat(id_no);
			var disc_id = "#disc_".concat(id_no);
			var net_id = "#net_".concat(id_no);	
		}//new po	
		
		$(source_id2).autocomplete({
		source: '<?php echo base_url().'index.php';?>/Product/product_autocomplate_search/',
		autoFocus:true,
		select: function(event, ui) {
				event.preventDefault();
				$(source_id2).val(ui.item.label);
				if(msg == 'same_id_one_search'){}else{$(dest_id2).val(ui.item.value);} //if source & dest not same
				
				if(msg == 'new_po')
				{
					//-----------------------------geting product details after selecting product
					if (window.XMLHttpRequest)
					{
						xmlhttp=new XMLHttpRequest();
					}
					else
					{
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange=function()
					{
					//document.getElementById("status1").innerHTML=xmlhttp.responseText;
						var data_fatech = xmlhttp.responseText.split("~");
						if(data_fatech.length > 2)
						{
							//alert(data_fatech[0]);
							$(unitname_id).val(data_fatech[0]);
							$(rate_id).val(data_fatech[1]);
							if(data_fatech[2]=='YES')//checking pcc are created or not
							{
								$(rate_id).css('border-color','green');
							}
							else
							{
								$(rate_id).css('border-color','red');
							}
							$(hsn_id).val(data_fatech[3]);
							$(rowdiv_id).val(data_fatech[4]);
							$(disc_id).val(data_fatech[5]);
							$(net_id).val(data_fatech[6]);
							$(itemsgst_id).val(data_fatech[7]);
							$(itemcgst_id).val(data_fatech[8]);
							$(itemigst_id).val(data_fatech[9]);
						}//if(data_fatech.length > 2)
					}
					xmlhttp.open("POST","<?php echo base_url().'index.php';?>/Po/get_product_last_purchase_details/?product_id="+ui.item.value+'&supplier_id='+supplier_id,true);
					xmlhttp.send();
				}//if(msg == 'new_po')
				else if(msg == 'get_rate')
				{
					/*
					//-----------------------------geting product details after selecting product
					if (window.XMLHttpRequest)
						{
							xmlhttp=new XMLHttpRequest();
						}
					else
						{
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
					xmlhttp.onreadystatechange=function()
						{
						//document.getElementById("status1").innerHTML=xmlhttp.responseText;
						$(rate_id).val(xmlhttp.responseText);
						//alert(unitname_id);
						}
					
					xmlhttp.open("POST","<?php echo base_url().'index.php';?>/Ajex/get_product_rate_list/?product_id="+ui.item.value,true);
					xmlhttp.send();
					//-------------------------------------------------------------------------
					*/
						
				}//msg
				
				else if(msg == 'get_grade_lotno_list')
				{
					fun_auto_issue_product_uom(id_no,ui.item.value);
					fun_auto_issue_product_grade(id_no,ui.item.value);
					fun_auto_issue_product_lotno(id_no,ui.item.value);
				}//msg
				
				
			},
		});
	}//function close


	//-------------------------------------------------Stock issue start----------------------------------
	//get grade list with row id and product id
	function fun_auto_issue_product_uom(id_no,product_id)
	{
		var uom_id = "#uom_".concat(id_no);	
		//-----------------------------geting product grade
		jQuery.post("<?php echo base_url().'index.php/Product/get_unit_name_from_id';?>", 
		{
			product_id:product_id,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			$(uom_id).val(data);
		});
	}//function close


	//get grade list with row id and product id
	function fun_auto_issue_product_grade(id_no,product_id)
	{
		var grade_id = "#grade_".concat(id_no);	
		//-----------------------------geting product grade
		jQuery.post("<?php echo base_url().'index.php/Store/get_all_grade_list_with_product_id';?>", 
		{
			product_id:product_id,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			$(grade_id).html(data);
		});
	}//function close

	
	function fun_auto_issue_product_lotno(id_no,product_id)
	{
		var lotno_id = "#lotno_".concat(id_no);	
		//-----------------------------geting product lotno
		jQuery.post("<?php echo base_url().'index.php/Store/get_all_lotno_list_with_product_id';?>", 
		{
			product_id:product_id,
		}, 
		function(data, textStatus)
		{	
			//alert(data);
			$(lotno_id).html(data);
		});
	}

	

	function fun_issue_product_get_qty(id)
	{
		var id2 = id.split("_");
		var id_no=id2[1];
		var goods_id = "#goods_".concat(id_no);
		var product_id=$(goods_id).val();
		var lotno_id = "#lotno_".concat(id_no);	
		var lotno_val=$(lotno_id).val();
		var grade_id = "#grade_".concat(id_no);	
		var grade_val=$(grade_id).val();
		var totalqty_id = "#totalqty_".concat(id_no);	
		//-------------------------------------------------- Qty
		jQuery.post("<?php echo base_url().'index.php/Store/get_total_qty_with_product_id_grade_lotno';?>", 
		{
			product_id:product_id,
			lotno_val:lotno_val,
			grade_val:grade_val,
		}, 
		function(data, textStatus)
		{	
			$(totalqty_id).val(data);
		});
	}//function close
 	//-------------------------------------------------Stock issue end----------------------------------






	//-----------------------------get machine form dept_id
	function fun_get_machine_form_dept_id(str,dest_id,msg)
	{
		var dest_id2 = '#'+dest_id;
		jQuery.post("<?php echo base_url().'index.php/Machine/fun_get_machine_form_dept_id';?>", 
		{
			dept_id:str,
		}, 
		function(data, textStatus)
		{	
			$(dest_id2).html(data);
		});
	}//function close



	
	function fun_check_gst(gst,type)
	{
		if(type == 'supplier')
		{
			jQuery.post("<?php echo base_url().'index.php/Supplier/fun_supplier_gst';?>", 
			{
				gst:gst,
			},
			function(data, textStatus)
			{	
				//alert(data);
				//$('#gst_ab').html(data);
				if(data == 'TRUE'){fun_message('error','GST : "'+gst+'"',' Already Exits1.','toast-bottom-right');}
			}); 
		}
		else if(type == 'customer')
		{
			jQuery.post("<?php echo base_url().'index.php/Customer/fun_customer_gst';?>", 
			{
				gst:gst,
			},
			function(data, textStatus)
			{	
				//alert(data);
				//$('#gst_ab').html(data);
				if(data == 'TRUE'){fun_message('error','GST : "'+gst+'"',' Already Exits1.','toast-bottom-right');}
			}); 
		}
	}//function close




	


	
	var counterjr = 0;
	function moreFields1(readrootjr,writerootjr) 
	{
		counterjr++;
		var newFields = document.getElementById(readrootjr).cloneNode(true);
		newFields.id = 'jr'+counterjr;
		newFields.style.display = 'block';
		var newField = newFields.childNodes;
		for (var i=0;i<newField.length;i++) 
		{
			
			var theId = newField[i].id;
			
			if (theId)
			{
				newField[i].id = theId + counterjr;
			}
		}
		
		var insertHere = document.getElementById(writerootjr);
		insertHere.parentNode.insertBefore(newFields,insertHere);
	}//function close




	//----export to xlsx without edit column
	function fun_export_xls() {

		const table = document.getElementById("printed_table");
		if (!table) {
			alert("Table not found");
			return;
		}

		// 🔥 Clone table
		const clone = table.cloneNode(true);

		/* ❌ REMOVE EDIT COLUMN (if exists) */
		let editColIndex = -1;
		clone.querySelectorAll("thead th").forEach((th, index) => {
			if (th.innerText.trim().toLowerCase() === "edit") {
				editColIndex = index;
			}
		});

		if (editColIndex !== -1) {
			clone.querySelectorAll("tr").forEach(row => {
				if (row.children[editColIndex]) {
					row.children[editColIndex].remove();
				}
			});
		}

		/* 🔥 Replace <br> */
		clone.querySelectorAll("br").forEach(br => br.replaceWith(", "));

		/* ❌ Remove UI junk */
		clone.querySelectorAll("img, button, ul, li, i").forEach(el => el.remove());
		clone.querySelectorAll("a, span").forEach(el => {
			el.replaceWith(el.innerText);
		});

		/* 🧹 Clean text */
		clone.querySelectorAll("td, th").forEach(cell => {
			cell.innerText = cell.innerText.replace(/\s+/g, " ").trim();
		});

		/* 📦 Create workbook */
		const wb = XLSX.utils.book_new();
		const ws = XLSX.utils.table_to_sheet(clone);

		/* 🔥 FORCE "Emp. Account No" COLUMN AS TEXT */
		let bankColIndex = -1;

		clone.querySelectorAll("thead th").forEach((th, i) => {
			if (th.innerText.trim().toLowerCase() === "emp. account no") {
				bankColIndex = i;
			}
		});

		if (bankColIndex !== -1 && ws['!ref']) {
			const range = XLSX.utils.decode_range(ws['!ref']);

			for (let R = range.s.r + 1; R <= range.e.r; ++R) {
				const cellAddr = XLSX.utils.encode_cell({ r: R, c: bankColIndex });
				const cell = ws[cellAddr];

				if (cell && cell.v) {
					cell.t = 's';              // TEXT
					cell.v = String(cell.v);  // STRING FORCE
				}
			}
		}

		/* 🔥 AUTO COLUMN WIDTH */
		const colWidths = [];
		clone.querySelectorAll("tr").forEach(row => {
			[...row.children].forEach((cell, i) => {
				const len = cell.innerText.length;
				colWidths[i] = Math.max(colWidths[i] || 10, len + 2);
			});
		});

		ws["!cols"] = colWidths.map(w => ({ wch: w }));

		XLSX.utils.book_append_sheet(wb, ws, "Report");
		XLSX.writeFile(wb, "Report.xlsx");
	}

	


	//----export to xls without edit column
	function fun_export_old_xls() {

		const table = document.getElementById("printed_table");
		if (!table) {
			alert("Table not found");
			return;
		}

		// 🔥 Clone table
		const clone = table.cloneNode(true);

		// 1️⃣ Find Edit column index
		let editColIndex = -1;
		clone.querySelectorAll("thead th").forEach((th, index) => {
			if (th.innerText.trim().toLowerCase() === "edit") {
				editColIndex = index;
			}
		});

		// 2️⃣ Remove Edit column (th + td)
		if (editColIndex !== -1) {
			clone.querySelectorAll("tr").forEach(row => {
				if (row.children[editColIndex]) {
					row.children[editColIndex].remove();
				}
			});
		}

		
		//clone.querySelectorAll("br").forEach(el => el.remove());
		clone.querySelectorAll("br").forEach(br => {
			br.replaceWith(", ");
		});
		clone.querySelectorAll("img").forEach(el => el.remove());
		clone.querySelectorAll("button").forEach(el => el.remove());
		clone.querySelectorAll("ul, li, i").forEach(el => el.remove());

		clone.querySelectorAll("a, span").forEach(el => {
			el.replaceWith(el.innerText);
		});

		
		clone.querySelectorAll("td, th").forEach(cell => {
			cell.innerText = cell.innerText.replace(/\s+/g, " ").trim();
		});

		
		const html = `
			<html xmlns:o="urn:schemas-microsoft-com:office:office"
				xmlns:x="urn:schemas-microsoft-com:office:excel">
			<head>
			<meta charset="UTF-8">
			<style>
				table {
					border-collapse: collapse;
					mso-border-alt: solid black 1px;
				}
				th, td {
					border: 1px solid #000;
					mso-border-alt: solid black 1px;
					padding: 4px;
					font-size: 10pt;
					vertical-align: middle;
					text-align: center;
				}
				th {
					font-weight: bold;
					background: #d9d9d9;
				}
			</style>
			</head>
			<body>
			${clone.outerHTML}
			</body>
			</html>
			`;


		const blob = new Blob([html], {
			type: "application/vnd.ms-excel;charset=utf-8;"
		});

		const link = document.createElement("a");
		link.href = URL.createObjectURL(blob);
		link.download = "Report.xls";

		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
	}

	////for print all show page or table data
	function fun_export_xls2(str)
    {
        if(str == '1'){ $("#printed_table_101").table2excel({filename: "State_Wise_sales.xls" }); }
        if(str == '2'){ $("#printed_table_102").table2excel({filename: "Company_type_Wise_sales.xls" }); }
        if(str == '3'){ $("#printed_table_103").table2excel({filename: "Sales_Person_Wise_sales.xls" }); }
        if(str == '4'){ $("#printed_table_104").table2excel({filename: "Grade_Wise_sales.xls" }); }
        if(str == '5'){ $("#printed_table_105").table2excel({filename: "Customer_Wise_sales.xls" }); }
        if(str == '6'){ $("#printed_table_106").table2excel({filename: "Product_Size_Wise_sales.xls" }); }
        if(str == '7'){ $("#printed_table_107").table2excel({filename: "Product_Grade_Wise_sales.xls" }); }
		if(str == '8'){ $("#printed_table_108").table2excel({filename: "Grade_Product_Wise_sales.xls" }); }
		if(str == '9'){ $("#printed_table_109").table2excel({filename: "Table.xls" }); }
		if(str == '10'){ $("#printed_table_110").table2excel({filename: "Table.xls" }); }
   }//function close

   function fun_export_xls3(id)
	{
		var table_id = "#".concat(id);
		$(table_id).table2excel({
			filename: "Table.xls"
		});
	}//function close


	///for print all show page or table data
	function fun_export_pdf()
	{
		//var date1= "<?php echo date('d-m-Y');?>";
		//var data='<h2 align="center">Rope M/C Tool Life Cycle</h2>';
		var divToPrint=document.getElementById("printed_table_div");
		newWin= window.open("");
		//newWin.document.write(data);
		newWin.document.write(divToPrint.outerHTML);
		newWin.print();
		newWin.close();
	}//function close

	






</script>



