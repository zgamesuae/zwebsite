
<?php
    $session = session();
    $orderModel = model("App\Model\OrderModel");
    $productModel = model("App\Model\ProductModel");
    $userModel = model("App\Model\UserModel");
    $brandModel = model("App\Model\BrandModel");
    $offerModel = model("App\Model\OfferModel");

    $orderModel = model("App\Model\OrderModel");
    $user_id = ($session->get("userLoggedin")) ? $session->get("userLoggedin") : session_id();
    $cart = $orderModel->get_user_cart($user_id);
    $user_address = $userModel->get_user_address($user_id);
    $user_phone = $userModel->get_user_phone($user_id);

    $cart_coupon_discount = $orderModel->cart_total_coupon_discount($user_id);
    $total_cart = $orderModel->total_cart($user_id);
    $cart_charges = $orderModel->cart_total_charges($user_id , $total_cart , $user_address->city);
    $total = $total_cart - $cart_coupon_discount;
    // Cart Has offer discount
    // Cart Has offer discount
    if(isset($offers)){
        array_map(function($offer) use(&$total){
            if($offer->application == "Discount")
            $total -= ($offer->discount_type == "Percentage") ? $total * $offer->discount_value / 100 : $offer->discount_amount;
        } , $offers);
        // $offer_discount = ($offer->discount_type == "Percentage") ? $total * $offer->discount_value / 100 : $offer->discount_amount;
        // $total = $total - $offer_discount;  
    } 
    $total += $cart_charges["total_charges"] ;

    $cart_has_coupon_applied = $orderModel->cart_has_coupon_applied($user_id);
    // all the brands in the cart
    $cart_product_brands = $orderModel->_getproductcart_bybrand($user_id);
    // all categories in the cart
    $cart_product_categories = $orderModel->_getproductcart_bycategory($user_id);
    $coupon_codes= $orderModel->coupon_exist_ontcart($total_cart,$cart_product_brands);

    $cart_coupon = $orderModel->cart_has_coupon_applied($user_id);
    $pre_order_enabled = !$orderModel->cart_has_preorder($cart);
    $city = $orderModel->get_city_list();

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
        max-width: 150px;
        height: auto;
        width: 100%;
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
    .cart-quantity{font-size: 1.1rem}
    .cart-quantity span{font-weight: bold}
    .cart-charges-list{font-size: .9rem; font-weight: 400}
    .sammary-details{ font-size: 1.1rem; font-weight: bold }
    .sub-sammary-details{ font-size: .9rem; font-weight: 600 }
    .checkout-content{max-height: 550px; overflow-y: scroll;color: rgb(68, 68, 68);}
    .checkout-sammary{}

    @media screen and (max-width: 450px){
        .cart-delete-product{
            /* position: absolute!important; */
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
                <h2 class="m-0"><?php echo lg_get_text("lg_86") ?></h2>
            </div>

            <?php if($productModel->total_cart() > 0 ): ?>

            <!-- Alert messages -->
            <?php if(isset($msg) && $msg !== ""): ?>
            <div class="col-12 j-c-center <?php echo text_from_right() ?>">

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg ?>
                  <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>

            </div>
            <?php endif; ?>
            <!-- Alert messages -->

            <!-- Checkout infos Details -->
            <div class="col-12 col-lg-8 row j-c-center c-view p-lg-3 p-0">
                
                <div class="card border-0 mb-2 shadow col-12 px-1">
                    <?php
                    if ($session->get('userLoggedin'))
                    {
                        if ($user_address)
                        {
                    ?>
                    <form action="<?php echo base_url(); ?>/order-submit" method="post">
                    <?php
                        }
                        else{
                    ?>
                    <form action="<?php echo base_url(); ?>/order-submit" method="post">
                    <?php
                        }
                    }
                    ?>
                        <div class="card-body px-3 col-12">
                            <?php
                            if ($session->get('userLoggedin'))
                            {
                            
                            ?>
                            <form action="<?php echo base_url(); ?>/order-submit" method="post">
                            <?php
                                if ($user_address){
                            ?>
                                <div class="title_heading d-flex justify-content-between">
                                    <h5 class="mb-3 font-weight-bold text-capitalize py-3" style="font-size: 20px; color: #4e4e4e"> <?php echo lg_get_text("lg_208") ?></h5>
                                    <?php if(true): ?>
                                    <a href="javascript:void();" data-toggle="modal" data-target="#changeAddressModla" class="text-primary ws-checkout-change-address"><?php echo lg_get_text("lg_209") ?></a>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="row">
                                    <div class="col">
                                        <div class="row justify-content-between pl-3 pr-3">
                                            <div class="pl-3 title_productrs">
                                                <p class="mb-2"><?php echo $user_address->name; ?></p>
                                                <p class="mb-2"><?php echo $user_address->street; ?></p>
                                                <p class="mb-2"><?php echo $user_address->apartment_house; ?></p>
                                                <p class="mb-2"><?php echo $user_address->address; ?></p>
                                                <p class="mb-2">
                                                    <?php
                                                        $cid = $user_address->city;
                                                        $sql = "select * from city where   city_id ='$cid'";
                                                        $cityDetail = $userModel->customQuery($sql);
            
                                                        echo @$cityDetail[0]->title; 
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                }
                                else
                                {
                                ?>
                                <h5 class="pb-3 border-bottom text-capitalize <?php text_from_right() ?>">
                                    <strong><?php echo lg_get_text("lg_208") ?></strong>
                                </h5>
                                <!-- DELIVERY INFORMATIONS FORM  -->
                                <div class="row">
                                    <!-- FIELD: NAME  -->
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_148") ?> </label>
                                        <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="<?php echo lg_get_text("lg_148") ?>" name="name" required value="<?php echo $userDetails[0]->name; ?>">
                                    </div>

                                    <!-- FIELD: STREET  -->
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_221") ?></label>
                                        <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="<?php echo lg_get_text("lg_221") ?>" name="street" required value="<?php echo $userDetails[0]->street; ?>">
                                    </div>

                                    <!-- FIELD: APPARTEMENT  -->
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_234") ?></label>
                                        <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="<?php echo lg_get_text("lg_234") ?>" name="apartment_house" required value="<?php echo $userDetails[0]->apartment_house; ?>">
                                    </div>

                                    <!-- FIELD: ADDRESS  -->
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_68") ?></label>
                                        <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="<?php echo lg_get_text("lg_68") ?>" name="address" required value="<?php echo $userDetails[0]->address; ?>">
                                    </div>

                                    <!-- FIELD: CITY  -->
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_222") ?></label>
                                        <select name="city" required class="form-control">
                                            <option value=""><?php echo lg_get_text("lg_223") ?></option>
                                            <?php 
                                            if ($city){
                                                foreach ($city as $k => $v){
                                            ?>
                                            <option <?php if ($v->city_id == $userDetails[0]->city) echo "selected"; ?> value="<?php echo $v->city_id; ?>"><?php echo $v->title; ?></option>
                                            <?php
                                                }
                                            } ?>

                                        </select>
                                    </div>
                                </div>
                                <!-- END DELIVERY INFORMATIONS  -->
                                <?php
                                }
                                ?>

                                <!-- FIELD: PHONE NUMBER if user didn't set it up -->
                                <?php if(trim($user_phone) == ""): ?>
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <label class="m-0 col-12 p-0 font-weight-bold <?php text_from_right() ?>"><?php echo lg_get_text("lg_274") ?></label>
                                        <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="0520000000" name="order_phone" value="<?php echo $userDetails[0]->address; ?>" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));">
                                    </div>
                                </div>   
                                <?php endif; ?>

                                <!-- PAYMENT METHOD BEGIN -->
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <h4 class="py-3 border-top text-capitalize <?php text_from_right() ?>" style="font-size: 20px; color: #4e4e4e"><strong><?php echo lg_get_text("lg_210") ?> </strong></h4>
                                    </div>

                                    <div class="col-12">
                                        <div class=" justify-content-center row">
                                            <div class="col-12 row p-0 my-2">
                                                <!-- ONLINE PAYMENT -->
                                                <div class="col-12 row m-0 my-1 px-0 py-2 border-bottom">
                                                    <div class="col-auto p-2 mx-2 border payment-method d-flex a-a-center">
                                                        <label class="checkbox light-green d-flex m-0" for="installation-checkbox" style="cursor: pointer">
                                                            <input hidden id="installation-checkbox" type="radio" required class="mr-2" name="payment_method" value="Online payment">
                                                            <img src="<?php echo base_url() ?>/assets/others/zg_payment_methods.jpg" class="" style="max-width: 100px">
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- END ONLINE PAYMENT -->

                                                <!-- Tabby Payment -->
                                                <?php if(true): ?>
                                                <div class="col-12 row px-0 py-2 m-0 my-1 align-items-center border-bottom">
                                                    <div class="col-auto p-2 mx-2 border payment-method d-flex a-a-center">
                                                        <label class="checkbox light-green d-flex m-0 align-items-center" for="installation-checkbox1" style="cursor: pointer">
                                                            <input hidden id="installation-checkbox1" type="radio" required class="mr-2" name="payment_method" value="Tabby payment">
                                                            <img src="<?php echo base_url() ?>/assets/others/tabby-badge.png" class="" style="max-width: 100px">
                                                        </label>
                                                    </div>
                                                    <div class="col-6 p-2">
                                                        <p class="m-0 <?php echo text_from_right() ?>">
                                                            <?php echo lg_get_text("lg_353") ?>
                                                            <i class="fa-solid fa-circle-info mx-2" type="button" data-tabby-language="<?php if(get_cookie('language') == 'AR') echo 'ar'; else echo 'en'   ?>" data-tabby-info="installments" data-tabby-price="<?php echo $total ?>" data-tabby-currency="<?php echo CURRENCY?>"></i>
                                                        </p>
                                                    </div>
                                                    <div class="col-12 p-2 d-flex a-a-center m-0">
                                                        <div id="tabbyCard" class="col-12 p-0"></div>
                                                    </div>
                                                </div>
                                                
                                                <?php endif; ?> 
                                                <!-- END Tabby Payment -->


                                                <!-- CASH ON DELIVERY -->
                                                <?php
                                                if ($pre_order_enabled == "No" && !$orderModel->cart_has_digital_codes($user_id)){
                                                ?>

                                                <div class="col-12 row px-0 py-2 m-0 my-1">
                                                    <div class="col-auto p-2 mx-2 border payment-method d-flex a-a-center">
                                                        <label class="checkbox light-green d-flex m-0" for="installation-checkbox2" style="cursor: pointer">
                                                            <input hidden id="installation-checkbox2" type="radio" required class="mr-2" name="payment_method" value="Cash on devlivery">
                                                            <img src="<?php echo base_url() ?>/assets/others/zg_cash_on_delivery.jpg" class="" style="max-width: 100px">
                                                        </label>
                                                    </div>
                                                </div>

                                                <?php
                                                }
                                                ?>
                                                <!-- END CASH ON DELIVERY -->
                                            </div>
                                            
                                            <?php
                                            // @$user_id = $session->get('userLoggedin');
                                            if (@$user_id && false){
                                                $sql = "select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used')  order by created_at desc";
                                                $cbal = $userModel->customQuery($sql);
                                                if ($cbal[0]->total){
                                            ?>

                                            <!-- WALLET BALANCE USER -->
                                            <div class="col-12 mt-2">
                                                <label class="m-0 font-weight-bold text-black">
                                                    <input type="checkbox" id="wallet_use" name="wallet_use" value="Yes"> <?php echo lg_get_text("lg_211") ?> (<b class="black"><?php echo lg_get_text("lg_212") ?> : <?php echo bcdiv($cbal[0]->total, 1, 2); ?> <?php echo lg_get_text("lg_102") ?></b>)
                                                </label>
                                            </div>
                                            <input type="hidden" id="wallet_bal" value="<?php echo bcdiv($cbal[0]->total, 1, 2); ?> ">
                                            <!-- WALLET BALANCE USER -->

                                            <?php
                                                }
                                            }
                                            ?>

                                            <div class="col-12 mt-2 <?php text_from_right() ?>">
                                                <label class="m-0 font-weight-bold text-gray">
                                                    <input type="checkbox" name="" required> <?php echo lg_get_text("lg_147") ?> <a class="text-primary" href="<?php echo base_url(); ?>/privacy-and-policy"><?php echo lg_get_text("lg_06") ?></a>
                                                </label>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <button type="submit" class="btn btn-primary w-100 p-2 text-capitalize"><?php echo lg_get_text("lg_164") ?></button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- PAYMENT METHOD END -->
                            </form>
                            <?php
                            }
                            else
                            {
                            ?>
                                

                                <!-- NEW LOGIN | REGISTER | GUEST FORMS  -->
                                <div id="checkout_lrg_area" class="row j-c-center py-3" style="background-color: #ffffff;">
                                    <!-- <div class="col-12 px-0 px-lg-3"> -->
                                        <?php
                                            echo view("forms/Login_forms" , array("flag" => "login" , "destination" => "checkout_lrg_area"));
                                        ?>
                                    <!-- </div> -->
                                </div>
                                <!-- END - NEW LOGIN | REGISTER | GUEST FORMS -->
                            <?php
                            }
                            ?>
                                

                                
                        </div>
                </div>

            </div>
            <!-- Checkout infos Details -->


            <!-- CART Summary -->
            <div class="col-12 col-lg-4 c-recap p-3">

                <?php if(!isset($offer)): ?>
                <!-- Show applicable coupons -->
                    <?php 

                    // all the coupon with minimum total cart 
                    $coupon_codes= $orderModel->coupon_exist_ontcart($total_cart,$cart_product_brands);
                    // var_dump($coupon_codes);die();

                    foreach($coupon_codes as $code):
                    $co = $orderModel->get_coupon_id($code);
                    $condition = false;


                    $coupon_entity=$orderModel->get_promo_coupon_code($co);
                    // var_dump($brandModel->_getbrandname($coupon_entity[0]->on_brand));

                    // test if coupon has min cart
                    if($coupon_entity[0]->min_cart_amount > 0 && $coupon_entity[0]->min_cart_amount !==null){
                        $condition = ($total_cart >= $coupon_entity[0]->min_cart_amount);
                    }

                    // test if coupon has brand
                    $coupon_has_brand=$coupon_entity[0]->on_brand > 0 && $coupon_entity[0]->on_brand !==null;
                    $coupon_has_category=($coupon_entity[0]->on_category!==null);

                    $brand_condition=in_array($coupon_entity[0]->on_brand,$cart_product_brands);
                    $category_condition=false;
                    foreach(explode(",",$coupon_entity[0]->on_category) as $value){
                        if(in_array($value,$cart_product_categories)){
                            $category_condition=true;
                            break;
                        }
                    }

                    if($coupon_has_brand && !$coupon_has_category){
                        $condition = $condition && $brand_condition;
                        $v_text = ($coupon_entity[0]->type == "Amount") ? $coupon_entity[0]->value." ".CURRENCY : $coupon_entity[0]->value. "%";

                    }
                    else if(!$coupon_has_brand && $coupon_has_category){
                        $condition = $condition && $category_condition;
                        $v_text = ($coupon_entity[0]->type == "Amount") ? $coupon_entity[0]->value." ".CURRENCY : $coupon_entity[0]->value. "%";
                    }

                    else if($coupon_has_brand && $coupon_has_category){
                        $condition = $condition && $brand_condition && $category_condition;
                        $v_text = ($coupon_entity[0]->type == "Amount") ? $coupon_entity[0]->value." ".CURRENCY : $coupon_entity[0]->value. "%";
                    }

                    else
                    $v_text = ($coupon_entity[0]->type == "Amount") ? $coupon_entity[0]->value." ".CURRENCY : $coupon_entity[0]->value. "%";


                    if($condition): 
                    ?>

                    <div class="row col-12 py-2 j-c-center my-2 mx-0" style="background-color:#3150c3;color:white">
                        <p class="m-0 text-center"><?php echo lg_get_text("lg_213") ?> <span style="color:yellow"><b ><?php echo $coupon_entity[0]->coupon_code?></b></span> <?php echo lg_get_text("lg_214") ?> <b><?php echo $v_text?></b> <?php echo lg_get_text("lg_215") ?> <?php if($b = $brandModel->_getbrandname($coupon_entity[0]->on_brand)): echo "on ".$b." products";  endif;?></p>
                    </div>  
                    <?php 
                    endif; 
                    endforeach; 
                    ?> 
                <!-- Show applicable coupons -->

                <!-- Apply coupon code -->
                <div class="promo-code-outer p-3">
                    <div data-toggle="collapse" data-target="#demo">
                        <div class="promo-code d-flex justify-content-between">
                            <p class="m-0">
                                <?php 
                                if ($cart_has_coupon_applied["applied"]) echo '<b style="color:green;">Coupon code applied!</b>';
                                else
                                {
                                    echo lg_get_text("lg_220");
                                } 
                                ?>
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                            </svg>
                        </div>
                    </div>
                    <div id="demo" class="collapse">
                        <div class=" form-sm d-flex bg-white border rounded pb-0 border-weight-2 mt-3">
                            <input <?php if ($cart_has_coupon_applied["applied"]) echo 'readonly disabled'; ?> value="<?php if ($cart_has_coupon_applied["applied"]) echo $cart_has_coupon_applied["coupon"]["coupon_code"]; ?>" id="coupon_code" label="Enter promo code" name="coupon_code" placeholder="<?php echo lg_get_text("lg_219") ?>" type="text" class="form-sm-input form-control m-0 border-0" aria-invalid="false">
                            <button <?php if ($cart_has_coupon_applied["applied"]) echo '  disabled'; ?> type="button" id="ApplyCoupon" class="form-sm-btn btn text-primary font-weight-bold" style="color:black !important;"><?php echo lg_get_text("lg_187") ?></button>
                        </div>
                    </div>
                </div>
                <!-- Apply coupon code -->
                <?php endif; ?>

                <div class="col-12 p-0 m-0 checkout-content">
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
                        <div class="col-12 pt-4 cart-quantity <?php text_from_right() ?>">
                            <p class="m-0"><?php echo lg_get_text("lg_279") ?>: <span class="ml-3"><?php echo $cart_price["quantity"] ?></span></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- Loop over the cart products -->


                    <!-- Loop on the charges -->
                    <?php foreach($cart_charges["charges"] as $charge): ?>
                    <div class="col-12 my-3 mx-0 px-2 py-3 row j-c-spacebetween a-a-center sum-cart-product-line">
                        <div class="col-8 mw-10">
                            <p class="m-0 <?php text_from_right(true) ?>">
                                <?php echo $charge["title"] ?>
                            </p>
                        </div>
                        <div class="col-auto p-0 text-right" style="font-weight: Bold; font-size: 1rem; position: relative">
                            <span><?php echo $charge["price"] ?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- Loop on the charges -->
                </div>

                <div class="checkout-sammary col-12 p-0 py-3 m-0 ">
                    <!-- subtotal summary -->
                    <div class="col-12 row j-c-spacebetween px-0 pt-0 pb-2 m-0 sub-sammary-details">
                        <div class="col <?php text_from_right(true) ?> ">
                            <span><?php echo lg_get_text("lg_284-1") ?>:</span>
                        </div>
                        <div class="col <?php text_from_left(true) ?> ">
                            <span><?php echo $total_cart ?></span> <span class=""><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <!-- subtotal summary -->

                    <!-- Charges summary -->
                    <?php if($cart_charges["total_charges"] > 0): ?>
                    <div class="col-12 row j-c-spacebetween px-0 pt-0 pb-2 m-0 sub-sammary-details">

                        <div class="col <?php text_from_right(true) ?> ">
                            <span><?php echo lg_get_text("lg_319") ?>:</span>
                        </div>
                        <div class="col-auto <?php text_from_left(true) ?> ">
                            <span><?php echo $cart_charges["total_charges"] ?></span> <span class=""><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- Charges summary -->

                    <!-- Discount summary -->
                    <?php if($cart_has_coupon_applied["applied"]): ?>
                    <div class="col-12 row j-c-spacebetween px-0 pt-0 pb-2 m-0 sub-sammary-details">
                        <div class="col <?php text_from_right(true) ?> ">
                            <span><?php echo lg_get_text("lg_216") ?>:</span>
                        </div>
                        <div class="col-auto <?php text_from_left(true) ?> ">
                            <span>-<?php echo $cart_coupon_discount ?></span> <span class=""><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Any Applicable offer -->
                    <?php
                    if(isset($offers)): 
                    foreach($offers as $offer):
                        if($offer->application == "Get_N"){
                            $free_products = $offerModel->_get_cart_GetN_products($offer);
                            $msg = isset($free_products["msg"]);
                        }
                    ?>  
                    <div class="col-12 row j-c-spacebetween px-0 py-2 m-0 mb-2 border <?php if($msg) echo "border-warning"; else echo "border-success";  ?> rounded"  style="font-size: .9rem; background-color: <?php if($msg) echo "#ffe5ad"; else echo "#c7e5c7" ?>; ">
                        <!-- Offer Title -->
                        <div class="col-12 m-0 <?php text_from_right(true) ?>">
                            <?php if(in_array($offer->application , ["Discount" , "Prize"])): ?>
                            <p style="font-size: .9rem;" class="m-0 mb-2">
                                <?php echo lg_get_text("lg_362") ?> <span style="color: #005800" class="font-italic">"<?php echo lg_put_text($offer->offer_title , $offer->offer_arabic_title) ?>"</span>
                                <?php 
                                // if ($offer->application == "Discount")
                                $title_prefix = lg_get_text("lg_368");
                                if($offer->application == "Prize")
                                $title_prefix .= lg_get_text("lg_366");
                                
                                ?>
                                <span><?php echo $title_prefix ?></span>
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
                                    $title_prefix = lg_get_text("lg_368");
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
                                <span>Discount<?php if($offer->discount_type == "Percentage") echo "(-$offer->discount_value%)"?>:</span>
                            </div>
                            <div class="col <?php text_from_left(true) ?> " style="font-weight: bold">
                                <span >-<?php echo $offer_discount?></span><span class="currency"><?php echo lg_get_text("lg_102") ?></span>
                            </div>
                        </div>
                        <!-- Discount -->
                        
                        <?php elseif($offer->application == "Prize"): ?>
                        <!-- Prize -->
                        <?php 
                            $saved_prizes = $offerModel->get_cart_product_prizes($user_id , $offer->offer_id);
                            $offer_prizes = (sizeof($saved_prizes) > 0) ? $saved_prizes : $offerModel->_select_offer_valid_prize($offer , $user_id);
                            $prizes = $offerModel->_get_offer_prize_products($offer_prizes)
                        ?>
                        <div class="col-12 row m-0 p-0">
                            <div class="col <?php text_from_right(true) ?> ">
                                <ul class="pl-0" style="list-style: none">
                                    <?php foreach($prizes as $prize_title => $prize_products): ?>
                                    <li class="my-2">
                                        <p class="font-weight-bold mb-1">
                                            <span class=""><?php echo $prize_title ?></span>
                                            <?php if(sizeof($prize_products) > 1): ?>
                                            <span>Includes: </span>
                                            <?php endif; ?>
                                        </p>
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
                    <?php 
                    endforeach;
                    endif; 
                    ?>
                    <!-- Any Applicable offer -->

                    <!-- discount summary -->

                    <!-- Total summary -->
                    <div class="col-12 row j-c-spacebetween px-0 py-2 m-0 sammary-details">
                        <div class="col <?php text_from_right(true) ?> ">
                            <span><?php echo lg_get_text("lg_198-1") ?>:</span>
                        </div>
                        <div class="col <?php text_from_left(true) ?> ">
                            <span><?php echo $total ?></span> <span class=""><?php echo lg_get_text("lg_102") ?></span>
                        </div>
                    </div>
                    <!-- Total summary -->

                    <?php if(true): ?>
                    <!-- EID MESSAGE -->
                    <div class="col-12 my-3 p-3 border-danger rounded" style="background: #ffa50047">
                        <p style="font-size: .8rem">
                            Please be aware that the Eid holidays may cause a delay in the delivery of your order. Nevertheless, as soon as our delivery systemis operational again, we will try our best to ship it.
                        </p>
                    </div>
                    <?php endif; ?>
                    
                </div>

                <!-- Action buttons -->
                <div class="col-12 row j-c-spacearound px-0 pt-4 m-0 cart-action"  style="font-size: 1.3rem; font-weight: bold">
                    <div class="col-6 text-left">
                        <a href="<?php echo base_url() ?>/cart">
                            <div class="btn-primary btn col-12"><span><?php echo lg_get_text("lg_217") ?></span></div>
                        </a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="<?php echo base_url() ?>/product-list">
                            <div class="btn-secondary btn col-12"><span><?php echo lg_get_text("lg_320") ?></span></div>
                        </a>
                    </div>
                </div>
                <!-- Action buttons -->
                
                <!-- Website security text -->
                <div class="col-12 row j-c-spacearound px-0 pt-4 m-0">
                    <div class="col-10 text-center p-0" style="font-size: .85rem">
                        <p class="m-0"><?php echo lg_get_text("lg_201") ?></p>
                    </div>
                </div>
                <!-- Website security text -->

                <!-- ENBD inslment plan information -->
                <?php if(false):?>
                <div class="col-12 row j-c-spacearound px-0 pt-4 m-0">
                    <div class="row m-0 p-2 border rounded justify-content-center">
                        <div class="col-12 mb-2 p-0 mr-1 d-flex justify-content-center">
                            <img class="m-0" style="width:auto; height: 1cm" alt="ENBD logo" src="<?= base_url() ?>/assets/img/<?php lg_put_text("enbd_mini_logo.jpg" , "enbd_mini_logo_ara.jpg") ?>">
                        </div>
                        <div class="col-auto d-flex p-0 m-0 flex-row justify-content-between" style="font-size: .9rem; line-height: 20px">
                            <div class="<?php text_from_right() ?>">
                                <span><?php echo lg_get_text("lg_343") ?> </span>
                            </div>
                            <div class="col-auto <?php text_from_left(); if(get_cookie("language") == 'AR') echo " pl-0"; else echo " pr-0"; ?> enbd_learn_more">
                                <a data-bs-toggle="modal" data-bs-target="#generalmodal" data-bs-modal-title="<?php echo lg_get_text("lg_344") ?>" data-bs-modal-content="<?php echo lg_get_text("lg_343") ?>" href="javascript:void(0)" style="text-decoration: underline!important; color:inherit"><?php echo lg_get_text("lg_345") ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <!-- ENBD inslment plan information -->
               
            <!-- CART Summary -->

            <?php else: ?>

            <div class="col-12 p-4" style="background-color: rgb(240, 240, 240);">
                <p class="m-0 text-center" style="font-size: 1.5rem; font-weight:bold; color: rgb(97, 97, 97);">
                    <?php echo lg_get_text("lg_321") ?> <span><a href="<?php echo base_url() ?>/product-list" style="color: rgb(0, 60, 255)"><?php echo lg_get_text("lg_322") ?></a></span> <?php echo lg_get_text("lg_323") ?>
                </p>
            </div>
            
            <?php endif; ?>


        </div>
        
            <!-- Change Address modal -->
            <div class="modal fade" id="changeAddressModla" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md rounded modal-dialog-centered">
                    <div class="modal-content" style="background-color: #373a47;">
                        <div class="model_eader " style="z-index: 1; top: 10px; right: 10px; background: none">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">×</span></button>
                        </div>
                        <div class="modal-body" style="color: white" >
    
                            <!-- Conent start -->
    
                            <!-- Content end -->
    
                        </div>
                    </div>
                </div>
            </div>
            <!-- Change Address modal -->
    </div>
</div>


