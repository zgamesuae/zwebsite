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
		.product_sorting_mobile_fixed_on_scrooll h5{display:none}
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
$productModel = model('App\Models\ProductModel');
$session = session();
@$user_id=$session->get('userLoggedin'); 


if (@$pagee) {}else{
?>
<div class="p-10px col-12 mb-3">
	<div class="row px-0 pb-3 product_sorting_mobile_fixed_on_scrooll col-sm-12 m-0 j-c-spacebetween a-a-flexstart">
	    <input type="hidden" value="<?php if($total_products) echo count(@$total_products);?>" id="totalProducts">
		<h5 class="m-0 text-capitalize col-md-12 col-lg-auto mb-3"><strong><span id="pgCount"><?php if($product) echo count($product);else echo 0;?> </span> <?php if(@$total_products) echo ' of '.count(@$total_products);?> Products <?php if(@$total_products) echo ' showing ';?></strong></h5>
		<div class="mobile_search_products d-block d-lg-none col-6 px-0">
                    <div class="icon_filter_m border" id="filter_open_mobile">
                        <span>Filter by</span>
                        <svg viewBox="0 0 16 13" id="icon-filter" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M.3 2.395h9.458c.177.888.977 1.618 1.955 1.618.978 0 1.778-.73 1.956-1.618h2.026c.16 0 .302-.107.302-.267 0-.16-.142-.267-.301-.267h-2.01c-.124-1.066-.959-1.76-1.973-1.76-1.013 0-1.867.694-1.974 1.76H.3c-.16 0-.302.107-.302.267 0 .16.142.267.302.267zM11.713.652c.765 0 1.387.622 1.387 1.387s-.622 1.387-1.387 1.387a1.388 1.388 0 0 1-1.387-1.387A1.39 1.39 0 0 1 11.713.652zm3.983 5.654c.16 0 .302.107.302.266 0 .16-.142.267-.302.267H7.589c-.178.889-.978 1.618-1.955 1.618-.978 0-1.778-.73-1.956-1.618H.3c-.16 0-.302-.107-.302-.267 0-.16.143-.266.302-.266h3.36c.125-1.067.96-1.76 1.974-1.76 1.013 0 1.849.693 1.973 1.76h8.089zM5.634 7.87c.764 0 1.386-.622 1.386-1.387 0-.764-.622-1.386-1.386-1.386-.765 0-1.387.622-1.387 1.386 0 .765.622 1.387 1.387 1.387zm10.062 2.88c.16 0 .302.107.302.267 0 .16-.142.266-.302.266h-4.054c-.177 1.067-.977 1.618-1.955 1.618-.978 0-1.778-.551-1.956-1.618H.301c-.16 0-.303-.107-.303-.266 0-.16.143-.267.302-.267h7.413c.107-1.067.96-1.76 1.974-1.76s1.85.693 1.974 1.76h4.035zm-6.01 1.582c.765 0 1.388-.622 1.388-1.387s-.623-1.387-1.387-1.387c-.765 0-1.387.622-1.387 1.387s.622 1.387 1.387 1.387z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
		<div class="sort_by border bg-white rounded d-flex col-6 col-lg-4 px-0 ">
			<div class="sort_by_option_news">
				<span>Sort By</span>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M19 3l4 5h-3v12h-2V8h-3l4-5zm-5 15v2H3v-2h11zm0-7v2H3v-2h11zm-2-7v2H3V4h9z"/></svg>
			</div>
			<div class="drop_down_sort_by_option">
				<a href="javascript:void(0);" onClick="sortby('Newest');">Newest To Oldest</a>
				<a href="javascript:void(0);" onClick="sortby('Oldest');"> Oldest To Newest</a>
				<a href="javascript:void(0);" onClick="sortby('Highest');">Price Highest To Lowest</a>
				<a href="javascript:void(0);" onClick="sortby('Lowest');">Price Lowest To Highest</a>
			</div>
		</div>
	</div>
</div>



<?php 
}
if($product){
	foreach($product as $k=>$v){
		$pid=$v->product_id;
		$sql="select * from product_image where     product='$pid' and status='Active' ";
		$product_image=$userModel->customQuery($sql);       
		?>
		<div class="p-10px col-md-3  col-sm-6 col-6 mb-3">
			<div class="product_box shadow-none bg-white rounded overflow-hidden">
				<a href="<?php echo $productModel->getproduct_url($v->product_id)?>">
					<div class="product_box_image">
						<?php 
						if(false){
						if($v->discount_percentage > 0 ){
							?>
							<div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
						<?php }} ?>
						<?php if(@$v->release_date !="" && @$v->pre_order_enabled=="Yes" && $v->release_date !="0000-00-00"): ?>
							<div class="release_date d-flex-row a-c-center" style=" position: absolute;background: linear-gradient(45deg, #0e0e0e, #646464, #000000);width: 100%;bottom: 0;"><p class="mb-0" style="color: white;">Release Date: <?php echo date('d/m/Y', strtotime($v->release_date));?></p></div>
						<?php endif; ?>
						<img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
					</div>
				</a>
				
				
				<div class="product_box_content">
				    <!-- Reduce title caracter -->
				    <?php 
						$p_title=(strlen($v->name) > 40) ? substr($v->name,0,40)."..." : $v->name;
					?>
					<h5>
					    <strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $p_title;?></a></strong>
					</h5>
					
					<?php if(@$v->release_date !="" && @$v->pre_order_enabled=="Yes" && $v->release_date !="0000-00-00" && false): ?>
						<p class="release_date">Release Date : <?php echo date('d/m/Y', strtotime($v->release_date));?></p>
					<?php endif; ?>
					<?php 
					if($productModel->get_discounted_percentage($v->product_id) > 0){
						?>
						<div class="pricing-card">
							<div class="card-subtitle">
								<span><?php echo bcdiv($v->price, 1, 2);?><span> AED </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo round(bcdiv($v->price - ($v->discount_percentage*$v->price)/100, 1, 2));?><span>AED</span></p>
					</div>
				<?php } else {
					?>
					
					
						<div class="pricing-card">
							<div class="card-subtitle">
								<span> <span>  &nbsp </span>
							</span>
						</div>
						<p class="offer-price card-text"><?php echo bcdiv($v->price, 1, 2);;?><span>AED</span></p>
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
				<?php if(@$v->available_stock>0){
					if($v->bundle_opt_enabled == "Yes" ):
				?>
					<button class="btn btn-primary view_detail p-sm-2" type="button"><a href="<?php echo base_url()."/product/".$v->product_id ?>">View details</a></button>
				<?php else:?>
					<button type="submit" class="btn btn-primary p-sm-2"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
				<?php endif;?>
					
            	<?php }else{ ?>
           			<button disabled class="btn btn-primary">Out of stock</button>
          		<?php } ?>
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
	<?php } ?>
	
	
	

<?php } ?>