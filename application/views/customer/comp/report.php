<?php 
  if(isset($res2[0]['complain_date']) and $res2[0]['complain_date'] != '0000-00-00'){$complain_date=$this->Base->change_date_dmy($res2[0]['complain_date']);}else{$complain_date='';}
  if(isset($res2[0]['tag_date1']) and $res2[0]['tag_date1'] != '0000-00-00'){$tag_date1=$this->Base->change_date_dmy($res2[0]['tag_date1']);}else{$tag_date1='';}
  if(isset($res2[0]['tag_date2']) and $res2[0]['tag_date2'] != '0000-00-00'){$tag_date2=$this->Base->change_date_dmy($res2[0]['tag_date2']);}else{$tag_date2='';}
  if(isset($res2[0]['resolution']) and $res2[0]['resolution'] != '0000-00-00'){$resolution=$this->Base->change_date_dmy($res2[0]['resolution']);}else{$resolution='';}
?>  
 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Customer Complaint Report</title>
		<meta name="author" content="Manorajan Sharma,keepcoding.in,manu"/>
		<meta name="changedby" content="Manu"/>
		<link href="<?php echo base_url();?>dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" media="screen" />
		<link href="<?php echo base_url();?>/jquery_ui/jquery-ui.min.css" rel="stylesheet" media="screen" />

		<style>
			@media print {
				a {text-decoration: none; color:#000}
				#attendanceModal{
					display: none;
				}
				body, html {
					margin: 0;
					padding: 0;
					color: #000 !important;
					background: #fff !important;
					font-size: 12pt;
				}
				.print_hide{
					display: none;
				}

				.no-print, .sidebar, .navbar, .footer {
					display: none !important;
				}

				table {
					width: 100% !important;
					border-collapse: collapse !important;
				}

				th, td {
					border: 1px solid #000 !important;
					padding: 6px !important;
				}

				a::after {
					content: "" !important;
				}
			}
	
  
    .report-container {
       max-width: 70%;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .section-header {
      font-size: 18px;
      font-weight: 600;
      color: #0056b3;
      border-bottom: 2px solid #ddd;
      margin-bottom: 15px;
      padding-bottom: 5px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 10px 20px;
      margin-bottom: 20px;
    }

    .info-box {
      background: #f0f4ff;
      padding: 10px 15px;
      border-radius: 6px;
    }

    .info-title {
      font-size: 13px;
      color: #666;
    }

    .info-value {
      font-size: 15px;
      font-weight: 500;
    }

    .multi-line-box {
      background: #fff5e6;
      border-left: 4px solid #ffa500;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 5px;
    }

    .multi-line-title {
      font-weight: 600;
      margin-bottom: 5px;
      color: #b36b00;
    }

    @media print {
      @page {
        size: A4;
        margin: 20mm;
      }
      body {
        background: none;
      }
      .report-container {
        box-shadow: none;
        margin: 0;
      }
    }

    .highlight{
      background-color: yellow;
    }
  </style>
	</head>







<div class="report-container">

  <h2 class="text-center mb-4">📝 Customer Complaint Report</h2>
 

  <!-- Complaint Details -->
  <div>
    <div class="section-header">Complaint Details</div>
    <div class="info-grid">
      <div class="info-box"><div class="info-title">Complaint ID</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['comp_id']; ?></div></div>
      <div class="info-box"><div class="info-title">Date</div><div class="info-value"><?php echo $complain_date; ?></div></div>
      <div class="info-box"><div class="info-title">Customer</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['cname']; ?></div></div>
      <div class="info-box"><div class="info-title">Type</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['type']; ?></div></div>
      <div class="info-box"><div class="info-title">Priority</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['priority']; ?></div></div>
      <div class="info-box"><div class="info-title">Status</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['status']; ?></div></div>
    </div>
  </div>

  <!-- Defect Info -->
  <div>
    <div class="section-header">Defect Summary</div>
    <div class="info-grid">
      <div class="info-box"><div class="info-title">Defect Qty</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['defect_qty']; ?> <?php if(!empty($res2)) echo $res2[0]['defect_unit']; ?></div></div>
      <div class="info-box"><div class="info-title">Amount</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['defect_amount']; ?></div></div>
      <div class="info-box"><div class="info-title">Bobbin</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['defect_bobbin']; ?></div></div>
    </div>
  </div>

  <hr>
   <div class="col-md-12" style="margin-top: 30px;">
      <?php
      if (isset($res2[0]['comp_id'])) {
          $customer_name = $res2[0]['customer_name'];
          $comp_id = $res2[0]['comp_id'];
          $this->Customermodel->get_all_cust_comp_photo_with_comp_id($customer_name,$comp_id);
          //$this->Customermodel->get_all_cust_comp_photo($customer_name);
      }
      ?>
  </div>
  <hr>


  <!-- Tag 1 -->
  <div style="margin-top: 30px;">
    <div class="section-header">Tag 1 (Wire) Details</div>
    <div class="info-grid">
      <div class="info-box"><div class="info-title">Tag Date</div><div class="info-value highlight" ><?php echo $tag_date1; ?></div></div>
      <div class="info-box"><div class="info-title">Size</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_size1']; ?></div></div>
      <div class="info-box"><div class="info-title">Wire Type</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['type_of_wire1']; ?></div></div>
      <div class="info-box"><div class="info-title">Grade</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_grade1']; ?></div></div>
      <div class="info-box"><div class="info-title">Coil No</div><div class="info-value highlight" id="coil1"><?php if(!empty($res2)) echo $res2[0]['tag_coil_no1']; ?></div></div>
      <div class="info-box"><div class="info-title">Shift</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_shift1']; ?></div></div>
    </div>
    <h5>Production Report : </h5>
    <?php 
      if(!empty($res2[0]['tag_date1']) && !empty($res2[0]['tag_size1'])){
        $tagDate = $res2[0]['tag_date1'];
        $tagSize = $res2[0]['tag_size1'];
        $where=" and A.entry_date = '$tagDate' ORDER by J.name ,I.order_list ASC  ";
        $production = $this->Productionmodel->get_all_production_with_search($where);
        $filteredProduction = array_filter($production, function ($item) use ($tagSize) {
            return (float)$item['out_size'] === (float)$tagSize;
        });
        //print_r($filteredProduction);
        $this->Productionmodel->create_production_report_on_date_data_print($filteredProduction);
      ?>
      <h5 style="margin-top: 20px;">Quality Report :</h5>
      <?php
        //QC test
        $where=" and B.entry_date = '$tagDate'   AND CAST(B.finish_size AS DECIMAL(10,3)) = CAST('$tagSize' AS DECIMAL(10,3))";
        $qc = $this->Qcmodel->get_all_test1_with_search($where);
        // print_r($qc);
        $this->Qcmodel->test_coil_print_table($qc);
      }
    ?>
  </div>



  <!-- Tag 2 -->
  <div style="margin-top: 30px;">
    <div class="section-header">Tag 2 (Wire) Details</div>
    <div class="info-grid">
      <div class="info-box"><div class="info-title">Tag Date</div><div class="info-value"><?php echo $tag_date2; ?></div></div>
      <div class="info-box"><div class="info-title">Size</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_size2']; ?></div></div>
      <div class="info-box"><div class="info-title">Wire Type</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['type_of_wire2']; ?></div></div>
      <div class="info-box"><div class="info-title">Grade</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_grade2']; ?></div></div>
      <div class="info-box"><div class="info-title">Coil No</div><div class="info-value"  id="coil2"><?php if(!empty($res2)) echo $res2[0]['tag_coil_no2']; ?></div></div>
      <div class="info-box"><div class="info-title">Shift</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['tag_shift2']; ?></div></div>
    </div>
    <h5>Production Report : </h5>
    <?php 
      $production = array();
      if(!empty($res2[0]['tag_date2']) && !empty($res2[0]['tag_size2'])){
        $tagDate = $res2[0]['tag_date2'];
        $tagSize = $res2[0]['tag_size2'];
        $where=" and A.entry_date = '$tagDate' ORDER by J.name ,I.order_list ASC  ";
        $production = $this->Productionmodel->get_all_production_with_search($where);
        $filteredProduction = array_filter($production, function ($item) use ($tagSize) {
            return (float)$item['out_size'] === (float)$tagSize;
        });
       //print_r($filteredProduction);
        $this->Productionmodel->create_production_report_on_date_data_print($filteredProduction);
       ?>


      <h5 style="margin-top: 20px;">Quality Report : </h5>
      <?php
        //QC test
        $where=" and B.entry_date = '$tagDate'   AND CAST(B.finish_size AS DECIMAL(10,3)) = CAST('$tagSize' AS DECIMAL(10,3))";
        $qc = $this->Qcmodel->get_all_test1_with_search($where);
        // print_r($qc);
        $this->Qcmodel->test_coil_print_table($qc);
      }
    ?>
  </div>





  <!-- Description Sections -->
  <div class="multi-line-box" style="margin-top: 30px;">
    <div class="multi-line-title">Problem Description</div>
    <div><?php if(!empty($res2)) echo $res2[0]['desc_problem']; ?></div>
  </div>

  <div class="multi-line-box">
    <div class="multi-line-title">Scope</div>
    <div><?php if(!empty($res2)) echo $res2[0]['scope']; ?></div>
  </div>

  <div class="multi-line-box">
    <div class="multi-line-title">Root Cause</div>
    <div><?php if(!empty($res2)) echo $res2[0]['root_cause']; ?></div>
  </div>

  <div class="multi-line-box">
    <div class="multi-line-title">Corrective Action</div>
    <div><?php if(!empty($res2)) echo $res2[0]['corrective_action']; ?></div>
  </div>

  <div class="multi-line-box">
    <div class="multi-line-title">Preventive Action</div>
    <div><?php if(!empty($res2)) echo $res2[0]['preventive_action']; ?></div>
  </div>

  <div class="multi-line-box">
    <div class="multi-line-title">Verification</div>
    <div><?php if(!empty($res2)) echo $res2[0]['verification']; ?></div>
  </div>

  <!-- Final Responsibility -->
  <div class="info-grid">
    <div class="info-box"><div class="info-title">Complaint By</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['comp_by']; ?></div></div>
    <div class="info-box"><div class="info-title">Received By</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['rece_by']; ?></div></div>
    <div class="info-box"><div class="info-title">Department</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['department']; ?></div></div>
    <div class="info-box"><div class="info-title">Assigned To</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['assigned_to']; ?></div></div>
    <div class="info-box"><div class="info-title">Follow-up Required</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['followup_req']; ?></div></div>
    <div class="info-box"><div class="info-title">Resolution Date</div><div class="info-value"><?php echo $resolution; ?></div></div>
    <div class="info-box"><div class="info-title">Remarks</div><div class="info-value"><?php if(!empty($res2)) echo $res2[0]['remarks']; ?></div></div>
  </div>

</div>


<script src="<?php echo base_url();?>dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
    var coil1Value = $("#coil1").text().trim(); // Get value of #coil1
    var coil2Value = $("#coil2").text().trim(); // Get value of #coil1
    

    $(".coilno").each(function(){
        if($(this).text().trim() === coil1Value || $(this).text().trim() === coil2Value ){
            $(this).css("background-color", "yellow");
        }
    });
});
</script>

