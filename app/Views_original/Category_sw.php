
<?php 
$cdate=date("Y-m-d");
$session = session();
@$user_id=$session->get('userLoggedin'); 

$userModel = model('App\Models\UserModel', false);

// $query="select * from products where products.status='Active'   AND ( FIND_IN_SET('accessories-1636468761', products.category)      OR (   FIND_IN_SET('cables-1641137988', products.category)      OR   FIND_IN_SET('chargers-1637830415', products.category)      OR   FIND_IN_SET('controllers-1641137675', products.category)      OR     FIND_IN_SET('accessories-16383472444279', products.category)       ) ) order by products.precedence desc limit 20";

// $access=$userModel->customQuery($query);
// var_dump($access);


// abnners section
?>



<!-- two banners section -->
<!-- banners -->
<?php if(false){?>
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <!-- <div class="col-10">
                <div class="heading heading_design_2 text-dark ">
                    <h2 class="text-white">Choose your next game</h2>
                </div>
        </div> -->
        <div class="col-md-5 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider_two">
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202203/d10/imgs/tiny-tina-wonderlans-banner.jpg" alt=""></div>
                <div class="item" style="height:auto"><img src="https://cdn.geekay.com/media/home-banners/20220211_Mailshot_960x430_Kirby.jpg" alt=""></div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider_two">
                <div class="item" style="height:auto"><img src="https://cdn.geekay.com/media/home-banners/20220211_Mailshot_960x430_Kirby.jpg" alt=""></div>
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202203/d10/imgs/tiny-tina-wonderlans-banner.jpg" alt=""></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<!-- Shop by category -->
<div class="container-fluid home-sec d-flex-column">
    <div class="sec_title"><h2>Shop by category</h2></div>
    <div class="categories cat d-flex-row">
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/product-list?category=tiles-1634549085">
                <div class="overlay_title"><h3>Games</h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_games_switch.png" alt="">
            </a>
        </div>
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/product-list?category=consoles-1634549117">
                <div class="overlay_title"><h3>Consoles</h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_consoles_switch.png" alt="">
            </a>
        </div>
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/product-list?category=accessories-1636468817">
                <div class="overlay_title"><h3>Accessories</h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_accessories_switch.png" alt="">
            </a>
        </div>
    </div>
</div>

<!-- New products -->
<?php
    if($new_realeses)
    echo view("Product_carousel" , (array)$new_realeses);
?>


<!-- Coming soon -->
<?php
    if($preorders)
    echo view("Product_carousel" , (array)$preorders);
?>



<!-- Best deals section -->
<?php if(false){?>
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <div class="col-md-10 col-sm-12">
                <div class="sec_title text-dark ">
                    <h2 class="text-white">Good deals</h2>
                </div>
        </div>
        <div class="col-md-10 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider">
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202202/d25/imgs/pokemon-brilliant-stars.jpg" alt=""></div>
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202202/d18/imgs/tws-earpods.gif" alt=""></div>
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202201/d14/imgs/nanoleaf.gif" alt=""></div>
                <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202202/d11/imgs/logitech-g413.gif" alt=""></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<!-- Shop by price -->
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <div class="col-md-10 col-sm-12">
                <div class="sec_title text-dark ">
                    <h2 class="text-white">SHOP BY PRICE</h2>
                </div>
        </div>
        <div class="col-md-10 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_price_slider">
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="https://zamzamgames.com/product-list?category=nintendo-switch-1634548899&priceupto=35">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">35</h3>
                                <p class="p-0 m-0 currency">AED</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="https://zamzamgames.com/product-list?category=nintendo-switch-1634548899&priceupto=50">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">50</h3>
                                <p class="p-0 m-0 currency">AED</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="https://zamzamgames.com/product-list?category=nintendo-switch-1634548899&priceupto=75">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">75</h3>
                                <p class="p-0 m-0 currency">AED</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="https://zamzamgames.com/product-list?category=nintendo-switch-1634548899&priceupto=150">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">150</h3>
                                <p class="p-0 m-0 currency">AED</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="https://zamzamgames.com/product-list?category=nintendo-switch-1634548899&priceupto=200">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">200</h3>
                                <p class="p-0 m-0 currency">AED</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Controllers best seller -->
<?php
    if($controllers)
    echo view("Product_carousel" , (array)$controllers);
?>




<!-- headsets best sellers -->
<?php
    if($headsets)
    echo view("Product_carousel" , (array)$headsets);
?>


<!-- best in adventure games -->
<?php
    if($adventure_games)
    echo view("Product_carousel" , (array)$adventure_games);
?>

<!-- Subscribe to news letter -->

<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize">
    <div class="container p-0">
        <div class="row">
            <div class="col-md-8 mt-2">
                <div class="heading">
                    <h3 class="text-white">Subscribe to our newsletter</h3>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <?php if(@$flashData['success']){?>
                <p style="margin-bottom: 0; padding-bottom: 10px; color: #fff; font-weight: 500;"><?php echo $flashData['success'];?></p>
                <?php } ?>
                <form method="post" class="d-flex" action="<?php echo base_url();?>/page/newsletter">
                    <input type="email" placeholder="Email Adderess" required name="email">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>


