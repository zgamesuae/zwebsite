<?php
$userModel = model('App\Models\UserModel', false);
$session = session();
@$user_id=$session->get('userLoggedin'); 
$sql="select * from cms";
$cms=$userModel->customQuery($sql);
$sql="select * from color where status='Active' AND show_in_home_page='Yes'";
$color=$userModel->customQuery($sql);
$sql="select * from banner where status='Active'  order by created_at desc";
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
 if ($id1="accessories-1636468761") {
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
 where products.status='Active' AND show_this_product_in_home_page='Yes' AND products.type=5 ";
 /*if ($id1="accessories-1636468761") {
  $sql2="select * from master_category where parent_id='$id1'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
    
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
}*/
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
                <a href="<?php echo $v->link;?>">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"
                        class="w-100 desltop_s_banner_home_sldier">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>"
                        class="w-100 mobile_banner_home_sldier" style="display: none;">
                </a>
                <?php if($v->title){?>

                <div class="container" id="banner_overlay_text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="banner_text_content">
                                <h1><?php echo $v->title;?></h1>
                                <div><?php echo $v->description;?></div>
                                <?php if($v->show_button=="Yes"){?>
                                <div class="banner_button">
                                    <a href="<?php echo $v->link;?>" class="btn btn-primary">Buy Now</a>
                                    <!--<a href="<?php echo base_url();?>/product-list" class="btn btn-default">Live demo</a>-->
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
        <?php }} ?>


    </div>
</div>



<!-- <div class="container-fluid categoriesarea" style="background-color:#171717;background-image: url('<?php //echo base_url();?>/assets/uploads/<?php //echo $cms[7]->image;?>');"> -->
<div class="container-fluid categoriesarea" style="background-color:#171717;">

    <div class="Abvd">
        <div class="row" id="cate_aear_row_top_minus_margin">
            <div class="col-md-12 mb-4 mt-3">
                <div class="heading text-center text-white">
                    <h2>Discover your next favourite game</h2>
                    <a href="<?php echo base_url();?>/product-list?type=5"
                        class="right_posiation_buttton bnt btn-primary">View All</a>
                </div>
            </div>
            <div class="col-md-12 pb-4">
                <div class="owl-carousel owl-theme category_list_home_page jagat-home-carasoul">
                    <?php 
          if($products){
            foreach($products as $k=>$v){ 
              $pid=$v->product_id;
              $sql="select * from product_image where     product='$pid' and status='Active' ";
              $product_image=$userModel->customQuery($sql); 
              ?>
                    <div class="item">
                        <div class="product_box shadow-none bg-white rounded overflow-hidden">
                            <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                                <div class="product_box_image">
                                    <?php 
						if($v->discount_percentage > 0 ){
							?>
                                    <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
                                    <?php } ?>
                                    <img src="<?php echo base_url(); ?>/assets/uploads/<?php if(@$product_image[0]->image) echo @$product_image[0]->image;else echo 'noimg.png'; ?>"
                                        class="border-0">
                                </div>
                            </a>
                            <div class="product_box_content">
                                <h5><strong><a
                                            href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong>
                                </h5>
                                <?php 
					if($v->discount_percentage > 0 ){
						?>
                                <div class="pricing-card">
                                    <div class="card-subtitle">
                                        <span><?php echo bcdiv($v->price, 1, 2);?><span> AED </span>
                                        </span>
                                    </div>
                                    <p class="offer-price card-text">
                                        <?php echo bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2);?><span>AED</span>
                                    </p>
                                </div>
                                <?php } else {
					?>


                                <div class="pricing-card">
                                    <div class="card-subtitle">
                                        <span> <span> &nbsp </span>
                                        </span>
                                    </div>
                                    <p class="offer-price card-text">
                                        <?php echo bcdiv($v->price, 1, 2);?><span>AED</span></p>
                                </div>




                                <?php
				}?>
                                <form class="products_add_to_cart each_products_add_card_list buy-now-form"
                                    method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
                                    <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
                                    <input name="product_image" type="hidden"
                                        value="<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>"
                                        required>
                                    <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>"
                                        required>
                                    <input name="discount_percentage" type="hidden"
                                        value="<?php echo $v->discount_percentage;?>" required>

                                    <input name="pre_order_before_payment_percentage" type="hidden"
                                        value="<?php echo $v->pre_order_before_payment_percentage;?>" required>

                                    <input name="pre_order_enabled" type="hidden"
                                        value="<?php echo $v->pre_order_enabled;?>" required>


                                    <div class="product_qty">
                                        <input name="quantity" type="number" value="1" required min="1">
                                    </div>
                                    <?php if(@$v->available_stock>0){?><?php 
            ?>
                                    <button type="submit"
                                        class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>


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
                                    <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>"
                                        href="javascript:void(0);"
                                        onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24">
                                            <path fill="none" d="M0 0H24V24H0z"></path>
                                            <path
                                                d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                            </path>
                                        </svg>
                                    </a>
                                    <?php
					}else{
						?>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#jagat-login-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24">
                                            <path fill="none" d="M0 0H24V24H0z"></path>
                                            <path
                                                d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                            </path>
                                        </svg>
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
</div>



<div class="container-fluid bg-datk">
    <div class="row services_area pt-4 pb-4 bg-dark" id="services_area">
        <div class="col-12">
            <div class="heading heading_design_2 mt-4 bmmd-100">
                <h2><?php echo $cms[7]->heading;?></h2>
                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>

        <div class="container-fluid full_cate_sliders mt-3">

            <div class="owl-carousel service_box_animated_sliders owl-theme">
                <?php if($color){
          $i=0;
          foreach($color as $k=>$v){
            if($v->image!="" && $v->mobile_image!=""){
             if($i<10){
              ?>
                <div class="item">
                    <div class="service_box_min_new ">
                        <div class="service_box">
                            <a href="<?php echo base_url();?>/product-list?genre=<?php echo $v->id;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" alt=""
                                    class="mobile_image" style="display: none;">
                                <div class="box_overlay_content">
                                    <!-- <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->icon;?>" alt="">-->
                                    <h6><?php echo $v->title;?> <span class="icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                            </svg></span></h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
          }
          $i++;
          } 
          }
          }
          ?>
            </div>
        </div>
    </div>

</div>







<div class="container-fluid bg-black  pb-3">
    <div class="container p-0">
        <div class="row">
            <div class="col-lg-4 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[16]->heading;?></h3>

                </div>
                <div class="area_play_with_game ">
                    <div class="">

                        <div class="">
                            <a href="<?php echo $cms[16]->link;?>">
                                <div class="blog_boxx w-100">
                                    <img class="  w-100"
                                        src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[16]->image;?>"
                                        alt="">
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-4 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[17]->heading;?></h3>

                </div>
                <div class="area_play_with_game ">
                    <div class="">

                        <div class="">
                            <a href="<?php echo $cms[17]->link;?>">
                                <div class="blog_boxx w-100">
                                    <img class="  w-100"
                                        src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[17]->image;?>"
                                        alt="">
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-4 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[18]->heading;?></h3>

                </div>
                <div class="area_play_with_game ">
                    <div class="">

                        <div class="">
                            <a href="<?php echo $cms[18]->link;?>">
                                <div class="blog_boxx w-100">
                                    <img class="  w-100"
                                        src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[18]->image;?>"
                                        alt="">
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



























<?php
          if($accessories){
          ?>
<!-- <div class="container-fluid categoriesarea" style="background-color:#171717;background-image: url('<?php //echo base_url();?>/assets/uploads/<?php //echo $cms[7]->image;?>');"> -->
<div class="container-fluid categoriesarea" style="background-color:#171717;">

    <div class="Abvd">
        <div class="row" id="cate_aear_row_top_minus_margin">
            <div class="col-md-12 mb-4 mt-3">
                <div class="heading text-center text-white">
                    <h2>Gaming accessories</h2>
                    <a href="<?php echo base_url();?>/product-list?type=7"
                        class="right_posiation_buttton bnt btn-primary">View All</a>
                </div>
            </div>
            <div class="col-md-12 pb-4">
                <div class="owl-carousel owl-theme category_list_home_page jagat-home-carasoul">
                    <?php 
        
            foreach($accessories as $k=>$v){ 
              $pid=$v->product_id;
              $sql="select * from product_image where     product='$pid' and status='Active' ";
              $product_image=$userModel->customQuery($sql); 
              ?>
                    <div class="item">
                        <div class="product_box shadow-none bg-white rounded overflow-hidden">
                            <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                                <div class="product_box_image">
                                    <?php 
						if($v->discount_percentage > 0 ){
							?>
                                    <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
                                    <?php } ?>
                                    <img src="<?php echo base_url(); ?>/assets/uploads/<?php if(@$product_image[0]->image) echo @$product_image[0]->image;else echo 'noimg.png'; ?>"
                                        class="border-0">
                                </div>
                            </a>
                            <div class="product_box_content">
                                <h5><strong><a
                                            href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong>
                                </h5>
                                <?php 
					if($v->discount_percentage > 0 ){
						?>
                                <div class="pricing-card">
                                    <div class="card-subtitle">
                                        <span><?php echo bcdiv($v->price, 1, 2);?><span> AED </span>
                                        </span>
                                    </div>
                                    <p class="offer-price card-text">
                                        <?php echo bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2);?><span>AED</span>
                                    </p>
                                </div>
                                <?php } else {
					?>


                                <div class="pricing-card">
                                    <div class="card-subtitle">
                                        <span> <span> &nbsp </span>
                                        </span>
                                    </div>
                                    <p class="offer-price card-text">
                                        <?php echo bcdiv($v->price, 1, 2);?><span>AED</span></p>
                                </div>




                                <?php
				}?>
                                <form class="products_add_to_cart each_products_add_card_list buy-now-form"
                                    method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
                                    <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
                                    <input name="product_image" type="hidden"
                                        value="<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>"
                                        required>
                                    <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>"
                                        required>
                                    <input name="discount_percentage" type="hidden"
                                        value="<?php echo $v->discount_percentage;?>" required>

                                    <input name="pre_order_before_payment_percentage" type="hidden"
                                        value="<?php echo $v->pre_order_before_payment_percentage;?>" required>

                                    <input name="pre_order_enabled" type="hidden"
                                        value="<?php echo $v->pre_order_enabled;?>" required>


                                    <div class="product_qty">
                                        <input name="quantity" type="number" value="1" required min="1">
                                    </div>
                                    <?php if(@$v->available_stock>0){?><?php 
            ?>
                                    <button type="submit"
                                        class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>


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
                                    <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>"
                                        href="javascript:void(0);"
                                        onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if(@$product_image[0]->image) echo $product_image[0]->image; ?>');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24">
                                            <path fill="none" d="M0 0H24V24H0z"></path>
                                            <path
                                                d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                            </path>
                                        </svg>
                                    </a>
                                    <?php
					}else{
						?>
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#jagat-login-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                            height="24">
                                            <path fill="none" d="M0 0H24V24H0z"></path>
                                            <path
                                                d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                            </path>
                                        </svg>
                                    </a>
                                    <?php
					}
					?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
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
            <div class="heading heading_design_2 text-dark ">
                <h2 class="text-dark">Best Offers</h2>
                <a href="<?php echo base_url();?>/product-list?show-offer=yes"
                    class="right_posiation_buttton bnt btn-primary">View All</a>
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
                                <img src="<?php echo base_url(); ?>/assets/uploads/<?php if(@$product_image[0]->image) echo @$product_image[0]->image;else echo 'noimg.png'; ?>"
                                    class="border-0">
                            </div>
                        </a>
                        <div class="product_box_content">
                            <h5><strong><a
                                        href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong>
                            </h5>
                            <?php 
					if($v->discount_percentage > 0 ){
						?>
                            <div class="pricing-card">
                                <div class="card-subtitle">
                                    <span><?php echo bcdiv($v->price, 1, 2);?><span> AED </span>
                                    </span>
                                </div>
                                <p class="offer-price card-text">
                                    <?php echo bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2);?><span>AED</span>
                                </p>
                            </div>
                            <?php } else {
					?>
                            <div class="pricing-card">
                                <div class="card-subtitle">
                                    <span> <span> &nbsp </span>
                                    </span>
                                </div>
                                <p class="offer-price card-text"><?php echo bcdiv($v->price, 1, 2);?><span>AED</span>
                                </p>
                            </div>

                            <?php
				}?>
                            <form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post"
                                action="<?php echo base_url();?>/page/buyNowSubmitForm">
                                <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
                                <input name="product_image" type="hidden"
                                    value="<?php if(@@$product_image[0]->image) echo @$product_image[0]->image; ?>"
                                    required>
                                <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required>
                                <input name="discount_percentage" type="hidden"
                                    value="<?php echo $v->discount_percentage;?>" required>

                                <input name="pre_order_before_payment_percentage" type="hidden"
                                    value="<?php echo $v->pre_order_before_payment_percentage;?>" required>

                                <input name="pre_order_enabled" type="hidden"
                                    value="<?php echo $v->pre_order_enabled;?>" required>


                                <div class="product_qty">
                                    <input name="quantity" type="number" value="1" required min="1">
                                </div>
                                <?php if(@$v->available_stock>0){?><?php 
            ?>
                                <button type="submit"
                                    class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>


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
                                <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>"
                                    href="javascript:void(0);"
                                    onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>');">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
                                </a>
                                <?php
					}else{
						?>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#jagat-login-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
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





<!--Trending Start-->

<?php if($trending_products){?>
<div class="container-fluid  pt-3 tradind_products_main_heading  bg-dark mt-3 pb-4 ">
    <div class="row">
        <div class="col-12">
            <div class="heading heading_design_2 text-dark ">
                <h2 class="text-white">Trending products</h2>
                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>
        <div class="col-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme category_list_home_page overflow-hidden ">
                <?php 
            if($trending_products){
              foreach($trending_products as $k=>$v){ 
                $pid=$v->product_id;
                $sql="select * from product_image where     product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql); 
                ?>
                <div class="item">
                    <div class="product_box shadow-none bg-white rounded overflow-hidden">
                        <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                            <div class="product_box_image">
                                <?php 
						if($v->discount_percentage > 0 ){
							?>
                                <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
                                <?php } ?>
                                <img src="<?php echo base_url(); ?>/assets/uploads/<?php if(@$product_image[0]->image) echo @$product_image[0]->image;else echo 'noimg.png'; ?>"
                                    class="border-0">
                            </div>
                        </a>
                        <div class="product_box_content">
                            <h5><strong><a
                                        href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong>
                            </h5>
                            <?php 
					if($v->discount_percentage > 0 ){
						?>
                            <div class="pricing-card">
                                <div class="card-subtitle">
                                    <span><?php echo bcdiv($v->price, 1, 2);?><span> AED </span>
                                    </span>
                                </div>
                                <p class="offer-price card-text">
                                    <?php echo bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2);?><span>AED</span>
                                </p>
                            </div>
                            <?php } else {
					?>


                            <div class="pricing-card">
                                <div class="card-subtitle">
                                    <span> <span> &nbsp </span>
                                    </span>
                                </div>
                                <p class="offer-price card-text"><?php echo bcdiv($v->price, 1, 2);?><span>AED</span>
                                </p>
                            </div>




                            <?php
				}?>
                            <form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post"
                                action="<?php echo base_url();?>/page/buyNowSubmitForm">
                                <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
                                <input name="product_image" type="hidden"
                                    value="<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>"
                                    required>
                                <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required>
                                <input name="discount_percentage" type="hidden"
                                    value="<?php echo $v->discount_percentage;?>" required>

                                <input name="pre_order_before_payment_percentage" type="hidden"
                                    value="<?php echo $v->pre_order_before_payment_percentage;?>" required>

                                <input name="pre_order_enabled" type="hidden"
                                    value="<?php echo $v->pre_order_enabled;?>" required>


                                <div class="product_qty">
                                    <input name="quantity" type="number" value="1" required min="1">
                                </div>
                                <?php if(@$v->available_stock>0){?><?php 
            ?>
                                <button type="submit"
                                    class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>


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
                                <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>"
                                    href="javascript:void(0);"
                                    onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>');">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
                                </a>
                                <?php
					}else{
						?>
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#jagat-login-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0H24V24H0z"></path>
                                        <path
                                            d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                        </path>
                                    </svg>
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



<!--Trending END-->






<!--  <div class="container-fluid  pt-3 trading_section_panel ">
    <div class="row">
      <div class="col-md-12">
        <div class="heading_design_2 ">
          <h2 class="text-dark"><?php echo $cms[9]->heading;?></h2>
        </div>
         <div class="headin_bottom mt-5 text-white text-center ">
          <p class="m-0">Explore a deep library of PC-first games and play all-new games from Xbox Game Studios the day they launch.</p><button class="btn btn-default">Explore the library</button>
        </div> 
      </div>
    </div>
    <div class="row ">
      <div class="col-12 p-0 mt-3">
          <div class="see_all_button">
              <a href="<?php echo $cms[9]->link;?>" class="btn btn-pimary">See all</a>
          </div>
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[9]->image;?>" class="w-100" >
      </div>
    </div>
  </div>--><?php /* ?>
<div class="container-fluid pt-3 bg-light play_of_the_panel_parnet">
    <div class="row">
        <div class="col-md-12">
            <div class="heading_design_2  ">
                <h2 class="text-dark">PLAY DAY ONE</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 p-0  mt-3 play_of_column">
            <div class="owl-carousel owl-theme dayof_the_play_slider">
                <div class="item" data-hash="slide">
                    <div class="slider_area row">
                        <div class="col-md-6 p-0">
                            <div class="banner_slider_image">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[12]->image;?>" alt=""
                                    class="w-100">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="content_area_banner">
                                <ul class="navigation">
                                    <li><a href="#slide"><?php echo substr($cms[12]->heading,0,30);?></a></li>
                                    <li><a href="#slide1"><?php echo substr($cms[13]->heading,0,30);?></a></li>
                                    <li><a href="#slide2"><?php echo substr($cms[14]->heading,0,30);?></a></li>
                                </ul>
                            </div>
                            <div class="content_area_label ">
                                <h2><?php echo $cms[12]->heading;?></h2>
                                <p><?php echo $cms[12]->description;?></p> <a href="<?php echo $cms[12]->link;?>"
                                    class="btn btn-primary">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" data-hash="slide1">
                    <div class="slider_area row">
                        <div class="col-md-6 p-0">
                            <div class="banner_slider_image">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[13]->image;?>" alt=""
                                    class="w-100">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="content_area_banner">
                                <ul class="navigation">
                                    <li><a href="#slide"><?php echo substr($cms[12]->heading,0,30);?></a></li>
                                    <li><a href="#slide1"><?php echo substr($cms[13]->heading,0,30);?></a></li>
                                    <li><a href="#slide2"><?php echo substr($cms[14]->heading,0,30);?></a></li>
                                </ul>
                            </div>
                            <div class="content_area_label ">
                                <h2><?php echo $cms[13]->heading;?></h2>
                                <p><?php echo $cms[13]->description;?></p> <a href="<?php echo $cms[13]->link;?>"
                                    class="btn btn-primary">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item" data-hash="slide2">
                    <div class="slider_area row">
                        <div class="col-md-6 p-0">
                            <div class="banner_slider_image">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[14]->image;?>" alt=""
                                    class="w-100">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="content_area_banner">
                                <ul class="navigation">
                                    <li><a href="#slide"><?php echo substr($cms[12]->heading,0,30);?></a></li>
                                    <li><a href="#slide1"><?php echo substr($cms[13]->heading,0,30);?></a></li>
                                    <li><a href="#slide2"><?php echo substr($cms[14]->heading,0,30);?></a></li>
                                </ul>
                            </div>
                            <div class="content_area_label ">
                                <h2><?php echo $cms[14]->heading;?></h2>
                                <p><?php echo $cms[14]->description;?></p>
                                <a href="<?php echo $cms[14]->link;?>" class="btn btn-primary">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php */ ?>
<?php /* ?>
<div class="container-fluid p-0" id="footer_banner_text">
    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[11]->image;?>" class="w-100 desk-img">
    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[11]->mobile_image;?>"
        class="w-100 jagat-mobile-img">
    <div class="container" id="banner_overlay_text">
        <div class="row">
            <div class="col-md-6">
                <div class="banner_text_content">
                    <h1><?php echo $cms[11]->heading;?></h1>
                    <div><?php echo $cms[11]->description;?></div>
                    <div class="banner_button">
                        <a href="<?php echo $cms[11]->link;?>" class="btn btn-primary">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php */ ?>


<!-- Two banners sliders NEW RELEASES AND PRE-ORDERS-->
<div class="container-fluid bg-black  pb-3">
    <div class="container p-0">
        <div class="row">

            <div class="col-lg-6 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[10]->heading;?></h3>
                    <a href="<?php echo base_url();?>/product-list?pre-order=enabled"
                        class="right_posiation_buttton_col-middle bnt btn-primary">View All</a>
                </div>
                <div class="area_play_with_game mt-3">
                    <div class="owl-carousel owl-theme footer_one_column_sliders">
                        <?php 
                if($left){
                foreach($left as $k=>$v){
              ?>
                        <div class="item">
                            <a href="<?php echo $v->link;?>">
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

            <div class="col-lg-6 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[12]->heading;?></h3>
                    <a href="<?php echo base_url();?>/product-list?type=13"
                        class="right_posiation_buttton_col-middle bnt btn-primary">View All</a>
                </div>
                <div class="area_play_with_game mt-3">
                    <div class="owl-carousel owl-theme footer_one_column_sliders">
                        <?php if($right){foreach($right as $k=>$v){
               ?>
                        <div class="item">
                            <a href="<?php echo $v->link;?>">
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
</div>


<?php 
                
                if($brand){
                    ?>
<div class="container-fluid bg-light pt-4 pb-4 shop_brand_shop_by">
    <div class="row">
        <div class="col-md-12">
            <div class="heading_design_four mb-4 text-center text-capitalize">
                <h2><b>shop by brand</b></h2>
                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>
        <div class="col-12 pl-2 mb-2">
            <div class="owl-carousel owl-theme two_rows_grid_sliders">

                <?php
                  $j=0;
                  $k=1;
                   for($i=0;$i<count($brand)/2;$i++){
                      
                        
                ?>

                <div class="item">
                    <div class="new_design_box_categoryies shadow-sm bg-white border rounded">
                        <a href="<?php echo base_url();?>/product-list?brand=<?php echo $brand[$j]->id;?>">
                            <img src="<?php echo base_url();?>/assets/uploads/<?php echo $brand[$j]->image;?>">
                        </a>
                    </div>
                    <div class="new_design_box_categoryies shadow-sm bg-white border rounded mt-2">
                        <a href="<?php echo base_url();?>/product-list?brand=<?php echo @$brand[$k]->id;?>">
                            <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$brand[$k]->image;?>">
                        </a>
                    </div>
                </div>
                <?php   $j=$j+2;
                  $k=$k+2;
                        
                    }?>

            </div>
        </div>


    </div>
</div>
<?php
  }
                ?>

<?php /* ?>
<div class="container-fluid bg-dark pt-3 pb-3">
    <div class="container p-0">
        <div class="row">
            <div class="col-12">
                <div class="heading d-flex justify-content-between align-items-center">
                    <h3 class="text-white" id="newsletter">Blogs</h3>
                    <a href="<?php echo base_url();?>/blog" class="btn btn-primary">See All</a>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="owl-carousel owl-theme blog_listring">
                    <?php if($blog){foreach($blog as $k=>$v){
           ?>
                    <div class="item">
                        <a href="<?php echo base_url();?>/blog-detail/<?php echo $v->blog_id;?>">
                            <div class="blog_box">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="">
                                <div class="overlay_conrtent_s">
                                    <h6><?php echo $v->title;?></h6>
                                    <button class="btn btn-primary">View</button>
                                </div>
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

<?php */ ?>

<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize">
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