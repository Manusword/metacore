         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
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
                            <select class="form-control" name="supplier" id="supplier"  >
                                <option value="">All</option>
                                <?php 
                                    foreach($supplier as $d)
                                    {
                                        ?>
                                            <option <?php if(9==$d['id']){echo "selected";}?> value="<?php echo $d['id'];?>">
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

                        <div class="col-md-2" >
                            <label >From Rod Stock / issued</label>
                            <select class="form-control"  id="issue"  >
                                <option value="YES">In Rod Stock (not issue)</option>
                                <option value="ALL">All (issued / not issue)</option>
                            </select>
                        </div>
                    
                    
                    
                    
                    <div class="col-md-1">
                        <input type="button" id="po_invoice_rod_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Wire rod List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('po/rod/show_table2',$res2);?></div>  
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



                  <!--  Large Modal -->
                  <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>
                <!--  Modal -->



<script>
    

//----------------------------------get today die history list
function fun_get_cust_details(rodid)
{
	$('.modal-body').html('Loading...');
	var search = 1
	$('.loader').show();
	setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Po/fun_get_get_all_coil_made_by_baseCoil_id_popop_wireRod_list';?>", 
			{
				rodid:rodid,
				search:search,
			}, 
			function(data, textStatus)
			{	
				$('.modal-body').html(data);
				$('.loader').hide();
			});
	 });
	
}//fucntion close 
</script>

<?php $this->load->view('js/po_js');?>


 
