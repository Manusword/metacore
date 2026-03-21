<?php 
    $login_emp_id = $this->session->userdata('login_emp_id');
    $empData = $this->Base->emp_details_from_emp_code($login_emp_id);
    /*
?>
<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header" style="background-color:<?php if(isset($design[0]['details1'])){echo $design[0]['details1'];}else{echo "red";}?>; color:<?php if(isset($design[0]['details2'])){echo $design[0]['details2'];}else{echo "white";}?>;">
            <div class="logo" >
                <a href="<?php echo base_url();?>index.php/Welcome/home">
                <img  src="<?php echo base_url(); if(isset($company[0]['details3'])){echo $company[0]['details3'];}?>" alt="company logo">
                </a>
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">
                
                <!-- / Mega menu -->
                <div  class="dropdown mega-menu d-none d-md-block">
                    <h3 style="color:<?php if(isset($design[0]['details3'])){echo $design[0]['details3'];}else{echo "white";}?>;">
                    <?php if(isset($company[0]['details1'])){echo $company[0]['details1'];}?>
                    </h3>
                </div>

               
            </div>

            <div style="margin: auto"> </div>
            
            <div class="header-part-right">
                
                <!-- Notificaiton End -->

                <?php 
                if($login_emp_id ==1){
                ?>
                    <div class="dropdown">
                    <button style="margin-left: 200px;"  onclick="fun_ask_to_ai()" type="button" class="btn btn-warning" data-toggle="modal" data-target="#aiModalLong">Ask AI about this page</button>
                    </div>
                <?php }?>


                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="<?php echo base_url();?>dist-assets/images/faces/new.png" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item"></a>
                            <a class="dropdown-item" href="<?php echo base_url();?>index.php/Welcome/home?Welcome/password_update" style="color:blue">Password Change</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>index.php/Welcome/logout" style="color:blue">Sign out</a>
                        </div>
                        <?php if(!empty($empData)){echo $empData[0]['first_name'];}?>
                    </div>
                </div>
            </div>
            
        </div>
         
        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    <style> 
                        /* Style the buttons *-/
                        .menu_item 
                        {
                            border: none;
                            outline: none;
                            padding: 10px 16px;
                            background-color: <?php if(isset($design[0]['details6'])){echo $design[0]['details6'];}else{echo "black";}?>;
                            cursor: pointer;
                        }

                        /* Style the active class (and buttons on mouse-over) *-/
                        .active, .menu_item:hover 
                        {
                            background-color: <?php if(isset($design[0]['details5'])){echo $design[0]['details5'];}else{echo "red";}?>;
                        }
                    </style>

                    <?php 
                        $menu_list = $this->Base->get_all_main_menu();
                        foreach($menu_list as $m)
                        {
                            if(in_array($login_emp_id ,explode(',',$m['access_to_emp_id'])))
                            {
                                ?>
                                    <li class="nav-item menu_item"  data-item="<?php echo $m['id_name']?>"><span class="nav-text"><?php echo $m['name']?></span></li>
                                <?php
                            }
                        }
                    ?>

                  
                   <!--
                         <li class="nav-item menu_item"  data-item="Dashboard"><span class="nav-text">Dashboard</span></li>
                        <li class="nav-item menu_item" data-item="Product"><span class="nav-text">Product</span></li>
                        <li class="nav-item menu_item" data-item="Supplier"><span class="nav-text">Supplier</span></li>
                        <li class="nav-item menu_item" data-item="Customer"><span class="nav-text">Customer</span></li>
                        <li class="nav-item menu_item" data-item="PO"><span class="nav-text">PO</span></li>
                        <li class="nav-item menu_item" data-item="Maintenance"><span class="nav-text">Maintenance</span></li>
                        <li class="nav-item menu_item" data-item="MOM"><span class="nav-text">MOM</span></li>
                        <li class="nav-item menu_item" data-item="Machine"><span class="nav-text">Machine</span></li>
                        <li class="nav-item menu_item" data-item="Production"><span class="nav-text">Production</span></li>
                        <li class="nav-item menu_item" data-item="Store"><span class="nav-text">Store</span></li>
                        <li class="nav-item menu_item" data-item="Dispatch"><span class="nav-text">Dispatch</span></li>
                        <li class="nav-item menu_item" data-item="Hr"><span class="nav-text">HR</span></li>
                    -->
                    <!--
                        <li class="nav-item menu_item" data-item="QC"><span class="nav-text">QC</span></li>
                        <li class="nav-item menu_item" data-item="Account"><span class="nav-text">Account</span></li>
                        <li class="nav-item" data-item="product"><a class="nav-item-hold" href="#"><i class="nav-icon i-Library"></i><span class="nav-text">Product</span></a> </li>
                   -->
                </ul>
              
            </div>
 

            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <!-- Submenu Dashboards-->

                <?php 
                        
                    foreach($menu_list as $m)
                    {
                        if(in_array($login_emp_id ,explode(',',$m['access_to_emp_id'])))
                        {
                            ?>
                                <ul class="childNav" data-parent="<?php echo $m['id_name'];?>">
                                <?php
                                $sub_menu_list = $this->Base->get_all_sub_menu_from_main_id($m['id']);
                                foreach($sub_menu_list as $n)
                                {
                                    if(in_array($login_emp_id ,explode(',',$n['access_to_emp_id'])))
                                    {
                                        if($n['is_direct_link']=='Yes')
                                        {
                                            ?>
                                                <li class="nav-item menu-toggle"><a href="<?php echo base_url();?><?php echo $n['link'];?>"><span class="item-name"><?php echo $n['name'];?></span></a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                                <li class="nav-item menu-toggle"><a href="#"  onClick="showPage(this.id)" id="<?php echo $n['id_name'];?>"><span class="item-name"><?php echo $n['name'];?></span></a></li>
                                            <?php
                                        }
                                    }//sub
                                }//sub for
                                ?>
                                </ul> 
                            <?php
                        }//main menu
                    }//foreach
                ?>

                <?php /*
                <ul class="childNav" data-parent="Dashboard">
                    <li class="nav-item menu-toggle"><a href="<?php echo base_url();?>index.php/Welcome/home"><span class="item-name">Home</span></a></li>
                    <li class="nav-item menu-toggle"><a href="#"  onClick="showPage(this.id)" id="Welcome/dispatch_dashboard"><span class="item-name">Dispatch</span></a></li>
                    <li class="nav-item menu-toggle"><a href="#"  onClick="showPage(this.id)" id="Welcome/energy_dashboard"><span class="item-name">Energy</span></a></li>
                </ul>
                *-/?>

               
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->


       
        <!-- Ai Modal -->
        <div class="modal fade" id="aiModalLong" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aiModalLongTitle" style=" color:#007bff">AI Assistance</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div >
                        <?php $this->Aimodel->ai_box_popup();?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Ai Modal -->
*/?>



<body class="text-left">
    <div class="app-admin-wrap layout-horizontal-bar">
         <div class="main-header" style="background-color:<?php if(isset($design[0]['design1_bg_color'])){echo $design[0]['design1_bg_color'];}else{echo "red";}?>; color:<?php if(isset($design[0]['design1_ft_color'])){echo $design[0]['design1_ft_color'];}else{echo "white";}?>;">
            <div class="logo"  style="width:150px; padding-right:20px ">
            <a href="<?php echo base_url();?>index.php/Welcome/home">
            <img  src="<?php echo base_url(); if(isset($company[0]['logo'])){echo $company[0]['logo'];}?>" alt="company logo" style="width:100%"> </a>  </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="d-flex align-items-center">
                  <div  class="dropdown mega-menu d-none d-md-block" >
                    <h3 style="color:white"><?php if(isset($company[0]['full_name'])){echo $company[0]['full_name'];}?></h3>
                </div>
            </div>
            <div style="margin: auto"> 
                <!-- <div class="search-bar">
                    <input type="text" placeholder="Search" /><i class="search-icon text-muted i-Magnifi-Glass1"></i>
                </div> -->
            </div>
            <div class="header-part-right">
                <!-- Grid menu Dropdown-->
                <div class="dropdown"><i  class="i-File-Clipboard-File--Text text-muted header-icon" id="dropdownMenuButton" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color:white"></i>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div class="menu-icon-grid">
                            <a href="#" onclick="showPage('Hr/add_gatepass')"><i class="i-File-Clipboard-File--Text"></i> GatePass</a>
                            <a href="#" onclick="showPage('Hr/add_leave2')"><i class="i-Calendar-4"></i> Leave</a>
                            <a href="#" onclick="showPage('Maintenance/add_reminder')"><i class="i-Clock-3"></i>Reminder</a>
                            <!-- <a href="#"><i class="i-Money-Bag"></i> Advance</a>
                            <a href="#"><i class="i-Speach-Bubble-Dialog"></i> Complain</a> -->
                        </div>
                    </div>
                </div>
                <!-- Notificaiton-->
                
                <!-- User avatar dropdown-->
                <div class="dropdown">
                    <div class="user col align-self-end" >
                       
                        <?php 
                               if(strlen($empData[0]['profile_pic'])>0)
                                {
                                    ?>
                                        <img  src="<?php echo base_url();?>pic/employee/dp/<?php echo $empData[0]['profile_pic'];?>" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <?php
                                }else{
                                    ?>
                                        <img  src="<?php echo base_url();?>dist-assets/images/faces/new.png" id="userDropdown" alt=""  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                }
                            ?>
                       
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item"></a>
                            <a class="dropdown-item" href="<?php echo base_url();?>index.php/Welcome/home?Welcome/password_update" >Password Change</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>index.php/Welcome/logout" >Sign out</a>
                        </div>
                        <?php if(!empty($empData)){echo $empData[0]['first_name'];}?>
                    </div>
                </div>
            </div>
        </div>
        <!-- header top menu end-->
        <div class="horizontal-bar-wrap">
            <div class="header-topnav">
                <div class="container-fluid">
                    <div class="topnav rtl-ps-none" id="" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                        <ul class="menu float-left">
    
                        <?php
                        $menu_list = $this->Company->get_all_main_menu();
                            foreach ($menu_list as $m):
                            ?>
                                <li>
                                    <div>
                                        <div>
                                            <label class="toggle" for="drop-<?= $m['id']; ?>">
                                                <?= $m['name']; ?>
                                            </label>

                                            <a href="#">
                                                <i class="nav-icon mr-2 <?= $m['icon']; ?>"></i>
                                                <?= $m['name']; ?>
                                            </a>

                                            <input id="drop-<?= $m['id']; ?>" type="checkbox" />

                                            <ul>
                                                <?php
                                                $sub_menu_list = $this->Company->get_all_sub_menu_from_main_id($m['id']);
                                                
                                                foreach ($sub_menu_list as $n):
                                                    if ($n['is_direct_link'] === 'Yes'):
                                                ?>
                                                        <li class="nav-item menu-toggle">
                                                            <a href="<?= base_url($n['link']); ?>">
                                                                <span class="item-name"><?= $n['name']; ?></span>
                                                            </a>
                                                        </li>
                                                <?php else: ?>
                                                        <li class="nav-item menu-toggle">
                                                            <a href="#" onclick="showPage(this.id)" id="<?= $n['id_name']; ?>">
                                                                <span class="item-name"><?= $n['name']; ?></span>
                                                            </a>
                                                        </li>
                                                <?php
                                                    endif;
                                                endforeach;
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; /*?>

                        

                        <li>
                            <div>
                                <div>
                                    <label class="toggle" for="drop-2">Traning</label><a href="#"><i class="nav-icon mr-2 i-Bar-Chart-5"></i>Traning</a>
                                    <input id="drop-2" type="checkbox" />
                                    <ul>
                                        <li class="nav-item"><a href="#" title="charts"><i class="nav-icon mr-2 i-Bar-Chart-2"></i><span class="item-name">Entry</span></a></li>
                                        <li class="nav-item"><a href="#"><i class="nav-icon mr-2 i-File-Clipboard-Text--Image"></i><span class="item-name">Reports</span></a></li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </li>

                         <li>
                            <div>
                                <div>
                                    <label class="toggle" for="drop-2">Reports</label><a href="#"><i class="nav-icon mr-2 i-Windows-2"></i> Reports</a>
                                    <input id="drop-2" type="checkbox" />
                                    <ul>
                                        <li class="nav-item"><a href="#" title="charts"><i class="nav-icon mr-2 i-Receipt-4"></i><span class="item-name">Absent</span></a></li>
                                        <li class="nav-item"><a href="#"><i class="nav-icon mr-2 i-Receipt-4"></i><span class="item-name">Late</span></a></li>
                                        <li><a href="#"><i class="nav-icon mr-2 i-Receipt-4"></i>Missing Punch</a></li>
                                        <li><a href="#"><i class="nav-icon mr-2 i-Receipt-4"></i>Leave</a></li>
                                        <li><a href="#"><i class="nav-icon mr-2 i-Receipt-4"></i>GatePass</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        */?>

                        
                            
                           
                            <!--end-doc  -->
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>