<?php 
 $sql="select * from products where status='Active' AND show_this_product_in_home_page='Yes' AND discount_percentage>0 order by created_at desc limit 20";
 $offer_products=$userModel->customQuery($sql);

if($offer_products){?>
<div class="container-fluid home-sec pt-3 best_offers_parent_con">
    <div class="row j-c-center">
        <div class="col-lg-10 col-md-12 col-sm-12">
            <div class="sec_title">
                <h2>Best Offers</h2>
                <a href="<?php echo base_url();?>/product-list?show-offer=yes"
                    class="right_posiation_buttton bnt btn-primary">View All</a>
            </div>
        </div>
        <div class="col-lg-10 col-md-12 col-sm-12 mt-3 overflow-hidden ">
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
                                if(false){
						            if($v->discount_percentage > 0 ){
							    ?>
                                <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
                                <?php } }?>
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