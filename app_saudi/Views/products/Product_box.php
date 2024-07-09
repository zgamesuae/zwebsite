<?php 
$userModel= model('App\Models\UserModel');
$productModel= model('App\Models\ProductModel');


?>


<!-- Product Box -->
<div class="product_box shadow-none bg-white rounded row m-0 <?php if($hr) echo "horizontal_product_box" ?>">
    
    
    <div class="col-12 px-0 <?php if($hr) echo "col-lg-6" ?>">
        <!-- promotion sticker -->
        <?php if($productModel->get_discounted_percentage($v->product_id) > 0 && $v->discount_rounded == "Yes"): ?>
        <div class="promotion_sticker right_sticker" >
            <div class="promotion_sticker_tag p-2" style=" ">
                <p class="pl-4 m-0 text-right" style="font-weight: bold; font-size: 26px; line-height:26px "><?php echo round("-".$v->discount_percentage) ?></p>
                <p class="pl-2 m-0 text-right" style="font-weight: bold; font-size: 25px; line-height: 26px;">%</p>
            </div>
        </div>
        <?php endif; ?>
        <!-- promotion sticker -->
    
        <!-- New sticker -->
        <?php if($productModel->is_new($v->product_id) && $v->pre_order_enabled !=='Yes'): ?>
        <div class="promotion_sticker left_sticker">
            <div class="new_sticker_tag p-2">
                <p class="text-center">NEW</p>
            </div>
        </div>
        <?php endif; ?>
        <!-- New sticker -->
        
        
        <a  href="<?php echo $productModel->getproduct_url($v->product_id)?>">
            <div class="product_box_image">
                <?php 
                if(false){
	    			if($v->discount_percentage > 0 ){
	    		?>
                <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
                <?php } }?>
                <?php
                    if($v->pre_order_enabled=="Yes" && $v->release_date !== null && $v->release_date !== "0000-00-00"):
                ?>
                <div class="release_date py-1 d-flex-row a-c-center" style=" position: absolute;background: linear-gradient(45deg, #0e0e0e, #646464, #000000);width: 100%;bottom: 0;"><p class="mb-0" style="color: white;"><?php echo lg_get_text("lg_53") ?>: <?php echo date('d/m/Y', strtotime($v->release_date));?></p></div>
                <!-- <div class="p_r_date px-1 py-0 col-12 mb-2 a-c-center" >
                    <p class="p-0 m-0"><?php echo("Release date: ".$v->release_date)?></p>
                </div> -->
                <?php endif; ?>
                <img alt="<?php echo $v->name ?>" src="<?php echo base_url() ?>/assets/uploads/<?php if(@$product_image[0]->image) echo @$product_image[0]->image;else echo 'noimg.png'; ?>"
                    class="border-0">
            </div>
        </a>
    </div>

    <div class="product_box_content col-12  <?php if($hr) echo "col-lg-6 d-flex flex-column justify-content-center"; ?>">
        <?php $p_title=(strlen(lg_put_text($v->name , $v->arabic_name , false)) > 50) ? substr(lg_put_text($v->name , $v->arabic_name , false),0,50)."..." : lg_put_text($v->name , $v->arabic_name , false); ?>
        <h5>
            <strong><a href="<?php echo $productModel->getproduct_url($v->product_id)?>"><?php echo $p_title;?></a></strong>
        </h5>
        <?php 
			if($productModel->get_discounted_percentage($v->product_id) > 0 ){
		?>
        <div class="pricing-card">
            <div class="card-subtitle">
                <span><?php echo bcdiv($v->price, 1, 2);?><span> <?php echo lg_get_text("lg_102") ?> </span>
                </span>
            </div>
            <p class="offer-price card-text">
                <?php
                    if($v->discount_rounded == "Yes")
                    echo round(bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2));
                    else
                    echo (bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2));
                ?>
                <span><?php echo lg_get_text("lg_102") ?></span>
            </p>
        </div>
        <?php } else { ?>
        <div class="pricing-card">
            <div class="card-subtitle">
                <span> <span> &nbsp </span></span>
            </div>
            <p class="offer-price card-text"><?php echo bcdiv($v->price, 1, 2);?><span><?php echo lg_get_text("lg_102") ?></span>
            </p>
        </div>

        <?php 
            }
        if(!$hr):
        ?>
        <form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post"
            action="<?php echo base_url();?>/page/buyNowSubmitForm" data-price="<?php if($productModel->get_discounted_percentage($v->product_id) > 0): echo bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2); else: echo $v->price; endif; ?>" data-sku="<?php echo $v->sku ?>">
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
            <?php if(@$v->available_stock>0){
				if($v->bundle_opt_enabled == "Yes" || $v->product_nature == "Variable"):
			?>
				<button class="btn btn-primary view_detail" type="button"><a href="<?php echo $productModel->getproduct_url($v->product_id)?>"><?php echo lg_get_text("lg_56") ?></a></button>
			<?php else:?>
				<button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo lg_get_text("lg_54") ;else echo lg_get_text("lg_33");?></button>
			<?php endif;?>
            
            <?php }else{ ?>
           		<button disabled class="btn btn-primary"><?php echo lg_get_text("lg_55") ?></button>
          	<?php } ?>  
            <?php
			    if($user_id){
            
			    $pid=$v->product_id;
                $sql="select * from wishlist where product_id='$pid' and user_id='$user_id' ";
                $pwishlist=$userModel->customQuery($sql); 
    
			?>
            <div class="add_to_whishlist <?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if(@$product_image[0]->image) echo @$product_image[0]->image; ?>');">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0H24V24H0z"></path>
                    <path
                        d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                    </path>
                </svg>
            </div>
            <?php
				}else{
			?>
            <div class="add_to_whishlist" data-toggle="modal" data-target="#login-modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0H24V24H0z"></path>
                    <path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                    </path>
                </svg>
            </div>
            <?php
				}
            endif;
			?>
        </form>
    </div>
</div>
<!-- Product Box -->