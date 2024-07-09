<link rel="stylesheet" href="<?= base_url() ?>/assets/gallery/lightgallery.css">

<style>
    .products_add_to_cart .btn-primary {
        max-width: unset !important;
    }

    @media screen and (min-width: 700px) {
        .carousel-item .pdetail-img {
            max-height: 450px;
            text-align: center;
            margin: auto;
            max-width:100%;
        }

        #carousel-thumbs img.img-fluid {
            max-width: unset;
            max-height: 160px;
            max-width: 100%;
        }
    }
</style>


<?php  
    $session = session(); 
    $userModel = model('App\Models\UserModel', false); 
    $productModel = model("App\Models\ProductModel");
    $brandModel = model("App\Models\BrandModel");
    $reviewModel = model("App\Models\ReviewModel");
    $attributeModel = model("App\Models\AttributeModel");


    $uri = service('uri');  
    @$user_id=$session->get('userLoggedin');  
    if(@$user_id){ 
     $sql="select * from users where user_id='$user_id'"; 
     $userDetails=$userModel->customQuery($sql); 
    }   

    $has_options= false;
    if($products[0]->bundle_opt_enabled == "Yes")
    $has_options= true;
    

    if($has_options){
        $opt=$userModel->customQuery("select * from bundle_opt where product_id='".$products[0]->product_id."'");
        // var_dump($opt);die();
        
    }
    
    $product_reviews = $reviewModel->get_product_reviews($products[0]->product_id);
    // var_dump($products);die();
?>


<!-- Page location links -->
<div class="container breadcrumbs_nav">
    <ul>
        <li><a href="<?php echo base_url();?>">Home </a><span>/ </span> </li>
        <li><a href="<?php echo base_url();?>/product-list">Product </a><span>/ </span> </li>
        <li>
            <?php echo @$products[0]->name;?>
        </li>
    </ul>
</div>

<!-- Mian content -->
<div class="container pt-2 padding_unset_none pb-4">
    <div class="row errors-back j-c-center col-12">
        
    </div>
    <div class="row pt-3 padding_unset_none">

        <!-- images section -->
        <div class="col-md-7">
            <!-- Carousel -->
            <div id="carousel" class="single_page_slider carousel slide gallery" data-ride="carousel"
                data-interval="false" data-interval="10000">
                <div class="carousel-inner">
                    <?php if(@$products[0]->youtube_link){ 
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', @$products[0]->youtube_link, $match); 
                    $youtube_id = $match[1]; 
                    ?>
                    <div class="carousel-item active" data-slide-number="0" data-toggle="lightbox"
                        data-gallery="gallery" data-remote="https://source.unsplash.com/vbNTwfO9we0/1600x900.jpg">
                        <iframe id="youtubeIfram" style="width:100%;height:500px"
                            src="https://www.youtube.com/embed/<?php echo @$youtube_id;?>" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                    <?php } ?>
                    <?php  
                    if($product_image){ 
                     foreach($product_image as $k=>$v){  
                      ?>
                    <div class="carousel-item   <?php if(@$products[0]->youtube_link=="" &&  $k==0) echo 'active';   ?>"
                        data-slide-number="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>"
                        data-toggle="lightbox" data-gallery="gallery"
                        data-remote="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>">
                        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"
                               class="d-block   pdetail-img" alt="...">
                    </div>
                    <?php 
                      } 
                    }else{ 
                    ?>
                    <div class="carousel-item active"
                        data-slide-number="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>"
                        data-toggle="lightbox" data-gallery="gallery"
                        data-remote="<?php echo base_url();?>/assets/uploads/noimg.png">
                        <img src="<?php echo base_url();?>/assets/uploads/noimg.png" class="d-block w-100" alt="...">
                    </div>
                    <?php 
                    } 
                    ?>
                </div>
                <?php  
                if($product_image){ 
                    if(count(@$product_image)>1){ 
                ?>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="box_control_nav" aria-hidden="true">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                               <path fill="none" d="M0 0h24v24H0z" /> 
                               <path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z" /> 
                           </svg> 
                       </span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="box_control_nav" aria-hidden="true">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                               <path fill="none" d="M0 0h24v24H0z" /> 
                               <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" /> 
                           </svg> 
                       </span>
                    <span class="sr-only">Next</span>
                </a>
                <a class="carousel-fullscreen" href="#carousel" role="button">
                    <span class="carousel-fullscreen-icon" aria-hidden="true"></span>
                    <span class="sr-only">Fullscreen</span>
                </a>
                <a class="carousel-pause pause" href="#carousel" role="button">
                    <span class="carousel-pause-icon" aria-hidden="true"></span>
                    <span class="sr-only">Pause</span>
                </a>
                <?php }} ?>
            </div>
            <!-- Carousel Navigatiom -->
            <div id="carousel-thumbs" class="carousel slide" data-ride="carousel" data-interval="10000">
                <div class="carousel-inner">
                    <?php  
                    $i=1; 
                    if($product_image){ 
                        if(count($product_image)>1){ 
                     foreach($product_image as $k=>$v){  
                      ?>
                    <?php if($i==1){?>
                    <div class="carousel-item <?php if($k==0) echo 'active';?>" data-slide-number="<?php echo $k;?>">
                        <div class="row mx-0">
                            <?php } ?>
                            <?php if(@$products[0]->youtube_link!="" AND $k==0){?>
                            <div id="carousel-selector-<?php echo $k;?>" class="thumb col-3 px-1 py-2 selected"
                                data-target="#carousel" data-slide-to="<?php echo $k;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/yt.jpg" class="img-fluid"
                                       alt="...">
                            </div>
                            <?php } ?>
                            <div id="carousel-selector-<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>"
                                class="thumb col-3 px-1 py-2" data-target="#carousel"
                                data-slide-to="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"
                                       class="img-fluid" alt="...">
                            </div>
                            <?php 
                            if(   (count($product_image) < 4  &&  count($product_image)==1 && $i==1 )   ||  (count($product_image) < 4  &&  count($product_image)==2 && $i==2 )  ||  (count($product_image) < 4  &&  count($product_image)==3 && $i==3 )    ||@$products[0]->youtube_link!="" && $i==3 || @$products[0]->youtube_link=="" && $i==4 || count($product_image)==1 || count($product_image)==2 && $i>1){ 
                              $i=1; 
                              ?>
                        </div>
                    </div>
                    <?php 
                    }else{ 
                     $i++; 
                    } 
                    ?>
                    <?php 
                    } 
                    }} 
                    ?>
                </div>
                <?php  if($product_image){ 
                if(count($product_image)>1){ 
                ?>
                <style>
                    .carousel-control-prev,
                    .carousel-control-next {
                        display: none !important;
                    }
                </style>
                <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
                <?php }} ?>
            </div>
        </div>
                
        <!-- Product details section -->
        <div class="col-md-5 pt-3 " >
            <div class="products_details" product_id="<?php echo $products[0]->product_id?>">
                <div class="mb-3 products_title">
                    <h1>
                        <?php echo @$products[0]->name;?>
                    </h1>
                    <div class="product_rank_str">
                        <?php if($pro_over_rating){ 
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
                        } 
                        ?>
                    </div>
                </div>

                <div class="brand pt-2 pb-2 d-flex align-items-center row col-12">
                    <h6 class="m-0"><strong>Brand:</strong></h6>
                    <a href="<?php echo $brandModel->get_brand_url($brands[0]->id)?>"><span class="pl-2"> <?php echo @$brands[0]->title;?> </span></a>
                    
                </div>
                <?php if(true):?>
                <div class="product_variations row p-0 m-0 my-2 col-12">
                    <?php 
                    $product_attributes = $productModel->get_attributes($products[0]->product_id);
                    if(sizeof($product_attributes) > 0 && $products[0]->product_nature == "Variable"):

                        foreach($product_attributes as $attribute_id): 
                            $i=0;$j=0;$ii=0;
                    ?>
                        <div class="p-0 my-3 col-12 attribute_section">
                            <div class="col-12">
                                <h6><strong><?php echo $attributeModel->get_attribute_name($attribute_id) ?></strong></h6>
                            </div>
                            <div class="col-12">
                                <!-- Hiden attribute select form -->
                                <select name="option[<?php echo $attribte_id?>]" id="" attribute_id="<?php echo $attribute_id ?>" class="d-none">
                                    <option value=""></option>
                                    <?php 
                                    // var_dump($productModel->get_product_options_on_attribute(null , null , $attribute_id , $products[0]->product_id) , $attribute_id , $products[0]->product_id);die();
                                        foreach($productModel->get_product_options_on_attribute(null , null , $attribute_id , $products[0]->product_id) as $option_id):
                                        $option = $attributeModel->get_option(preg_replace("/\"/" , "" , $option_id->option_id));
                                        // var_dump(preg_replace("/\"/" , "" , $option_id->result));

                                        if($option):
                                    ?>
                                    <option value="<?php echo $option->id ?>" <?php if($j==0) echo "selected"; ?>>
                                            <?php echo $option->name ?>
                                    </option>             
                                    <?php $j++; endif;endforeach;?>
                                </select>   

                                <!-- UI attribute options -->
                                <ul class="col-12 d-flex-row j-c-start p-0 m-0 ">
                                    <?php 
                                        foreach($productModel->get_product_options_on_attribute(null , null , $attribute_id , $products[0]->product_id) as $option_id):
                                        $option = $attributeModel->get_option(preg_replace("/\"/" , "" , $option_id->option_id));
                                        
                                        $stock = $productModel->get_variation_total_stock(array($attribute_id.":".preg_replace("/\"/" , "" , $option_id->option_id)) , $products[0]->product_id);
                                        
                                        if($option):

                                    ?>
                                    <li class="<?php if($i == 0 && !$option->thumb_url) echo "selected "; elseif($i == 0 && $option->thumb_url) echo " ybr selected "; if($stock > 0) echo "active"; else echo "disabled";?> col-3 p-0 mx-2 var_option d-flex-column a-a-center <?php if(!$option->thumb_url) echo "border" ?>" style="text-align:center">
                                    <?php 
                                            $img= $productModel->get_roduct_image_from_variation_option($attribute_id , preg_replace("/\"/" , "" , $option_id->option_id) , $products[0]->product_id);
                                            if(sizeof($product_attributes) == 1 && $img !== null): ?>
                                            <img src="<?php echo base_url()."/assets/uploads/".$img?>" alt="" <?php if($stock<=0): echo "style='mix-blend-mode:luminosity'";endif ?>>
                                            <?php elseif(trim($option->thumb_url) !== ""):?>
                                            <img src="<?php echo base_url()."/assets/others/".$option->thumb_url?>" alt="" <?php if($stock<=0): echo "style='mix-blend-mode:luminosity'";endif ?>>
                                            <?php else:?>
                                            <span><?php echo $option->name ?></span>
                                            <?php endif; ?> 

                                    </li>             
                                    <?php $i++; endif;endforeach;?>
                                </ul>


                            </div>
                        </div>
                    <?php endforeach;endif;?>
                </div>
                <?php endif;?>
                <?php if($products[0]->type == 12): ?>
                    <div class="d-flex col-12 pt-2 pb-2 px-0">
                        <ul class="pp_additional_infos">
                            <li>Limited stock quantity</li>
                            <li>Limited order quantity 1 per customer</li>
                        </ul>
                    </div>
                <?php endif;?>

              
                <!-- Show release date if exist -->
                <?php 
                    if(@$products[0]->release_date!="" && @$products[0]->pre_order_enabled=="Yes" && $products[0]->release_date!="0000-00-00"){ 
                ?>
                <div class="brand pt-2 pb-2 d-flex align-items-center">
                    <h6 class="m-0"><strong>Release Date:</strong></h6>
                    <span class="pl-2"><?php echo date('d/m/Y', strtotime(@$products[0]->release_date));?> </span>
                </div>

                <?php } ?>

                <!-- Product Price  -->
                <div class="pricing-card mt-2">
                    <div class="card-subtitle">
                        <?php  
                        // $discount_cond1=@$products[0]->discount_percentage > 0 && !$productModel->has_daterange_discount($products[0]->offer_start_date,$products[0]->offer_end_date);
                        // $discount_cond2= @$products[0]->discount_percentage > 0 && $productModel->has_daterange_discount($products[0]->offer_start_date,$products[0]->offer_end_date) && $productModel->is_date_valide_discount($products[0]->product_id);
                        // var_dump($discount_cond1,$productModel->is_date_valide_discount($products[0]->product_id));die();
                        if($productModel->get_discounted_percentage($products[0]->product_id) > 0){ 
                         ?>
                        <span><?php echo bcdiv(@$products[0]->price, 1, 2);?><span>AED</span></span>
                        <?php } ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php  

                        if($productModel->get_discounted_percentage($products[0]->product_id) > 0){
                             
                         ?>
                        <p class="offer-price card-text d-flex m-0">
                            <span style="font-size: inherit;font-weight:inherit"><?php echo round(bcdiv(@$products[0]->price - (@$products[0]->discount_percentage*@$products[0]->price)/100, 1, 2));?></span><span>AED</span>
                        </p>
                        <?php 

                        }
                        else{ 
                          ?>
                        <p class="offer-price card-text d-flex m-0">
                            <span style="font-size: inherit;font-weight:inherit"><?php echo bcdiv(@$products[0]->price, 1, 2);?></span><span>AED</span>
                        </p>
                        <?php }?>
                        <?php  
                            if(false){ 
                                if(@$products[0]->discount_percentage > 0){ 
                        ?>
                        <div class="badge-discount ml-2">
                            <?php echo @$products[0]->discount_percentage;?>% off
                        </div>
                        <?php } }?>
                    </div>
                </div>


                <!-- Assembly proffesionally elements -->
                <?php if(@$products[0]->assemble_professionally=="Yes"){?>
                <div class="product-option-message">
                    <div class="option-check d-flex justify-content-between">
                        <label class="checkbox light-green d-flex " for="installation-checkbox">
                               <input onclick="putassebly();" id="installation-checkbox" type="checkbox" 
                                   value="<?php if(@$products[0]->assemble_professionally_price) echo @$products[0]->assemble_professionally_price;?>"> 
                               <span class="checkmark" 
                                   style="background-image:url(<?= base_url() ?>/assets/img/assable.PNG)"></span> 
                               <span class="checklabel option-installation">Assemble Professionally</span> 
                           </label>
                        <span class="checkcount">
                               <?php if(@$products[0]->assemble_professionally_price==0 ){ 
                                  echo 'Free'; 
                                }else{ 
                                  echo @$products[0]->assemble_professionally_price.' AED'; 
                                }?> 
                           </span>
                    </div>
                </div>
                <?php } ?>


                <form style="display:flex;flex-direction:column" class="products_add_to_cart custom_select_boxes each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
                    <!-- If product is simple or variation -->
                    <?php if(in_array($products[0]->product_nature , array("Variation" , "Simple"))):?>
                    <input name="product_name" type="hidden" value="<?php echo @$products[0]->name;?>" required>
                    <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required>
                    <input name="product_id" id="product_id" type="hidden" value="<?php echo @$products[0]->product_id;?>" required>
                    <input name="assemble_professionally_price" id="assemble_professionally_price" type="hidden">
                    <input name="discount_percentage" type="hidden" value="<?php echo $products[0]->discount_percentage;?>" required>
                    <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $products[0]->pre_order_before_payment_percentage;?>" required>
                    <input name="pre_order_enabled" type="hidden" value="<?php echo $products[0]->pre_order_enabled;?>" required>

                    <?php 
                        elseif($products[0]->product_nature == "Variable"):
                    ?>
                    <input name="product_name" type="hidden" value="" required>
                    <input name="product_image" type="hidden" value="" required>
                    <input name="product_id" id="product_id" type="hidden" value="<?php echo @$products[0]->product_id;?>" required>

                    <?php  foreach($product_attributes as $attribute_id):  ?>
                    <input name="product_variation[]" attribute_id="<?php echo $attribute_id ?>" id="" type="hidden" value="" required>
                    <?php endforeach; ?>

                    <?php endif; ?>
                    <!-- end of the condition -->
                    
                    <?php if($has_options && isset($opt) && sizeof($opt) >= 2): ?>
                        <div class=" col-12 px-0 my-3">
                            <label for="bundle_opt"><b>Select an option*</b></label>
                            <select id="pp_bundle_opt_select" name="bundle_opt" id="" class="form-control">
                                <?php foreach($opt as $key => $value): ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->option_title ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    
                    <!--  <div class="product_qty"> 
                       <input   class="product_qty_single_page" name="quantity" type="number" value="1" required min="1" > 
                       <div class="qty_option"> 
                        <div class="qty_up"> 
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/></svg> 
                       </div> 
                       <div class="qty_down"> 
                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg> 
                       </div> 
                     </div> 
                    </div>-->


                    <!-- Button wish list and quantity -->
                    <div class="col-12 d-flex j-c-spacebetween px-0">
                        <div class="quanitity_div_parent mr-2">
                            <div class="quantitynumber">
                                <span class="minus">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                                           <path fill="none" d="M0 0h24v24H0z"></path> 
                                           <path 
                                               d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"> 
                                           </path> 
                                       </svg> 
                                   </span><input class="form-control" type="text" name="quantity" value="1">
                                <span class="plus">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                                           <path fill="none" d="M0 0h24v24H0z"></path> 
                                           <path 
                                               d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"> 
                                           </path> 
                                       </svg> 
                                   </span>
                            </div>
                        </div>


                        <!-- Button Add to cart, Pre-order or Showing Out of stock -->
                        <?php if( @$products[0]->available_stock>0){ ?>
                            <button type="submit" class="btn btn-primary"><?php if($products[0]->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
                        <?php }else{ ?>
                            <button disabled class="btn btn-primary">Out of stock</button>
                        <?php } ?>


                        <!-- WISH LIST BUTTON -->
                        <?php 
                            if($user_id){ 

                                $pid=@$products[0]->product_id; 
                                $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' "; 
                                $pwishlist=$userModel->customQuery($sql);  
                            
				        ?>

                        <a class="<?php echo @$products[0]->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo @$products[0]->product_id;?>','<?php echo @$products[0]->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
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
                    </div>
                </form>

                <!-- Additional information like delivery availability -->
                <div class="specification">
                    <?php if(@$age[0]->image){?>
                    <div class="icon">
                        <img src="<?= base_url() ?>/assets/uploads/<?php echo @$age[0]->image;?>">
                        <span>Suitable for age <?php echo @$age[0]->title;?></span>
                    </div>
                    <?php } ?>
                    <div class="icon">
                        <img src="<?= base_url() ?>/assets/img/icon2.PNG">
                        <span>Delivery Available <?php if($products[0]->type == 32) echo '(5 to 7 business days) for this product ' ?></span>
                    </div>
                </div>

                <!-- Social media share -->
                <div class="share_products d-flex">
                    <h5>share</h5>
                    <ul>
                        <li><a target="_blank"
                                href="https://www.facebook.com/sharer.php?u=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>"><img
                                       src="<?= base_url() ?>/assets/img/facebook.svg" alt=""></a></li>
                        <li><a target="_blank"
                                href="https://twitter.com/share?url=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>&text=<?php echo @$products[0]->name;?>&via=<?php echo base_url();?>&hashtags=<?php echo base_url();?>"><img
                                       src="<?= base_url() ?>/assets/img/twitter.svg" alt=""></a></li>
                        <li><a target="_blank"
                                href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo base_url();?>/assets/uploads/<?php echo $product_image[0]->image;?>&url=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>&description=<?php echo @$products[0]->name;?>"><img
                                       src="<?= base_url() ?>/assets/img/pinterest.svg" alt=""></a></li>
                        <li><a target="_blank"
                                href="mailto:?subject=<?php echo @$products[0]->name;?>&body=Check out this site: <?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>"
                                title="Share by Email';"><img src="<?= base_url() ?>/assets/img/email.svg"
                                       alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row j-c-spacearound">
        <!-- <div class="col-md-1  text-center mt-3"></div> -->

        <!-- Show Brand -->
        <div class="col-md-auto col-6 text-center mt-3">

            <h6>Brands</h6>
            <div class="list_of_burron">
                <a href="<?php echo $brandModel->get_brand_url($brands[0]->id) ?>">
                    <?php echo @$brands[0]->title;?>
                </a>
            </div>
        </div>

        <!-- Show product Type -->
        <?php  if($sf=@$products[0]->type){ ?>
        <div class="col-md-auto col-6 text-center mt-3">
            <h6>Type</h6>
            <div class="list_of_burron">
                <?php  
                $ar= array_values(array_unique(explode(",",$sf))); 
                  foreach( $ar as $k=>$v){ $sql="select * from type where type_id=$v;"; 
                  $suit=$userModel->customQuery($sql); 
                  ?>
                <a href="<?php echo base_url() ?>/product-list?type=<?php echo $suit[0]->type_id ?>">
                    <?php echo @$suit[0]->title;   ?>
                </a>
                <?php 
                } 
                ?>
            </div>
        </div>

        <!-- Show Suitable for -->
        <?php  } 
        if($sf=@$products[0]->suitable_for){?>
        <div class="col-md-auto col-6 text-center   mt-3">
            <h6>Suitable For</h6>
            <div class="list_of_burron">
                <?php  
                $ar= array_values(array_unique(explode(",",$sf))); 
                  foreach($ar  as $k=>$v){ $sql="select * from suitable_for where id=$v;"; 
                  $suit=$userModel->customQuery($sql); 
                  ?>
                <a href="<?php echo base_url() ?>/product-list?suitable_for=<?php echo $suit[0]->id ?>">
                    <?php echo @$suit[0]->title;   ?>
                </a>
                <?php 
                  } 
                ?>
            </div>
        </div>

        <!-- Show Age rating -->
        <?php } ?>
        <?php   if($sf=@$products[0]->age){ ?>
        <div class="col-md-auto col-6 text-center mt-3">
            <h6>Age</h6>
            <div class="list_of_burron">
                <?php  
                $ar= array_values(array_unique(explode(",",$sf))); 
                   foreach( $ar as $k=>$v){ $sql="select * from age where id=$v;"; 
                   $suit=$userModel->customQuery($sql); 
                   ?>
                <a href="<?php echo base_url() ?>/product-list?age=<?php echo $suit[0]->id ?>">
                    <?php echo @$suit[0]->title;   ?>
                </a>
                <?php 
                  } 
                ?>
            </div>
        </div>

        <!-- Show games Genre -->
        <?php    
            } 
            if($sf=@$products[0]->color){ 
        ?>
        <div class="col-md-auto col-6 text-center mt-3">
            <h6>Genre</h6>
            <div class="list_of_burron">
                <?php  
                $ar= array_values(array_unique(explode(",",$sf))); 
                   foreach($ar as $k=>$v){ $sql="select * from color where id=$v;"; 
                   $suit=$userModel->customQuery($sql); 
                   ?>
                <a href="<?php echo base_url() ?>/product-list?genre=<?php echo $suit[0]->id ?>">
                    <?php echo @$suit[0]->title;   ?>
                </a>
                <?php 
                } 
                ?>
            </div>
        </div>
        <?php } ?>

        <!-- <div class="col-md-1  text-center mt-3"></div> -->
    </div>

    <div class="row ">
        <?php  
        if(@$products[0]->description){ 
        ?>
        <div class="col-md-12 mt-3">
            <h4>Description</h4>
            <div class="desc">
                <p>
                    <?php echo @$products[0]->description;?>
                </p>
            </div>
        </div>
        <?php } ?>
        <?php if(@$products[0]->features){?>
        <div class="col-md-12 mt-3">
            <h4>Features</h4>
            <div class="desc">
                <p>
                    <?php echo @$products[0]->features;?>
                </p>
            </div>
        </div>
        <?php } ?>
        
        <?php 
            $pidd=@$products[0]->product_id; 
            $sql="select * from product_screenshot where     product='$pidd' and status='Active' "; 
            $product_screenshot=$userModel->customQuery($sql);  
            if($product_screenshot){ 
        ?>
        
        <div class="col-md-12 mt-3">
            <h4>Other images</h4>
            <div class="screenshot mt-2">
                
                <div class="owl-carousel owl-theme screeshot_sldier owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage gallery_open_1" id="lightgallery">
                            <?php 
                                foreach($product_screenshot as $k4=>$v4){ 
                            ?>
                            <div class="owl-item"
                                data-src="<?php echo base_url();?>/assets/uploads/<?php if($v4->image) echo $v4->image;else echo 'noimg.png';?>">
                                <div class="item">
                                    <div class="image_thubnail">
                                        <img
                                               src="<?php echo base_url();?>/assets/uploads/<?php if($v4->image) echo $v4->image;else echo 'noimg.png';?>">
                                    </div>
                                </div>
                            </div>
                            <?php 
            } 
            ?>
                        </div>
                    </div>



                </div>
                
            </div>
        </div>
        <?php 
            }
            // else{ 
            //   echo 'Screenshot not available!'; 
            // } 
        ?>
        <div class="col-md-12 mt-4">
            <h4>Related Products</h4>
            <div class="screenshot mt-2">
                <div class="owl-carousel owl-theme add_ons_for_game owl-loaded owl-drag">
                    <div class="owl-stage-outer">
                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1396px; padding-left: 30px; padding-right: 30px;">
                            <?php 
                            if(@$sproducts){ 
                                foreach(@$sproducts as $k=>$v){ 
                                    $pid=$v->product_id; 
                                    $sql="select * from product_image where     product='$pid' and status='Active' "; 
                                    $product_image=$userModel->customQuery($sql);    
                            ?>
                            <div class="owl-item active" style="width: 157px; margin-right: 10px;">
                                <div class="item">
                                    <div class="add_ons_for_game_parent">
                                        <a href="<?php echo $productModel->getproduct_url($pid)?>"><img src="<?php echo base_url();?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png';?>"></a>
                                        <div class="overlay_content_s_add_one">
                                            <h4><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                                                    <?php echo substr($v->name,0,25);?>
                                                </a>
                                            </h4>
                                            <h5>AED
                                                <?php  
                                                    if($productModel->get_discounted_percentage($V->product_id) > 0){
                                                    // if(@$v->discount_percentage > 0 ){ 
                                                ?>
                                                <?php echo round(bcdiv(@$v->price - (@$v->discount_percentage*@$v->price)/100, 1, 2));?>
                                                <?php 
                                                    }else{ 
                                                ?>
                                                <?php echo bcdiv(@$v->price, 1, 2);?>
                                                <?php } ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="owl-nav">
                        <button type="button" role="presentation" class="owl-prev disabled">
                            <span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span>
                        </button></div>
                    <div class="owl-dots disabled"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php if($products[0]->review_enabled == "Yes"): ?>
<!-- Review section -->
    <div class="container p-0">
        <div class="col-12">
            <div class="row j-c-spacebetween col-12 m-0 p-0">
                <h4 class="col-auto p-0">Reviews</h4>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary col-auto" data-toggle="modal" data-target="<?php if(@$user_id): echo "#reviewproductform"; else: echo "#jagat-login-modal"; endif;?>">
                  Review this product
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="reviewproductform" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Review product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                     </div>

                    <div class="modal-body j-c-center ">
                        <div class="col-12 row j-c-center a-c-center mb-3">
                            <h5 class="m-0">Rate this product</h5>
                            <div class="rating rate-action d-flex-row col-6 m-0 a-a-center j-c-center">
                                <div class="star p-0 col-2" data-score="1"></div>
                                <div class="star p-0 col-2" data-score="2"></div>
                                <div class="star p-0 col-2" data-score="3"></div>
                                <div class="star p-0 col-2" data-score="4"></div>
                                <div class="star p-0 col-2" data-score="5"></div>
                            </div>
                        </div>
                        
                        <form method="post" action="<?php echo base_url() ?>/review/add/<?php echo $products[0]->product_id?>" id="rating-form">

                            <div class="btn-group rating-group d-none" role="group" aria-label="Basic radio group">
                              <input type="text" value="" name="rating">
                              <input type="text" value="<?php echo $products[0]->product_id ?>" name="product">


                            </div>

                            <!-- <div class="form-group">
                              <label for="exampleInputEmail1">Email address</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name="email" required placeholder="Enter email">
                            </div> -->


                            <div class="form-group">
                              <label for="exampleFormControlTextarea1">Your opinion:</label>
                              <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="review" required placeholder="Tell us about your thought..."></textarea>
                            </div>

                            <!-- <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="exampleCheck1">
                              <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div> -->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                             </div>

                         </form>
                         

                    </div>

                  
                </div>
              </div>
            </div>

            <div class="row col-12 reviews a-c-flexstart  mx-auto my-3">
                
                <?php 
                    if($product_reviews):
                        foreach($product_reviews as $key => $review):
                ?>

                <div class="review-element col-12 my-3 mx-auto p-3">
                        <div class="review-header col-12 container d-flex-row a-a-center p-0 m-0 ">
                            <div class="row col-12 m-0 j-c-spacebetween">
                                <div class="user-infos d-flex-row col-auto p-0 j-c-center no-wrap">
                                    <div class="col-auto p-0 m-0">
                                        <div class="user-avatar mr-3">
                                            <img src="<?php echo base_url() ?>/<?php echo $userModel->get_user_image($review->user_id) ?>" alt="user avatar">
                                        </div>
                                    </div>
                                    <span class="user-name"><?php echo $review->user_name; ?></span>
                                </div>
                                <div class="d-flex-row p-0 col-md-auto col-sm-12">
                                    <div class="rating row j-c-center a-a-center col-auto m-0 p-0">
                                        <div class="star p-0 col-2 <?php if($review->rating >= 1): echo "star-filled"; endif; ?>" data-score="1"></div>
                                        <div class="star p-0 col-2 <?php if($review->rating >=2): echo "star-filled"; endif; ?>" data-score="2"></div>
                                        <div class="star p-0 col-2 <?php if($review->rating >=3): echo "star-filled"; endif; ?>" data-score="3"></div>
                                        <div class="star p-0 col-2 <?php if($review->rating >=4): echo "star-filled"; endif; ?>" data-score="4"></div>
                                        <div class="star p-0 col-2 <?php if($review->rating ==5): echo "star-filled"; endif; ?>" data-score="5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="review-date col-auto"><span><?php echo((new \DateTime($review->created_at))->format("Y/m/d")); ?></span></div>
                        </div>
                        <div class="review-content col-12 row m-0 mt-3 p-3">
                            <p class="m-0"><?php echo $review->comment?></p>
                        </div>
                </div>

                <?php
                        endforeach;
                                            
                    else:
                   ?>
                    
                    <p class="col-12 p-5" style="text-align:center;font-size: 15px; color:gray">No reviews for this product</p>

                <?php
                    endif;
                ?>
                                                        
            </div>

        </div>
    </div>
    <?php endif;?>


<script>
    function putassebly() { 
        const checkbox = document.getElementById('installation-checkbox') 
        checkbox.addEventListener('change', (event) => { 
            if (event.currentTarget.checked) { 
                document.getElementById('assemble_professionally_price').value = document.getElementById( 
                    'installation-checkbox').value; 
            } else { 
                document.getElementById('assemble_professionally_price').value = ''; 
            } 
        }) 
        //   
    } 
    
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