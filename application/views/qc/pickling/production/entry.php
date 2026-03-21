<?php 
  $year = date('Y');
  $month= date('m');
?> 
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Pickling Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" style="color:<?php echo $this->Company->table_bg_color();?>;" >Pickling Entry </div>
                                    <div class="form-row">
                                      
              
         
                                    
                                  <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                  <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                
                                          
                                           <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Pickled Date</label>
                                                <input type="text" class="form-control"    id="entry_date" required  autocomplete="off" value="<?php //if(isset($res2[0]['emp_id']))echo $res2[0]['emp_id'];?>">
                                              </div>
                                            </div>


                                            <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label>Status</label>
                                                  <select class="form-control"  id="rodStatus" onchange="getRod()">
                                                      <option  value="ALL">All</option>
                                                      <option selected value='zero'>Not Issue yet</option>
                                                      <option value='one'>Issued Cold</option>
                                                  </select>
                                              </div>
                                            </div>

                                  
                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Size</label>
                                                  <select class="form-control"  id='size' onchange="getRod()">
                                                      <option value="">Select</option>
                                                      <?php 
                                                        foreach($size as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['finish_size'];?>" ><?php echo $h['finish_size'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Grade</label>
                                                  <select class="form-control"  id="grade" onchange="getRod()">
                                                      <option value="">Select</option>
                                                      <?php 
                                                        foreach($grade as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['product_grade'];?>" ><?php echo $h['gname'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>

                                            


                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Heat No</label>
                                                  <select class="form-control"  id="heat" onchange="getRod()">
                                                      <option value="">All</option>
                                                      <?php 
                                                        foreach($heat as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['heat_no'];?>" ><?php echo $h['heat_no'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Breaking Load Category</label>
                                                  <select class="form-control"  id="blcategory" onchange="getRod()">
                                                      <option value="">All</option>
                                                      <option>1</option>
                                                      <option>2</option>
                                                      <option>3</option>
                                                      <option>4</option>
                                                      <option>5</option>
                                                  </select>
                                              </div>
                                            </div>

                                           
                                         
                                          
                                           





                                            <div class="col-md-12" style="margin-top:20px" >  
                                                 


                                                <div class="col-md-12" style="margin-top:20px" id="dis_output">
                                                   To get coils list please select above filter.
                                                </div> 

                                            </div>   




                                          
                                        
                          
                                      
                                      <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="pickling_coil_test_save" >Pickling Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>

<script>
  
	//-----------All reports search
	function getRod()
	{
		var size=$('#size').val();
		var grade=$('#grade').val();
		var heat=$('#heat').val();
    var blcategory=$('#blcategory').val();
    var rodStatus=$('#rodStatus').val();
    var search1='1';
		$('#wait').show();
    $('#dis_output').html('Please wait...');
    jQuery.post("<?php echo base_url().'index.php/Qc/fun_get_rod_search';?>", 
		{
			size:size,
      grade:grade,
      heat:heat,
			blcategory:blcategory,
			rodStatus:rodStatus,
      search1:search1,
		}, 
		function(data, textStatus)
		{	
			$('#dis_output').html(data);
      $('#wait').hide();
		});
	}//function close

</script>

