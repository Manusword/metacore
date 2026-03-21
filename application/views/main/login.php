<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f5f6fa;
}

/* WRAPPER */
.login-wrapper{
    min-height:100vh;
    display:flex;
}

/* LEFT PANEL */


.login-left{
    flex:1;
    padding:60px;
    color:#ffffff;
    display:flex;
    flex-direction:column;
    justify-content:center;

    background:
        linear-gradient(rgba(20,43,77,.88), rgba(20,43,77,.88)),
        url('<?php echo base_url("pic/a.jpeg"); ?>');
    background-size:cover;
    background-position:center;
}


.login-left img{
    max-width:160px;
    margin-bottom:20px;
}

.login-left h2{
    font-size:30px;
    font-weight:700;
    margin-bottom:10px;
    color:#ffffff;
}

.company-tagline{
    font-size:15px;
    margin-bottom:25px;
    color:#f1f3f6;
}

/* SERVICES */
.service-list h4{
    font-size:17px;
    margin-bottom:12px;
    font-weight:700;
    color:#ffffff;
}

.service-list ul{
    padding-left:18px;
    font-size:14px;
}

.service-list li{
    margin-bottom:7px;
    color:#f1f3f6;
}

/* FOOTER */
.company-footer{
    margin-top:35px;
    font-size:14px;
    color:#e4e8ef;
}

/* RIGHT PANEL */
.login-right{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
}

.login-box{
    background:#ffffff;
    width:100%;
    max-width:380px;
    padding:40px;
    border-radius:10px;
    box-shadow:0 10px 30px rgba(0,0,0,.1);
    color:#142B4D;
}

.login-box h3{
    font-size:22px;
    font-weight:700;
    margin-bottom:5px;
}

.login-box p{
    font-size:14px;
    color:#6c757d;
}

.auth-logo img{
    max-height:60px;
}

.form-group{
    margin-top:15px;
}

label{
    font-size:14px;
    font-weight:600;
    margin-bottom:5px;
    display:block;
}

.form-control{
    width:100%;
    height:45px;
    border-radius:6px;
    border:1px solid #ccc;
    padding:0 12px;
    font-size:14px;
}

.btn-login{
    width:100%;
    height:45px;
    margin-top:25px;
    background:#142B4D;
    color:#ffffff;
    font-weight:600;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.btn-login:hover{
    background:#0f223d;
}

.error-msg{
    margin-top:10px;
    color:red;
    font-weight:600;
    text-align:center;
}


.login-left img{
    max-width:120px;   /* logo smaller */
    margin-bottom:25px;
}

.brand-line{
    font-size:16px;
    font-weight:600;
    margin-bottom:30px;
    color:#ffffff;
}

.quick-points{
    display:grid;
    grid-template-columns:1fr;
    gap:10px;
    margin-bottom:35px;
    font-size:14px;
}

.quick-points div{
    display:flex;
    align-items:center;
    gap:10px;
    color:#f1f3f6;
}

.quick-points span{
    font-size:16px;
}

.contact-info{
    font-size:14px;
    color:#e4e8ef;
    line-height:1.8;
}

.contact-info div{
    display:flex;
    align-items:center;
    gap:10px;
}



/* MOBILE */
@media(max-width:768px){
    .login-left{
        display:none;
    }
}
</style>


<div class="login-wrapper">

    <!-- LEFT : KEEP CODING -->
    <div class="login-left">

        <!-- LOGO -->
        <img src="<?php echo base_url('pic/keepcoding.png'); ?>" alt="KeepCoding">

        <!-- BRAND -->
        <h2>KeepCoding</h2>
        <div class="brand-line">
            ERP | Software | Website | Digital Marketing | AI
        </div>

        <!-- CORE MESSAGE -->
        <div style="font-size:15px; margin-bottom:25px; color:#f1f3f6;">
            Reliable software solutions designed to manage
            factory operations, people, and processes.
        </div>

        <!-- QUICK POINTS -->
        <div class="quick-points">
            <div><span>✔</span> Digital Marketing, Website & Social Media Setup</div>
            <div><span>✔</span> Company Profile Videos, Training & Process Documentation Videos</div>
            <div><span>✔</span> ERP : HR, Production, Quality, Purchase, Dispatch & Store Maintenance Systems</div>
            <div><span>✔</span> Maintenance, Dispatch & Store Management</div>
            <div><span>✔</span> CRM & Custom Business Software</div>
            <div><span>✔</span> Fully Customized Software</div>
        </div>

        <!-- CONTACT -->
        <div class="contact-info">
            <div>📍 Bhiwadi, Rajasthan</div>
            <div>📞 +91 97999 58768</div>
            <div>✉️ keepcoding2323@gmail.com</div>
            <div>🌐 https://keepcoding.in</div>
        </div>

    </div>



    <!-- RIGHT : LOGIN -->
    <div class="login-right">
        <div class="login-box">

            
            <div class="auth-logo text-center mb-3">
                <img src="<?php if(isset($company[0]['logo'])){ echo base_url($company[0]['logo']); } ?>" alt="">
            </div>
           

            <h3>ERP Login</h3>
            <p>Enter your credentials to continue</p>

            <?php if(isset($msg)){ ?>
                <div class="error-msg"><?php echo $msg; ?></div>
            <?php } ?>

            <form action="<?php echo base_url('index.php/Welcome/login'); ?>" method="post">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-login">Sign In</button>
            </form>

        </div>
    </div>

</div>

