
<?php 
// var_dump($infos);
$productModel = model("App\Model\ProductModel");
$offerModel = model("App\Model\OfferModel");
$systemModel = model("App\Model\SystemModel");
$settings = $this->systemModel->get_website_settings();
if(true): 

?>
<style>
    *{
        /* font-family: 'Kanit', sans-serif; */
    }
</style>

<!-- Abondoned Carts email notification -->
<div style="height: auto; width:650px; background-color: #eef0f7; border: solid 1px rgba(0, 0, 0, 0.171); margin: 15px auto">

    <!-- Header -->
    <div style="padding: 0px 50px 20px; background-color: rgb(232, 234, 238 , 0);">
        <table style="width:100%; height:auto; text-align:center">
            <tbody>
                <tr>
                    <td style="text-align: center; width: auto;" colspan="2">
                        <div style="height: 100%; width: 100%; margin: auto; padding: 15px">
                            <a target="blank" href="<?php echo base_url() ?>">
                                <img src="https://zamzamgames.com/assets/uploads/ZGames-logo-01-66570.png" width="150px" alt="">
                            </a>
                        </div>
                    </td>
                </tr>

                <?php if(false): ?>
                <tr>
                    
                    <td style="height: 150px; width: 50%; text-align: center; ">
                        <div style="height: 150px; width: 100%; margin: auto; overflow: hidden; position:relative; background-image: url('<?php echo base_url() ?>/assets/uploads/csv/cart.png'); background-position: 0px 0px; background-repeat:no-repeat; background-size:cover;">
                            <p style="color:rgb(255, 255, 255 , .75); font-weight:bold; font-size:45px; position: absolute; top:35px; right:25px; margin: 0px;">3</p>
                        </div>
                    </td>
                    <td style="width: 50%;">
                        <p style="line-height:auto ;margin: 0px; font-weight: bold; font-size: 2rem;@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap');font-family: 'Kanit', sans-serif;">
                            IN YOUR CART
                        </p>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
    <!-- Header -->

    <!-- Message content -->
    <div style="width: 90%; padding: 25px 25px; text-align: justify; margin: auto; box-sizing: border-box;">
        <div style="text-align:center; line-height: 1.4rem; font-size:.85rem; ">
            <p style="color: rgb(32, 32, 32)">Dear <?php echo strtoupper($infos["user"]["name"]) ?>,</p>
            <p style="color: rgb(32, 32, 32)">The <?php if($infos["user"]["product_count"]>1) echo "items"; else echo "item"; ?> in your ZGames cart (<?php echo $infos["user"]["product_count"] ?>) <?php if($infos["user"]["product_count"]>1) echo "are"; else echo "is"; ?> currently waiting for you. Did something happen while you were checking out, or are you still shopping?</p> 
        </div>
    </div>
    <!-- Message content -->

    <!-- Items in the cart -->
    <div class="product-cart" style="height: auto; width: 100%; padding: 0px">
        <table style="width:96%; height: auto; border-collapse: collapse; background-color: rgb(248, 249, 251 , 0); color: rgb(46, 46, 46); border-collapse: separate; border-spacing: 0 15px; margin:auto">
            <tbody>
                <?php
                    $counter = 0;
                    foreach($infos["carts_product"] as $product): 
                ?>
                <tr>
                    <td style="width:25%; height: 130px; padding:15px; text-align: center; background-color: #d9dfec; border-top-left-radius:15px; border-bottom-left-radius:15px; vertical-align:top;">
                        <div style="background: white; height: 130px; width: 130px; overflow: hidden; margin:auto; border-radius: 15px;">
                            <img src="<?php echo base_url() ?>/assets/uploads/<?php echo $product->image ?>" alt="" style="height:100%; margin:auto">
                        </div>
                    </td>

                    <td style="width:25%; height: 130px; padding:30px 8px 8px; text-align: center; background-color: #d9dfec; vertical-align:top;">
                        <p style="font-weight:700; margin-bottom: 10px; font-size: 1rem">
                            Product Name
                        </p>
                        <p style="line-height: 18px; font-size: .7rem;">
                            <?php echo $product->name ?>
                        </p>
                    </td>

                    <td style="width:25%; height: 130px; padding:30px 8px 8px; text-align: center; background-color: #d9dfec; vertical-align:top;">
                        <p style="font-weight:700; margin-bottom: 10px; font-size: 1rem">
                            Quantity
                        </p>
                        <p style="line-height: 18px; font-size: 1rem;"><span style="font-size: .7rem">X</span> <?php echo $product->quantity ?></p>
                    </td>

                    <td style="width:25%; height: 130px; padding:30px 8px 8px; text-align: center; background-color: #d9dfec; border-top-right-radius:15px; border-bottom-right-radius:15px; vertical-align:top;">
                        <p style="font-weight:700; margin-bottom: 10px; font-size: 1rem">
                            Price
                        </p>
                        <?php 
                            $discount = $productModel->get_discounted_percentage($offers_list , $product->product_id);
                            $is_rounded = $productModel->is_discount_rounded($product->product_id);
                            if($discount["discount_amount"] > 0)
                            $price = $discount["new_price"];
                            else 
                            $price = $product->price;
                        ?>
                        <p style="line-height: 18px; font-size: 1rem;"><?php echo $price ?> <span style="position: relative; top: 10px; font-size: .6rem;"><?php echo CURRENCY ?></span></p>
                    </td>
                </tr>
                <?php 
                    $counter++ ;
                    endforeach; 
                ?>

            </tbody>
        </table>
    </div>
    <!-- Items in the cart -->


    <!-- Call to action message -->
    <div style="width: 90%; padding: 25px 25px; text-align: justify; margin: auto; box-sizing: border-box;">
        <div style="margin:30px auto; width: 150px; height: auto; background-color: #133d99; text-align: center; border-radius: 10px;">
            <a href="<?php echo base_url() ?>" style="color:#ececec;">
                <p style="padding:10px 0px; margin: 0px; font-weight: bold">Checkout</p>
            </a>
        </div>
    </div>
    <!-- Call to action message -->

    <!-- footer -->
    <table align="center" style="width:100%; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px; color:rgb(46, 46, 46)">
        <tbody>
            <tr></tr>
            
            <tr>
                <td style="text-align: left; padding: 0 10px">
                    <a style="text-decoration:none; margin:0; fill:#363636" href="<?php echo $settings->facebook ?>">
                        <img style="height:22px; vertical-align:middle;" src="https://zamzamgames.com/assets/uploads/ns_facebook.png" alt="">
                    </a>
                    <a style="text-decoration:none; margin:0 10px; fill:#363636" href="<?php echo $settings->instagram ?>">
                        <img style="height:22px; vertical-align:middle;" src="https://zamzamgames.com/assets/uploads/ns_instagram.png" alt="">
                    </a>
                    <a style="text-decoration:none; margin:0; fill:#363636" href="<?php echo $settings->tiktok ?>">
                        <img style="height:22px; vertical-align:middle;" src="https://zamzamgames.com/assets/uploads/ns_tiktok.png" alt="">
                    </a>
                </td>
                <td></td>
            </tr>
            <tr>
                <td style="height:auto; text-align:left; line-height:20px; padding:10px;" colspan="4">
                    <p style="font-size: .8rem; margin:0">
                        Tel: <?php echo $settings->phone ?> <br>
                        Email: <?php echo $settings->email ?> <br>
                        © <?php echo $settings->business_name ?> | <?php echo $settings->address ?>.
                    </p>
                </td>
                <td style="text-align: right;">
                    <div>
                        <img width="45px" src="https://zamzamgames.com/assets/others/Visa_card.png" alt="">
                        <img width="45px" src="https://zamzamgames.com/assets/others/master_card.png" alt="">
                        <img width="45px" src="https://zamzamgames.com/assets/others/american_express.png" alt="">
                        <img width="45px" src="https://zamzamgames.com/assets/others/union_pay.png" alt="">
                        <img width="45px" src="https://zamzamgames.com/assets/others/cash_on_delivery.png" alt="">
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- footer -->

</div>
<!-- Abondoned Carts email notification -->

<?php endif; ?>
