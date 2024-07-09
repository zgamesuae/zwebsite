<style>
	.product_box_image img {
	    /*height: 357px;*/
	    object-fit: cover;
	    object-position: center;
	}
	
	.drop_down_sort_by_option{padding:9px 0}

	.drop_down_sort_by_option::after{content:"";
		position:absolute;
		left:14px;
		top:-9px;
		width:17px;
		height:17px;
		background:#fff;
		transform:rotate(45deg);
		border-top:1px solid #ded9d9;
		border-left:1px solid #ded9d9}
	.drop_down_sort_by_option a{display:block;
		padding:5px 11px;
		text-align:left;
		font-size:14px}
	.drop_down_sort_by_option{display:none;
		position:absolute;
		top:59px;
		right:11px;
		background:#fff;
		border-radius:5px;
		z-index:9999;
		border:1px solid #ded9d9}
	header.mobile_header.bg-primary.container-fluid .col-md-12{display:none}
	header.mobile_header .middle_header_show_sticky{display:block!important;
		position:fixed!important;
		background-color:#007bff!important;
		z-index:999}
	.mobile_header{min-height:60px}
	.sort_by_option_news{display:flex;
		justify-content:space-between;
		width:100%;
		padding:8px 5px;
		color:#4e5155;
		fill:#4e5155}
	@media screen and (max-width:600px){
		.mw-100{width:100%}
	
		.product_sorting_mobile_fixed_on_scrooll select{box-shadow:0 0 #fff!important}
		/*.product_sorting_mobile_fixed_on_scrooll h5{display:none}*/
		.breadcrumbs_nav{margin-top:40px}
		/* .product_sorting_mobile_fixed_on_scrooll{
			position:fixed;
			top:101px;
			width:51%;
			z-index:99999;
			right:0;
			background:#fff;
			padding:1px 3px!important;
			border-bottom:1px solid #dee2e6;
			border-left:1px solid #dee2e6;border-top:1px solid #dee2e6
		} */
	}

	.product_box_image img {
	    height: 267px;
	    width: 100%;
	    object-fit: contain !important;
	}

</style>
<?php
$userModel = model('App\Models\UserModel', false);
$ezpinModel = model('App\Models\Ez_pin' , false);
$productModel = model('App\Models\ProductModel');
$session = session();
@$user_id=$session->get('userLoggedin');
global $offerModel;
$offerModel = $_offerModel;

// var_dump($product);die();
// var_dump($ezpinModel->ezpin_get_catalogs_availabity((int)@$v->sku , 1 , (float)@$v->ez_price));die();
// var_dump($ezpinModel);die();

// function search_title($filters){
// 	$brandModel = model('App\Models\BrandModel');
// 	$categoryModel = model('App\Models\Category');
	
// 	$title = "";
// 	if($filters->getVar("keyword") && $filters->getVar("keyword") !== "" && !is_null($filters->getVar("keyword"))){
// 		$title = '"'.$filters->getVar("keyword").'"';
// 	}

// 	else if($filters->getVar("master_category") && $filters->getVar("master_category") !== "" && !is_null($filters->getVar("master_category"))){
// 		$title = lg_put_text($categoryModel->_getcatname($filters->getVar("master_category")) , $categoryModel->_getcatname($filters->getVar("master_category") , true) , false);
// 	}
	
// 	else if($filters->getVar("brand") && sizeof($filters->getVar("brand")) == 1 && $filters->getVar("brand")[0] !== "" && !is_null($filters->getVar("brand")[0])){
// 		$brand_name = lg_put_text($brandModel->_getbrandname($filters->getVar("brand")[0]) , $brandModel->_getbrandname($filters->getVar("brand")[0] , true) , false);
// 		$title = ($brand_name) ? $brand_name : "";
// 	}

// 	return $title;
// }

if (@$pagee) {}else{
?>

<?php 
// var_dump($productModel->getproduct_url("40211689696434")); die(); 
?>

<?php if(true): ?>
<div class="p-10px col-12">
	<div class="row px-0 pb-3 align-items-center product_sorting_mobile_fixed_on_scrooll col-sm-12 m-0 j-c-spacebetween a-a-flexstart">
	    <input type="hidden" value="<?php if($total_products) echo count(@$total_products);?>" id="totalProducts">
		<div class="m-0 text-capitalize col-md-12 col-lg-auto mb-2 mb-md-0">
			<span id="pgCount"><?php if($product) echo count($product);else echo 0;?> </span> 
			<?php if(@$total_products) echo lg_get_text("lg_139")." ".count(@$total_products);?> <?php echo lg_get_text("lg_142") ?> 
		</div>
	</div>
</div>
<?php endif; ?>



<?php 
}
if($product){
	foreach($product as $k=>$v){
		$pid=$v->product_id;
		$sql="select * from product_image where     product='$pid' and status='Active' ";
		$product_image=$userModel->customQuery($sql);       
		?>
		<div class="p-10px col-md-3  col-sm-6 col-6 mb-3">
			
			<?php echo view("products/Product_box" , ["user_id"=> $user_id , "v" => $v , "product_image" => $product_image , "hr" => false]); ?>
			
			<?php if(false): ?>
			<div class="product_box shadow-none bg-white rounded overflow-hidden">
			    
			    <!-- promotion sticker -->
			    <?php 
				$discount = $productModel->get_discounted_percentage($offerModel->offers_list , $v->product_id);
				$offer = ($offerModel->product_Get_N_offer_comply($v->product_id)) ?? $offerModel->product_prize_offer_comply($v->product_id);
				if($discount["discount_amount"] > 0 && false): 
					if(strtolower($discount["discount_type"]) == "percentage" && $v->discount_rounded == "Yes"): 
				?>
                <div class="promotion_sticker right_sticker" >
                    <div class="promotion_sticker_tag p-2" style=" ">
                        <p class="pl-4 m-0 text-right" style="font-weight: bold; font-size: 26px; line-height:26px "><?php echo round("-".$discount["discount_value"]) ?></p>
                        <p class="pl-2 m-0 text-right" style="font-weight: bold; font-size: 25px; line-height: 26px;">%</p>
                    </div>
                </div>
			    <!-- promotion sticker -->

				<!-- Buy N Get N -->
				<?php
        		    endif;
				elseif(!is_null($offer) && false):
        		?>
        		<div class="promotion_sticker get_right_sticker">
        		    <div class="<?php if(!is_null($offer->get_qty)) echo "get_sticker_tag"; else echo "prize_sticker_tag"; ?> p-1">
        		        <p class="p-0 m-0 text-center" style="font-weight: bold; line-height: 16px;">Buy <?php echo $offer->buy_qty ?> Get <?php if(!is_null($offer->get_qty)) echo $offer->get_qty; else echo "a prize"  ?></p>
        		    </div>
        		</div>
        		<?php 
        		endif; 
        		?>
        		<!-- Buy N Get N -->
			    
			    <!-- New sticker -->
                <?php if($productModel->is_new($v->product_id) && $v->pre_order_enabled !=='Yes'): ?>
                <div class="promotion_sticker left_sticker">
                    <div class="new_sticker_tag p-2">
                        <p class="text-center">NEW</p>
                    </div>
                </div>
                <?php endif; ?>
                <!-- New sticker -->

				<a href="<?php echo $productModel->getproduct_url($v->product_id)?>">
					<div class="product_box_image">
						<?php 
						if(false){
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php }} ?>
						<?php if(@$v->release_date !="" && @$v->pre_order_enabled=="Yes" && $v->release_date !="0000-00-00"): ?>
							<div class="release_date d-flex-row a-c-center" style=" position: absolute;background: linear-gradient(45deg, #0e0e0e, #646464, #000000);width: 100%;bottom: 0;"><p class="mb-0" style="color: white;"><?php echo lg_get_text("lg_53") ?>: <?php echo date('d/m/Y', strtotime($v->release_date));?></p></div>
						<?php endif; ?>
						<img alt="<?php echo $v->name ?>" src="<?php echo base_url() ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
					</div>
				</a>
				
				
				<div class="product_box_content">
				    <?php 
						$p_title=(strlen(lg_put_text($v->name , $v->arabic_name , false)) > 50) ? substr(lg_put_text($v->name , $v->arabic_name , false),0,50)."..." : lg_put_text($v->name , $v->arabic_name , false);
					?>
					<h5 class="<?php text_from_right() ?>">
					    <strong><a href="<?php echo $productModel->getproduct_url($v->product_id)?>"><?php echo $p_title;?></a></strong>
					</h5>
					
					<?php if(@$v->release_date !="" && @$v->pre_order_enabled=="Yes" && $v->release_date !="0000-00-00" && false): ?>
						<p class="release_date"><?php echo lg_get_text("lg_53") ?> : <?php echo date('d/m/Y', strtotime($v->release_date));?></p>
					<?php endif; ?>
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
						<?php 

						// if(@$v->available_stock > 0 || ($v->type == "6" && $ezpinModel->ezpin_get_catalogs_availabity((int)@$v->sku , 1 , (float)@$v->ez_price))){
						if(@$v->available_stock > 0){
							if($v->bundle_opt_enabled == "Yes" || $v->product_nature == "Variable"):
						?>
							<button class="btn btn-primary view_detail p-sm-2" type="button"><a href="<?php echo $productModel->getproduct_url($v->product_id)?>"><?php echo lg_get_text("lg_56") ?></a></button>
						<?php else:?>
							<button type="submit" class="btn btn-primary p-sm-2"><?php if($v->pre_order_enabled=="Yes") echo lg_get_text("lg_54") ;else echo lg_get_text("lg_33");?></button>
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
								<div class="add_to_whishlist <?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
								</div>
								<?php
							}else{
								?>
								<div class="add_to_whishlist" data-toggle="modal" data-target="#login-modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
								</div>
								<?php
							}
							?>
					</form>
				</div>
			</div>
			<?php endif; ?>

		</div> 
	</div> 
	<?php } ?>
	
	
	

<?php } ?>