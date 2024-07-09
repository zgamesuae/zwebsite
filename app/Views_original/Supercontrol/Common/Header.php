<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$admin_id=$session->get('adminLoggedin');  
$sql="select * from admin where admin_id='$admin_id' ";
$adminDetail=$userModel->customQuery($sql);
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
?>
<?php 
 //   Access Start
    // Checking access user Start ################
$addFlag=0; 
$editFlag=0; 
$deleteFlag=0;
$uri1=$uri2=$uri3="";
if(count(@$uri->getSegments())>1){
  $uri1=@$uri->getSegment(2); 
} 
if(count(@$uri->getSegments())>2){
  $uri2=@$uri->getSegment(3); 
} 
if(count(@$uri->getSegments())>3){
 $uri3=@$uri->getSegment(4);  
} 
if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$userModel->customQuery($sql); 
          if(@$access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
          }
        }
      }
    }
  }
}else{
  header('Location: '.site_url('supercontrol/Login'));
}
// Checking Access user END##############
    // Access END
if($uri1=="Home" ||  $uri1=="home" ){
}else{
  if($viewFlag==0){
   echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
 }
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
 <meta name="description" content="<?php echo ucwords($settings[0]->business_description);?>">
 <meta name="keywords" content="<?php echo ucwords($settings[0]->business_description);?>">
 <title> <?php echo ucwords(@$uri->getSegment(2));   ?> | <?php echo ucwords($settings[0]->business_name);?></title>
 <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">
 <!-- BEGIN: Vendor CSS-->
 
  
 

 
 
 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/vendors.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/weather-icons/climacons.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/fonts/meteocons/style.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/charts/morris.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/charts/chartist.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/vendors/css/charts/chartist-plugin-tooltip.css">
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
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/fonts/simple-line-icons/style.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/core/colors/palette-gradient.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/pages/timeline.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/pages/dashboard-ecommerce.min.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/back_end_custom_css.css">
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/css/supercontrol_yahia_css.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

 <!-- Extra libraries for jquery UI -->
 <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>/grocery-crud/css/jquery-ui/jquery-ui.css">
 <link type="text/css" rel="stylesheet" href="<?php echo base_url()?>/grocery-crud/css/grocery-crud-v2.8.8.10b14e1.css">
 <!--<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>-->
  <script src="<?php echo base_url()?>/assets/js/ckeditor/ckeditor.js"></script>

 <!-- END: Page CSS-->
 <!-- BEGIN: Custom CSS-->
 <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/admin-assets/css/style.css">
 <!-- END: Custom CSS-->
 
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"> 
 <link rel="stylesheet" type="text/css" href="//at.alicdn.com/t/font_o5hd5vvqpoqiwwmi.css">
 <link href="https://cdn.jsdelivr.net/npm/ficons@1.1.52/dist/ficons/font.css" rel="stylesheet">


 
 <?php 
 if(@$css_files){
  foreach($css_files as $file){ ?>
   <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
   <?php 
 }
}
?>
<style>.alert-success{background-color:#00c17c!important;color:#fff!important}.header-navbar{line-height:64px;box-shadow:0 6px 20px 0 rgb(255 110 64 / 50%)!important;background:linear-gradient(45deg ,#ec1c24,#ffd42b)!important;height:64px}.navbar-semi-dark .navbar-header{background:#ed1c24;box-shadow:0 4px 7px 0 rgb(0 0 0 / 20%)}.header-navbar .navbar-container ul.nav li a.dropdown-user-link .user-name{color:#fff}.navigation>li.active{background-color:transparent}.navigation-main{padding-top:10px!important}.main-menu.menu-dark .navigation>li.active>a{box-shadow:0 6px 20px 0 rgb(255 110 64 / 50%)!important;background:linear-gradient(45deg ,#8e24aa,#ff6e40)!important;box-shadow:0 2px 2px 0 rgb(0 0 0 / 14%),0 3px 1px -2px rgb(0 0 0 / 12%),0 1px 5px 0 rgb(0 0 0 / 20%);color:#fff;margin:0!important;background:-webkit-linear-gradient(45deg ,#8e24aa,#ff6e40);background:linear-gradient(45deg ,#8e24aa,#ff6e40);box-shadow:3px 3px 20px 0 rgb(255 110 64 / 50%)}.card-body{box-shadow:0 6px 20px 0 rgb(97 50 35 / 50%)!important}.main-menu.menu-dark.expanded .navigation>li.active>a{margin:0!important;border-radius:unset!important}.header-navbar .navbar-header .navbar-brand .brand-logo{max-height:50px;width:unset}body.vertical-layout.vertical-menu-modern.menu-collapsed .main-menu .navigation>li>a i:before{font-size:1.6rem}.main-menu.menu-dark .navigation .navigation-header{padding:12px 30px 12px 18px}
</style>
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
 <!-- BEGIN: Header-->
 <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
  <div class="navbar-wrapper">
   <div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
     <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="la la-bars font-large-1"></i></a></li>
     <li class="nav-item mr-auto"><a class="navbar-brand" href="<?php echo base_url();?>/supercontrol">
      <img class="brand-logo" alt="modern admin logo" src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
    </a></li>
  <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3 white" data-ticon="ft-toggle-right"></i></a></li>
      <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a></li>
    </ul>
  </div>
  <div class="navbar-container content">
   <div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="nav navbar-nav mr-auto float-left">
     <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
   </ul>
   <ul class="nav navbar-nav float-right">
         
                <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <span class="mr-1 user-name text-bold-700"><?php echo $adminDetail[0]->name;?></span><span class="avatar avatar-online">
                   <img src="<?php echo base_url();?>/assets/uploads/<?php if($adminDetail[0]->image) echo $adminDetail[0]->image;else echo 'usr.png';?>" > </span></a>
                   <div class="dropdown-menu dropdown-menu-right">
                     <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#editProfile"><i class="la la-edit"></i> Edit Profile</a>
                     <a class="dropdown-item" href=""><i class="ft ft-check-square"></i> Change password</a>
                     <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo base_url();?>/supercontrol/login/logout"><i class="la la-sign-out"></i> Logout</a>
                   </div>
                 </li>
               </ul>
             </div>
           </div>
         </div>
       </nav>
       <!-- END: Header-->
       <!-- BEGIN: Main Menu-->
       <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="main-menu-content">
         <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="<?php if($uri->getSegment(2) =='Home' || $uri->getSegment(2) =='home') echo 'active';?>"><a href="<?php echo base_url();?>/supercontrol/home"><i class="la la-home"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
          </li>
          <li  ><a href="<?php echo base_url();?>" target="_blank"><i class="la la-sign-out"></i><span class="menu-title" data-i18n="Go to site">Go to site</span></a>
          </li>
          <li class=" navigation-header"><span data-i18n="MAIN NAVIGATION">MAIN NAVIGATION</span>  
          </li>
          
          
        
          
          
          
          
          
          
          
          <?php
          $sflag=0;
          $sql="select * from menu where  status='Active' and parent_id=0 order by title asc ";
          $menu=$userModel->customQuery($sql); 
          if ($menu) { 
           foreach ($menu as $k => $v) {
                // 
            $sql="select * from access_group_master where  admin_id='$admin_id' ";
            $access_group_master=$userModel->customQuery($sql); 
            if($access_group_master){
             foreach($access_group_master as $k1=>$v1) {
              $group_id=$v1->group_id;
              $sql="select * from groups_assigned where  group_id='$group_id' ";
              $groups_assigned=$userModel->customQuery($sql); 
              if($groups_assigned){
               foreach($groups_assigned as $k2=>$v2){ 
                $access_modules_id=$v2->access_modules_id;
                $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
                $access_modules=$userModel->customQuery($sql); 
                if(@$access_modules[0]->segment_1==$v->link) { $sflag=1;
                
                
                 $sql="select * from menu where  status='Active' and parent_id=$v->id ";
          $submenu=$userModel->customQuery($sql); 
                if($submenu){
                    ?>
                      
          <li class="nav-item has-sub <?php if($uri->getSegment(2) == $v->link) echo ' active open '; ?>"><a href="#"><i class="la la-<?php echo $v->icon; ?>"></i><span class="menu-title" data-i18n="<?php echo $v->title; ?>"><?php echo $v->title; ?></span></a>
            <ul class="menu-content">
            
            <?php foreach($submenu as $sk=>$sv) { ?>
              <li><a class="menu-item" href="<?php echo base_url(); ?>/<?php echo $uri->getSegment(1);?>/<?php echo $sv->link;?>"><i></i><span data-i18n="<?php echo $sv->title;?>"><?php echo $sv->title;?></span></a>
              </li>
             <?php } ?>
            </ul>
          </li>
          
                    
                    <?php
                }else{
                    ?>
                      <li class=" nav-item <?php if($uri->getSegment(2) == $v->link) echo 'active'; ?>" ><a href="<?php echo base_url(); ?>/<?php echo $uri->getSegment(1);?>/<?php echo $v->link; ?>"><i class="la la-<?php echo $v->icon; ?>"></i><span class="menu-title" data-i18n="<?php echo $v->title; ?>"><?php echo $v->title; ?></span></a>
                 </li>
                    <?php
                }
                
                        // 
                
                 break;
               }
             }
           }
         }
       } 
     }
   }
   if($sflag==0){
     ?>
     <li class=" navigation-header"><span data-i18n="Available MENU">MENU not available for you!</span>  
     </li>
     <?php
   }
   ?> 
 </ul>
</div>
</div>
<!-- END: Main Menu-->
<div class="modal fade text-left" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel1">Edit Profile</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>  
      <form class="form" method="post" action="<?php echo base_url();?>/supercontrol/Home/UpdateProfile" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-body">
            <div class="form-group">
              <label for="userinput5">Name</label>
              <input class="form-control border-primary" type="text" placeholder="Name"   required name="name"  value="<?php echo @$adminDetail[0]->name;?>">
            </div>
            <div class="form-group">
              <label for="userinput6">Email</label>
              <input class="form-control border-primary" type="email" placeholder="Email"    name="email"  required value="<?php echo @$adminDetail[0]->email;?>">
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input class="form-control border-primary"   type="tel" placeholder="Phone"  name="phone"  required value="<?php echo @$adminDetail[0]->phone;?>">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="projectinput3">Image</label>
                  <input onchange="document.getElementById('jagat-img').src = window.URL.createObjectURL(this.files[0])" type="file" id="projectinput3" class="form-control"   name="file">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="projectinput4">Preview</label><br>
                  <img src="<?php echo base_url();?>/assets/uploads/<?php if($adminDetail[0]->image) echo $adminDetail[0]->image;else echo 'usr.png';?>" id="jagat-img" width="50" height="50" >
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">     Close</button>
          <button type="submit" class="btn btn-primary">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</div>