        
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Customer</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Change Your Password</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                               
                                           
                                            <div class="col-md-12">
                                                <label >Current Password</label>
                                                <input type="password" class="form-control"  name="old_pass" id="old_pass" required  autocomplete="off"  >
                                            </div>

                                            <div class="col-md-12">
                                                <label >New Password (Min 6 digit)</label>
                                                <input type="password" class="form-control"  name="new_pass" id="new_pass" required  autocomplete="off"  >
                                            </div>

                                            <div class="col-md-12">
                                                <label >Re-Entry Password</label>
                                                <input type="password" class="form-control"  name="re_pass" id="re_pass" required  autocomplete="off"  >
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



              
              
    
              
   
            





    

<?php $this->load->view('js/profile_js');?>

