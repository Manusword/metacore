         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">


                
                    <div class="col-md-1" >
                        <label >Dept.</label>
                        <select class="form-control" id="dept"  >
                            <option >FG</option>
                        </select>
                    </div>

                    <div class="col-md-1" >
                        <label>Rec. / Des.</label>
                        <select class="form-control" id="inout"  >
                            <option value=''>All</option>
                            <option value="IN">Receive</option>
                            <option value="OUT">Despatch</option>
                        </select>
                    </div>


                    <div class="col-md-1" >
                        <label >Receive From</label>
                        <select class="form-control" id="in_from"  >
                            <option value="">All</option>
                            <option >WD</option>
                            <option >Wet</option>
                            <option >Mini</option>
                            <option >GI</option>
                            <option >Rope</option>
                            <option >Party</option>
                            <option >Other</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label>Form Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('d-m-Y')?>" required  >
                    </div>
                    
                    <div class="col-md-1">
                        <label>To Date</label>
                        <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('d-m-Y')?>" required>
                    </div>

                    <div class="col-md-1" >
                        <label >Oil</label>
                        <select class="form-control" id="inout"  >
                            <option value="">All</option>
                            <option value="IN">Receive</option>
                            <option value="OUT">Despatch</option>
                        </select>
                    </div>

                    <div class="col-md-1" >
                        <label >Size</label>
                        <input type="text"    class="form-control"   id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','diff_id_one_search2')"   />
                        <input type="hidden"  class="goods"   id="goods_" value="<?php if(isset($res2[0]['product_id']))echo $res2[0]['product_id'];?>" style="width:50px"  />
                    </div>


                    <div class="col-md-1" >
                        <label >Dia</label>
                        <input type="text"  class="form-control"   id="dia" >
                    </div>

                    <div class="col-md-1" >
                        <label >Oil</label>
                        <select class="form-control" id="oil"  >
                            <option value="">All</option>
                            <option >Oil</option>
                            <option >Without Oil</option>
                        </select>
                    </div>

                    <div class="col-md-1" >
                        <label >Grade</label>
                        <select class="form-control"  id="grade"  >
                            <option value="">All</option>
                            <?php 
                            foreach($grade as $d){
                            ?>
                                <option value="<?php echo $d['id'];?>" >
                                    <?php echo $d['name'];?>
                                </option>
                            <?php }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-1" >
                        <label >Unit</label>
                        <select class="form-control" id="unit"  >
                            <option value="">All</option>
                            <?php 
                            foreach($unit as $d){
                                if($d['unit_id'] != 1 and $d['unit_id'] != 3){
                                    continue;
                              }
                            ?>
                                <option value="<?php echo $d['unit_id'];?>" >
                                    <?php echo $d['name'];?>
                                </option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="inout_stock_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Stock Receive / Despatch List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('stock/inout/show_table',$res2);?></div>  
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


 
