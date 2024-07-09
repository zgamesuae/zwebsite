 
<link rel='stylesheet' href='https://icodefy.com/Tools/iZoom/css/zoom.css'>
<style>
    /*! fancyBox v2.1.5 fancyapps.com | fancyapps.com/fancybox/#license */.fancybox-image,.fancybox-inner,.fancybox-nav,.fancybox-nav span,.fancybox-outer,.fancybox-skin,.fancybox-tmp,.fancybox-wrap,.fancybox-wrap iframe,.fancybox-wrap object{padding:0;margin:0;border:0;outline:0;vertical-align:top}.fancybox-wrap{position:absolute;top:0;left:0;transform:translate3d(0,0,0);z-index:8020}.fancybox-skin{position:relative;background:#f9f9f9;color:#444;text-shadow:none;border-radius:4px}.fancybox-opened{z-index:8030}.fancybox-opened .fancybox-skin{box-shadow:0 10px 25px rgba(0,0,0,.5)}.fancybox-inner,.fancybox-outer{position:relative}.fancybox-inner{overflow:hidden}.fancybox-type-iframe .fancybox-inner{-webkit-overflow-scrolling:touch}.fancybox-error{color:#444;font:14px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;margin:0;padding:15px;white-space:nowrap}.fancybox-iframe,.fancybox-image{display:block;width:100%;height:100%}.fancybox-image{max-width:100%;max-height:100%}#fancybox-loading,.fancybox-close,.fancybox-next span,.fancybox-prev span{background-image:url(fancybox_sprite.png)}#fancybox-loading{position:fixed;top:50%;left:50%;margin-top:-22px;margin-left:-22px;background-position:0 -108px;opacity:.8;cursor:pointer;z-index:8060}#fancybox-loading div{width:44px;height:44px;background:url(fancybox_loading.gif) center center no-repeat}.fancybox-close{position:absolute;top:-18px;right:-18px;width:36px;height:36px;cursor:pointer;z-index:8040}.fancybox-nav{position:absolute;top:0;width:40%;height:100%;cursor:pointer;text-decoration:none;background:transparent url(blank.gif);-webkit-tap-highlight-color:transparent;z-index:8040}.fancybox-prev{left:0}.fancybox-next{right:0}.fancybox-nav span{position:absolute;top:50%;width:36px;height:34px;margin-top:-18px;cursor:pointer;z-index:8040;visibility:hidden}.fancybox-prev span{left:10px;background-position:0 -36px}.fancybox-next span{right:10px;background-position:0 -72px}.fancybox-nav:hover span{visibility:visible}.fancybox-tmp{position:absolute;top:-99999px;left:-99999px;max-width:99999px;max-height:99999px;overflow:visible!important}.fancybox-lock{overflow:visible!important;width:auto}.fancybox-lock body{overflow:hidden!important}.fancybox-lock-test{overflow-y:hidden!important}.fancybox-overlay{position:absolute;top:0;left:0;overflow:hidden;display:none;z-index:8010;background:rgba(0,0,0,.5)}.fancybox-overlay-fixed{position:fixed;bottom:0;right:0}.fancybox-lock .fancybox-overlay{overflow:auto;overflow-y:scroll}.fancybox-title{visibility:hidden;font:normal 13px/20px "Helvetica Neue",Helvetica,Arial,sans-serif;position:relative;text-shadow:none;z-index:8050}.fancybox-opened .fancybox-title{visibility:visible}.fancybox-title-float-wrap{position:absolute;bottom:0;right:50%;margin-bottom:-35px;z-index:8050;text-align:center}.fancybox-title-float-wrap .child{display:inline-block;margin-right:-100%;padding:2px 20px;background:0 0;background:rgba(0,0,0,.8);border-radius:15px;text-shadow:0 1px 2px #222;color:#fff;font-weight:700;line-height:24px;white-space:nowrap}.fancybox-title-outside-wrap{position:relative;margin-top:10px;color:#fff}.fancybox-title-inside-wrap{padding-top:10px}.fancybox-title-over-wrap{position:absolute;bottom:0;left:0;color:#fff;padding:10px;background:#000;background:rgba(0,0,0,.8)}@media only screen and (-webkit-min-device-pixel-ratio:1.5),only screen and (min--moz-device-pixel-ratio:1.5),only screen and (min-device-pixel-ratio:1.5){#fancybox-loading,.fancybox-close,.fancybox-next span,.fancybox-prev span{background-image:url(https://fancyapps.com/fancybox/source/fancybox_sprite.png);background-size:44px 152px}#fancybox-loading div{background-image:url(https://fancyapps.com/fancybox/source/fancybox_loading@2x.gif);background-size:24px 24px}}.gallery-viewer{margin-top:30px!important;margin-bottom:0!important}
    .gallery-viewer img{
        width: 500px !important;
        height: 500px !important;
 
    }
    #gallery_pdp img{
         width: 100%; 
    }
    #gallery_pdp  {
        height: 500px !important;
    }
    
    
    .wrapper a img {
    width: 100%;
    }
    
  .zoomContainer {
    cursor: unset !important;
} 

.header .lead {
  max-width: 620px;
}

.inline-gallery-container {
  width: 100%;
  height: 450px;
  position: relative;
}

</style>

<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
}
?>
<style>
.review_toggle{
  cursor: pointer;
}
</style>
<div class="container breadcrumbs_nav">
  <ul>
    <li><a href="<?php echo base_url();?>">Home </a><span>/ </span> </li>
    <li><a href="<?php echo base_url();?>">Product </a><span>/ </span> </li>
    <li><?php echo @$products[0]->name;?></li>
  </ul>
</div>
<div class="container pt-2  padding_unset_none pb-4">
  <div class="row pt-3 padding_unset_none">
    <div class="col-md-7">
      <div class="gallery_products">
          
    
          
          
          <div class="pdp-image-gallery-block">
		<!-- Gallery -->
		<div class="gallery_pdp_container">
			<div id="gallery_pdp">
			    
			    
			    	<div style="cursor: pointer;"   onClick="ShowYoutube('aqz-KE-bpKQ')">
					<img id="" src="<?php echo base_url();?>/assets/uploads/play.jpg" />
				</div>
			     
			 
			     <?php 
          if($product_image){
            foreach($product_image as $k=>$v){ 
              ?>
			    
				<a href="#"  data-image="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"  onClick="hideYoutube()" >
					<img id="" src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" />
				</a>
				
				
				  <?php
            }
          }else{
            ?>
              
				<a href="#" data-image="<?php echo base_url();?>/assets/uploads/noimg.png"  >
					<img id="" src="<?php echo base_url();?>/assets/uploads/noimg.png" />
				</a>
            
            
          <?php
            }
            ?>
				
				
			</div>
		 
			<a href="#" id="ui-carousel-next" style="display: inline;"></a>
			<a href="#" id="ui-carousel-prev" style="display: inline;"></a>
		</div>
	 
		<div class="gallery-viewer galleryDIv">
			<img id="zoom_10" src="<?php echo base_url();?>/assets/uploads/<?php echo $product_image[0]->image;?>"
			data-zoom-image="<?php echo base_url();?>/assets/uploads/<?php echo $product_image[0]->image;?>" href="<?php echo base_url();?>/assets/uploads/<?php echo $product_image[0]->image;?>" />
		</div>
		<div class="gallery-viewer youtubeDiv" style="display:none;width: 500px;
    height: 500px;"  >
		 <iframe id="youtubeIfram" style="width:100%;height:100%"  src="https://www.youtube.com/embed/aqz-KE-bpKQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  
		</div>
		
	</div>
          
          
          
          
          
          
           
        </div>
      </div>
      <div class="col-md-5 pt-3">
        <div class="products_details">
<!--          <label class="label_begde_single_products"><?php echo @$brands[0]->title;?></label>
          <div class="category_name">
            <h6 class="text-dark"><?php echo $master_category[0]->category_name;?></h6>
          </div>-->
          <div class="mb-3 products_title">
            <h4><?php echo @$products[0]->name;?></h4>
           <!-- <div class="product_rank_str">
              <?php 
              for($i=1;$i<=5;$i++)
              {
                if($i<=@$pro_over_rating){
                  ?>
                  <img src="<?= base_url() ?>/assets/img/star.png" alt="star" class="w10">
                  <?php
                }else {
                  ?>
                  <img src="<?= base_url() ?>/assets/img/star-disable.png" alt="star" class="w10">
                  <?php
                }
              }
              ?>
            </div>-->
          </div>
          <div class="brand pt-2 pb-2 d-flex align-items-center"><h6 class="m-0"><strong>Brand:</strong></h6><span class="pl-2">Gizmovine Remote </span></div>
          <div class="pricing-card mt-2"><div class="card-subtitle"><span>3599<span>AED</span></span></div>
            <div class="d-flex align-items-center">
                <p class="offer-price card-text d-flex m-0">2699<span>AED</span>  </p>
                <div class="badge-discount ml-2">25% off</div>
            </div>
            </div>
            
            <div class="product-option-message">
                <div class="option-check d-flex justify-content-between">
                    <label class="checkbox light-green d-flex " for="installation-checkbox">
                        <input id="installation-checkbox" type="checkbox">
                        <span class="checkmark" style="background-image:url(<?= base_url() ?>/assets/img/assable.PNG)"></span>
                        <span class="checklabel option-installation">Add professional assembly</span>
                    </label>
                    <span class="checkcount">Free</span>
                </div>
            </div>
            
            <form class="products_add_to_cart">
                <div class="product_qty">
                    <input type="number" value="1" >
                </div>
                <button class="btn btn-primary">Add To Cart</button>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
                </a>
            </form>
                
                <div class="specification">
                    <div class="icon">
                        <img src="<?= base_url() ?>/assets/img/icon1.PNG">
                        <span>Suitable for age 3 years +</span>
                    </div>
                    <div class="icon">
                        <img src="<?= base_url() ?>/assets/img/icon2.PNG">
                        <span>Home delivery available</span>
                    </div>
                </div>
                
             <!--   <div class="product-tags"><h5> Recommended for</h5><ul class="tag-list"><li><span>Independent Play</span></li><li><span>Active Play</span></li></ul></div>
                -->
                <div class="share_products d-flex">
                    <h5>share</h5>
                    <ul>
                        <li><a href="#"><img src="<?= base_url() ?>/assets/img/facebook.svg" alt=""></a></li>
                        <li><a href="#"><img src="<?= base_url() ?>/assets/img/twitter.svg" alt=""></a></li>
                        <li><a href="#"><img src="<?= base_url() ?>/assets/img/pinterest.svg" alt=""></a></li>
                        <li><a href="#"><img src="<?= base_url() ?>/assets/img/email.svg" alt=""></a></li>
                    </ul>
                </div>
                
        <!--  <div class="">
            <div class="products_price mt-4 mb-4 d-flex align-items-center">
              <?php 
              if(@$products[0]->discount_percentage > 0){
                ?>
                <h4 class="m-0"><strong><?php echo number_format(@$products[0]->price-(@$products[0]->price*@$products[0]->discount_percentage)/100);?> AED</strong></h4>
                <span class="text-sm ml-3"><del><?php echo number_format(@$products[0]->price);?> AED</del></span>
                <?php
              }else{
                ?>
                <h4 class="m-0"><strong><?php echo number_format(@$products[0]->price);?> AED</strong></h4>
                <?php
              }
              ?>
            </div>
            <div class="mobile_d_flex_check ">
              <?php 
              if($session->get('userLoggedin')){
                ?>
                <div class="d-flex justify-content-center">
                <form class="buy-now-form w-100"   action="<?php echo base_url();?>/page/buyNowSubmitForm" method="POST">
                  <input type="hidden" id="product_id" value="<?php echo $products[0]->product_id; ?>" name="product_id">
                  <div class="bg-light rounded p-2 cart_single_page">
                    <div id="qtty_form">
                      <div class="quanitity_div_parent car_header_update_qtyt">
                        <div class="quantitynumber">
                          <span class="minus" onclick="decreaseValue()">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                          </span>
                          <input  type="number" id="number" name="quantity" class="form-control btn btn-black kborder-o hoverqrt_button-dark shadow-sm bg-white text-dark cartInput"
                          value="1" min="1" max="<?php echo $products[0]->available_stock; ?>">
                          <span class="plus" onclick="increaseValue()">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z">
                            </path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mobile_check_is d-flex mt-3 align-items-center ">
                    <button class="btn btn-black w-100  " name="addToCart" value="yes" type="submit">add to bag</button>
                  </div>
                </form>
                <form class="addWishlist  pb-2" style="    margin-top: 11%;"  action="<?php echo base_url();?>/page/addWishtlist" method="POST">
                  <input type="hidden" id="product_id" value="<?php echo $products[0]->product_id; ?>" name="product_id">
                  <div class="mobile_check_is d-flex mt-3 align-items-center  " s>
                    <button class="icon " name="addToWhishlist" value="yes" type="submit" style="background: unset;border: unset;">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
                    </button>
                  </div>
                </form>
                </div>
                <?php
              }else {
                ?>
                <div class="bg-light rounded p-2 cart_single_page w-100">
                  <div id="qtty_form">
                    <div class="quanitity_div_parent car_header_update_qtyt">
                      <div class="quantitynumber">
                        <span class="minus">
                          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                        </span><input class="form-control" type="number" name="qty" value="1">
                        <span class="plus">
                          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="mobile_check_is d-flex mt-3 align-items-center">
                  <a class="btn btn-black w-100  "  href="javascript:void(0);"  data-toggle="modal" data-target="#buyer_login_modal">add to bag</a>
                  <a class="icon ml-3" href="javascript:void(0);"  data-toggle="modal" data-target="#buyer_login_modal"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
                  </a>
                </div>
                <?php
              }
              ?>
            </div>
          </div>-->
        </div>
      </div>
    </div>
    
    <div class="row mt-5 desktop_single_products_data">
        <div class="col-md-12">
           <ul class="nav nav-tabs checkout_nav">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#home">Description </a>
            </li>
            <li class="nav-item">
              <a class="nav-link " data-toggle="tab" href="#menu1">features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " data-toggle="tab" href="#menu2">review</a>
            </li>
          </ul>  
            <div class="tab-content pt-2">
                <div class="tab-pane active" id="home">
                    <ul class="pl-3 text-capitalize">
                        <li class="pb-2"><span class="mr-3"><strong>Brand</strong></span><span> : <?php echo @$brands[0]->title;?></span></li>
                        <li class="pb-2"><span class="mr-3"><strong>Suitable For</strong></span><span>  : <?php echo @$suitable_for[0]->title;?></span></li>
                        <li class="pb-2"><span class="mr-3"><strong>Age</strong></span><span>  : <?php echo @$age[0]->title;?> <?php echo @$age[0]->description;?></span></li>
                        <li class="pb-2"><span class="mr-3"><strong>Color</strong></span><span>  : <?php echo @$color[0]->title;?></span></li>
                    </ul>
                    <p><?php echo @$products[0]->description;?></p>
                </div>
                <div class="tab-pane fade" id="menu1">
                    <p><?php echo @$products[0]->features;?></p>
                </div>
                <div class="tab-pane fade" id="menu2">
                     <div class="pt-2 " id="comments">
                          <h4><strong><?php if($review) echo count(@$review);?> Comments</strong></h4>
                          <!-- comment-->
                          <?php
                          if($review){
                            foreach($review as $k=>$v){ 
                              $uid=$v->user_id;
                              $sql="select * from users where user_id='$uid'";
                              $udata=$userModel->customQuery($sql);
                              ?>
                              <div class="d-flex align-items-start py-4 border-bottom">
                                <img class="rounded-circle user_image_revirewe" src="<?= base_url() ?>/assets/uploads/<?php if($udata[0]->image) echo $udata[0]->image;else echo 'noimg.png';?>" width="50" alt="Laura Willson">
                                <div class="ps-3">
                                  <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fs-md mb-0"><?php echo $udata[0]->name;?></h6> 
                                  </div>
                                  <div class="star_review">
                                    <div class="star d-block w-100 text-left">
                                      <?php 
                                      for($i=1;$i<=5;$i++)
                                      {
                                        if($i<=$v->rating){
                                          ?>
                                          <img src="<?= base_url() ?>/assets/img/star.png" alt="star" class="w10">
                                          <?php
                                        }else {
                                          ?>
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png" alt="star" class="w10">
                                          <?php
                                        }
                                      }
                                      ?>
                                    </div>
                                  </div>
                                  <p class="fs-md mb-1">
                                    <?php echo $v->comment;?>
                                    </p><span class="fs-ms text-muted"><i class="ci-time align-middle me-2"></i><?php echo date("M d , Y ", strtotime($v->created_at));?>
                                  </span>
                                  <!-- comment reply-->
                                </div>
                              </div>
                              <?php 
                            }
                          }
                          ?>
                          <!-- Post comment form-->
                          <div class="card border-0 shadow mt-2 mb-4" id="review">
                            <div class="card-body">
                              <div class="d-flex align-items-start">
                                <img class="rounded-circle user_image_revirewe" src="<?= base_url() ?>/assets/uploads/<?php if($userDetails[0]->image) echo $userDetails[0]->image;else echo 'noimg.png';?>" width="50"  >
                                <form class="w-100 needs-validation ms-3" novalidate="" method="post">
                                  <?php
                                  if(@$flashData['error']){
                                    ?>
                                    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                      </button>
                                      <?php echo @$flashData['error'];?>
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
                                      <?php echo @$flashData['success'];?>
                                    </div>
                                    <?php  
                                  }
                                  ?>
                                  <input type="hidden" id="product_id" value="<?php echo $products[0]->product_id; ?>" name="product_id">
                                  <h6><strong>Rate this Product</strong></h6>
                                  <div class="mb-3 d-flex">
                                    <div class="rating_radio_parent rating_1" data_raview="1" data-toggle="tooltip" title="" data-original-title="Bad">
                                      <label for="1star_rating" class="radion_child">
                                        <input type="radio" value="1" name="rating" id="1star_rating">
                                        <div class="lebl_con">
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png">
                                        </div>
                                      </label>
                                    </div>
                                    <div class="rating_radio_parent rating_2" data_raview="2" data-toggle="tooltip" title="" data-original-title="Ok">
                                      <label for="2star_rating" class="radion_child">
                                        <input type="radio" value="2" name="rating" id="2star_rating">
                                        <div class="lebl_con">
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png">
                                        </div>
                                      </label>
                                    </div>
                                    <div class="rating_radio_parent rating_3" data_raview="3" data-toggle="tooltip" title="" data-original-title="Good">
                                      <label for="3star_rating" class="radion_child">
                                        <input type="radio" value="3" name="rating" id="3star_rating">
                                        <div class="lebl_con">
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png">
                                        </div>
                                      </label>
                                    </div>
                                    <div class="rating_radio_parent rating_4" data_raview="4" data-toggle="tooltip" title="" data-original-title="Very Good ">
                                      <label for="4star_rating" class="radion_child">
                                        <input type="radio" value="4" name="rating" id="4star_rating">
                                        <div class="lebl_con">
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png">
                                        </div>
                                      </label>
                                    </div>
                                    <div class="rating_radio_parent rating_5" data_raview="5" data-toggle="tooltip" title="" data-original-title="Excellent">
                                      <label for="5star_rating" class="radion_child">
                                        <input type="radio" name="rating" value="5" id="5star_rating">
                                        <div class="lebl_con">
                                          <img src="<?= base_url() ?>/assets/img/star-disable.png">
                                        </div>
                                      </label>
                                    </div>
                                  </div>
                                  <div class="mb-3">
                                    <textarea class="form-control" rows="4" placeholder="Write comment..." required="" name="comment"></textarea>
                                    <div class="invalid-feedback">Please write your comment.</div>
                                  </div>
                                  <?php 
                                  if($user_id){
                                    ?>
                                    <button class="btn btn-primary " type="submit">Post comment</button>
                                    <?php
                                  }else{
                                    ?>
                                    <a class="btn btn-primary "  href="javascript:void(0);"  data-toggle="modal" data-target="#buyer_login_modal">Post comment</a>
                                    <?php 
                                  }
                                  ?>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                </div>
            </div>
        </div>
        
        </div>
    </div>
    
    <div class="row mt-5 mobile_view_review_tabs_toggle d-none">
      <div class="col-md-12 mb-2">
           <div class="title_products_page">
          <h4><strong>Description</strong> <div class="toggle_button"></div> </h4>
          <hr>
          <div class="body_data_open">
            <ul class="pl-3 text-capitalize">
                <li class="pb-2"><span class="mr-3"><strong>Brand</strong></span><span> : <?php echo @$brands[0]->title;?></span></li>
                <li class="pb-2"><span class="mr-3"><strong>Suitable For</strong></span><span>  : <?php echo @$suitable_for[0]->title;?></span></li>
                <li class="pb-2"><span class="mr-3"><strong>Age</strong></span><span>  : <?php echo @$age[0]->title;?> <?php echo @$age[0]->description;?></span></li>
                <li class="pb-2"><span class="mr-3"><strong>Color</strong></span><span>  : <?php echo @$color[0]->title;?></span></li>
            </ul>
            <p><?php echo @$products[0]->description;?></p>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="title_products_page">
          <h4><strong>Features</strong> <div class="toggle_button"></div> </h4>
          <hr>
          <div class="body_data_open">
            <p>
              <?php echo @$products[0]->features;?>
            </p>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="title_products_page bg_review_background">
          <h4 class="d-flex justify-content-between review_toggle"><strong>Product reviews</strong> <div class="toggle_button review_toggle_button"></div> </h4>
          <hr>
          <div class="body_data_open" style="display:<?php if(@$flashData['error']) echo 'block';else if(@$flashData['success']) echo 'block';else echo 'none';?>" >
            <div class="pt-2 " id="comments">
              <h4><strong><?php if($review) echo count(@$review);?> Comments</strong></h4>
              <!-- comment-->
              <?php
              if($review){
                foreach($review as $k=>$v){ 
                  $uid=$v->user_id;
                  $sql="select * from users where user_id='$uid'";
                  $udata=$userModel->customQuery($sql);
                  ?>
                  <div class="d-flex align-items-start py-4 border-bottom">
                    <img class="rounded-circle user_image_revirewe" src="<?= base_url() ?>/assets/uploads/<?php if($udata[0]->image) echo $udata[0]->image;else echo 'noimg.png';?>" width="50" alt="Laura Willson">
                    <div class="ps-3">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fs-md mb-0"><?php echo $udata[0]->name;?></h6> 
                      </div>
                      <div class="star_review">
                        <div class="star d-block w-100 text-left">
                          <?php 
                          for($i=1;$i<=5;$i++)
                          {
                            if($i<=$v->rating){
                              ?>
                              <img src="<?= base_url() ?>/assets/img/star.png" alt="star" class="w10">
                              <?php
                            }else {
                              ?>
                              <img src="<?= base_url() ?>/assets/img/star-disable.png" alt="star" class="w10">
                              <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                      <p class="fs-md mb-1">
                        <?php echo $v->comment;?>
                        </p><span class="fs-ms text-muted"><i class="ci-time align-middle me-2"></i><?php echo date("M d , Y ", strtotime($v->created_at));?>
                      </span>
                      <!-- comment reply-->
                    </div>
                  </div>
                  <?php 
                }
              }
              ?>
              <!-- Post comment form-->
              <div class="card border-0 shadow mt-2 mb-4" id="review">
                <div class="card-body">
                  <div class="d-flex align-items-start">
                    <img class="rounded-circle user_image_revirewe" src="<?= base_url() ?>/assets/uploads/<?php if($userDetails[0]->image) echo $userDetails[0]->image;else echo 'noimg.png';?>" width="50"  >
                    <form class="w-100 needs-validation ms-3" novalidate="" method="post">
                      <?php
                      if(@$flashData['error']){
                        ?>
                        <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                          <?php echo @$flashData['error'];?>
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
                          <?php echo @$flashData['success'];?>
                        </div>
                        <?php  
                      }
                      ?>
                      <input type="hidden" id="product_id" value="<?php echo $products[0]->product_id; ?>" name="product_id">
                      <h6><strong>Rate this Product</strong></h6>
                      <div class="mb-3 d-flex">
                        <div class="rating_radio_parent rating_1" data_raview="1" data-toggle="tooltip" title="" data-original-title="Bad">
                          <label for="1star_rating" class="radion_child">
                            <input type="radio" value="1" name="rating" id="1star_rating">
                            <div class="lebl_con">
                              <img src="<?= base_url() ?>/assets/img/star-disable.png">
                            </div>
                          </label>
                        </div>
                        <div class="rating_radio_parent rating_2" data_raview="2" data-toggle="tooltip" title="" data-original-title="Ok">
                          <label for="2star_rating" class="radion_child">
                            <input type="radio" value="2" name="rating" id="2star_rating">
                            <div class="lebl_con">
                              <img src="<?= base_url() ?>/assets/img/star-disable.png">
                            </div>
                          </label>
                        </div>
                        <div class="rating_radio_parent rating_3" data_raview="3" data-toggle="tooltip" title="" data-original-title="Good">
                          <label for="3star_rating" class="radion_child">
                            <input type="radio" value="3" name="rating" id="3star_rating">
                            <div class="lebl_con">
                              <img src="<?= base_url() ?>/assets/img/star-disable.png">
                            </div>
                          </label>
                        </div>
                        <div class="rating_radio_parent rating_4" data_raview="4" data-toggle="tooltip" title="" data-original-title="Very Good ">
                          <label for="4star_rating" class="radion_child">
                            <input type="radio" value="4" name="rating" id="4star_rating">
                            <div class="lebl_con">
                              <img src="<?= base_url() ?>/assets/img/star-disable.png">
                            </div>
                          </label>
                        </div>
                        <div class="rating_radio_parent rating_5" data_raview="5" data-toggle="tooltip" title="" data-original-title="Excellent">
                          <label for="5star_rating" class="radion_child">
                            <input type="radio" name="rating" value="5" id="5star_rating">
                            <div class="lebl_con">
                              <img src="<?= base_url() ?>/assets/img/star-disable.png">
                            </div>
                          </label>
                        </div>
                      </div>
                      <div class="mb-3">
                        <textarea class="form-control" rows="4" placeholder="Write comment..." required="" name="comment"></textarea>
                        <div class="invalid-feedback">Please write your comment.</div>
                      </div>
                      <?php 
                      if($user_id){
                        ?>
                        <button class="btn btn-primary " type="submit">Post comment</button>
                        <?php
                      }else{
                        ?>
                        <a class="btn btn-primary "  href="javascript:void(0);"  data-toggle="modal" data-target="#buyer_login_modal">Post comment</a>
                        <?php 
                      }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      </div>
      <div class="container pb-5">
      <div class="row">
          <div class="col-md-12 mt-5">
        <h5><strong>Similar Sets</strong></h5>
      </div>
      <div class="col-12 mt-3">
        <div class="owl-carousel owl-theme simlilar_products_dedsktop">
          <?php if(@$sproducts)
          {
            foreach(@$sproducts as $k=>$v){
              $pid=$v->product_id;
              $sql="select * from product_image where     product='$pid' and status='Active' ";
              $product_image=$userModel->customQuery($sql);   
              ?>
              <div class="item">
                  <div class="product_box shadow-none bg-white rounded overflow-hidden">
              <a href="https://sanjoobtoys.com/product/gizmovine-remote-control-boa-1624519449">
                <div class="product_box_image">
                    <div class="product_label_offer">24% off</div>
                   <img src="https://sanjoobtoys.com/assets/uploads/71dbCSbc6tS._SS1000_.jpg" class="border-0">
              
    
                  
              
                 
              
                </div>
              </a>
              <div class="product_box_content">
                <h5><strong><a href="https://sanjoobtoys.com/product/gizmovine-remote-control-boa-1624519449">Gizmovine Remote Control Boats For Pools</a></strong></h5>
                <div class="pricing-card"><div class="card-subtitle"><span>3599<span>AED</span></span></div><p class="offer-price card-text">2699<span>AED</span></p></div>
                <div class="d-none products_price text-small text-primary font-weight-bold">
                 
                                   2,554                  <span class="curreny">AED</span>
                  <del class="text-gray">2,838 AED</del>
                  
                                  </div>
                <form class="products_add_to_cart">
                    <button class="btn btn-primary">Add To Cart</button>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
                    </a>
                </form>
              </div>
            </div>
                <!--<div class="product_box shadow-sm bg-white rounded overflow-hidden">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                      <?php 
                      $file_name = $product_image[0]->image;
                      $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                      if($extension=="mp4"){
                        ?>
                        <video   controls>
                          <source src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" type="video/mp4"> 
                          </video>         
                          <?php 
                        }else{
                          ?>
                          <img src="<?php echo base_url();?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png';?>" class="border-0"  >
                          <?php 
                        }
                        ?>
                      </div>
                    </a>
                    <div class="product_box_content">
                      <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo @$v->name;?></a></strong></h5>
                      <?php 
                      if($v->discount_percentage > 0 ){
                        ?>
                        <?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?>
                        <span class="curreny">AED</span>
                        <del class="text-gray"><?php echo number_format($v->price);?> AED</del>
                      <?php } else {
                        ?>
                        <?php echo number_format($v->price) ;?>
                        <span class="curreny">AED</span>
                        <?php
                      }?>
                      <div class="product_rank_str">
                        <img src="<?php echo base_url();?>/assets/img/star.png" alt="star" class="w10">
                        <img src="<?php echo base_url();?>/assets/img/star.png" alt="star" class="w10">
                        <img src="<?php echo base_url();?>/assets/img/star.png" alt="star" class="w10">
                        <img src="<?php echo base_url();?>/assets/img/star.png" alt="star" class="w10">
                        <img src="<?php echo base_url();?>/assets/img/star-disable.png" alt="star" class="w10">
                      </div>
                    </div>
                  </div>-->
                </div>
              <?php }} ?>
            </div>
          </div>
        </div>
      </div>
        </div>
      
  <!--    <div class="fixed_mobile_optin" style="display: none;">
        <div class="icon">
          <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M6.5 2h11a1 1 0 0 1 .8.4L21 6v15a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6l2.7-3.6a1 1 0 0 1 .8-.4zM19 8H5v12h14V8zm-.5-2L17 4H7L5.5 6h13zM9 10v2a3 3 0 0 0 6 0v-2h2v2a5 5 0 0 1-10 0v-2h2z"/></svg>
        </div>
        <div class="add_to_cart">add to cart</div>
        <div class="price">AED 200.00</div>
      </div>
-->
      <script>
        function increaseValue() {
          var value = parseInt(document.getElementById('number').value, 10);
          value = isNaN(value) ? 0 : value;
          value++;
          document.getElementById('number').value = value;
        }
        function decreaseValue() {
          var value = parseInt(document.getElementById('number').value, 10);
          value = isNaN(value) ? 0 : value;
          value < 1 ? value = 1 : '';
          value--;
          document.getElementById('number').value = value;
        }
      </script>

 




 