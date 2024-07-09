
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
<?php 
if(isset($category_banners) && sizeof($category_banners) >= 2):
    $first_half = round(sizeof($category_banners)/2);
?>
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <!-- <div class="col-10">
                <div class="heading heading_design_2 text-dark ">
                    <h2 class="text-white">Choose your next game</h2>
                </div>
        </div> -->
        <div class="col-md-5 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider_two">
            <?php for($i = 0 ; $i < $first_half ; $i++): ?>
                <div class="item" style="height:auto"><a href="<?php echo $category_banners[$i]->link ?>"><img src="<?php echo base_url()?>/assets/others/category_banners/<?php echo $category_banners[$i]->image?>" alt="<?php echo $category_banners[$i]->title ?>"></a></div>
            <?php endfor; ?><?php $category_banners[$i]->title ?>
            </div><?php $category_banners[$i]->title ?>
        </div><?php $category_banners[$i]->title ?>
        <div class="col-md-5 col-sm-12 mt-3 overflow-hidden "><?php $category_banners[$i]->title ?>
            <div class="owl-carousel owl-theme catpage_h_slider_two"><?php $category_banners[$i]->title ?>
            <?php for($i = $first_half ; $i < sizeof($category_banners) ; $i++): ?><?php $category_banners[$i]->title ?>
                <div class="item" style="height:auto"><a href="<?php echo $category_banners[$i]->link ?>"><img src="<?php echo base_url()?>/assets/others/category_banners/<?php echo $category_banners[$i]->image?>" alt="<?php echo $category_banners[$i]->title ?>"></a></div>
            <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- Shop by category -->
<div class="container-fluid home-sec d-flex-column">
    <div class="sec_title"><h2><?php echo lg_get_text("lg_27") ?></h2></div>
    <div class="categories cat d-flex-row">
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/nintendo-switch/games">
                <div class="overlay_title"><h3><?php echo lg_get_text("lg_28") ?></h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_games_switch.png" alt="Switch games">
            </a>
        </div>
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/nintendo-switch/consoles">
                <div class="overlay_title"><h3><?php echo lg_get_text("lg_29") ?></h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_consoles_switch.png" alt="Switch consoles">
            </a>
        </div>
        <div class="category c-sw d-flex-column">
            <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/nintendo-switch/accessories">
                <div class="overlay_title"><h3><?php echo lg_get_text("lg_100") ?></h3></div>
                <img src="<?php echo base_url()?>/assets/uploads/cat_page_accessories_switch.png" alt="Switch accessories">
            </a>
        </div>
    </div>
</div>

<!-- Offers -->
<?php
    if($offers)
    echo view("Product_carousel" , (array)$offers);
?>


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
                    <h2><?php echo lg_get_text("lg_101") ?></h2>
                </div>
        </div>
        <div class="col-md-10 col-sm-12 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_price_slider">
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=nintendo-switch-1634548899&priceupto=35">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">35</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=nintendo-switch-1634548899&priceupto=50">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">50</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=nintendo-switch-1634548899&priceupto=75">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">75</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=nintendo-switch-1634548899&priceupto=150">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">150</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card switch d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=nintendo-switch-1634548899&priceupto=200">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">200</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
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



