<?php 
    $emp_id=$this->session->userdata('login_emp_id'); 
    if(isset($po_search_stage))
    {
        if($po_search_stage==1)
        {
            $seg2="New PO List";
        }
        if($po_search_stage==2)
        {
            $seg2="PO Approved by Dept.";
        }
        elseif($po_search_stage==3)
        {
            $seg2="Rejected PO List";
        }
        elseif($po_search_stage==4)
        {
            $seg2="PO Approved By G.M/M.D";
        }
        elseif($po_search_stage==11)
        {
            $seg2="PO Approved By G.M";
        }
        elseif($po_search_stage==5)
        {
            $seg2="PO Send To Supplier";
        }
        else
        {
            $seg2='';
        }
    }
    else
    {
        $seg2='';
    }
?>            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">

                    <input type="hidden" name="po_search_stage" id="po_search_stage" value="<?php echo $po_search_stage;?>">
                   
                    <div class="col-md-2">
                        <label>Form Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('d-m-Y');}?>" required  >
                    </div>
                
                    <div class="col-md-2">
                        <label>To Date</label>
                        <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                    </div>
                
                    <div class="col-md-2" >
                        <label >Supplier Name</label>
                        <select class="form-control" name="name" id="name"  >
                            <option value="">All</option>
                            <?php 
                            foreach($supplier as $d)
                            {
                                ?>
                                    <option <?php if(isset($name)){if($name==$d['id']){echo "selected";}}?> value="<?php echo $d['id'];?>">
                                        <?php echo $d['name'];?>
                                    </option>
                                <?php 
                            }
                            ?>
                        </select>
                    </div>
                
                    <div class="col-md-2">
                        <label >P.O No.</label>
                        <input type="text" class="form-control"  id="pono" name="pono" value="<?php if(isset($pono))echo $pono;?>" >
                    </div>  


                    <div class="col-md-1">
                        <input type="button" id="po_list_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                </div>
                
                
                
                
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                   
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title"><?php  echo $seg2;?> List</div>
                               
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('po/show_table',$res2);?>
                                </div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/po_js');?>

