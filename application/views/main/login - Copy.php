<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
    
?>


<div class="auth-layout-wrap" style="background-image: url(<?php echo base_url();?>dist-assets/images/photo-wide-4.jpg);">
    <div class="auth-content" align="center">
        <div class="card o-hidden"  style="width:300px;">
            <div class="row">
                <div class="col-md-12">
                    <div class="p-4">
                        <div class="auth-logo text-center mb-4"><img src="<?php echo base_url(); if(isset($company[0]['details3'])){echo $company[0]['details3'];}?>" alt=""></div>
                        <h1 class="mb-3 text-18" style="color:#E61722">Sign In</h1>
						<h1 class="mb-3 text-18" style="color:red;font-weight:bold"><?php if(isset($msg)){echo $msg;}?></h1>
                        <form  action="<?php echo base_url();?>index.php/Welcome/login" method="post">
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control form-control-rounded" id="email" name="username" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input class="form-control form-control-rounded" id="password" name="password" type="password">
                            </div>
                            <button class="btn btn-rounded btn-danger btn-block mt-2">Sign In</button>
                        </form>
                        <div class="mt-3 text-center">
							<!--<a class="text-muted" href="forgot.html">
									<u>Forgot Password?</u>
							</a>-->
						</div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>

