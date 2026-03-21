         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-2" >
                        <label >Category</label>
                        <select class="form-control" name="cat" id="cat"  >
                            <option value="">All</option>
                            <?php 
                            foreach($cat2 as $d){
                            ?>
                                <option <?php //if($this->Productmodel->get_default_category_product_search()==$d['category_id']){echo "selected";}?> value="<?php echo $d['category_id'];?>">
                                    <?php echo $d['name'];?>
                                </option>
                            <?php }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2" >
                        <label >Product (Select via Click)</label>
                        <input type="text"  class="form-control"   id="name2_" placeholder="Type to Select" onKeyUp="fun_get_product(this.id,'name2_','name_','diff_id_one_search')">
                        <input type="hidden"  class="form-control"   id="name_">
                    </div>
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="product_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Product List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('product/show_table',$res2);?></div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


 
