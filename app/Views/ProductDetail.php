<link rel="stylesheet" href="<?= base_url() ?>/assets/gallery/lightgallery.css">

<style>
    .products_add_to_cart .btn-primary {
        max-width: unset !important;
    }

    form.bndle_add_to_cart .ws-bundle-offer-title{
        cursor: pointer;
    }
    
    .ws-bundle-prop{
        max-height: 400px;
    }

    .ws-bundle-prop .ws-bundle-prop-element:nth-child(n+2)::before{
        content: "+";
        font-size: 1.3rem;
        font-weight: bold;
        position: absolute;
        top: 50%;
        left: -10px;
        transform: translate(50%,-50%);
    }

    .ws-bundle-prop-element .check , .ws-bundle-prop-element .default-checked{
        position: absolute;
        top: 5px;
        left: 5px;
        height: 20px;
        width: 20px;
        z-index: 5;
        cursor: pointer;
    }

    .ws-bundle-prop-element .check.checked , .ws-bundle-prop-element .default-checked{
        background: url("https://f.nooncdn.com/s/app/com/noon/icons/checkbox-square_checked_v2.svg") center
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

    $has_options= $products[0]->bundle_opt_enabled == "Yes" &&  $productModel->get_bundle_option_groups($products[0]->product_id , true);
    

    if($has_options){
        // $opt=$userModel->customQuery("select * from bundle_opt where product_id='".$products[0]->product_id."'");

        // var_dump($opt);die();
        
    }
    
    $product_reviews = $reviewModel->get_product_reviews($products[0]->product_id);
    // var_dump($products);die();
?>




<!-- Mian content -->
<div class="container-fluid col-xl-10 pt-2 padding_unset_none pb-4">
    <!-- Page location links -->
    <div class="col-12 p-0 breadcrumbs_nav <?php text_from_right() ?>" <?php content_from_right() ?>>
        <ul>
            <li><a href="<?php echo base_url();?>"><?php echo lg_get_text("lg_119"); ?> </a><span>/ </span> </li>
            <li><a href="<?php echo base_url();?>/product-list"><?php echo lg_get_text("lg_142") ?> </a><span>/ </span> </li>
            <li>
                <?php echo @$products[0]->name;?>
            </li>
        </ul>
    </div>
    <div class="row pt-3 padding_unset_none" <?php content_from_right() ?>>

        <!-- images section -->
        <div class="col-md-7 loaded_images">
            <?php echo view("products/Pdetails_images" , ["products" => $products]); ?>
        </div>
                
        <!-- Product details section -->
        <div class="col-md-5 pt-3 " <?php content_from_right() ?>>
            <div class="products_details" product_id="<?php echo $products[0]->product_id?>">
                <div class="mb-3 products_title">
                    <h1 class="<?php text_from_right() ?>">
                        <?php lg_put_text(@$products[0]->name , @$products[0]->arabic_name);?>
                    </h1>
                    <div class="product_rank_str">
                        <?php if($pro_over_rating){ 
                        for($i=1;$i<=5;$i++) 
                        { 
                         if($i<=@$pro_over_rating){ 
                          ?>
                        <img alt="star" src="<?= base_url() ?>/assets/img/star.png" alt="star" class="w10">
                        <?php 
                        }else { 
                          ?>
                        <img alt="star disabled" src="<?= base_url() ?>/assets/img/star-disable.png" alt="star" class="w10">
                        <?php 
                            } 
                          } 
                        } 
                        ?>
                    </div>
                </div>

                <!-- ATTRIBUTE OPTION FRO VARIABLE PRODUCTS -->
                <?php if(true):?>
                <div class="product_variations row p-0 m-0 my-2 col-12">
                    <?php 
                    $product_attributes = $productModel->get_attributes($products[0]->product_id);
                    if(sizeof($product_attributes) > 0 && $products[0]->product_nature == "Variable"):

                        foreach($product_attributes as $attribute_id): 
                            $i=0;$j=0;$ii=0;
                    ?>
                        <div class="p-0 my-3 col-12 attribute_section">
                            <div class="col-12 <?php text_from_right() ?>">
                                <h6><strong><?php lg_put_text($attributeModel->get_attribute_name($attribute_id) , $attributeModel->get_attribute_name($attribute_id , true) ) ?></strong></h6>
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
                                            if(sizeof($product_attributes) == 1 && $img !== null && $attributeModel->get_attribute($attribute_id)->show_variation_image == "Yes"): 
                                    ?>
                                            <img alt="option" src="<?php echo base_url()."/assets/uploads/".$img?>" alt="" <?php if($stock<=0): echo "style='mix-blend-mode:luminosity'";endif ?>>
                                            <?php elseif(trim($option->thumb_url) !== ""):?>
                                            <img alt="option" src="<?php echo base_url()."/assets/others/".$option->thumb_url?>" alt="" <?php if($stock<=0): echo "style='mix-blend-mode:luminosity'";endif ?>>
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
                <!-- ATTRIBUTE OPTION -->
                <?php endif;?>

                <?php if($products[0]->max_qty_order > 0): ?>
                    <div class="d-flex col-12 pt-2 pb-2 px-0">
                        <ul class="pp_additional_infos">
                            <li><?php echo lg_get_text("lg_171") ?></li>
                            <li><?php echo "Limited order quantity (".$products[0]->max_qty_order." peice ".lg_put_text("per customer" , "لكل عميل" , false).")" ?></li>
                        </ul>
                    </div>
                <?php endif;?>
                

                <?php 
                $offer = ($GLOBALS["offerModel"]->product_Get_N_offer_comply($products[0]->product_id)) ?? $GLOBALS["offerModel"]->product_prize_offer_comply($products[0]->product_id);
                if(!is_null($offer)):
                    // var_dump(array_keys($GLOBALS["offerModel"]->get_offers_conditions_filters([$offer])));die();
                ?>
                <div class="py-2 px-3 d-flex bg-primary text-white">
                    <p class="m-0">
                        <?php echo lg_get_text("lg_362"); ?>
                        <ins><a class="text-white" target="blank" href="<?php echo base_url() ?>/product-list/offers?offer_cdn=<?php echo implode("," , array_keys($GLOBALS["offerModel"]->get_offers_conditions_filters([$offer]))) ?>">"<?php echo lg_put_text($offer->offer_title , $offer->offer_arabic_title) ?>"</a></ins>
                        <?php echo lg_get_text("lg_363"); ?>

                    </p>
                </div>
                <?php endif; ?>

                <!-- Product Price  -->
                <div class="pricing-card mt-2">
                    <div class="card-subtitle <?php text_from_right() ?>">
                        <?php  
                        $price = bcdiv($products[0]->price, 1, 2);
                        $discount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $products[0]->product_id);
                        if($discount["discount_amount"] > 0){
                            $price = $discount["new_price"] ;
                        }
                        // $discount_cond1=@$products[0]->discount_percentage > 0 && !$productModel->has_daterange_discount($products[0]->offer_start_date,$products[0]->offer_end_date);
                        // $discount_cond2= @$products[0]->discount_percentage > 0 && $productModel->has_daterange_discount($products[0]->offer_start_date,$products[0]->offer_end_date) && $productModel->is_date_valide_discount($products[0]->product_id);
                        // var_dump($discount_cond1,$productModel->is_date_valide_discount($products[0]->product_id));die();
                        if($discount["discount_amount"] > 0){ 
                         ?>
                        <span><?php echo bcdiv(@$products[0]->price, 1, 2);?><span><?php echo lg_get_text("lg_102") ?></span></span>
                        <?php } ?>
                    </div>
                    <div class="d-flex align-items-center">
                        <?php  

                        if($discount["discount_amount"] > 0){
                             
                         ?>
                        <p class="offer-price card-text d-flex m-0">
                            <span style="font-size: inherit;font-weight:inherit">
                                <?php 
                                    echo bcdiv($discount["new_price"], 1, 2);
                                ?>
                            </span>

                            <span><?php echo lg_get_text("lg_102") ?></span>

                        </p>
                        <?php 

                        }
                        else{ 
                          ?>
                        <p class="offer-price card-text d-flex m-0">
                            <span style="font-size: inherit;font-weight:inherit"><?php echo bcdiv(@$products[0]->price, 1, 2);?></span><span><?php echo lg_get_text("lg_102") ?></span>
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
                
                <!-- Tabby promo badge -->
                <?php if(true): ?>
                    <div class="col-12 m-0 px-0">
                        <div id="ws-tabby-promo"></div>
                    </div>
                <?php endif; ?>
                <!-- Tabby promo badge -->

                <!-- Assembly proffesionally elements -->
                <?php if(@$products[0]->assemble_professionally=="Yes"){?>
                <div class="product-option-message">
                    <div class="option-check d-flex justify-content-between">
                        <label class="checkbox light-green d-flex " for="installation-checkbox">
                               <input onclick="putassebly();" id="installation-checkbox" type="checkbox" 
                                   value="<?php if(@$products[0]->assemble_professionally_price) echo @$products[0]->assemble_professionally_price;?>"> 
                               <span class="checkmark" 
                                   style="background-image:url(<?= base_url() ?>/assets/img/assable.PNG)"></span> 
                               <span class="checklabel option-installation"><?php echo lg_get_text("lg_173") ?></span> 
                           </label>
                        <span class="checkcount">
                               <?php if(@$products[0]->assemble_professionally_price==0 ){ 
                                  echo 'Free'; 
                                }else{ 
                                  echo @$products[0]->assemble_professionally_price.' '.CURRENCY; 
                                }?> 
                           </span>
                    </div>
                </div>
                <?php } ?>


                <form style="display:flex;flex-direction:column" data-price="<?php echo $price ?>" data-sku="<?php echo $products[0]->sku ?>" class="products_add_to_cart custom_select_boxes each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
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
                    
                    <!-- IF PRODUCT HAS OPTIONS (BUNDLE PRODUCT)-->
                    <?php 
                    if($has_options):
                        foreach($productModel->get_bundle_option_groups($products[0]->product_id) as $group_id):
                            if($productModel->get_bundle_options_on_group_id($group_id , true) > 0):
                            $opt = $productModel->get_bundle_options_on_group_id($group_id)
                    ?>
                        <div class=" col-12 px-0 my-3">
                            <label for="bundle_opt" class="col-12 p-0 <?php text_from_right() ?>"><b><?php echo lg_get_text("lg_288") ?></b></label>
                            <select id="pp_bundle_opt_select" name="bundle_opt[]" id="" class="form-control">
                                <?php foreach($opt as $key => $value): 
                                    $title = ((int)$value["additional_price"] !== 0) ? $value["option_title"] . " (" .$value["additional_price"] ." ".CURRENCY." extra)" : $value["option_title"];
                                ?>
                                    <option value="<?php echo $value["option_id"] ?>"><?php echo $title ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php
                            endif;
                        endforeach;
                    endif; 
                    ?>
                    <!-- IF PRODUCT HAS OPTIONS -->

                    
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
                                </span>
                                <input class="form-control" type="text" name="quantity" value="1">
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
                        <?php
                        $is_variable = ($products[0]->product_nature == "Variable") ? true : false;
                        $product_stock = $productModel->get_product_stock($products[0]->product_id , $is_variable);
                        // if( @$products[0]->available_stock > 0){
                        if( @$product_stock > 0){
                        ?>
                            <button type="submit" class="btn btn-primary"><?php if($products[0]->pre_order_enabled=="Yes") echo lg_get_text("lg_54") ;else echo lg_get_text("lg_33");?></button>
                        <?php }else{ ?>
                            <button disabled class="btn btn-primary"><?php echo lg_get_text("lg_55") ?></button>
                        <?php } ?>


                        <!-- WISH LIST BUTTON -->
                        <?php 
                            if($user_id){ 

                                $pid=@$products[0]->product_id; 
                                $sql="select * from wishlist where product_id='$pid' and user_id='$user_id' "; 
                                $pwishlist=$userModel->customQuery($sql);  
                            
				        ?>

                        <div class="add_to_whishlist <?php echo @$products[0]->product_id;?>  <?php if($pwishlist) echo 'active';?>" onClick="addToWishlist('<?php echo @$products[0]->product_id;?>','<?php echo @$products[0]->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
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
                        <div class="add_to_whishlist" data-toggle="modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0H24V24H0z"></path>
                                <path
                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                </path>
                            </svg>
                        </div>
                        <?php 
                        } 
                        ?>
                    </div>
                </form>
                
                <!-- Offers including this Product That Can be Applied at checkout -->
                <?php 
                    if(sizeof($cart_offers) > 0): 
                    foreach($cart_offers as $cart_offer):
                ?>

                <form method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm"  class="bndle_add_to_cart p-2 row my-3 rounded" style="background-color:#0055a30d">
                    <input name="is_bundle" type="hidden" id="bndle_quantity" value="true" required>
                    <!-- Offer Bundle Header -->
                    <div class="col-12 py-2 text-left d-flex justify-content-between ws-bundle-offer-title">
                        <b><span class="1.1rem"> <?php echo lg_get_text("lg_385") ?> </span> <i><span style="color: #1881ab"><?php echo lg_put_text($cart_offer->offer_title , $cart_offer->offer_arabic_title) ?></span></i></b>
                        <i class="fa-solid fa-chevron-down" style=""></i>
                    </div>
                    <!-- Offer Bundle Header -->
                    
                    <div class="col-12 ws-bundle-content" <?php content_from_right() ?> style="overflow-y: auto;">
                        <div class="col-12 p-3 d-flex flex-column border bg-white" <?php content_from_right() ?> style="overflow-y: auto;">
                            <?php 

                            $total = 0;
                            $pr_index = 1;
                            $bundle_products = [];

                            array_walk($cart_offer->conditions , function($condition , $index) use(&$bundle_products , &$products , &$cart_offer){
                                if($condition->on_product_aggregation == "All"){
                                    $bundle_products = array_merge($condition->product_list , $bundle_products);
                                }
                                else{
                                    if(in_array($products[0]->product_id , $condition->product_list)){
                                        array_push($bundle_products , $products[0]->product_id);
                                        $key = array_search($products[0]->product_id , $cart_offer->conditions[$index]->product_list);
                                        unset($cart_offer->conditions[$index]->product_list[$key]);
                                        $cart_offer->conditions[$index]->on_product_qty -= 1;
                                    }
                                    // $key = array_search($products[0]->product_id, $condition->product_list);
                                    // unset($condition->product_list[$key]);
                                }
                            });


                            ?>
                                <div class="ws-bundle-prop col-auto p-0 d-flex flex-row" style="overflow-y: auto; background: none">
                            <?php 
                                    foreach($bundle_products as $pr_id): 
                                    $product = $productModel->get_product_infos($pr_id);
                                    $discount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $pr_id);
                                    $bundle_element_price = ($discount["discount_amount"] > 0) ? bcdiv($discount["new_price"] , 1 , 0) : $product->price;
                                    $total += $bundle_element_price;
                            ?>
                            <?php 
                                    echo view("products/Bundle_product_carousel" , ["product" => $product , "pr_index"=> $pr_index , "price" => $bundle_element_price ,  "default" => true]);
                                    $pr_index++;
                                    endforeach;
                            ?>
                            </div>

                            <?php 
                            foreach($cart_offer->conditions as $condition): 

                                if($condition->on_product_aggregation !== "All"):
                            ?>
                                    <!-- Item of Choise title -->
                                    <div class="py-3" style="background: #f2f2fa">
                                        <?php
                                        $choice_title_eng = ($condition->on_product_qty > 1) ? "Pick ".$condition->on_product_qty." items" : "Pick one item";
                                        $choice_title_ara = ($condition->on_product_qty > 1) ? "اختر ".$condition->on_product_qty." عناصر" : "اختر عنصرا";
                                        ?>
                                        <b><span class="1rem p-3"><?php echo lg_put_text($choice_title_eng , $choise_title_ara) ?></span></b>
                                    </div>
                                    <!-- Item of Choise title -->
                                    <div class="ws-bundle-prop col-auto p-0 row m-0" style="overflow-y: auto; background: #f2f2fa24">
                                    <?php
                                    $i = 0 ;
                                    foreach($condition->product_list as $pr_id):
                                    $product = $productModel->get_product_infos($pr_id);
                                    $discount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $pr_id);
                                    $bundle_element_price = ($discount["discount_amount"] > 0) ? bcdiv($discount["new_price"] , 1 , 0) : $product->price;
                                    $total += ($i == 0) ? $bundle_element_price : 0;
                                    echo view("products/Bundle_product_carousel" , ["product" => $product , "pr_index"=> $pr_index , "price" => $bundle_element_price , "default" => false]);
                                    $pr_index++;
                                    ?>

                                    <?php
                                    $i++;
                                    endforeach;
                                    ?>
                                    </div>
                                <?php
                                endif; 
                                ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- CTA -->
                    <div class="col-12 py-2 px-0">
                        <?php 
                        $bundle_discount = ($cart_offer->discount_type == "Amount") ? $cart_offer->discount_value : ($total * $cart_offer->discount_value / 100);
                        ?>
                        <button data-discount="<?php echo $bundle_discount ?>" class="btn btn-primary col-12 ws-bundle-prop-action" type="submit">Buy It Together for <span class="bundle-price"><?php echo ($total - $bundle_discount)."</span> ".CURRENCY ?> </button>
                    </div>
                    <!-- CTA -->
                </form>

                <?php endforeach; ?>
                <?php endif; ?>
                <!-- Offers including this Product That Can be Applied at checkout -->

                <!-- Stock alert notification -->
                <?php if( @$product_stock <= 0): ?>
                <div class="row my-3 p-0 justify-content-center">
                    <!-- <div class="col-12 col-md-6 py-2">
                        <button class="btn btn-success col-12 ws-btn-notfy-me">Notify Me</button>
                    </div> -->
                    <div class="col-12 py-2">
                        <button class="btn ws-btn col-12 ws-btn-ask-instore" data-country="uae">Ask In-Store</button>
                    </div>
                </div>
                <?php endif; ?>
                <!-- Stock alert notification -->

                <!-- Additional information like delivery availability -->
                <div class="specification">
                    <div class="icon d-flex flex-row flex-wrap">
                        <!-- Product Brand -->
                        <div class="row col-12 m-0 p-0 text-left">
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_129") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <span>
                                    <a href="<?php echo $brandModel->get_brand_url($brands[0]->id) ?>">
                                        <?php echo lg_put_text(@$brands[0]->title , @$brands[0]->arabic_title);?>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <!-- Product Brand -->

                        <!-- Product Type -->
                        <?php if(!empty($products[0]->type)): ?>
                        <div class="row my-2 col-12 m-0 p-0 text-left">
                            <?php
                            $types = $productModel->get_product_types($products[0]->type);
                            ?>
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_128") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <?php  
                                    foreach( array_values(array_unique(explode(",",$products[0]->type))) as $k=>$v){
                                    $sql = "select * from type where type_id=$v;"; 
                                    $suit = $userModel->customQuery($sql); 
                                ?>
                                    <span>
                                        <a href="<?php echo base_url() ?>/product-list?type=<?php echo $suit[0]->type_id ?>">
                                            <?php echo lg_put_text(@$suit[0]->title , @$suit[0]->arabic_title );  ?>
                                        </a>
                                    </span>
                                <?php 
                                    } 
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Product Type -->

                        <!-- Suitable For -->
                        <?php if(!empty($products[0]->suitable_for)): ?>
                        <div class="row my-2 col-12 m-0 p-0 text-left">
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_131") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <?php  
                                    $i=0;
                                    foreach( array_values(array_unique(explode(",",$products[0]->suitable_for))) as $k=>$v){
                                    $sql = "select * from suitable_for where id=$v;"; 
                                    $suit = $userModel->customQuery($sql); 
                                    if($i > 0) echo " | ";
                                ?>
                                    <span>
                                        <a href="<?php echo base_url() ?>/product-list?suitable_for=<?php echo $suit[0]->id ?>">
                                            <?php echo lg_put_text(@$suit[0]->title , @$suit[0]->arabic_title );  ?>
                                        </a>
                                    </span>
                                <?php 
                                    $i++;
                                    } 
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Suitable For -->
                        
                        <!-- Game Genre -->
                        <?php if(!empty($products[0]->color)): ?>
                        <div class="row my-2 col-12 m-0 p-0 text-left">
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_132") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <?php  
                                    $i = 0;
                                    foreach( array_values(array_unique(explode(",",$products[0]->color))) as $k=>$v){
                                    $sql = "select * from color where id=$v;"; 
                                    $suit = $userModel->customQuery($sql); 
                                    if($i > 0) echo " | ";
                                ?>
                                <span>
                                    <a href="<?php echo base_url() ?>/product-list?genre=<?php echo $suit[0]->id ?>">
                                        <?php 
                                            echo @$suit[0]->title;
                                        ?>
                                    </a>
                                </span>
                                <?php 
                                    $i++;
                                    } 
                                ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Game Genre -->

                        <!-- Age Rating -->
                        <?php if(!empty($products[0]->age) && @$age[0]->image): ?>
                        <div class="row my-2 col-12 m-0 p-0 text-left">
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_130") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <img alt="Age" src="https://zgames.ae/assets/uploads/<?php echo @$age[0]->image;?>">
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Age Rating -->

                        <!-- Release Date if Pre-Order -->
                        <?php if(@$products[0]->release_date!="" && @$products[0]->pre_order_enabled=="Yes" && $products[0]->release_date!="0000-00-00"): ?>
                        <div class="row my-2 col-12 m-0 p-0 text-left">
                            <div class="col-5 pl-0">
                                <span><b><?php echo lg_get_text("lg_53") ?></b></span>
                            </div>
                            <div class="col-7 pl-0">
                                <span> <?php echo date('d/m/Y', strtotime(@$products[0]->release_date));?> </span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Release Date if Pre-Order -->
                    </div>
                    
                    <div class="icon">
                        <!-- <img alt="delivery infos" src="<?= base_url() ?>/assets/img/icon2.PNG"> -->
                        <i class="fa-solid fa-truck pr-3" style="font-size: 1.5rem; color: #22398d"></i>
                        <span><?php echo lg_get_text("lg_175") ?> <?php if($products[0]->type == 32) echo '(5 to 7 business days) for this product ' ?></span>
                    </div>
                    <?php if(false):?>
                    <div class="icon row m-0 justify-content-center p-3 border rounded">
                        <div class="col-12 p-0 pb-2 mr-1">
                            <img class="m-0" style="width:auto; height: 1cm" alt="ENBD logo" src="<?= base_url() ?>/assets/img/enbd_mini_logo.jpg">
                        </div>
                        <div class="col-auto d-flex p-0 m-0 flex-row justify-content-between" style="font-size: .9rem; line-height: 20px">
                            <div class="<?php text_from_right() ?>">
                                <span><?php echo lg_get_text("lg_343") ?> </span>
                            </div>
                            <div class="col-auto <?php text_from_left(); if(get_cookie("language") == 'AR') echo " pl-0"; else echo " pr-0"; ?> enbd_learn_more">
                                <a data-bs-toggle="modal" data-bs-target="#generalmodal" data-bs-modal-title="<?php echo lg_get_text("lg_344") ?>" data-bs-modal-content="<?php echo lg_get_text("lg_343") ?>" href="javascript:void(0)" style="text-decoration: underline!important; color:inherit">Learn more</a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Social media share -->
                <div class="share_products my-3 align-items-center d-flex" style="position:relative">
                    <?php if(false): ?>
                    <div class="p-1 rounded" style="position:absolute; top:50%; right:0px; background: linear-gradient(45deg , #22398d 0% , #5c79e1 52% , #22398d 100%) ; transform: translate(0, -50%);">
                        <a href="<?php echo base_url() ?>/skull-and-bones-treasure-quest">
                            <img src="<?php echo base_url() ?>/assets/others/skull&bones-logo-tresor-quest.png" width="75px" height="auto" alt="">
                        </a>
                    </div>
                    <?php endif; ?>

                    <h5><?php echo lg_get_text("lg_176") ?></h5>
                    <ul>
                        <li><a target="_blank"
                                href="https://www.facebook.com/sharer.php?u=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>"><img
                                       alt="facebook share" src="<?= base_url() ?>/assets/img/facebook.svg"></a></li>
                        <li><a target="_blank"
                                href="https://twitter.com/share?url=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>&text=<?php echo @$products[0]->name;?>&via=<?php echo base_url();?>&hashtags=<?php echo base_url();?>"><img
                                       alt="twitter share" src="<?= base_url() ?>/assets/img/twitter.svg"></a></li>
                        <li><a target="_blank"
                                href="https://pinterest.com/pin/create/bookmarklet/?media=<?php echo base_url();?>/assets/uploads/<?php echo $product_image[0]->image;?>&url=<?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>&description=<?php echo @$products[0]->name;?>"><img
                                       alt="pintrest share" src="<?= base_url() ?>/assets/img/pinterest.svg"></a></li>
                        <li><a target="_blank"
                                href="mailto:?subject=<?php echo @$products[0]->name;?>&body=Check out this site: <?php echo base_url();?>/product/<?php echo @$products[0]->product_id;?>"
                                title="Share by Email';"><img alt="email share" src="<?= base_url() ?>/assets/img/email.svg"></a></li>
                    </ul>
                </div>

                <!--  -->
            </div>
        </div>
    </div>

    <div class="row mt-3 justify-content-center">
        <?php  
        if(@$products[0]->description ){ 
        ?>
        <div class="col-12 col-lg-10 mt-3">
            <h4 class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_177") ?></h4>
            <div class="desc <?php text_from_right() ?>">
                <p>
                    <?php lg_put_text(@$products[0]->description , @$products[0]->arabic_description);?>
                </p>
            </div>
        </div>
        <?php } ?>

        <?php 
        if(@$products[0]->features)
        {
        ?>

        <!-- PRODUCT FEATURES -->
        <div class="col-12 col-lg-10 mt-3">
            <h4 class="<?php text_from_right() ?>"> <?php echo lg_get_text("lg_178") ?></h4>
            <div class="desc <?php text_from_right() ?>">
                <p>
                    <?php lg_put_text(@$products[0]->features , @$products[0]->arabic_features);?>
                </p>
            </div>
        </div>
        <!-- END PRODUCT FEATURES -->

        <?php } ?>
        
        <?php 
            $pidd=@$products[0]->product_id; 
            $sql="select * from product_screenshot where     product='$pidd' and status='Active' "; 
            $product_screenshot=$userModel->customQuery($sql);  
            if($product_screenshot){ 
        ?>

        <!-- PRODUCT SCREENSHOTS -->
        <div class="col-12 col-lg-10 mt-3">
            <h4 class="<?php text_from_right()?>"><?php echo lg_get_text("lg_179") ?></h4>
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
                                        <img alt="<?php echo 'screenshot_'.$k4 ?>" src="<?php echo base_url();?>/assets/uploads/<?php if($v4->image) echo $v4->image;else echo 'noimg.png';?>">
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
        <!-- END PRODUCT SCREENSHOTS -->

        <?php 
            }
            // else{ 
            //   echo 'Screenshot not available!'; 
            // } 
        ?>

        <!-- RELATED PRODUCTS -->
        <div class="col-12 mt-4">
            <h4 class="<?php text_from_right()?>"><?php echo lg_get_text("lg_180") ?></h4>
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
                                        <?php 
						                    $related_p_title=(strlen(lg_put_text($v->name , $v->arabic_name , false)) > 25) ? substr(lg_put_text($v->name , $v->arabic_name , false),0,25)."..." : lg_put_text($v->name , $v->arabic_name , false);
                                        ?>
                                        <a href="<?php echo $productModel->getproduct_url($pid)?>">
                                            <img alt="<?php echo $related_p_title ?>" src="<?php echo base_url();?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png';?>">
                                        </a>
                                        <div class="overlay_content_s_add_one">
                                            <h4><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                                                    <?php echo $related_p_title;?>
                                                </a>
                                            </h4>
                                            <h5>
                                                <?php echo lg_get_text("lg_102") ?>
                                                <?php  
                                                    $sdiscount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $V->product_id);
                                                    if($discount["discount_amount"] > 0){
                                                    // if(@$v->discount_percentage > 0 ){ 
                                                ?>
                                                <?php echo $discount["new_price"];?>
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
        <!-- END RELATED PRODUCTS -->

    </div>
</div>

    <?php if($products[0]->review_enabled == "Yes"): ?>
    <!-- Review section -->
    <div class="container p-0" <?php content_from_right()?>>
        <div class="col-12">
            <div class="row j-c-spacebetween col-12 m-0 p-0">
                <h4 class="col-auto p-0 <?php text_from_right()?>"><?php echo lg_get_text("lg_181") ?></h4>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary col-auto" data-toggle="modal" data-target="<?php if(@$user_id): echo "#reviewproductform"; else: echo "#login-modal"; endif;?>" <?php if(!@$user_id): ?>data-form="login" onclick="get_form(this.getAttribute('data-form'))" <?php endif; ?>>
                  <?php echo lg_get_text("lg_182") ?>
                </button>
            </div>

            <!-- REVIEW MODAL -->
            <div class="modal fade" id="reviewproductform" tabindex="-1" role="dialog" aria-labelledby="reviewProductForm" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><?php echo lg_get_text("lg_183") ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                     </div>

                    <div class="modal-body j-c-center ">
                        <div class="col-12 row j-c-center a-c-center mb-3">
                            <h5 class="m-0"><?php echo lg_get_text("lg_184") ?></h5>
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
                              <label for="exampleFormControlTextarea1"><?php echo lg_get_text("lg_185") ?>:</label>
                              <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="review" required placeholder="<?php echo lg_get_text("lg_188") ?>"></textarea>
                            </div>

                            <!-- <div class="form-check">
                              <input type="checkbox" class="form-check-input" id="exampleCheck1">
                              <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div> -->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lg_get_text("lg_186") ?></button>
                                <button type="submit" class="btn btn-primary"><?php echo lg_get_text("lg_187") ?></button>
                             </div>

                         </form>
                         

                    </div>

                  
                </div>
              </div>
            </div>
            <!-- REVIEW MODAL -->

            <!-- REVIEW LIST -->
            <div class="row col-12 reviews a-c-flexstart  mx-auto my-3">
                
                <?php 
                    if($product_reviews):
                        foreach($product_reviews as $key => $review):
                ?>

                <div class="review-element col-12 my-3 mx-auto p-3">
                        <div class="review-header col-12 container d-flex-row a-a-center p-0 m-0 ">
                            <div class="review-date col-12 <?php text_from_left() ?>"><?php echo((new \DateTime($review->created_at))->format("Y/m/d")); ?></div>
                            <div class="row col-12 m-0 j-c-spacebetween">
                                <div class="user-infos d-flex-row col-auto p-0 j-c-center no-wrap">
                                    <div class="col-auto p-0 m-0">
                                        <div class="user-avatar mx-3">
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
                        </div>
                        <div class="review-content col-12 row m-0 mt-3 p-3">
                            <p class="m-0"><?php echo $review->comment?></p>
                        </div>  
                </div>

                <?php
                        endforeach;
                                            
                    else:
                   ?>
                    
                    <p class="col-12 p-5" style="text-align:center;font-size: 15px; color:gray"><?php echo lg_get_text("lg_189") ?></p>

                <?php
                    endif;
                ?>
                                                        
            </div>
            <!-- REVIEW LIST -->


        </div>
    </div>
    <?php endif;?>
    <!-- END Review section -->

    <!-- Ask In store Modal -->
    <?php if( @$product_stock <= 0): ?>
    <div class="modal fade" data-modal-autoshow="false" id="askinstoremodal" tabindex="-1" aria-labelledby="askinstoremodallabel" aria-hidden="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header row justify-content-center">
                    <h4 class="px-3 modal-title fs-5 text-center" id="exampleModalLabel">Ask <?php echo $products[0]->name?> In-Store</h4>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body px-0">
                    
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Ask In store Modal -->

<script src="https://checkout.tabby.ai/tabby-promo.js"></script>
<script>
    var tabby_product_page = {
        selector: '#ws-tabby-promo',
        currency: '<?php echo CURRENCY ?>',
        price: <?php echo $price ?>, 
        installmentsCount: 4, 
        lang: <?php if(get_cookie("language") == "AR") echo "'ar'"; else echo "'en'" ?>, 
        source: 'product',
        publicKey: '<?php echo TABBY_PUBLIC_KEY ?>',
        merchantCode: '<?php echo TABBY_MERCHANT_CODE ?>'
    }
    // Tabby product page snipet
    new TabbyPromo(tabby_product_page);
    // Tabby product page snipet

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

    // $(".enbd_learn_more").click(function(){
    //     alert("hello world")
    // })
</script>