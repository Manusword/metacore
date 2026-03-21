<!DOCTYPE html>
<html lang="en" dir="ltr" translate="no">


<head>
   <meta charset="UTF-8" />
   <meta name="google" content="notranslate">

    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="author" content="https://keepcoding.in/" />
    <title><?php if(isset($company[0]['full_name'])){echo $company[0]['full_name'];}?></title>
    <link href="<?php echo base_url();?>dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url();?>dist-assets/css/plugins/datatables.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>dist-assets/css/plugins/ladda-themeless.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>dist-assets/css/plugins/sweetalert2.min.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>dist-assets/css/plugins/toastr.css" />
    <link href="<?php echo base_url();?>/jquery_ui/jquery-ui.min.css" rel="stylesheet"></link>

    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('pic/favicons/favicon-16x16.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url('pic/favicons/favicon-32x32.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('pic/favicons/apple-touch-icon.png'); ?>">
    <link rel="shortcut icon" href="<?php echo base_url('pic/favicons/favicon.ico'); ?>">


    
	<style>
        /* auto complate */
        .table-responsive table tbody tr:hover { background-color: #d8dce3; }
        .dis_td {font-size:14px; font-weight:bold;}
        .shift_a{background-color:#80d18e;}
        .shift_b{background-color:#d18f80;}
        .dis_td {font-size:14px; font-weight:bold;}
        
        .ui-widget-content 
        {
            border: 1px solid #aaaaaa;
            color: #222222;
        }
        
        @media print {
            a[href]:after {
                content: none !important;
            }
        }
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1000000;
            background: url('<?php echo base_url();?>pic/loading.gif') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>
    <div class="loader" style="display:none;"></div></div>
    
</head>