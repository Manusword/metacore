
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">

                    <input type="hidden" name="po_search_stage" id="po_search_stage" value="5">
                   
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
                        <select class="form-control" id="supplier"  >
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
                
                    <div class="col-md-2" >
                        <label >Product (Select via Click)</label>
                        <input type="text"  class="form-control"   id="name2_" placeholder="Type to Select" onKeyUp="fun_get_product(this.id,'name2_','name_','diff_id_one_search')">
                        <input type="hidden"  class="form-control"   id="name_">
                    </div>

                    <div class="col-md-1">
                        <input type="button" id="po_product_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                </div>
                
                
                
                
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                   
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title">Po Product Status List</div>
                               
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('po/show_table_product',$res2);?>
                                </div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/po_js');?>

