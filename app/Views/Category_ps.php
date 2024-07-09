
<?php 
$cdate=date("Y-m-d");
$session = session();
@$user_id=$session->get('userLoggedin'); 
$date = new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
$userModel = model('App\Models\UserModel', false);
?>



<!-- two banners section -->
<!-- banners -->
<?php 
if(isset($category_banners) && sizeof($category_banners) >= 2):
    $first_half = round(sizeof($category_banners)/2);
?>
<div class="container-fluid justify-content-center d-flex pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row col-12 col-xl-10 justify-content-center">
        <div class="col-12 col-lg-6 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider_two">
            <?php for($i = 0 ; $i < $first_half ; $i++): ?>
                <div class="item" style="height:auto"><a href="<?php echo $category_banners[$i]->link ?>"><img src="<?php echo base_url()?>/assets/others/category_banners/<?php echo $category_banners[$i]->image?>" alt="<?php echo $category_banners[$i]->title ?>"></a></div>
            <?php endfor; ?>
            </div>
        </div>
        <div class="col-12 col-lg-6 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider_two">
            <?php for($i = $first_half ; $i < sizeof($category_banners) ; $i++): ?>
                <div class="item" style="height:auto"><a href="<?php echo $category_banners[$i]->link ?>"><img src="<?php echo base_url()?>/assets/others/category_banners/<?php echo $category_banners[$i]->image?>" alt="<?php echo $category_banners[$i]->title ?>"></a></div>
            <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Shop by category -->
<div class="container-fluid home-sec">
    <div class="row justify-content-center">
        <div class="sec_title col-12 col-xl-10"><h2><?php echo lg_get_text("lg_27") ?></h2></div>
        <div class="categories col-12 col-xl-10 cat d-flex-row justify-content-between">
                <div class="category j-c-center c-ps d-flex-column ">
                    <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/playstation/games">
                        <div class="overlay_title"><h3><?php echo lg_get_text("lg_28") ?></h3></div>
                        <img src="<?php echo base_url()?>/assets/uploads/cat_page_games.png" alt="Playstation games">
                     </a>
                </div>
                
                <div class="category j-c-center c-ps d-flex-column ">
                    <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/playstation/consoles">
                        <div class="overlay_title"><h3><?php echo lg_get_text("lg_29") ?></h3></div>
                        <img src="<?php echo base_url()?>/assets/uploads/cat_page_consoles.png" alt="Playstation consoles">
                    </a>
                </div>
                
                <div class="category j-c-center c-ps d-flex-column ">
                    <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/playstation/accessories">
                        <div class="overlay_title"><h3><?php echo lg_get_text("lg_100") ?></h3></div>
                        <img src="<?php echo base_url()?>/assets/uploads/cat_page_accessories.png" alt="Playstation accessories">
                    </a>
                </div>
        </div>
    </div>
</div>

<!-- OFFERS -->
<?php
    if($offers){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$offers , $params));
    }
?>

<!--Jumbo PS5 Eid offer-->
<?php 
$start = (new \DateTime("2023-11-17 00:00:01" , new \DateTimeZone(TIME_ZONE)))->getTimestamp();
$end = (new \DateTime("2023-11-30 23:59:59", new \DateTimeZone(TIME_ZONE)))->getTimestamp();
if($date->getTimestamp() > $start && $date->getTimestamp() < $end){ 
?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/playstation/accessories/controllers?show-offer=yes"><img alt="Jumbo offer" class="d-none d-md-block" src="<?php echo base_url()?>/assets/others/17112023_wb_dualsense_desktop.gif" alt=""></a>
        <a href="<?php base_url() ?>/playstation/accessories/controllers?show-offer=yes"><img alt="Jumbo offer" class="d-block d-md-none" src="<?php echo base_url()?>/assets/others/17112023_wb_dualsense_mobile.gif" alt=""></a>
    </div>
</div>
<?php } ?>
<!--Jumbo PS5 Eid offer-->

<!-- New products -->
<?php
    if($new_realeses){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$new_realeses , $params));
    }
?>

<!-- Coming soon -->
<?php
    if($preorders){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$preorders , $params));
    }
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

<?php 

// PLAYSTATION EXCLUSIVE SECTION
if($ps_exclusive){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/carrousel_banner_ps_exclusive_corner_desktop.jpg",
            "mobile" => base_url()."/assets/others/carrousel_banner_ps_exclusive_corner_mobile.jpg",
        ],
    "section_division" => [],
        "no_bg" => false,
        "bts_font" => false
    ];
    echo view("products/Product_carousel_vertical" , array_merge((array)$ps_exclusive , $car_params)) ;
}

?>


<!-- Shop by price -->
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <div class="col-12 col-xl-10">
                <div class="sec_title text-dark ">
                    <h2><?php echo lg_get_text("lg_101") ?></h2>
                </div>
        </div>
        <div class="col-12 col-xl-10 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_price_slider">
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card ps d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=playstation-1634548926&priceupto=35">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">35</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card ps d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=playstation-1634548926&priceupto=50">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">50</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card ps d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=playstation-1634548926&priceupto=75">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">75</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card ps d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=playstation-1634548926&priceupto=150">
                            <div class="c-s-price">
                                <h3 class="sby-price m-0">150</h3>
                                <p class="p-0 m-0 currency"><?php echo lg_get_text("lg_102") ?></p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="item d-flex-column j-c-center" >
                    <div class="shop_by_price_card ps d-flex-column">
                        <a href="<?php echo base_url() ?>/product-list?category=playstation-1634548926&priceupto=200">
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

<?php 

// CUSTOMIZED SKINS
if($console_skins){
    $car_params = [
        "section_background" => [
                "desktop" => base_url()."/assets/others/Carrousel_section_desktop_skins.jpg",
                "mobile" => base_url()."/assets/others/Carrousel_section_mobile_skins.jpg",
            ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false
    ];
    echo view("Product_carousel" , array_merge((array)$console_skins , $car_params)) ;
}

?>

<!-- Controller best sellers -->
<?php
    if($controllers){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$controllers , $params));
    }
?>


<!-- headsets bestseller -->
<?php
    if($headsets){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$headsets , $params));
    }
?>

<!-- Best in RPG games -->
<?php
    if($rpg_games){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$rpg_games , $params));
    }
?>



