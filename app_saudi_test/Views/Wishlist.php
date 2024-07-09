

<?php

  $session = session();
  $userModel = model('App\Models\UserModel', false);
  $productModel = model('App\Models\ProductModel');

  $uri = service('uri'); 
  @$user_id=$session->get('userLoggedin'); 
  if(@$user_id){
      $sql="select * from users where user_id='$user_id'";
      $userDetails=$userModel->customQuery($sql);
  }

?>


<style>
  .bg-light {
    background-color: #eeeeee !important;
  }

  .text-muted {
    color: #6c757d!important;
  }

  img.products_cart_image {
    width: 133px;
    max-height: 130px;
    object-fit: contain;
    /* margin-right: 26px; */
    border: 1px solid #e8e8e8;
  }

  .quanitity_div_parent {
    height: fit-content;
  }

  .add_to_card_wishlist_button {
    white-space: pre;
  }
</style>

<div class="container-fluid p-0 bg-light pb-5" <?php content_from_right() ?>>
  <?php include 'Common/Breadcrumb.php';?>
    <div class="container pb-5 mb-2 mb-md-4  pt-5">
      <div class="row">
 
        <div class="col-lg-4">
          <?php include 'Common/UserMenu.php';?>
        </div>

        <section class="col-lg-8 bg-white">

          <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
           <h1 class="h3 mb-0"><?php echo lg_get_text("lg_241") ?> </h1><a class="btn btn-primary text-white ps-2" href="<?php echo base_url();?>/product-list"><i class="ci-arrow-left me-2"></i><?php echo lg_get_text("lg_200") ?></a>
          </div>
           
          <?php 
            $session = session();
            $userModel = model('App\Models\UserModel', false);
            @$user_id=$session->get('userLoggedin'); 
            $sql="select * from wishlist inner join products on products.product_id =wishlist.product_id where wishlist.user_id='$user_id'";
            $wishlist=$userModel->customQuery($sql);   
            if($wishlist){
              foreach($wishlist as $k=>$v){
                $bid=$v->brand;
                $sql="select * from brand where id=$bid;";
                $brands=$userModel->customQuery($sql); 
                              
                $aid=$v->age;
                $sql="select * from age where id=$aid;";
                $age=$userModel->customQuery($sql);
                              
                $sid=$v->suitable_for;
                $sql="select * from suitable_for where id=$sid;";
                $suitable_for=$userModel->customQuery($sql); 
                $pid=$v->product_id;
                $sql="select * from product_image where product='$pid' and status='Active' ";
                $product_image=$userModel->customQuery($sql);   
          ?>
            
          <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom products_card_box">
            <div class="d-block d-sm-flex align-items-center  text-sm-start">
                  
              <a class="d-inline-block flex-shrink-0 mx-auto mx-sm-4" href="<?php echo $productModel->getproduct_url($pid)?>">
                <img src="<?php echo base_url();?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png';?>" class="products_cart_image" alt="Product">
              </a>
                  
              <div class="pt-2 <?php text_from_right() ?>">
                  
                <h5 class="product-title fs-base mb-2">
                  <a href="<?php echo $productModel->getproduct_url($pid)?>">
                    <?php echo $v->name;?> 
                  </a>
                </h5>
                  
                <div class="fs-sm"><span class="text-muted me-2">
                  <?php echo lg_get_text("lg_170") ?> : </span><?php echo lg_put_text(@$brands[0]->title , @$brands[0]->arabic_title);?>
                </div>
                  
                <div class="fs-sm"><span class="text-muted me-2">
                  <?php echo lg_get_text("lg_131") ?> : </span><?php echo lg_put_text(@$suitable_for[0]->title , @$suitable_for[0]->arabic_title);?>
                </div>
                  
                <div class="fs-sm">
                  <span class="text-muted me-2"><?php echo lg_get_text("lg_130") ?> : </span> <?php echo @$age[0]->title;?>
                </div>
                  
                  
                <div class="fs-lg text-accent pt-2">
                  
                  
                  <?php 
                  if(@$v->discount_percentage > 0)
                  {
                  ?>
    
                    <?php 
                  
                      if($v->discount_rounded == "Yes")
                      echo bcdiv(round(@$v->price-(@$v->price*@$v->discount_percentage)/100),1,2);
                      else
                      echo bcdiv(@$v->price-(@$v->price*@$v->discount_percentage)/100,1,2);


                    ?> 
                    <?php echo lg_get_text("lg_102") ?> 
                    <del><?php echo number_format(@$v->price);?> <?php echo lg_get_text("lg_102") ?></del> 
                  
                  <?php
                  }
                
                  else
                  {
                  ?>
    
                   <?php echo number_format(@$v->price);?> <?php echo lg_get_text("lg_102") ?> 
                  
                  <?php
                  }
                  ?>
                
                </div>
              </div>
            </div>
                
            <!-- ADD TO CART OR REMOVE FROM WHISH LIST  -->
            <div class="p-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0  text-sm-start" style="max-width: 17rem;">
                
              <form method="post">
                
                <input type="hidden" name="id" value="<?php echo $v->id;?>">
                
                <button class="btn btn-primary w-100" type="submit">
                  <span class="fs-sm"><?php echo lg_get_text("lg_242") ?></span>
                </button>
                
              </form>
              
            	<form class="products_add_to_cart each_products_add_card_list buy-now-form  d-flex mt-3" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
			    		  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required>
			    		  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required>
			    		  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required>
			    			<input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required>
			    			<input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required>
			    		  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required>
                
			    		  <div class="quanitity_div_parent mr-2">
            	    <div class="quantitynumber">
                
            		    <span class="minus">
            			    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path>
                      </svg>
            		    </span>
                
                    <input class="form-control" name="quantity" type="number" value="1" required min="1">
                
            		    <span class="plus">
            		    	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path>
                      </svg>
            		    </span>
                
            	    </div>		
                
                </div>
                
			    		  <button type="submit" class="btn btn-primary w-100 add_to_card_wishlist_button px-2"><?php if($v->pre_order_enabled=="Yes") echo lg_get_text("lg_54");else echo lg_get_text("lg_33");?></button>
                
			    	  </form>

                
              <!-- <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>" class="btn btn-primary mb-10 w-100" style="margin-top:10px;" type="button"><span class="fs-sm">view</span></a>  -->
                
            </div>
            <!-- END ADD TO CART OR REMOVE FROM WHISH LIST  -->

                
          </div>
        
          <!-- Item-->
           <?php }}else{ 
           ?>
           <h6><?php echo lg_get_text("lg_243") ?></h6>
          
           <?php
           } ?>
         
        </section>
       
      </div>
    </div>
</div>








 