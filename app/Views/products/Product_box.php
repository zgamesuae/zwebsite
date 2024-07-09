<?php 
$userModel= model('App\Models\UserModel');
$productModel= model('App\Models\ProductModel');
// $GLOBALS["offerModel"]->_Get_N_offers_products();
?>


<!-- Product Box -->
<div class="product_box shadow-none bg-white rounded row m-0 <?php if($hr): echo "horizontal_product_box"; endif; ?>" style="height: 100%">
    
    
    <div class="col-12 px-0 <?php if($hr) echo "col-lg-6" ?>">
        <?php 
        $discount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $v->product_id);
        $offer = ($GLOBALS["offerModel"]->product_Get_N_offer_comply($v->product_id)) ?? $GLOBALS["offerModel"]->product_prize_offer_comply($v->product_id);
        ?>
        
        <!-- promotion sticker -->
        <?php
        $cart_offers = $GLOBALS["offerModel"]->_get_valid_offers($GLOBALS["offerModel"]->offers_list , $v->product_id , null , true);
        if(sizeof($cart_offers) > 0):
        ?>
        <div class="promotion_sticker get_right_sticker">
            <div class="prize_sticker_tag p-1">
                <p class="p-0 m-0 text-center" style="font-weight: bold; line-height: 16px;">Bundle Offer</p>
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

		<div class="pricing-card flex-row justify-content-between align-items-end <?php if(get_cookie("language") == 'AR'): echo "text-right"; else: echo "text-left"; endif ?>">
			<?php  if($discount["discount_amount"] > 0): ?>
			<div class="col-7 col-lg-auto p-0">
				<div class="card-subtitle col-auto p-0">
					<span>
						<?php echo bcdiv($v->price, 1, 2);?>
						<span class="currency"> <?php echo lg_get_text("lg_102") ?> </span>
					</span>
				</div>
				<p class="offer-price card-text">
					<?php echo ($discount["new_price"]); ?>
					<span class="currency"><?php echo lg_get_text("lg_102") ?></span>
				</p>
			</div>

			<?php else: ?>
			<div class="col-7 col-lg-auto p-0">
				<div class="card-subtitle">
					<!-- <span> 
						<span>  &nbsp </span>
					</span> -->
				</div>
				<p class="offer-price card-text"><?php echo bcdiv($v->price, 1, 2);?><span class="currency"><?php echo lg_get_text("lg_102") ?></span></p>
			</div>
			<?php endif; ?>

			<div class="col-5 d-flex flex-column justify-content-center align-items-end p-0 text-center">
            	
            	<!-- promotion sticker -->
				<?php 
				if($discount["discount_amount"] > 0): 
					if(strtolower($discount["discount_type"]) == "percentage" && $v->discount_rounded == "Yes"): 
				?>
				<span style="border-radius:5px; padding:2px 4px; font-size: .7rem; border: solid 1px rgb(13, 163, 81); background: rgb(199 255 224); color: rgb(22, 145, 77)"><?php echo lg_put_text(round("-".$discount["discount_value"])."% off" , "تنزيل ".round($discount["discount_value"])."%") ?></span>
				<?php 
				    endif;
                elseif(!is_null($offer)):
                $get_ = (!is_null($offer->get_qty)) ? $offer->get_qty : "a prize";
                $prize_title = (isset($offer->prize_title)) ? $offer->prize_title : "Buy" . $offer->buy_qty . "Get" . $get_;
                ?>
                <span style="border-radius:5px; padding:2px 4px; font-size: .7rem; border: solid 1px #134b7b; background: #d0e7fc; color: #134b7b"><?php echo $prize_title ?></span>
                <?php 
				endif; 
				 ?>
				<!-- promotion sticker -->
				<?php if($v->available_stock < 5 && $v->available_stock > 0): ?>
				<span style="border-radius:5px; padding:4px 4px 0px; font-size: .7rem; color: rgb(163 0 0)"><?php echo lg_put_text("only $v->available_stock left" , "باقي $v->available_stock فقط") ?></span>
				<?php endif; ?>
        	</div>

		</div>
       

        <?php 
        if(!$hr):
        ?>
        <form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm" data-price="<?php if($discount["discount_amount"] > 0): $discount["new_price"]; else: echo $v->price; endif; ?>" data-sku="<?php echo $v->sku ?>">
            <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
            <input name="product_image" type="hidden" value="<?php if(@@$product_image[0]->image) echo @$product_image[0]->image; ?>" required>
            <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required>
            <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required>
            <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required>
            <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required>
            <div class="product_qty">
                <input name="quantity" type="number" value="1" required min="1">
            </div>
            <?php 
            if(@$v->available_stock>0){
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
			}
            else{
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
			?>
        </form>
        <?php endif; ?>
    </div>
</div>
<!-- Product Box -->