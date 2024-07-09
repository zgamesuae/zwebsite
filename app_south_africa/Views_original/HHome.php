<?php




 
$userModel = model('App\Models\UserModel', false);
$session = session();
@$user_id=$session->get('userLoggedin'); 
 





 
$sql="select * from banner where status='Active'";
$banner=$userModel->customQuery($sql);


$sql="select * from mobile_banner where status='Active'";
$mobile_banner=$userModel->customQuery($sql);

$sql="select * from offer_banner where status='Active'";
$offer_banner=$userModel->customQuery($sql);
?>
<div id="myCarousel" class="home_slider_boostrap carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
   <?php
   if($banner){ 
    foreach($banner as $k=>$v){
      ?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $k;?>" class="<?php if($k==0) echo 'active';?>"></li> <?php }} ?>
    </ol>
    <div class="carousel-inner">
      <?php
      if($banner){ 
        foreach($banner as $k=>$v){
          ?>
          <div class="carousel-item <?php if($k==0) echo 'active';?>">
              <a href="<?php echo $v->link;?>">
            <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"   class="w-100 is_visable_desktop">
            <img src="<?php echo base_url();?>/assets/uploads/<?php if($mobile_banner[$k]->image) echo $mobile_banner[$k]->image;else echo $v->image;?>"   class="w-100 is_visable_mobile" style="display:none">
            </a>
          </div>
        <?php }} ?>
      </div>
    </div>
    
 
    <div class="container-fluid bg-light p-0 pt-5 shop_by_category_list">
      <div class="container pb-4">
        <div class="row">
          <div class="col-md-12">
            <h4 class="text-capitalize"><strong>Shop by category</strong></h4>
          </div>
        </div>
        <div class="row shop_by_category_list_newss d-none">
          <?php
          $sql="select * from master_category where     parent_id='0'";
          $master_category=$userModel->customQuery($sql);
          if($master_category){
            foreach ($master_category as $key => $value) {
              $sql="select * from category_image where     category='$value->category_id' and status='Active'";
              $category_image=$userModel->customQuery($sql);
              ?> 
              <div class="col-xl-2 col-lg-2 col-md-3 col-4 mt-3">
               <a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>" class="category_box_on_the_top">
                <div class="box" style="background-image: url('<?php echo base_url();?>/assets/uploads/<?php if($category_image[0]->image) echo $category_image[0]->image;else echo 'noimg.png';?>');">
                </div>
                <h5><strong><?php echo $value->category_name;?></strong></h5>
              </a>
            </div>
          <?php }} ?>
        </div>  
          <div class="category-card desktop_view_category row mt-2">
              
              
                <?php
          $sql="select * from master_category where     parent_id='0'";
          $master_category=$userModel->customQuery($sql);
          if($master_category){
            foreach ($master_category as $key => $value) {
              $sql="select * from category_image where     category='$value->category_id' and status='Active'";
              $category_image=$userModel->customQuery($sql);
              ?> 
	<div class="col-12 col-md-4 col-lg-3">
		<a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>">
			<div class="cg-item <?php if($key%2==0) echo 'right';else echo 'left';?> <?php   if($value->color_name) echo $value->color_name;else echo 'green';?>">
				<div class="cg-col">
					<figure><img src="<?php echo base_url();?>/assets/uploads/<?php if($category_image[0]->image) echo $category_image[0]->image;else echo 'noimg.png';?>"></figure>
					<div class="cg-content">
						<h4><?php echo $value->category_name;?></h4><i class="fa fa-certificate	
"></i>
						<a href="<?php echo base_url();?>/product-list?category=<?php echo $value->category_id;?>" as="/toys/lego-and-building-toys/"></a>
					</div>
				</div>
			</div>
		</a>
	</div>
	 <?php }} ?>
	
	 
</div>
     
     </div>
      <div class="container pb-5">
        <div class="row">
            <?php 
            if($offer_banner){
                foreach($offer_banner as $k=>$v){
            
            ?>
          <div class="col-sm-6 mt-5">
            <div class="category_box_secondary">
              <a href="<?php echo base_url();?>/product-list?offer=<?php echo $v->discount_percentage;?>">
                <div class="box_thumbnail">
                  <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="h-400"  >
                </div>
              </a><div class="box_category_content text-center  text-capitalize pt-3"><a href="#">
                <h6><strong><?php echo $v->title;?></strong></h6>
                <p class="text-gray"><?php echo $v->text;?></p>
              </a><a href="<?php echo base_url();?>/product-list?offer=<?php echo $v->discount_percentage;?>" class="btn btn-black text-small"> shop now </a>
            </div>
          </div>
        </div>
        
        <?php }} ?>
       
    </div>  
  </div>
  <div class="container pb-5">
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-capitalize"><strong>Shop by age</strong></h4>
      </div>
      <div class="col-12 mt-3">
       <div class="owl-carousel owl-theme age_box_slider">
         <?php
         $sql="select * from age where     status='Active'";
         $age=$userModel->customQuery($sql);
         if($age){
          foreach ($age as $k => $v) {
            ?> 
            <div class="item">
              <a href="<?php echo base_url();?>/product-list?age=<?php echo $v->id;?>">
                <div class="age_box" style="background-color: <?php echo $v->color_code;?>">
                  <h5 class="age_range"><?php echo $v->title;?></h5>
                  <h4><strong><?php echo $v->description;?></strong></h4>
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
<div class="container pb-5">
  <div class="row">
    <div class="col-md-12">
      <h4 class="text-capitalize"><strong>Super Savings on Outdoor!</strong></h4>
    </div>
    <div class="col-12 mt-1 ">
     <div class="row m-10px">
         <div class="owl-carousel products_list">
             <?php
      $sql="select * from products where     status='Active' AND show_this_product_in_home_page='Yes'  order by precedence asc ";
      $products=$userModel->customQuery($sql);
      if($products){
        foreach ($products as $k => $v) {
          $pid=$v->product_id;
          $sql="select * from product_image where     product='$pid' and status='Active' ";
          $product_image=$userModel->customQuery($sql);       
          ?> 
          <div class="item">
             <div class="product_box shadow-none bg-white rounded overflow-hidden">
              <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                <div class="product_box_image">
                    <div class="product_label_offer">24% off</div>
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
                <h5 ><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo substr($v->name,0,40);?></a></strong></h5>
                <div class="pricing-card">
                     <?php 
                 if($v->discount_percentage > 0 ){
                 ?>
                     <div class="card-subtitle">
                      <span><?php echo number_format($v->price) ;?>AED</span>
                     
                      </div>
                      <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span>AED</span></p>
                      
                       <?php } else {
                  ?> <div class="card-subtitle">
                     
                      </div>
                      <p class="offer-price card-text"><?php echo number_format($v->price);?><span>AED</span></p>
                      
                        <?php
                  }?>
                    </div>
                <div class="d-none products_price text-small text-primary font-weight-bold">
                 
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
                </div>
             <!--  <form class="products_add_to_cart each_products_add_card_list">
                    <div class="product_qty">
                        <input type="number" value="1">
                    </div>
                    <button class="btn btn-primary">Add To Cart</button>
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
                    </a>
                </form>-->
                		<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
					<input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
					<input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
					<input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
					<div class="product_qty">
						<input name="quantity" type="number" value="1" required min="1" >
					</div>
					<button type="submit" class="btn btn-primary">Add To Cart</button>
					<?php
					if($user_id){
						?>
						<a href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
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
          <?php
        }
      }
      ?>
        </div>
      
          
    </div>
  </div>
</div>  
</div>
</div><!--
<div class="mobile_menu_bottom_fixed" style="display: none;">
  <ul>
    <li><a href="#"><div class="icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M21 20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.49a1 1 0 0 1 .386-.79l8-6.222a1 1 0 0 1 1.228 0l8 6.222a1 1 0 0 1 .386.79V20zm-2-1V9.978l-7-5.444-7 5.444V19h14z"/></svg></div><span>home</span></a></li>
    <li><a href="#"><div class="icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 4h13v2H8V4zm-5-.5h3v3H3v-3zm0 7h3v3H3v-3zm0 7h3v3H3v-3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z"/></svg></div><span>categories</span></a></li>
    <li class="active"><a href="#"><div class="icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M10.9 2.1l9.899 1.415 1.414 9.9-9.192 9.192a1 1 0 0 1-1.414 0l-9.9-9.9a1 1 0 0 1 0-1.414L10.9 2.1zm.707 2.122L3.828 12l8.486 8.485 7.778-7.778-1.06-7.425-7.425-1.06zm2.12 6.364a2 2 0 1 1 2.83-2.829 2 2 0 0 1-2.83 2.829z"/></svg></div><span>offers</span></a></li>
    <li><a href="#"><div class="icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg></div><span>wishlist</span></a></li>
    <li><a href="#"><div class="icon"><svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.34 17a10.018 10.018 0 0 1-.978-2.326 3 3 0 0 0 .002-5.347A9.99 9.99 0 0 1 4.865 4.99a3 3 0 0 0 4.631-2.674 9.99 9.99 0 0 1 5.007.002 3 3 0 0 0 4.632 2.672c.579.59 1.093 1.261 1.525 2.01.433.749.757 1.53.978 2.326a3 3 0 0 0-.002 5.347 9.99 9.99 0 0 1-2.501 4.337 3 3 0 0 0-4.631 2.674 9.99 9.99 0 0 1-5.007-.002 3 3 0 0 0-4.632-2.672A10.018 10.018 0 0 1 3.34 17zm5.66.196a4.993 4.993 0 0 1 2.25 2.77c.499.047 1 .048 1.499.001A4.993 4.993 0 0 1 15 17.197a4.993 4.993 0 0 1 3.525-.565c.29-.408.54-.843.748-1.298A4.993 4.993 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8.126 8.126 0 0 0-.75-1.298A4.993 4.993 0 0 1 15 6.804a4.993 4.993 0 0 1-2.25-2.77c-.499-.047-1-.048-1.499-.001A4.993 4.993 0 0 1 9 6.803a4.993 4.993 0 0 1-3.525.565 7.99 7.99 0 0 0-.748 1.298A4.993 4.993 0 0 1 6 12c0 1.26-.47 2.437-1.273 3.334a8.126 8.126 0 0 0 .75 1.298A4.993 4.993 0 0 1 9 17.196zM12 15a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg></div><span>setting</span></a></li>
  </ul>
</div>-->