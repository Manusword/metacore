   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                        <?php 
                        if(empty($qc_test1_id)){
                        ?>
                              <div class="col-md-1">
                                    <label>Link</label>
                                    <select class="form-control" id="link" >
                                          <option >Yes</option>
                                          <option >No</option>
                                    </select>
                              </div>

                              <div class="col-md-1">
                                    <label>Type</label>
                                    <select class="form-control" id="type" >
                                          <option value="Simi">After Patt</option>
                                          <option value="Rod">Before Patt</option>
                                    </select>
                              </div>

                              <div class="col-md-1">
                                    <label>Finish Size</label>
                                    <input type="text" class="form-control" id="fsize"  >
                              </div>

                              <div class="col-md-1">
                                    <label>From Date</label>
                                    <input type="text" class="form-control" id="search_date1" value="<?php echo date('01-m-Y');?>"   >
                              </div>
                                    
                              <div class="col-md-1">
                                    <label>To Date</label>
                                    <input type="text" class="form-control" id="search_date2"   value="<?php echo date('t-m-Y');?>"   >
                              </div>

                              <div class="col-md-1">
                              <input type="button" id="track_finish_coil" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Get Data" >
                              </div>
                        <?php }?>
                         
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                  <div >
                            
                              
                        <div id="table_show" >
                              <?php 
                                    if($type == "Simi"){
                                          $simi_base_rod = $this->Qcmodel->get_wet_mini_prod_lotno_from_id($qc_test1_id);
                                          // Step 1: Group by lotno
                                          $grouped = [];
                                          foreach ($simi_base_rod as $row) {
                                                $grouped[$row['lotno']][] = $row;
                                          }

                                          // Step 2: Render
                                          foreach ($grouped as $lotno => $records) {
                                                $lotname = $this->Base->get_all_lotno_with_id($lotno);
                                                echo "<h5>Finish Coil in Lotno: <span style='color:red'>".$lotname[0]['name']."</span></h5>";
                                                echo $this->Qcmodel->finish_coil_list($records);
                                                //print_r($records);
                                                
                                                $baseCoillist = $this->Qcmodel->get_baseCoilId_from_lotno($lotno,$records[0]['actual_size']);
                                                //print_r($baseCoillist);
                                                
                                                echo "<h5 style='margin-top:100px'>Simi Base Coil List</h5>";
                                                $this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoillist);
                                                
                                                // Extract unique baseCoilId values
                                                $baseCoilIds = array_unique(array_column($baseCoillist, 'baseCoilId'));
                                                echo "<h5 style='margin-top:100px'>Wire Rod List</h5>";
                                                $this->Qcmodel->get_baseCoilID_from_finishid_html_table($baseCoilIds);
                                                      
                                          }//foreach
                                    }else{
                                          $baseCoil = $this->Qcmodel->get_baseCoilId_from_id($qc_test1_id);
                                          //print_r($baseCoil);
                                          $this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoil);

                                          // Extract unique baseCoilId values
                                          $baseCoilIds = array_unique(array_column($baseCoil, 'baseCoilId'));
                                          echo "<h5 style='margin-top:100px'>Wire Rod List</h5>";
                                          $this->Qcmodel->get_baseCoilID_from_finishid_html_table($baseCoilIds);
                                          
                                    }//else
                              ?>
                        </div>  
                                 
                        
                  </div>           
                           
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/qc_js');?>

                
