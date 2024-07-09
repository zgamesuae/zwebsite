<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
  $sql="select * from cart where user_id='$user_id'";
  $cartCount=$userModel->customQuery($sql);
}else{
    $sid=session_id(); 
    $sql="select * from cart where user_id='$sid'";
  $cartCount=$userModel->customQuery($sql);
}
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
$sql="select * from cms";
$cms=$userModel->customQuery($sql);
$sql1="";
$uri1=$uri2=$uri3="";
if(count(@$uri->getSegments())>0){
  $sql1="select * from seo  ";
  $uri1=@$uri->getSegment(1); 
  $sql1.= " where  segment_1= '$uri1'";
} 
if(count(@$uri->getSegments())>1){
  $uri2=@$uri->getSegment(2); 
  $sql1.= " where  segment_2= '$uri2'";
} 
if(count(@$uri->getSegments())>2){
 $uri3=@$uri->getSegment(3);  
 $sql1.= " where  segment_3= '$uri3'";
} 
if($sql1){
 $seo=$userModel->customQuery($sql1);  
}
?>
<?php
$sql="select * from master_category where     parent_id='0' order by category_name asc";
$master_category=$userModel->customQuery($sql);
?> 
<!DOCTYPE html>
<html>
<head>
  <title><?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?></title>
  <meta charset="utf-8">
  <meta name="theme-color" content="#1f96f4">

  <meta name="description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_name);}?>">
  <meta name="keywords" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_keywords;}else{ echo ucwords($settings[0]->business_name);}?>" >
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
  <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
<!--  <link rel="stylesheet" href="<?php echo base_url();?>/assets/gallery/lightgallery.css">-->
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
  <style>
      .each_products_add_card_list input {
    padding-right: 0 !important;
    width: 43px !important;
    margin: 0 !important;
}
.each_products_add_card_list a {
    margin: 0 !important;
}
.each_products_add_card_list button {
    font-size: 14px !important;
    margin: 0 4px;
}.show_indesktop{display:none;}
       .counter_cart{position:absolute;right:-11px;top:-9px;background:#fff;text-align:center;border-radius:13px;color:#000;padding:0 9px}.menu-a{margin-right:10px}.header_language_option_dropdown{background:0 0;color:#fff}img.header_lenguage_logo{width:20px;height:20px;object-fit:cover;border-radius:100%}</style>
</head>
<body>
    
    
    <div class="add_to_card_popup  show_indesktop" >
  <div class="popup_design_close">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
  </div>
  <div class="card_popup_esign">
    <div class="products_list_gg">
      <div class="card_thumbnailk">
        <img src="" id="cart-img">
      </div>
      <a href="#">
        <h5 id="cart-heading"></h5>
        <p id="cart-para"></p>
      </a>
    </div>
  </div>
  <div class="card_pop_foot">
    <a href="<?php echo base_url();?>/cart"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z"/></svg> view cart</a>
    <a href="<?php echo base_url();?>/checkout">checkout <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"/></svg></a>
  </div>
</div>



  <header class="mobile_header bg-primary container-fluid " style="display: none;">
    <div class="row">
      <div class="col-md-12 bg-primary pt-1 pb-1 top_header_mobile">
        <div class="d-flex mobile_top_header_inner justify-content-between align-items-center">
          <div class="header_top_right m-0">
            <?php if(@$user_id){?>
              <div class="user_acount mr-3">
                <div class="dropdown">
                  <div class="dropdown-toggle"  data-toggle="dropdown">
                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/></svg>
                    <span><?php echo $userDetails[0]->name;?></span>
                    <span class="caret"></span></div>
                    <ul class="dropdown-menu border-0 p-3">
                      <li class="pb-2"><a href="<?php echo base_url();?>/profile/">My Profile</a></li>
                      <li class="pb-2"><a href="<?php echo base_url();?>/profile/changePassword">Change Password</a></li>
                      <li class="pb-2"><a href="<?php echo base_url();?>/logout">Logout</a></li>
                    </ul>
                  </div>
                </div>
              <?php } else { ?>
                    <div class="login" data-toggle="modal" data-target="#jagat-login-modal" >
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 11V8l5 4-5 4v-3H1v-2h9zm-7.542 4h2.124A8.003 8.003 0 0 0 20 12 8 8 0 0 0 4.582 9H2.458C3.732 4.943 7.522 2 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10c-4.478 0-8.268-2.943-9.542-7z"/></svg>
                          <span>login</span>
                      </div>
                      <div class="register" data-toggle="modal" data-target="#jagat-login-modal">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12.684 4.029a8 8 0 1 0 7.287 7.287 7.936 7.936 0 0 0-.603-2.44l1.5-1.502A9.933 9.933 0 0 1 22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2a9.982 9.982 0 0 1 4.626 1.132l-1.501 1.5a7.941 7.941 0 0 0-2.44-.603zM20.485 2.1L21.9 3.515l-9.192 9.192-1.412.003-.002-1.417L20.485 2.1z"/></svg>
                          <span>register</span>
                      </div>
           <?php } ?>
         </div>
         <div class="icon chnage_languages">
          <div class="dropdown">
            <div class="dropdown-toggle header_language_option_dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="<?php echo base_url();?>/assets/img/ae.png" alt=""> EN
            </div>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="<?php echo base_url();?>/ar-ae"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/ae.png" alt=""> Arabic</a>
              <a class="dropdown-item" href="<?php echo base_url();?>"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/images.png" alt=""> English</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12 middle_header_show_sticky">
      <div class="d-flex mobile_middle_header_inner justify-content-between align-items-center">
        <div class="left_column_mobile_view d-flex">
          <div class="icon desktop_hidden_mobile_show" id="menu_optn_mobile">
           <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"></path></svg>
         </div>
         <div class="mobile_wishlist">
          <a href="#">
            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
          </a>
        </div>
      </div>
      <div class="header_logo">
        <a href="#">
          <img src="<?php echo base_url();?>/assets/uploads/fun__1_-removebg-preview-03eb9.png">
        </a>
      </div>
      <div class="mobile_header_cart_icon">
       
        
        
        
        <?php if(@$user_id){?>
 <a class="cart color-white" href="<?php echo base_url();?>/cart" >
          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path></svg>
          <span>
            <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div>
          </span>
        </a>
<?php } else { ?>
 <a class="cart color-white" href="<?php echo base_url();?>/cart"    >
          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path></svg>
          <span>
            <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div>
          </span>
        </a>
<?php } ?>
        
        
        
        
        
        
        
        
      </div>
    </div>
  </div>
  <div class="col-md-12 pb-2" id="search_column_main">
   <div class="search_form">
    <form class="search_form_main m-0"  action="<?php echo base_url();?>/product-list">
     <input type="text" class="form_control" placeholder="I'm looking for" name="keyword" value="<?php echo @$_GET['keyword'];?>">
     <button type="submit" class="submit_btn"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"></path></svg></button>
   </form>
 </div>
</div>
</div>
<div class="col-lg-12 position_unset" id="menu_parent_coumn">
 <div class="navigation_header">
  <div class="navigation_mene" style="display: none;">
   <div class="menui_icon_icon">
    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
  </div>
</div>
<ul class="main_menu">
  <?php  
  if($master_category){
    foreach ($master_category as $key => $value) {
      $sql="select * from master_category where     parent_id='$value->category_id'";
      $cat2=$userModel->customQuery($sql);
      if ($cat2) {
        ?>
        <li>
          <div class="dropdown_m_menu">
            <a class="drop_down_enable" href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a>
            <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
          </div>
          <ul class="drop_drow_menu">
            <div class="drp_menu">
              <ul class="open_menu_mobile_s">
               <?php 
               if($cat2){
                foreach($cat2 as $k2=>$v2){
                 $sql="select * from master_category where     parent_id='$v2->category_id'";
                 $cat3=$userModel->customQuery($sql);
                 if ($cat3) {
                   ?>
                   <li>
                    <div class="dropdown_m_menu remove_after_arrow">
                      <a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>" class="drop_down_enable"  ><span><?php echo  $v2->category_name;?> <label><?php echo count($cat3);?></label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                      <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
                    </div>
                    <ul class="open_menu_mobile_s">
                      <?php 
                      if($cat3){
                        foreach($cat3 as $k3=>$v3){
                          ?>
                          <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v3->category_id;?>"><span><?php echo  $v3->category_name;?>  </span></a></li>
                          <?php 
                        }
                      }
                      ?>
                    </ul>
       <!--     <ul class="open_menu_mobile_s">
                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                <li>
                  <div class="dropdown_m_menu remove_after_arrow">
                    <a class="drop_down_enable" href="#"><span>other <label>310</label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                    <svg  style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
                    </div>
                <ul class="open_menu_mobile_s">
                    <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                    <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                    <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                    <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                    <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                    <li><a href="#"><span>gift finder <label>205</label> </span></a></li>
                </ul>
              </li>
            </ul>-->
          </li>
          <?php
        }else {
         ?>
         <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><span><?php echo  $v2->category_name;?>  </span></a></li>
         <?php
       }
     }
   }
   ?>
 </ul>
</div>
</ul>
</li> 
<?php
}else{
  ?>
  <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a></li>
  <?php
}
?>
<?php 
}
}
?>
</ul>
  <?php /* ?>
  <ul class="main_menu">
      <li>
                    <div class="dropdown_m_menu">
                    <a class="drop_down_enable" href="#">toys</a>
                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
                    </div>
                    <ul class="drop_drow_menu">
                      <div class="drp_menu">
                        <ul>
                          <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                            <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                          <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                          <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                          <li><a href="#"><span>gift finder <label>205</label> </span></a></li>
                          <li><a href="#"><span>other <label>310</label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                            <ul>
                                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                                <li><a href="#"><span>other <label>310</label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                            <ul>
                                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                                <li><a href="#"><span>other <label>310</label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                                <ul>
                                    <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                    <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                    <li><a href="#"><span>Baby Room <label>02</label> </span></a></li>
                                    <li><a href="#"><span>outdoor <label>10</label> </span></a></li>
                                    <li><a href="#"><span>gaming <label>15</label> </span></a></li>
                                    <li><a href="#"><span>gift finder <label>205</label> </span></a></li>
                                </ul>
                              </li>
                            </ul>
                          </li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                    </ul>
                  </li>
    <?php  
    if($master_category){
      foreach ($master_category as $key => $value) {
        $sql="select * from master_category where     parent_id='$value->category_id'";
        $cat2=$userModel->customQuery($sql);
        if ($cat2) {
          ?>
          <li>
            <div class="dropdown_m_menu">
             <a class="drop_down_enable" href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a>
             <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" 
             viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path>
             <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
           </div>
           <ul class="drop_drow_menu">
             <div class="drp_menu">
              <div class="row">
                <?php 
                if($cat2){
                  foreach($cat2 as $k2=>$v2){
                   $sql="select * from master_category where     parent_id='$v2->category_id'";
                   $cat3=$userModel->customQuery($sql);
                   ?>
                   <div class="col-md-12 col-sm-12 mt-3">
                    <div class="dropdown_header">
                     <h6><strong><a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><?php echo  $v2->category_name;?></a></strong></h6>
                   </div>
                   <div class="dropdown_body">
                     <ul>
                       <?php 
                       if($cat3){
                        foreach($cat3 as $k3=>$v3){
                          ?>
                          <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v3->category_id;?>"><?php echo  $v3->category_name;?></a></li>
                        <?php 
                        }
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                <?php
                }
                }
                ?>
              </div>
            </div>
          </ul>
        </li>
        <?php
      }else{  
        ?>
        <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a></li>
        <?php
      }
      ?>
      <?php 
    }
  }
  ?>
</ul>
<?php */ ?>
</div>
<div class="login_mobile_button" style="display: none">
  <a href="#">login</a>
  <a href="#">register</a>
</div>
</div>
</header>
<header class="container-fluid header p-0">
  <div class="top_header">
   <div class="container">
    <div class="row">
    
<div class="col-6">
  <div class="header_top_right">
    <?php if(@$user_id){?>
      <div class="user_acount mr-3">
        <div class="dropdown">
          <div class="dropdown-toggle"  data-toggle="dropdown">
            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/></svg>
            <span><?php echo $userDetails[0]->name;?></span>
            <span class="caret"></span></div>
            <ul class="dropdown-menu border-0 p-3">
              <li class="pb-2"><a href="<?php echo base_url();?>/profile/">My Profile</a></li>
              <li class="pb-2"><a href="<?php echo base_url();?>/profile/changePassword">Change Password</a></li>
              <li class="pb-2"><a href="<?php echo base_url();?>/logout">Logout</a></li>
            </ul>
          </div>
        </div>
        
      <?php } else { ?>
      <div class="login" data-toggle="modal" data-target="#jagat-login-modal" >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10 11V8l5 4-5 4v-3H1v-2h9zm-7.542 4h2.124A8.003 8.003 0 0 0 20 12 8 8 0 0 0 4.582 9H2.458C3.732 4.943 7.522 2 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10c-4.478 0-8.268-2.943-9.542-7z"/></svg>
          <span>login</span>
      </div>
      <div class="register" data-toggle="modal" data-target="#jagat-login-modal">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12.684 4.029a8 8 0 1 0 7.287 7.287 7.936 7.936 0 0 0-.603-2.44l1.5-1.502A9.933 9.933 0 0 1 22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2a9.982 9.982 0 0 1 4.626 1.132l-1.501 1.5a7.941 7.941 0 0 0-2.44-.603zM20.485 2.1L21.9 3.515l-9.192 9.192-1.412.003-.002-1.417L20.485 2.1z"/></svg>
          <span>register</span>
      </div>
       <!--<div class="logout">  <a style="color: #fff;" href="javascript:void(0);"  data-toggle="modal" data-target="#jagat-login-modal" >  
         <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/></svg>
       </a>
     </div>-->
   <?php } ?>
    <!--        
    <?php if(@$user_id){?>
    <a  class="menu-a" href="<?php echo base_url();?>/profile/wishlist" style="fill:#fff;color:#fff"> <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg>
</a>
   <?php } else { ?>
    <a  class="menu-a" href="javascript:void(0);"  data-toggle="modal" data-target="#jagat-login-modal" style="fill:#fff;color:#fff"> <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg>
 </a>
       <?php } ?>
                <?php if(@$user_id){?>
               <a class="cart color-white"  href="<?php echo base_url();?>/cart"    style="color:white;">
                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                <span  > <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div></span>
                <?php } else { ?>
                 <a class="cart color-white"  href="javascript:void(0);"  data-toggle="modal" data-target="#jagat-login-modal"  style="color:white;">
                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                <span  > <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div></span>
              </a>
              <?php } ?>-->
              
            </div>
          </div>
           <div class="col-6 col-6  text-right" id="languages_option_box">
       <div class="dropdown">
        <div class="dropdown-toggle header_language_option_dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?php echo base_url();?>/assets/img/ae.png" alt=""> EN
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="<?php echo base_url();?>/ar-ae"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/ae.png" alt=""> Arabic</a>
          <a class="dropdown-item" href="<?php echo base_url();?>"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/images.png" alt=""> English</a>
        </div>
      </div>
      <!--<div class="languages_option_headder">
       <div class="chnage_languages">
        <div class="icon">
         <img src="<?php echo base_url();?>/assets/img/ae.png" alt="">
       </div>
       <h6>EN</h6>
       <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
     </div>
    <div class="current_language d-flex align-items-center">
      <a href="#"><h6 class="m-0">EN</h6></a>
    </div>
  </div>-->
  <div class="languages_poup">
   <div class="close_header">
    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"></path></svg>
  </div>
</div>
</div>
        </div>
      </div>
    </div>
    <div class="container header_middle">
     <div class="row align-items-center">
      <div class="col-md-3" id="logo_headre_s">
       <div class="left_mobile_side_show">
        <div class="icon desktop_hidden_mobile_show" id="menu_optn_mobile">
         <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z"/></svg>
       </div>
       <div class="icon desktop_hidden_mobile_show chnage_languages">
        <div class="dropdown">
          <div class="dropdown-toggle header_language_option_dropdown" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="<?php echo base_url();?>/assets/img/ae.png" alt=""> EN
          </div>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?php echo base_url();?>/ar-ae"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/ae.png" alt=""> Arabic</a>
            <a class="dropdown-item" href="<?php echo base_url();?>"><img class="header_lenguage_logo" src="<?php echo base_url();?>/assets/img/images.png" alt=""> English</a>
          </div>
        </div>
      </div>
    </div>
    <div class="header_logo">
      <a href="<?php echo base_url();?>"><img  src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>"></a>
    </div>
  </div>
  <div class="col-md-6" id="search_column_main">
   <div class="search_form">
    <form class="search_form_main m-0"  action="<?php echo base_url();?>/product-list">
     <input type="text" class="form_control" placeholder="I'm looking for" name="keyword" value="<?php echo @$_GET['keyword'];?>">
     <button type="submit" class="submit_btn"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z"></path></svg></button>
   </form>
 </div>
</div>
<div class="col-md-3">
  <div class="account_wishlist">
   <?php if(@$user_id){?>
    <a href="<?php echo base_url();?>/profile/wishlist" >
      <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
    </a>
  <?php } else { ?>
   <a href="javascript:void(0);"  data-toggle="modal" data-target="#jagat-login-modal">
    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
<?php } ?>
<?php if(@$user_id){?>
 <a class="cart color-white"  href="<?php echo base_url();?>/cart" >
  <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path></svg>
  <span> <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div></span>
</a>
<?php } else { ?>
 <a class="cart color-white"   href="<?php echo base_url();?>/cart"    >
  <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"></path></svg>
  <span> <div class="counter_cart" id="counter_cart"><?php if($cartCount) echo count($cartCount);else echo 0;?></div></span>
</a>
<?php } ?>
</div>
</div>
</div>
<div class="row justify-content-center">
  <div class="col-lg-12 position_unset" id="menu_parent_coumn">
   <div class="navigation_header">
    <div class="navigation_mene" style="display: none;">
     <div class="menui_icon_icon">
      <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg>
    </div>
  </div>
  <ul class="main_menu">
   <?php  
   if($master_category){
    foreach ($master_category as $key => $value) {
      if($key<=6){
        $sql="select * from master_category where     parent_id='$value->category_id'";
        $cat2=$userModel->customQuery($sql);
        if ($cat2) {
          ?>
          <li>
            <div class="dropdown_m_menu">
              <a class="drop_down_enable" href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a>
              <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
            </div>
            <ul class="drop_drow_menu">
              <div class="drp_menu">
                <ul class="open_menu_mobile_s">
                 <?php 
                 if($cat2){
                  foreach($cat2 as $k2=>$v2){
                   $sql="select * from master_category where     parent_id='$v2->category_id'";
                   $cat3=$userModel->customQuery($sql);
                   if($cat3){
                     ?>
                     <li>
                      <div class="dropdown_m_menu remove_after_arrow">
                        <a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>" class="drop_down_enable"  ><span><?php echo $v2->category_name;?> <label>   <?php echo count($cat3);?>   </label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                        <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
                      </div>
                      <ul class="open_menu_mobile_s">
                        <?php 
                        if($cat3){
                          foreach($cat3 as $k3=>$v3){
                            ?>
                            <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v3->category_id;?>"><span><?php echo  $v3->category_name;?>   </span></a></li>
                            <?php 
                          }
                        }
                        ?>
                      </ul>
                    </li>
                    <?php
                  }else{
                   ?>
                   <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><?php echo $v2->category_name;?></a></li>
                   <?php  
                 }
               }
             }
             ?>
           </ul>
         </div>
       </ul>
     </li> 
     <?php
   }else{  
    ?>
    <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a></li>
    <?php
  }
  ?>
  <?php 
}else if($key==7){
  ?>
  <!--more start -->
  <li>
    <div class="dropdown_m_menu">
      <a class="drop_down_enable" href="javascript:void(0);">More</a>
      <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
    </div>
    <ul class="drop_drow_menu">
      <div class="drp_menu">
        <ul class="open_menu_mobile_s">
         <?php  
         if($master_category){
          foreach ($master_category as $key => $value) {
            if($key>6){
              $sql="select * from master_category where     parent_id='$value->category_id'";
              $cat2=$userModel->customQuery($sql);
              if ($cat2) {
                ?>
                <li>
                  <div class="dropdown_m_menu remove_after_arrow">
                    <a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>" class="drop_down_enable"><span><?php echo $value->category_name;?> <label>   <?php echo count(@$cat2);?>   </label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></a>
                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                  </div>
                  <ul class="open_menu_mobile_s">
                      
                      <?php 
                 if($cat2){
                  foreach($cat2 as $k2=>$v2){
                   $sql="select * from master_category where     parent_id='$v2->category_id'";
                   $cat3=$userModel->customQuery($sql);
                   if($cat3){
                     ?>
                      
                      
                    <!--<li><a href="https://sanjoobtoys.com/product-list?category=test3-1625218036">test3   </a></li>-->
                    <li>
                      <div class="dropdown_m_menu remove_after_arrow">
                        <a class="drop_down_enable" href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><span><?php echo  $v2->category_name;?>  <label><?php echo count(@$cat3);?></label> </span><span class="dropdown_icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"/></svg></span></a>
                        <svg  style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"/></svg>
                      </div>
                      <ul class="open_menu_mobile_s">
                        <?php 
                        if($cat3){
                          foreach($cat3 as $k3=>$v3){
                            ?>
                            <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v3->category_id;?>"><span><?php echo  $v3->category_name;?>   </span></a></li>
                            <?php 
                          }
                        }
                        ?>
                        
                        
                      </ul>
                    </li> 
                      <?php
                  }else{
                   ?>
                   <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><span><?php echo $v2->category_name;?></span></a></li>
                   <?php  
                 }
               }
             }
             ?>
                    
                  </ul>
                </li>
                <?php
              }else{  
                ?>
                <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a></li>
                <?php  
              }
            }
          }
        }
        ?>
      </ul>
    </div>
  </ul>
</li>
<!--more end-->
<?php
}
}
}
?>
</ul>
  <?php /* ?>
  <ul class="main_menu">
    <?php  
    if($master_category){
      foreach ($master_category as $key => $value) {
        $sql="select * from master_category where     parent_id='$value->category_id'";
        $cat2=$userModel->customQuery($sql);
        if ($cat2) {
          ?>
          <li>
            <div class="dropdown_m_menu">
             <a class="drop_down_enable" href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a>
             <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" 
             viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path>
             <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
           </div>
           <ul class="drop_drow_menu">
             <div class="drp_menu">
              <div class="row">
                <?php 
                if($cat2){
                  foreach($cat2 as $k2=>$v2){
                   $sql="select * from master_category where     parent_id='$v2->category_id'";
                   $cat3=$userModel->customQuery($sql);
                   ?>
                   <div class="col-md-12 col-sm-12 mt-3">
                    <div class="dropdown_header">
                     <h6><strong><a href="<?php echo base_url();?>/product-list?category=<?php echo $v2->category_id;?>"><?php echo  $v2->category_name;?></a></strong></h6>
                   </div>
                   <div class="dropdown_body">
                     <ul>
                       <?php 
                       if($cat3){
                        foreach($cat3 as $k3=>$v3){
                          ?>
                          <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $v3->category_id;?>"><?php echo  $v3->category_name;?></a></li>
                        <?php 
                        }
                        }
                        ?>
                      </ul>
                    </div>
                  </div>
                <?php
                }
                }
                ?>
              </div>
            </div>
          </ul>
        </li>
        <?php
      }else{  
        ?>
        <li><a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>"><?php echo $value->category_name;?></a></li>
        <?php
      }
      ?>
      <?php 
    }
  }
  ?>
</ul>
<?php */ ?>
</div>
<div class="login_mobile_button" style="display: none">
  <a href="#">login</a>
  <a href="#">register</a>
</div>
</div>
</div>
</div>
</header>
<div class="header_blanck_spoaCE"></div>
<!--
<div class="container-fluid">
    <div class="owl-carousel header_bottom_slider">
      <div class="item">
        <a href="#">
            <img src="https://cdn.toysrusmena.com/storefront/tru/usp-shipping.svg">
            <span>FREE shipping for orders 100 AED and over</span>
        </a>
      </div>
      <div class="item">
          <a href="#">
                <img src="https://cdn.toysrusmena.com/storefront/tru/usp-offer.svg" >
                <span>10% when you create an account</span>
            </a>
      </div>
      <div class="item">
        <a href="#">
            <img src="https://cdn.toysrusmena.com/storefront/tru/usp-return.svg" >
            <span>FREE 30-day returns</span>
        </a>
      </div>
    </div>
</div>
-->

<!--#########################################################-->
<!--jagat new signup design start-->
<div class="modal fade" id="jagat-login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="model_eader " style="    z-index: 1;">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
  </div>
  <div  class="modal-body" >
   
      <div class="  bg-white">
        <ul class="nav nav-tabs checkout_nav">
            <li class="nav-item">
              <a id="loginTab" class="nav-link active" data-toggle="tab" href="#login_tab">login </a>
            </li>
            <li class="nav-item">
              <a  id="signupTab" class="nav-link " data-toggle="tab" href="#ergsiter_fisrt">register</a>
            </li>
           <!-- <li class="nav-item">
              <a class="nav-link " data-toggle="tab" href="#guest_user">guest</a>
            </li>-->
          </ul>
          <div class="tab-content p-4">
            <div class="tab-pane active" id="login_tab">
              <div class="headding text-center text-capitalize">
                <h6 class="font-weight-bold">login using social account</h6>
              </div>
              <div class="social_media_login">
                <a href="#">
                  <div class="icon">
                    <img src="<?php echo base_url();?>/assets/uploads/fb.png" alt="">
                    <span>Facebook</span>
                  </div>
                </a>
                <a href="#">
                  <div class="icon">
                    <img src="<?php echo base_url();?>/assets/uploads/google.png" alt="">
                    <span>Google</span>
                  </div>
                </a>
              </div>
              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- or using email --</h6>
              </div>
          <form id="buyer_login_form" class="row  " method="POST" action="<?php echo base_url();?>/auth/LoginValidation" autocomplete="off">
                  <div class="col-md-12 mt-2">
                
                  <div id="buyer_login_form_message"></div>
     </div>
                
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Email</label>
                  <div class="password_parent_field" >
                 
                  <input name="email" required type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Email">
                  </div>
                </div>
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Password</label>
                  <div class="password_parent_field" >
                  <div class="eye_password" data_val="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                  </div>
                  <input name="password"  required type="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Password">
                  </div>
                </div>
              
                <div class="col-12 mt-2">
                  <button class="btn btn-primary w-100 p-2 text-capitalize mt-2">Login</button>
                </div>
              </form>
              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- or login with otp --</h6>
              </div>
              <form>
                <div class="mt-3 d-flex justify-content-between border border-weight-2 rounded position-relative">
                  <select class=" border-0 w-100 p-2" style="width: 82px !important">
                    <option>+971</option>
                  </select>
                  <label class="label_top m-0" style="left: 14%;">Mobile</label>
                <input type="number" class=" w-100 border-0  p-2" placeholder="0000 0000 0000">
                <button class="btn btn-primary text-capitalize p-2">Submit</button>
                </div>
              </form>
              <hr>
              <div class="d-flex text-capitalize justify-content-between font-weight-bold">
                <a href="#">Forgotten Password</a>
                <a href="javascript:void(0);"  onclick="document.getElementById('signupTab').click()" >Create an Account</a>
              </div>
            </div>
            <div class="tab-pane" id="ergsiter_fisrt">
              <div class="headding text-center text-capitalize">
                <h6 class="font-weight-bold">login using social account</h6>
              </div>
              <div class="social_media_login">
                <a href="#">
                  <div class="icon">
                    <img src="<?php echo base_url();?>/assets/uploads/fb.png" alt="">
                    <span>Facebook</span>
                  </div>
                </a>
                <a href="#">
                  <div class="icon">
                    <img src="<?php echo base_url();?>/assets/uploads/google.png" alt="">
                    <span>Google</span>
                  </div>
                </a>
              </div>
              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- or using email --</h6>
              </div>
              <form id="buyer_signup_form" class="row  " method="POST" action="<?php echo base_url();?>/auth/registration" autocomplete="off">
                    <div class="col-md-12 mt-2">
                    <div id="buyer_signup_message"></div>
                  </div>
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Name</label>
                  <input name="name" required type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter name">
                </div>
               
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">Email</label>
                  <input type="email" required name="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter email">
                </div>
                <div class="col-md-6 mt-2">
                  <label class="font-weight-bold">Phone</label>
                  <div class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                      <select class=" border-0 w-100 p-2" style="width: 82px !important">
                        <option>+971</option>
                      </select>
                      <input type="number" required class=" w-100 border-0  p-2" placeholder="Enter phone no.">
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">Password</label>
                  <div class="password_parent_field" >
                  <div class="eye_password" data_val="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                  </div>
                  <input type="password" required name="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter password">
                  </div>
                </div>
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">Confirm Password</label>
                  <div class="password_parent_field" >
                  <div class="eye_password" data_val="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                  </div>
                  <input type="password" required name="confirm_pass" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter confirm password">
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <label class="m-0 font-weight-bold text-gray">
                    <input type="checkbox"  required >
                    I have read and agree to the <a class="text-dark" href="<?php echo base_url();?>/privacy-and-policy">Privacy Policy</a></label>
                </div>
                <div class="col-12 mt-2">
                  <button class="btn btn-primary w-100 p-2 text-capitalize">Register</button>
                </div>
              </form>

              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold"> - Already Registered User? Click here  <a href="javascript:void(0);" onclick="document.getElementById('loginTab').click()"><b>Click here</b></a> to login   </h6>
              </div>
            <!--  <form class="row">
                <div class="col-12 mt-2">
                  <a class="btn btn-primary w-100 p-2 text-capitalize">login</a>
                </div>
              </form>-->
              
            </div>
            <div class="tab-pane" id="guest_user">
              <div class="mt-3 headding text-center text-capitalize">
                <h5 class="font-weight-bold">checkout as a guest</h5>
              </div>
              <form class="row">
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">First Name</label>
                  <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder=" ">
                </div>
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">Last Name</label>
                  <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="">
                </div>
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Email</label>
                  <input type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="">
                </div>
                <div class="col-md-12 mt-2">
                  <label class="font-weight-bold">Mobile</label>
                  <div class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                      <select class=" border-0 w-100 p-2" style="width: 82px !important">
                        <option>+971</option>
                      </select>
                      <input type="number" class=" w-100 border-0  p-2" placeholder="0000 0000 0000">
                    </div>
                </div>
                <div class="col-12 mt-2">
                  <button class="btn btn-primary w-100 p-2 text-capitalize">continue</button>
                </div>
              </form>

              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- already have a account --</h6>
              </div>
              <form class="row">
                <div class="col-12 mt-2">
                  <a class="btn btn-primary w-100 p-2 text-capitalize">login</a>
                </div>
              </form>
              
           
      </div>
    </div>
  </div>
</div>
 
   </div>
 </div>
</div>
<!--jagat new signup design end-->