<style>
.slider_center_four_items_s .owl-stage {
    margin: auto;
}
.category_new_home_page_Design img {
    border-radius: 4px;
    width: 100%;
    object-fit: cover;
    object-position: center;
}
body.page-home {
    background: #171717;
}
</style>
<?php
$userModel = model('App\Models\UserModel', false);
$session = session();
@$user_id=$session->get('userLoggedin'); 
$sql="select * from cms";
$cms=$userModel->customQuery($sql);
$sql="select * from color where status='Active' AND show_in_home_page='Yes'";
$color=$userModel->customQuery($sql);
$sql="select * from banner where status='Active'";
$banner=$userModel->customQuery($sql);
$sql="select * from blog where status='Active' order by created_at desc";
$blog=$userModel->customQuery($sql);
$sql="select * from mobile_banner where status='Active'";
$mobile_banner=$userModel->customQuery($sql);
$sql="select * from offer_banner where status='Active'";
$offer_banner=$userModel->customQuery($sql);



$sql="select * from brand where status='Active'";
$brand=$userModel->customQuery($sql);


$sql="select * from home_slider where status='Active' AND type='left'";
$left=$userModel->customQuery($sql);


$sql="select * from home_slider where status='Active' AND type='right'";
$right=$userModel->customQuery($sql);



/*$sql="select * from products
inner join master_category on products.category=master_category.category_id
where products.status='Active' AND products.show_this_product_in_home_page='Yes' order by products.created_at desc limit 20";
$products=$userModel->customQuery($sql);*/

$sql="select * from products where status='Active' AND show_this_product_in_home_page='Yes' AND discount_percentage>0 order by created_at desc limit 20";
$offer_products=$userModel->customQuery($sql);



 $cdate=date("Y-m-d");
  $sql="select * from products
  inner join trending_products on products.product_id=trending_products.product
  
  where       '$cdate' between trending_products.start_date  AND trending_products.end_date 
  AND products.status='Active'
   AND trending_products.status='Active'
  order by products.precedence asc limit 20";
$trending_products=$userModel->customQuery($sql);






 $sql="select *     from products 
 where products.status='Active' AND show_this_product_in_home_page='Yes' ";
 if ($id1="accessories-1635772036") {
  $sql2="select * from master_category where parent_id='$id1'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
    //  $sql=$sql." AND (";
    $sql=$sql."   AND  FIND_IN_SET('$id1', products.category)      OR ( "; 
    foreach($mcat as $km=>$mv){
     $scats=$mv->category_id;
     $sql2="select * from master_category where parent_id='$scats'";
     $ssmcat=$userModel->customQuery($sql2); 
     if($ssmcat){
       foreach($ssmcat as $sbk=>$sbv){
        $lcat2=$sbv->category_id;
        if($sbk==count($ssmcat)-1){
          $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
        }else{
          $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
        }
      }
    }else{
      $lcat=$mv->category_id;
      if($km==count($mcat)-1){
        $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
      }else{
        $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR ";     
      }
    }
  }
  $sql=$sql."   ) ";
}else{
  $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
 $sql=$sql."order by created_at desc limit 20";
  $accessories=$userModel->customQuery($sql); 
  
  
  
  
  
  
  
  
  
  
  
  
 $sql="select *     from products 
 where products.status='Active' AND show_this_product_in_home_page='Yes' ";
 if ($id1="accessories-1635772036") {
  $sql2="select * from master_category where parent_id='$id1'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
    //  $sql=$sql." AND (";
    $sql=$sql."   AND  !FIND_IN_SET('$id1', products.category)      AND ( "; 
    foreach($mcat as $km=>$mv){
     $scats=$mv->category_id;
     $sql2="select * from master_category where parent_id='$scats'";
     $ssmcat=$userModel->customQuery($sql2); 
     if($ssmcat){
       foreach($ssmcat as $sbk=>$sbv){
        $lcat2=$sbv->category_id;
        if($sbk==count($ssmcat)-1){
          $sql=$sql."    !FIND_IN_SET('$lcat2', products.category)      ";   
        }else{
          $sql=$sql."    !FIND_IN_SET('$lcat2', products.category)    AND ";     
        }
      }
    }else{
      $lcat=$mv->category_id;
      if($km==count($mcat)-1){
        $sql=$sql."  !FIND_IN_SET('$lcat', products.category)         ";   
      }else{
        $sql=$sql."  !FIND_IN_SET('$lcat', products.category)      AND ";     
      }
    }
  }
  $sql=$sql."   ) ";
}else{
  $sql=$sql."   AND    !FIND_IN_SET('$id1', products.category)  ";    
}
}
 $sql=$sql."order by created_at desc limit 20";
  
  $products=$userModel->customQuery($sql); 
?>

<div id="myCarousel" class="home_slider_boostrap carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
   
   <?php if($banner){ 
   foreach($banner as $k=>$v){?>
    <li data-target="#myCarousel" data-slide-to="<?php echo $k;?>" class="<?php if($k==0) echo 'active';?>"></li> 
    <?php }} ?>
  </ol>
  <div class="carousel-inner">
        <?php if($banner){ 
   foreach($banner as $k=>$v){?>
      
    <div class="carousel-item <?php if($k==0) echo 'active';?>">
      <div class="container-fluid p-0" id="banner_slider">

      <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="w-100 desltop_s_banner_home_sldier"  >
      <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" class="w-100 mobile_banner_home_sldier" style="display: none;" >
             <div class="container" id="banner_overlay_text">
        <div class="row">
          <div class="col-md-6">
            <div class="banner_text_content">
              <h1><?php echo $v->title;?></h1>
              <div><?php echo $v->description;?></div>
              <div class="banner_button">
                <a href="<?php echo $v->link;?>" class="btn btn-primary">Buy Now</a>
                <!--<a href="<?php echo base_url();?>/product-list" class="btn btn-default">Live demo</a>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <?php }} ?>
   <a class="home_slider_indictes carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
    <span>‹</span>
  </a>
  <a class="home_slider_indictes carousel-control-next" href="#myCarousel" role="button" data-slide="next">
    <span>›</span>
  </a>
   
</div>
</div>

<div class="container pt-3">
    <div class="row">
        <div class="col-12">
            <div class="owl-carousel owl-theme slider_center_four_items_s">
                <div class="item">
                    <div class="category_new_home_page_Design ">
                        <div class="service_box">
                        <a href="http://192.168.2.177/cizgames/product-list?genre=2">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter.png" alt="">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter-8dc85.jpg" alt="" class="mobile_image" style="display: none;">
                            <div class="box_overlay_content">
                            <!-- <img src="http://192.168.2.177/cizgames/assets/uploads/box2.svg" alt="">-->
                            <h6>Shooter <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category_new_home_page_Design ">
                        <div class="service_box">
                        <a href="http://192.168.2.177/cizgames/product-list?genre=2">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter.png" alt="">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter-8dc85.jpg" alt="" class="mobile_image" style="display: none;">
                            <div class="box_overlay_content">
                            <!-- <img src="http://192.168.2.177/cizgames/assets/uploads/box2.svg" alt="">-->
                            <h6>Shooter <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category_new_home_page_Design ">
                        <div class="service_box">
                        <a href="http://192.168.2.177/cizgames/product-list?genre=2">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter.png" alt="">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter-8dc85.jpg" alt="" class="mobile_image" style="display: none;">
                            <div class="box_overlay_content">
                            <!-- <img src="http://192.168.2.177/cizgames/assets/uploads/box2.svg" alt="">-->
                            <h6>Shooter <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category_new_home_page_Design ">
                        <div class="service_box">
                        <a href="http://192.168.2.177/cizgames/product-list?genre=2">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter.png" alt="">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter-8dc85.jpg" alt="" class="mobile_image" style="display: none;">
                            <div class="box_overlay_content">
                            <!-- <img src="http://192.168.2.177/cizgames/assets/uploads/box2.svg" alt="">-->
                            <h6>Shooter <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="category_new_home_page_Design ">
                        <div class="service_box">
                        <a href="http://192.168.2.177/cizgames/product-list?genre=2">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter.png" alt="">
                            <img src="http://192.168.2.177/cizgames/assets/uploads/Shooter-8dc85.jpg" alt="" class="mobile_image" style="display: none;">
                            <div class="box_overlay_content">
                            <!-- <img src="http://192.168.2.177/cizgames/assets/uploads/box2.svg" alt="">-->
                            <h6>Shooter <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>

 <!--<div class="container-fluid   pb-3">
  <div class="p-0">
    <div class="row">
      <div class="col-lg-6">
        <div class="heading">
          <h3 class=" text-capitalize text-center"></h3>
        </div>
        <div class="area_play_with_game mt-3">
           <div class="owl-carousel owl-theme footer_one_column_sliders">
             <?php if($left){foreach($left as $k=>$v){
               ?>
               <div class="item">
                <a href="<?php echo $v->link;?>" >
                  <div class="blog_box">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="">
                  </div>
                </a> 
              </div>
            <?php 
            }
            }
            ?> 
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="heading">
          <h3 class=" text-capitalize text-center"></h3>
        </div>
        <div class="area_play_with_game mt-3">
           <div class="owl-carousel owl-theme footer_one_column_sliders">
             <?php if($right){foreach($right as $k=>$v){
               ?>
               <div class="item">
                <a href="<?php echo $v->link;?>" >
                  <div class="blog_box">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="">
                  </div>
                </a> 
              </div>
            <?php 
            }
            }
            ?> 
          </div>
        </div>
      </div>
  </div>
</div>
</div>-->


<?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Trending Games</h2>
          </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="owl-carousel owl-theme category_list_home_page  ">
            <?php 
            if($offer_products){
              foreach($offer_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                 <div class="product_box shadow-none bg-white rounded ">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                     	<?php 
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php } ?>
                      <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
                    </div>
                  </a>
                  <div class="product_box_content">
                    <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
                 	<?php 
					if($v->discount_percentage > 0 ){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
					</div>
				<?php } else {
					?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
					</div>
					
					<?php
				}?>
                 	<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
					
						<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
					
					<input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
				
					
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
				<?php if(@$v->available_stock>0){?><?php 
            ?>
             <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
       
            
            <?php  
          }else{
              
          ?>
          
           <button disabled class="btn btn-primary">Out of stock</button>
       
          
          
          <?php
          }
          ?>
					<?php
					if($user_id){
					 
					  $pid=$v->product_id;
              $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
              $pwishlist=$userModel->customQuery($sql); 
					    
						?>
						<a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}else{
						?>
						<a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}
					?>
				</form>
                </div>
              </div>
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

<?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Best in gaming gear</h2>
        </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="owl-carousel owl-theme category_list_home_page  ">
            <?php 
            if($offer_products){
              foreach($offer_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                 <div class="product_box shadow-none bg-white rounded ">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                     	<?php 
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php } ?>
                      <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
                    </div>
                  </a>
                  <div class="product_box_content">
                    <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
                 	<?php 
					if($v->discount_percentage > 0 ){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
					</div>
				<?php } else {
					?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
					</div>
					
					<?php
				}?>
                 	<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
					
						<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
					
					<input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
				
					
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
				<?php if(@$v->available_stock>0){?><?php 
            ?>
             <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
       
            
            <?php  
          }else{
              
          ?>
          
           <button disabled class="btn btn-primary">Out of stock</button>
       
          
          
          <?php
          }
          ?>
					<?php
					if($user_id){
					 
					  $pid=$v->product_id;
              $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
              $pwishlist=$userModel->customQuery($sql); 
					    
						?>
						<a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}else{
						?>
						<a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}
					?>
				</form>
                </div>
              </div>
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
<?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Pre orders</h2>
            <a href="<?php echo base_url();?>/product-list?show-offer=yes" class="right_posiation_buttton bnt btn-primary">View All</a>
          </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="owl-carousel owl-theme category_list_home_page  ">
            <?php 
            if($offer_products){
              foreach($offer_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                 <div class="product_box shadow-none bg-white rounded ">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                     	<?php 
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php } ?>
                      <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
                    </div>
                  </a>
                  <div class="product_box_content">
                    <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
                 	<?php 
					if($v->discount_percentage > 0 ){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
					</div>
				<?php } else {
					?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
					</div>
					
					<?php
				}?>
                 	<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
					
						<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
					
					<input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
				
					
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
				<?php if(@$v->available_stock>0){?><?php 
            ?>
             <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
       
            
            <?php  
          }else{
              
          ?>
          
           <button disabled class="btn btn-primary">Out of stock</button>
       
          
          
          <?php
          }
          ?>
					<?php
					if($user_id){
					 
					  $pid=$v->product_id;
              $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
              $pwishlist=$userModel->customQuery($sql); 
					    
						?>
						<a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}else{
						?>
						<a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}
					?>
				</form>
                </div>
              </div>
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
    <?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Shop games by price</h2>
          </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="row justify-content-center">
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-6">
                <div class="shop_by_games_box">
                    <a href="#">
                        <h1>up to</h1>
                        <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
                    </a>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
    <?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Shop Accessories by brand</h2>
          </div>
        </div>
        <div class="col-12  mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme category_list_home_page  ">
                <?php 
                if($offer_products){
                  foreach($offer_products as $k=>$v){ 
                    $pid=$v->product_id;
                    $sql="select * from product_image where     product='$pid' and status='Active' ";
                    $product_image=$userModel->customQuery($sql); 
                    ?>
                    <div class="item">
                        <div class="shop_accessies_by_brand">
                            <a href="#">
                                <img src="http://192.168.2.177/cizgames/assets/uploads/armor__2.png" alt="">
                            </a>
                        </div>  
                    </div>
              <?php }} ?>
            </div>
      </div>
    </div>
  </div>
  <?php } ?>
  
  <?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Action Games</h2>
            <a href="<?php echo base_url();?>/product-list?show-offer=yes" class="right_posiation_buttton bnt btn-primary">View All</a>
          </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="owl-carousel owl-theme category_list_home_page  ">
            <?php 
            if($offer_products){
              foreach($offer_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                 <div class="product_box shadow-none bg-white rounded ">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                     	<?php 
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php } ?>
                      <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
                    </div>
                  </a>
                  <div class="product_box_content">
                    <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
                 	<?php 
					if($v->discount_percentage > 0 ){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
					</div>
				<?php } else {
					?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
					</div>
					
					<?php
				}?>
                 	<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
					
						<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
					
					<input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
				
					
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
				<?php if(@$v->available_stock>0){?><?php 
            ?>
             <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
       
            
            <?php  
          }else{
              
          ?>
          
           <button disabled class="btn btn-primary">Out of stock</button>
       
          
          
          <?php
          }
          ?>
					<?php
					if($user_id){
					 
					  $pid=$v->product_id;
              $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
              $pwishlist=$userModel->customQuery($sql); 
					    
						?>
						<a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}else{
						?>
						<a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}
					?>
				</form>
                </div>
              </div>
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($offer_products){?>
    <div class="container-fluid  pt-3 best_offers_parent_con">
      <div class="row">
        <div class="col-12">
          <div class="heading heading_design_2 text-dark " >
            <h2 class="text-white">Shooter Games</h2>
            <a href="<?php echo base_url();?>/product-list?show-offer=yes" class="right_posiation_buttton bnt btn-primary">View All</a>
          </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
          <div class="owl-carousel owl-theme category_list_home_page  ">
            <?php 
            if($offer_products){
              foreach($offer_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                 <div class="product_box shadow-none bg-white rounded ">
                  <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                    <div class="product_box_image">
                     	<?php 
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php } ?>
                      <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
                    </div>
                  </a>
                  <div class="product_box_content">
                    <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
                 	<?php 
					if($v->discount_percentage > 0 ){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
					</div>
				<?php } else {
					?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
					</div>
					
					<?php
				}?>
                 	<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
					
						<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
					
					<input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
				
					
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
				<?php if(@$v->available_stock>0){?><?php 
            ?>
             <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
       
            
            <?php  
          }else{
              
          ?>
          
           <button disabled class="btn btn-primary">Out of stock</button>
       
          
          
          <?php
          }
          ?>
					<?php
					if($user_id){
					 
					  $pid=$v->product_id;
              $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
              $pwishlist=$userModel->customQuery($sql); 
					    
						?>
						<a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}else{
						?>
						<a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
						</a>
						<?php
					}
					?>
				</form>
                </div>
              </div>
            </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  
  
                
<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize" >
  <div class="container p-0">
    <div class="row">
      <div class="col-md-8 mt-2">
        <div class="heading">
          <h3 class="text-white">Subscribe to our newsletter</h3>
        </div>
      </div>
      <div class="col-md-4 mt-2">
       <?php  
       if(@$flashData['success']){?>
          <p style="margin-bottom: 0;
    padding-bottom: 10px;
    color: #fff;
    font-weight: 500;"><?php echo $flashData['success'];?></p>
    <?php } ?>
          <form method="post" class="d-flex" action="<?php echo base_url();?>/page/newsletter">
              <input type="email" placeholder="Email Adderess" required name="email">
                <button type="submit" class="btn btn-primary">Subscribe</button>
          </form>
      </div>
  </div>
</div>
</div>


