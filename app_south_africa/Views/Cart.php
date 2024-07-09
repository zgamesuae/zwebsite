
<?php
    $session = session();
    $orderModel = model("App\Model\OrderModel");
    $productModel = model("App\Model\ProductModel");
    $orderModel = model("App\Model\OrderModel");
    $offerModel = model("App\Model\OfferModel");
    $user_id = ($session->get("userLoggedin")) ? $session->get("userLoggedin") : session_id();
    $cart = $orderModel->get_user_cart($user_id);
    $total_cart = $orderModel->total_cart($user_id);
    // var_dump($offers);die();
?>

<style>
    .c-view{
        /* background-color: #eeeeee; */
    }
    .c-recap{
        background-color: rgb(247, 247, 247);
        border-radius: 15px
    }

    .cart-item{
        border: solid rgba(0, 0, 0, 0.123) 1px;
        border-radius: 15px;
        background-color: #ffffff;
    }

    .cart-product-image{
        max-width: 100%;
        max-height: 180px;
    }

    .currency{
        position: relative;
        top: 8px;
        font-size: .8rem;
    }

    .sum-cart-product-line{
        font-size: .8rem;
        line-height: 17px;
        background-color: rgb(236, 236, 236);
        border: 1px solid rgba(0, 0, 0, 0.048);
        border-radius: 10px;
        color: rgb(77, 77, 77)

    }

    .cart-action .btn span{
        line-height: .9rem;
        font-size: .9rem;
    }

    .old{
        text-decoration: line-through;
        color: gray;
        font-size: .9rem;
    }
    .cart-product-price{font-weight: Bold; font-size: 1.4rem; position: relative}
    .cart-payment-solutions img{ max-width:80px; height:auto }


    @media screen and (max-width: 450px){
        .cart-delete-product{
            /* position: absolute!important; */
            cursor: pointer;
        }

        .cart-item{
            justify-content: space-between;
        }

        .cart-product-name{
            font-size: .8rem;
        }

        .cart-product-price{
            font-size: 1.2rem
        }
    }
</style>

<div class="container-fluid">
    <div class="container">
        <div class="row j-c-spacearound py-5 a-a-start" <?php echo content_from_right() ?>>
            <div class="col-12 py-3 <?php text_from_right() ?>">
                <h2 class="m-0"><?php echo lg_get_text("lg_193") ?> (<?php echo $productModel->total_cart() ?>)</h2>
            </div>

            <?php if($productModel->total_cart() > 0): ?>

            <!-- Alert messages -->
            <?php if($max_qty_order || $product_order_resctricted || $dc_availability || $qty_unavailable): ?>
            <div class="col-12 py-3">
                <?php if ($max_qty_order && sizeof($max_qty_order) > 0): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><?php echo lg_get_text("lg_206") ?></strong> <br> 
                            <?php 
                                foreach ($max_qty_order as $key => $value) {
                                    # code...
                                    if($value){
                                        // echo("You have already ordered '".$productModel->get_product_name($key)."' you can reorder after ".$productModel->get_order_restriction_periode($key)." day(s) from you last order </br>");
                                        echo("Orders on '".$productModel->get_product_name($key)."' are limited to ".$value." piece(s)");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($product_order_resctricted && sizeof($product_order_resctricted) > 0): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <?php echo lg_get_text("lg_206") ?>
                            </strong> <br> 
                            <?php 
                                foreach ($product_order_resctricted as $key => $value) {
                                    # code...
                                    if($value){
                                        echo("You have already ordered '".$productModel->get_product_name($key)."' you can reorder after ".$productModel->get_order_restriction_periode($key)." day(s) from your last order </br>");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                if ($dc_availability && sizeof($dc_availability) > 0): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <?php echo lg_get_text("lg_206") ?>
                            </strong> <br> 
                            <?php 
                                foreach ($dc_availability as $value) {
                                    # code...
                                    if($value){
                                        echo("<p>".$productModel->get_product_name($value)."'s chosen quantity is currently not available. Reduce the quantity and try again </p>");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php endif;

                if ($qty_unavailable && trim($qty_unavailable) !== ""): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>
                                <?php echo lg_get_text("lg_206") ?>
                            </strong> <br> 
                            <?php 
                                echo("<p>$qty_unavailable</p>");
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <!-- Alert messages -->
            
            

            <!-- Cart product Details -->
            <div class="col-12 col-lg-8 row j-c-center c-view p-lg-3 p-0">
                
                <?php
                    foreach($cart as $product): 
                    $product_stock = $productModel->get_product_stock($product->product_id);
                    $stock_cond = $product_stock < $product->quantity;
                    $is_discounted = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $product->product_id)["discount_amount"] > 0;
                    $cart_price = $orderModel->cart_product_price($product->id)
                ?>
                <!-- Loop on product cart -->
                <div class="col-12 mx-0 my-2 p-lg-3 p-0 row j-c-spacearound cart-item">

                    <!-- Product Image -->
                    <div class="col-4 col-xs-12 col-lg-3 p-2 d-flex j-c-center a-a-center">
                        <a href="<?php echo $productModel->getproduct_url($product->product_id) ?>">
                            <!-- <img class="cart-product-image" src=<?php echo base_url()."/assets/uploads/".$product->image ?> alt="<?php echo substr($product->name , 0 , 25)."..." ?>"> -->
                            <img class="cart-product-image" src=<?php echo base_url()."/assets/uploads/".$product->image ?> alt="<?php echo substr($product->name , 0 , 25)."..." ?>">
                        </a>
                    </div>
                    <!-- Product Image -->

                    <div class="col-8 col-xs-12 col-lg-9 p-0 d-flex-row m-0 a-a-spacebetween">
                        <div class="row m-0 py-2 col-12  pt-0 <?php if($stock_cond) echo "j-c-spacebetween"; else echo "j-c-end"  ?> a-a-center">
                            <?php if($stock_cond): ?>
                            <div class="col-8" style="line-height: .85rem">
                                <span style="color:red; font-size: .9rem;"><?php echo lg_get_text("lg_55") ?>! </span>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Delete from cart -->
                            <div class="col-auto p-0 cart-delete-product">
                                <a href="?rcid=<?php echo $product->id; ?>">
                                    <i class="fa-solid fa-trash-can" style="font-size: 1.5rem; color: rgb(95, 95, 95)"></i>
                                </a>
                            </div>
                            <!-- Delete from cart -->

                        </div>
                        <div class="row m-0 py-2 col-12 j-c-spacebetween cart-product-name">
                            <div class="col-12 col-lg-8 p-0">
                                <p class="m-0 <?php text_from_right(true) ?>"><?php echo $cart_price["product_name"]?></p>
                            </div>
                        </div>
                        <div class="row m-0 py-2 col-12 j-c-spacebetween a-a-center ">
                            <div class="col-12 col-lg-auto <?php echo text_from_right(true) ?> py-2 px-0 cart-product-price" style="">
                                <?php if($is_discounted): ?>
                                <span class="old"><?php echo $cart_price["original_price"] ?> <?php echo lg_get_text("lg_102") ?></span>
                                <?php endif; ?>

                                <div>
                                    <span><?php echo $cart_price["price"] ?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-auto p-0">

                                <!-- Quantity incerementor -->
                                <div class="quanitity_div_parent">
                                    <div class="quantitynumber">
                                    <span class="minus" onclick="updatecart_less('<?php echo $product->id ?>','<?php echo $product_stock ?>');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                                    </span>
                                    <input onchange="updatecart('<?php echo $product->id ?>','<?php echo $product_stock ?>');" class="form-control" type="text" id="q-<?php echo $product->id ?>" name="quantity" value="<?php echo $cart_price["quantity"] ?>" required="" min="1" max="7">
                                    <span class="plus" id="plus<?php echo $product->id; ?>" style="" onclick="updatecart_plus('<?php echo $product->id ?>','<?php echo $product_stock ?>');">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                                    </span> 
                                    </div>   
                                </div>
                                <!-- Quantity incerementor -->

                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Loop on product cart -->

            </div>
            <!-- Cart product Details -->


            <!-- CART Summary -->
            <div class="col-12 col-lg-4 c-recap p-3">
                <!-- Order sammary Tilte -->
                <div class="col-12 mb-3">
                    <h2 style="font-size:1.4rem"><?php echo lg_get_text("lg_324"); ?></h2>
                </div>
                <!-- Order sammary Tilte -->
                <!-- Loop over the cart products -->
                <?php
                    foreach($cart as $product):
                    $cart_price = $orderModel->cart_product_price($product->id);
                    $total_product_cart_price = $cart_price["total_product_price"];
                ?>
                <div class="col-12 my-3 mx-0 px-2 py-3 row j-c-spacebetween a-a-center sum-cart-product-line">
                    <div class="col-8 mw-10">
                        <p class="m-0 <?php text_from_right(true) ?>">
                            <?php echo $cart_price["product_name"] ?>
                        </p>
                    </div>
                    <div class="col-auto p-0 text-right" style="font-weight: Bold; font-size: 1rem; position: relative">
                        <span><?php echo bcdiv($total_product_cart_price , 1 , 2) ?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- Loop over the cart products -->

                <!-- subtotal summary -->                
                <div class="col-12 row j-c-spacebetween px-0 py-2 m-0"  style="font-size: 1.3rem; font-weight: bold">
                    <div class="col <?php text_from_right(true) ?> ">
                        <span><?php echo lg_get_text("lg_284-1") ?>:</span>
                    </div>
                    <div class="col <?php text_from_left(true) ?> ">
                        <span><?php echo $total_cart ?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                    </div>
                </div>
                <!-- subtotal summary -->

                <?php 
                if(isset($offers)): 
                    // var_dump($offer);die();
                foreach($offers as $offer):
                    if($offer->application == "Get_N"){
                        $free_products = $offerModel->_get_cart_GetN_products($offer);
                        $msg = isset($free_products["msg"]);
                    }
                ?>  
                <!-- Any Applicable offers -->
                <div class="col-12 row j-c-spacebetween px-0 py-2 m-0 mb-2 border <?php if($msg) echo "border-warning"; else echo "border-success";  ?> rounded"  style="font-size: .9rem; background-color: <?php if($msg) echo "#ffe5ad"; else echo "#c7e5c7" ?>; ">
                    <!-- Offer Title -->
                    <div class="col-12 m-0 <?php text_from_right(true) ?>">
                        <?php if(in_array($offer->application , ["Discount" , "Prize"])): ?>
                        <p style="font-size: .9rem;" class="m-0 mb-2">
                            <?php echo lg_get_text("lg_362") ?> <span style="color: #005800" class="font-italic">"<?php echo lg_put_text($offer->offer_title , $offer->offer_arabic_title) ?>"</span>
                            <?php 
                            // if ($offer->application == "Discount")
                            $title_prefix = lg_get_text("lg_365");
                            if($offer->application == "Prize")
                            $title_prefix .= lg_get_text("lg_366");
                            ?>
                            <span><?php echo $title_prefix ?></span>
                            <?php if($offer->application == "Prize"): ?>
                                <ul style="font-size: .7rem" class="pl-3">
                                    <li>
                                        <?php echo lg_get_text("lg_369") ?>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </p>
                        <?php elseif($offer->application == "Get_N"): ?>
                            <?php if($msg): ?>  
                            <p style="font-size: .9rem;" class="m-0 mb-2">
                                <span><?php echo $free_products["msg"] ?></span>
                            </p>                          
                            <?php else: ?>     
                            <p style="font-size: .9rem;" class="m-0 mb-2">
                                <?php echo lg_get_text("lg_362") ?> <span style="color: #005800" class="font-italic">"<?php echo lg_put_text($offer->offer_title , $offer->offer_arabic_title) ?>"</span>
                                <?php 
                                $title_prefix = lg_get_text("lg_365");
                                $title_prefix .= (sizeof($free_products["free_items"]) > 0) ? lg_get_text("lg_367") : "";
                                ?>
                                <span><?php echo $title_prefix ?></span>
                            </p>              
                            <?php endif; ?>                            
                        <?php endif; ?>

                    </div>
                    <!-- Offer Title -->
                    
                    <?php 
                    if($offer->application == "Discount"):
                        $offer_discount = ($offer->discount_type == "Percentage") ? $total_cart * $offer->discount_value/100 : $offer->discount_amount;
                    ?>
                    <!-- Discount -->
                    <div class="col-12 row m-0 p-0">
                        <div class="col <?php text_from_right(true) ?> ">
                            <span><?php echo lg_get_text("lg_215") ?><?php if($offer->discount_type == "Percentage") echo "(-$offer->discount_value%)"?>:</span>
                        </div>
                        <div class="col <?php text_from_left(true) ?> " style="font-weight: bold">
                            <span >-<?php echo $offer_discount?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <!-- Discount -->
                    
                    <!-- Prize -->
                    <?php elseif($offer->application == "Prize"): ?>
                    <?php 
                        
                        $offer_prizes = $offerModel->_select_offer_valid_prize($offer , $user_id);
                        $prizes = $offerModel->_get_offer_prize_products($offer_prizes)
                    ?>
                    <div class="col-12 row m-0 p-0">
                        <div class="col <?php text_from_right(true) ?> ">
                            <ul class="pl-0" style="list-style: none">
                                <?php foreach($prizes as $prize_title => $prize_products): ?>
                                <li class="my-2">
                                    <?php if(false): ?>
                                    <p class="font-weight-bold mb-1">
                                        <span class=""><?php echo $prize_title ?></span>
                                        <?php if(sizeof($prize_products) > 1): ?>
                                        <span><?php echo lg_get_text("lg_370") ?> </span>
                                        <?php endif; ?>
                                    </p>
                                    <?php endif; ?>

                                    <?php foreach ($prize_products as $prize_product):?>
                                        <div class="row justify-content-between align-content-center m-0 my-1 col-12 p-1 rounded" style="font-size: .8rem; background-color: #acd7b3">
                                            <div class='col-12 col-md-7 p-0'>
                                                <span><?php echo $prize_product->name ?> </span>
                                            </div>
                                            <div class="col-12 col-md-4 p-0 font-weight-bold" style="font-size: .7rem">
                                                <span><?php echo lg_get_text("lg_364") ?> <?php echo $prize_product->price ?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <!-- Prize -->
                    
                    <!-- Buy N Get N  -->
                    <?php 
                    elseif($offer->application == "Get_N"): 
                        foreach($free_products["free_items"] as $product):
                    ?>
                    <div class="row justify-content-between align-content-center m-0 my-1 col-12 p-1 rounded" style="font-size: .8rem; background-color: #acd7b3">
                        <div class='col-12 col-md-7 p-0 text-center'>
                            <span><?php echo $product["name"] ?> </span>
                        </div>
                        <div class="col-12 d-flex align-items-center justify-content-center col-md-4 p-0 font-weight-bold" style="font-size: 1rem">
                            <span><?php echo "X ".$product["qty"] ?></span>
                        </div>
                    </div>
                    <?php 
                        endforeach;
                    endif 
                    ?>
                    <!-- Buy N Get N  -->

                </div>
                <!-- Any Applicable offers -->
                <?php
                endforeach;
                endif; 
                ?>

                <?php if(true): ?>
                    <!-- Tabby promo badge -->
                    <div class="col-12 m-0 px-0">
                        <div id="ws-tabby-promo"></div>
                    </div>
                <?php endif; ?>
                
                <?php if(true): ?>
                    <!-- EID MESSAGE -->
                    <div class="col-12 my-3 p-3 border-danger rounded" style="background: #ffa50047">
                        <p style="font-size: .8rem">
                            Please be aware that the Eid holidays may cause a delay in the delivery of your order. Nevertheless, as soon as our delivery systemis operational again, we will try our best to ship it.
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Action buttons -->
                <div class="col-12 row j-c-spacearound px-0 pt-4 m-0 cart-action"  style="font-size: 1.3rem; font-weight: bold">
                    <div class="col-6 text-left">
                        <a href="<?php echo base_url() ?>/checkout">
                            <div class="btn-primary btn col-12"><span><?php echo lg_get_text("lg_86") ?></span></div>
                        </a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="<?php echo base_url() ?>/product-list">
                            <div class="btn-secondary btn col-12"><span><?php echo lg_get_text("lg_320") ?></span></div>   
                        </a>
                    </div>
                </div>
                <!-- Action buttons -->

                <div class="col-12 row j-c-spacearound px-0 pt-4 m-0">
                    <div class="col-10 text-center p-0" style="font-size: .85rem">
                        <p class="m-0"><?php echo lg_get_text("lg_201") ?></p>
                    </div>
                </div>
                
                <!-- Payment solutions -->
                <div class="col-12 row m-0 mt-3 j-c-center a-a-center cart-payment-solutions">
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/union_pay.png" alt=""> </div>
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/cash_on_delivery.png" alt=""> </div>
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/master_card.png" alt=""> </div>
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/Visa_card.png" alt=""> </div>
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/american_express.png" alt=""> </div>
                    <?php if(false): ?>
                    <div class="col-3 m-2 d-flex j-c-center"> <img src="<?php echo base_url() ?>/assets/others/tabby-badge.png" alt=""> </div>
                    <?php endif; ?>
                </div>
                <!-- Payment solutions -->
            </div>
               
            <!-- CART Summary -->

            <?php else: ?>
            <div class="row j-c-center a-a-center col-12 m-0" dir="ltr">
                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="250px" height="250px" viewBox="0 0 859.98 802"><title>basket</title><path d="M879.6,539.46H329l10.74,50.46H869l-15.64,74.53c-10.44,49.75-54.89,85.44-106.44,85.44H374.26l8.6,40.92c1.37-.08,2.75-.12,4.14-.12a75.17,75.17,0,0,1,72.64,55.83H673a75.15,75.15,0,1,1,0,38.65H459.65A75.16,75.16,0,1,1,345.9,802.93L214.57,177.65H129.34a19.33,19.33,0,0,1,0-38.65H245.94l28,133.27H707.25a163.66,163.66,0,0,0-19,130.84H299l10.74,50.46H712.36a163.52,163.52,0,0,0,171.81,64.1ZM753.25,442.84c-1.33-1.47-2.64-3-3.91-4.52C750.61,439.85,751.91,441.37,753.25,442.84Zm-3.91-163c1.27-1.54,2.58-3,3.91-4.52C751.91,276.82,750.61,278.34,749.35,279.87Zm0,158.45c1.27,1.54,2.57,3,3.91,4.52C751.92,441.37,750.61,439.85,749.35,438.32ZM962.43,316.27c-1.4-3.81-3-7.55-4.72-11.18A125.29,125.29,0,0,0,947,287q-1.74-2.43-3.59-4.79c-.62-.78-1.25-1.56-1.88-2.33-1.27-1.54-2.58-3-3.91-4.52-.68-.74-1.35-1.47-2-2.19s-1.39-1.44-2.09-2.14a124.54,124.54,0,0,0-176.12,0l-1.22,1.25-.87.89c-.69.72-1.36,1.45-2,2.19-1.33,1.47-2.64,3-3.91,4.52-.64.77-1.27,1.55-1.88,2.33q-1.85,2.35-3.59,4.79a125.29,125.29,0,0,0-10.69,18.1c-1.75,3.63-3.33,7.37-4.72,11.18a125,125,0,0,0,.45,86.85q1.92,5.11,4.27,10a125.29,125.29,0,0,0,10.69,18.1q1.74,2.43,3.59,4.79c.62.78,1.25,1.56,1.88,2.33,1.27,1.54,2.58,3,3.91,4.52.68.74,1.35,1.47,2,2.19s1.39,1.43,2.09,2.14c2.12,2.1,4.29,4.14,6.56,6.11l.34.3h0a124.69,124.69,0,0,0,129,20.53h0a124.77,124.77,0,0,0,40.18-26.94c.71-.7,1.41-1.42,2.09-2.14s1.36-1.45,2-2.19c1.33-1.47,2.64-3,3.91-4.52.63-.77,1.26-1.55,1.88-2.33q1.85-2.35,3.59-4.79a125.29,125.29,0,0,0,10.69-18.1c1.75-3.63,3.33-7.37,4.72-11.18a125.11,125.11,0,0,0,0-85.65ZM753.25,442.84c-1.33-1.47-2.64-3-3.91-4.52C750.61,439.85,751.91,441.37,753.25,442.84Zm0-167.49c-1.34,1.47-2.64,3-3.91,4.52C750.61,278.34,751.92,276.82,753.25,275.35Zm188.29,163c-1.27,1.54-2.58,3-3.91,4.52C939,441.37,940.28,439.85,941.55,438.32Zm-3.91-163c1.33,1.47,2.64,3,3.91,4.52C940.28,278.34,939,276.82,937.64,275.35ZM753.25,442.84c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm0,167.49c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm188.29,163c-1.27,1.54-2.57,3-3.91,4.52C939,441.37,940.28,439.85,941.55,438.32Zm0-158.45c-1.27-1.54-2.58-3-3.91-4.52C939,276.82,940.28,278.34,941.55,279.87Zm-188.29-4.52c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm0,167.49c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Z" transform="translate(-110.01 -139)" style="fill:#22398d82"/><text style="transform:translate(685px,266px); font-size:144px;fill:#ffffff;font-family:TTInterphases-Bold, TT Interphases;font-weight:700">0</text></svg>
                <h5 style="font-size:2.3rem; color: #353535ab" class="<?php text_from_right() ?> col-12 text-center"><?php echo lg_get_text("lg_196") ?></h5>
            </div>
            <?php endif; ?>

            
        </div>
    </div>
</div>


<script>
    function updatecart(cid,as){
        var q=document.getElementById("q-"+cid).value;
        if( q > 0 )  window.location.href = "?cid="+cid+"&quantity="+q;
    }

    function updatecart_plus(cid,as){
      
        var q=document.getElementById("q-"+cid).value;
        var c = parseInt(q) + parseInt(1);
      
        if(c<=parseInt(as) && c > 0 ) {
            window.location.href = "?cid="+cid+"&quantity="+c;
        }

        else{
          document.getElementById('plus'+cid).style.pointerEvents = 'none';
        }
    }

    function updatecart_less(cid,as){
        var q=document.getElementById("q-"+cid).value;
        if(parseInt(q)>1){
            var c = parseInt(q) - parseInt(1);
            if( c<=parseInt(as) && c > 0 ) window.location.href = "?cid="+cid+"&quantity="+c;
        }
    }
</script>
