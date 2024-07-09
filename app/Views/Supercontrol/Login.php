<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
 
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
 

?>



<!DOCTYPE html>
 
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
 
  
  <title>Login | <?php  echo ucwords($settings[0]->business_name);?></title>

 <meta charset="utf-8">
 <meta name="description" content="<?php  echo ucwords($settings[0]->business_name);?>">
 <meta name="keywords" content="<?php  echo ucwords($settings[0]->business_name);?>" >
  
   <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
 <link href="<?php echo base_url();?>/admin-assets/css.css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
 <!-- BEGIN: Vendor CSS-->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/vendors.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/forms/icheck/icheck.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/forms/icheck/custom.css">
 <!-- END: Vendor CSS-->
 <!-- BEGIN: Theme CSS-->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/bootstrap-extended.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/colors.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/components.min.css">
 <!-- END: Theme CSS-->
 <!-- BEGIN: Page CSS-->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/core/menu/menu-types/vertical-menu-modern.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/core/colors/palette-gradient.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/pages/login-register.min.css">
 <!-- END: Page CSS-->
 <!-- BEGIN: Custom CSS-->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/<?php echo base_url();?>/admin-assets/css/style.css">
 <!-- END: Custom CSS-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 <style>.alert-success {
    background-color: #00d488!important;
    color: #fff !important;
}

.jagat-login-btn{
   box-shadow: 0 6px 20px 0 rgb(97 50 35 / 50%) !important;
    color: #fff;
    background-color: #ed1c24;
    border-color: #ef353c;
}
.jagat-login-text{
    font-weight: 600;
    font-size: 16px;
    color: #1a262b;
    text-transform: uppercase!important;
    
    
    letter-spacing: 1px;
}
body {
    
    font-family: 'Poppins', sans-serif!important;
    font-size: 14px!important;
     
    letter-spacing: 1px!important;
}
.mt-10{
    margin-top:10px;
}
</style>
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 1-column  bg-full-screen-image blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" 
style="background: url(<?php echo base_url();?>/admin-assets/images/backgrounds/flat-bg.jpg) center center no-repeat fixed;
    background-size: cover;">
 <!-- BEGIN: Content-->
 <div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
   <div class="content-header row">
   </div>
   <div class="content-body"><section class="row flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
     <div class="col-lg-4 col-md-8 col-10 box-shadow-2 p-0">
      <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
       <div class="card-header border-0 pb-0">
        <div class="card-title text-center">
         <img style="width:200px;" src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
        </div>
        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2 jagat-login-text"><span>Admin Login</span></h6>
       </div>
       <div class="card-content">
     
       
        <div class="card-body">
            <?php
            if(@$flashData['error']){
              ?>
                   <div class="alert alert-danger alert-dismissible mb-2" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<strong>Oh snap!</strong>  <?php echo @$flashData['error'];?>
						</div>
              <?php  
            }
            ?>
             <?php
            if(@$flashData['success']){
              ?>
            <div class="alert alert-success alert-dismissible mb-2" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							<strong>Well done!</strong> <?php echo @$flashData['success'];?>
						</div>
            
            		 
              <?php  
            }
            ?>
       
            
            
         <form class="form-horizontal" method="post"  >
         
          <fieldset class="form-group position-relative has-icon-left">
           <input type="email" class="form-control" id="user-email" placeholder="Your Email Address" required="" name="email">
           <div class="form-control-position">
            <i class="fa fa-envelope"></i>
           </div>
            <small class="text-danger error"><?= isset($validation) ?  $validation['email'] :null ; ?></small>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left">
           <input type="password" class="form-control" id="user-password" placeholder="Enter Password" required="" name="password">
           <div class="form-control-position">
            <i class="fa fa-key"></i>
           </div>
            <small class="text-danger error"><?= isset($validation) ?  $validation['password'] :null ; ?></small>
          </fieldset>
          
          <button type="submit" class="btn btn-outline-info btn-block jagat-login-btn"><i class="fa fa-sign-in "></i> Login</button>
         </form>
        </div>
       
       </div>
       <div class="card-footer border-0 mt-10">
          <p class="float-sm-left text-center"><a href="login-simple.html" class="card-link">Go to Home</a></p>
          <p class="float-sm-right text-center">   <a href="register-simple.html" class="card-link">Forgot Password?</a></p>
        </div>
      </div>
     </div>
    </div>
   </section>
  </div>
 </div>
</div>
<!-- END: Content-->
<!-- BEGIN: Vendor JS-->
<script src="<?php echo base_url();?>/admin-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="<?php echo base_url();?>/admin-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="<?php echo base_url();?>/admin-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo base_url();?>/admin-assets/js/core/app-menu.min.js"></script>
<script src="<?php echo base_url();?>/admin-assets/js/core/app.min.js"></script>
<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<script src="<?php echo base_url();?>/admin-assets/js/scripts/forms/form-login-register.min.js"></script>
<!-- END: Page JS-->
</body>
<!-- END: Body-->
</html>