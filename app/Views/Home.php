<?php
  $userModel = model('App\Models\UserModel', false);
  $brandModel = model("App\Models\BrandModel");
  $session = session();
  @$user_id=$session->get('userLoggedin'); 
  $sql="select * from cms";
  $cms=$userModel->customQuery($sql);
  $sql="select * from color where status='Active' AND show_in_home_page='Yes'";
  $color=$userModel->customQuery($sql);
  $sql="select * from banner where status='Active'  order by precedence asc";
  $banner=$userModel->customQuery($sql);

  $sql="select * from brand where status='Active' AND image<>''";
  $brand=$userModel->customQuery($sql);

?>

<?php if(false):?>
<div id="myCarousel" class="home_slider_boostrap carousel slide container-fluid home-sec" data-ride="carousel">
    <ol class="carousel-indicators">

        <?php if($banner){ 
        foreach($banner as $k=>$v){?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $k;?>" class="<?php if($k==0) echo 'active';?>"></li>
        <?php }} ?>
    </ol>
    <div class="carousel-inner">
        <?php if($banner){ 
        foreach($banner as $k=>$v){?>

        <div class="carousel-item <?php if($k==0) echo 'active';?>">
            <div class="container-fluid p-0" id="banner_slider">
                <a href="<?php echo $v->link;?>">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="w-100 ">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" class="w-100 mobile_banner_home_sldier" style="display: none;">
                </a>
                <?php if($v->title){?>

                <div class="container" id="banner_overlay_text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="banner_text_content">
                                <h1><?php echo $v->title;?></h1>
                                <div><?php echo $v->description;?></div>
                                <?php if($v->show_button=="Yes"){?>
                                <div class="banner_button">
                                    <a href="<?php echo $v->link;?>" class="btn btn-primary"><?php lg_get_text("lg_91")?></a>
                                    <!--<a href="<?php echo base_url();?>/product-list" class="btn btn-default">Live demo</a>-->
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
        <?php }} ?>


    </div>
</div>
<?php endif;?>


<?php if(true): ?>

<div class="container-fluid home-sec d-flex j-c-center px-0">
    <div class="owl-carousel owl-theme m_home_slider col-12 m-0 p-0" style="max-width: 3500px">
        <?php
        foreach ($banner as $key => $value):?>
        <?php
            $date = new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
            $start = new \DateTime($value->start_date , new \DateTimeZone(TIME_ZONE));
            $end = new \DateTime($value->end_date , new \DateTimeZone(TIME_ZONE));
            $cond1 = $date->getTimestamp() > $start->getTimestamp();
            $cond2 = $date->getTimestamp() < $end->getTimestamp();
            $cond3 = ($value->start_date == null || $value->start_date == "0000-00-00 00:00:00") && ($value->end_date == null || $value->end_date == "0000-00-00 00:00:00");
            if(($cond1 && $cond2) || $cond3):
                // var_dump($start->format("Y-m-d H:i:s"),$date->format("Y-m-d H:i:s"),$end->format("Y-m-d H:i:s"));
        ?>
        <div class="item p-0" style="height:auto" id="banner_slider">
            <a href="<?php echo $value->link;?>">
                <img alt="<?php echo $value->title ?>" src="<?php echo base_url() ?>/assets/uploads/<?php echo $value->image;?>" class="d-none d-lg-block">
            </a>
            <a href="<?php echo $value->link;?>">
                <img alt="<?php echo $value->title ?>" src="<?php echo base_url() ?>/assets/uploads/<?php echo $value->mobile_image;?>" class="d-block d-lg-none">
            </a>
            
        </div>
        <?php endif;?>
        <?php endforeach; ?>

    </div>
</div>
<?php endif;?>


<?php 
$cats = [
    [
        "eng_title" => "Video Games",
        "ara_title" => "ألعاب الفيديو",
        "link" => base_url() . "/product-list?type=5",
        "img" => base_url() . "/assets/others/games_home_category_carousel.png",
    ],
    [
        "eng_title" => "Consoles",
        "ara_title" => "منصات الألعاب",
        "link" => base_url() . "/product-list?type=18",
        "img" => base_url() . "/assets/others/consoles_home_category_carousel.png",
    ],
    [
        "eng_title" => "Gaming PC",
        "ara_title" => "كمبيوتر الألعاب",
        "link" => base_url() . "/product-list?category=gaming-desktops-1649784817",
        "img" => base_url() . "/assets/others/pc_home_category_carousel.png",
    ],
    [
        "eng_title" => "Gaming Accessories",
        "ara_title" => "ملحقات الألعاب",
        "link" => base_url() . "/product-list?type=26,27,29,28,30",
        "img" => base_url() . "/assets/others/accessories_home_category_carousel.png",
    ],
    [
        "eng_title" => "K-Gaming Products",
        "ara_title" => "منتجات كيجيمنج",
        "link" => base_url() . "/product-list/k-gaming",
        "img" => base_url() . "/assets/others/kgaming_home_category_carousel.png",
    ],
    [
        "eng_title" => "Merchandize",
        "ara_title" => "بضائع الألعاب",
        "link" => base_url() . "/gaming-merchandise",
        "img" => base_url() . "/assets/others/merchandize_home_category_carousel.png",
    ],
    [
        "eng_title" => "Collectibles",
        "ara_title" => "المقتنيات",
        "link" => base_url() . "/product-list?type=48,88",
        "img" => base_url() . "/assets/others/collectibles_home_category_carousel.png",
    ],
    [
        "eng_title" => "Gaming Monitors",
        "ara_title" => "شاشات الألعاب",
        "link" => base_url() . "/product-list?type=42",
        "img" => base_url() . "/assets/others/monitors_home_category_carousel.png",
    ],
    [
        "eng_title" => "Virtual Reality",
        "ara_title" => "الواقع الافتراضي",
        "link" => base_url() . "/virtual-reality-headset",
        "img" => base_url() . "/assets/others/vr_category_carousel.png",
    ],
];
echo view("Shopbycategory" , ["categories_elements" => $cats]);

?>

<!-- Other acts carousel -->

<?php 
if($bundle_offers && false){
    $car_params = [
        "section_background" => [
            // "desktop" => base_url()."/assets/others/carrousel_section_white_friday_desktop.jpg",
            // "mobile" => base_url()."/assets/others/carrousel_section_white_friday_mobile.jpg",
        ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => true,

    ];
    echo view("Product_carousel" , array_merge($bundle_offers , $car_params) );
}

if($best_offers){
    $car_params = [
        "section_background" => [
            // "desktop" => base_url()."/assets/uploads/2024-ramadan-offer-main-desktop-2ba5e.jpg",
            // "mobile" => base_url()."/assets/uploads/2024-ramadan-offer-main-mobile-01e3b.jpg",
        ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => true,

    ];
    echo view("Product_carousel" , array_merge($best_offers , $car_params) );
}
?>

<!--Jumbo PS5 Promo-->
<?php 
$start = (new \DateTime("2023-11-17 00:00:01" , new \DateTimeZone(TIME_ZONE)))->getTimestamp();
$end = (new \DateTime("2023-11-30 23:59:59", new \DateTimeZone(TIME_ZONE)))->getTimestamp();
if($date->getTimestamp() > $start && $date->getTimestamp() < $end){ 
?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/playstation/consoles?show-offer=yes" class="ps_bundle_jb_offer"><img alt="Jumbo offer" class="d-none d-md-block" src="<?php echo base_url()?>/assets/others/17112023_wb_bundles_msm2_desktop.gif" alt=""></a>
        <a href="<?php base_url() ?>/playstation/consoles?show-offer=yes" class="ps_bundle_jb_offer"><img alt="Jumbo offer" class="d-block d-md-none" src="<?php echo base_url()?>/assets/others/17112023_wb_bundles_msm2_mobile.gif" alt=""></a>
    </div>
</div>
<?php } ?>
<!--Jumbo PS5 Promo-->

<?php
// NEW ARRIVALS SECTION
if($new_arrivals_softwares){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$new_arrivals_softwares , $car_params) ) ;
}
?>


<?php
// NEW in Collectibles
if($new_in_collectibles){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$new_in_collectibles , $car_params) ) ;
}
?>


<?php
// PC PARTS SECTION
if($pc_parts){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/pc_parts_carrousel_section_desktop.jpg",
            "mobile" => base_url()."/assets/others/pc_parts_carrousel_section_mobile.jpg",
        ],
        "section_division" => [
            ["img"=> base_url()."/assets/others/carrousel_cat_pc_parts_cpu.jpg" , "link" => base_url()."/gaming-accessories/processor"],
            ["img"=> base_url()."/assets/others/carrousel_cat_pc_parts_gpu.jpg" , "link" => base_url()."/gaming-accessories/graphics-card"],
            ["img"=> base_url()."/assets/others/carrousel_cat_pc_parts_powersupply.jpg" , "link" => base_url()."/gaming-accessories/power-supply"],
            ["img"=> base_url()."/assets/others/carrousel_cat_pc_parts_ram.jpg" , "link" => base_url()."/gaming-accessories/data-storage/internal-data-storage"],
        ],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$pc_parts , $car_params)) ;
}
?>

<?php
// MARVEL CORNER SECTION
if($marvel_corner){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/carrousel_banner_marvel_corner_desktop.jpg",
            "mobile" => base_url()."/assets/others/carrousel_banner_marvel_corner_mobile.jpg",
        ],
    "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("products/Product_carousel_vertical" , array_merge((array)$marvel_corner , $car_params)) ;
}
?>

<?php
// Spider man Section
if($spiderman_section){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/spiderman_carrousel_section_desktop.jpg",
            "mobile" => base_url()."/assets/others/spiderman_carrousel_section_mobile.jpg",
        ],
    "section_division" => [
        ["img"=> base_url()."/assets/others/carrousel_cat_spiderman_figurines.jpg" , "link" => base_url()."/product-list?type=41,88,43&keyword=spider"],
        ["img"=> base_url()."/assets/others/carrousel_cat_spiderman_vgames.jpg" , "link" => base_url()."/product-list?type=5&keyword=spider"],
        ["img"=> base_url()."/assets/others/carrousel_cat_spiderman_drinkware.jpg" , "link" => base_url()."/product-list?type=54,51&keyword=spider"],
        ["img"=> base_url()."/assets/others/carrousel_cat_spiderman_toys.jpg" , "link" => base_url()."/product-list?type=46&keyword=spider"],
    ],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$spiderman_section , $car_params)) ;
}
?>

<?php
// Racing corner
if($racing_corner){
    $car_params = [
        "section_background" => [
                "desktop" => base_url()."/assets/others/racing_hr_carrousel_section_desktop.jpg",
                "mobile" => base_url()."/assets/others/racing_hr_carrousel_section_mobile.jpg",
            ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("products/Product_carousel_vertical" , array_merge((array)$racing_corner , $car_params)) ;
}
?>



<!--Handheld Gaming banners-->
<?php if(true){ ?>
<div class="container-fluid home-sec">
    <div class="row col-12 col-xl-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/handheld-gaming-console"><img alt="handheld-gaming-console" class="d-none d-lg-block" src="<?php echo base_url()?>/assets/others/home_horz_handheld_gaming_desktop.jpg" alt=""></a>
        <a href="<?php base_url() ?>/handheld-gaming-console"><img alt="handheld-gaming-console" class="d-sm-block d-lg-none" src="<?php echo base_url()?>/assets/others/home_horz_handheld_gaming_mobile.jpg" alt=""></a>
    </div>
</div>
<?php } ?>
<!--Handheld Gaming banners-->

<!-- Other acts carousel -->
<?php if(true){?>
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <div class="col-12 col-xl-10">
           <div class="sec_title">
               <h2><?php echo lg_get_text("lg_337") ?></h2>
           </div>
        </div>
        <div class="col-12 col-xl-10 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider">
                <div class="item d-flex flex-row justify-content-center" style="height:auto;"><a href="<?php echo base_url() ?>/trading-card-games"><img alt="Collectible card games" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/other_cats/collectible_cards_cat_home_carousel.jpg" alt=""></a></div>
                <div class="item d-flex flex-row justify-content-center" style="height:auto;"><a href="<?php echo base_url() ?>/gaming-merchandise/drinkware"><img alt="Drinkware gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/other_cats/drinkware_cat_home_carousel.jpg" alt=""></a></div>
                <div class="item d-flex flex-row justify-content-center" style="height:auto;"><a href="<?php echo base_url() ?>/gaming-merchandise/stationery"><img alt="Stationary gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/other_cats/notbooks_cat_home_carousel.jpg" alt=""></a></div>
                <div class="item d-flex flex-row justify-content-center" style="height:auto;"><a href="<?php echo base_url() ?>/gaming-merchandise/apparels"><img alt="Apparels gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/other_cats/t-shirts_cat_home_carousel.jpg" alt=""></a></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Paldon Gaming Merchandize -->
<?php 

if($paladon_merchandize){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/paladon-gaming-merchandize-desk.jpg",
            "mobile" => base_url()."/assets/others/paladon-gaming-merchandize-mob.jpg",
        ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,
    ];
    echo view("products/Product_carousel_vertical" , array_merge((array)$paladon_merchandize , $car_params)) ;
}

?>

<?php 
if($new_arrivals_accessories){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$new_arrivals_accessories , $car_params)) ;
}
?>

<?php include "Home_xboxshopby.php";?>
<?php include "Home_psshopby.php";?>
<?php if(false){ ?>
<?php include "Home_build_your_pc.php";?>
<?php } ?>

<?php if(false){ ?>
<?php include "Home_exclusivities.php"?>
<?php } ?>


<?php 
if(isset($new_in_pc_gaming)){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$new_in_pc_gaming), $car_params) ;
}

if(isset($trending_products)){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$trending_products , $car_params)) ;
}
?>

<!-- Horizontal banner -->
<?php if(true){ ?>
<div class="container-fluid home-sec">
    <div class="row col-12 col-xl-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/get_a_quote"><img alt="Gaming PC customization" class="d-none d-lg-block" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc.gif" alt=""></a>
        <a href="<?php base_url() ?>/get_a_quote"><img alt="Gaming PC customization" class="d-sm-block d-lg-none" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc_mobile.gif" alt=""></a>
    </div>
</div>
<?php } 

if($console_skins && false){
    $car_params = [
        "section_background" => [
                "desktop" => base_url()."/assets/others/Carrousel_section_desktop_skins.jpg",
                "mobile" => base_url()."/assets/others/Carrousel_section_mobile_skins.jpg",
            ],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$console_skins , $car_params)) ;
}


if($coming_soon){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false,
        "countdown" => false,

    ];
    echo view("Product_carousel" , array_merge((array)$coming_soon , $car_params));
}



?>

 <!--Horizontal banner cutomized consoles-->
<?php if(false){?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/product-list?type=49"><img alt="Console skin cutomization" class="desktop_img" src="<?php echo base_url()?>/assets/uploads/craft_by_merlin_website_banner.gif" alt=""></a>
        <a href="<?php base_url() ?>/product-list?type=49"><img alt="Console skin cutomization" class="mobile_img" src="<?php echo base_url()?>/assets/uploads/craft_by_merlin_website_banner_mobile.gif" alt=""></a>
    </div>
</div>
<?php
} 

if(true)
include "Other_cats.php";
?>


<!-- Shop games by genre -->
<?php if(false): ?>
<div class="container-fluid home-sec">
    <div class="row services_area pt-4 pb-4" id="services_area">
        <div class="col-md-10 mb-4 mt-3" style="margin:auto">
            <div class="sec_title">
                <!-- <h2><?php echo $cms[7]->heading;?></h2> -->
                <h2><?php echo lg_get_text("lg_21");?></h2>

                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>

        <div class="container-fluid full_cate_sliders mt-3">

            <div class="owl-carousel service_box_animated_sliders owl-theme col-lg-10 .col-sm-12 p-0" style="margin:auto">
                <?php if($color){
          $i=0;
          foreach($color as $k=>$v){
            if($v->image!="" && $v->mobile_image!=""){
             if($i<10){
              ?>
                <div class="item">
                    <div class="service_box_min_new ">
                        <div class="service_box">
                            <a href="<?php echo base_url();?>/product-list?genre=<?php echo $v->id;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="<?php echo $v->title ?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" alt="<?php echo $v->title ?>" class="mobile_image" style="display: none;">
                                <div class="box_overlay_content">
                                    <!-- <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->icon;?>" alt="">-->
                                    <h6>
                                        <?php if(get_cookie("language") == "AR") echo $v->arabic_title; else echo $v->title;?>
                                        <span class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                            </svg>
                                        </span>
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
          }
          $i++;
          } 
          }
          }
          ?>
            </div>
        </div>
    </div>

</div>
<?php endif; ?>

<!-- Shop games by genre -->
<div class="container-fluid home-sec">
    <div class="row services_area pt-4 pb-4" id="services_area">
        <div class="col-12 col-xl-10 mb-4 mt-3" style="margin:auto">
            <div class="sec_title">
                <h2><?php echo lg_get_text("lg_21");?></h2>
            </div>
        </div>
        <div class="container-fluid full_cate_sliders m-0">
            <div class="owl-carousel ws-shopby-genre-carousel owl-theme col-12 col-xl-10 p-0" style="margin:auto">

                <div class="item row align-items-end justify-content-center" style="color: white;font-weight: 300; min-height: 200px">

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=18">
                        <img src="https://zgames.ae/assets/others/ws-shopby-finght.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Fighting" , "قتال") ?></h4>
                    </div>
                  </div>

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=6">
                        <img src="https://zgames.ae/assets/others/ws-shopby-sport.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Sport" , "رياضة") ?></h4>
                    </div>
                  </div>
                      
                </div>

                <div class="item row align-items-end justify-content-center" style="color: white;font-weight: 300; min-height: 200px">

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=2">
                        <img src="https://zgames.ae/assets/others/ws-shopby-shooter.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Shooter" , "بندقية") ?></h4>
                    </div>
                  </div>

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=16">
                        <img src="https://zgames.ae/assets/others/ws-shopby-racing.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Racing" , "سباق") ?></h4>
                    </div>
                  </div>
                      
                </div>
                
                <div class="item row align-items-end justify-content-center" style="color: white;font-weight: 300; min-height: 200px">

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=14">
                        <img src="https://zgames.ae/assets/others/ws-shopby-horror.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Horror" , "رعب") ?></h4>
                    </div>
                  </div>

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=31">
                        <img src="https://zgames.ae/assets/others/ws-shopby-action.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Action" , "أكشن") ?></h4>
                    </div>
                  </div>
                      
                </div>

                <div class="item row align-items-end justify-content-center" style="color: white;font-weight: 300; min-height: 200px">

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=5">
                        <img src="https://zgames.ae/assets/others/ws-shopby-adventure.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Adventure" , "مفامرة") ?></h4>
                    </div>
                  </div>

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=3">
                        <img src="https://zgames.ae/assets/others/ws-shopby-strategy.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Strategy" , "إستراتيجية") ?></h4>
                    </div>
                  </div>
                      
                </div>

                <div class="item row align-items-end justify-content-center" style="color: white;font-weight: 300; min-height: 200px">

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=19">
                        <img src="https://zgames.ae/assets/others/ws-shopby-multiplayer.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Multiplayer" , "متعددة اللاعبين") ?></h4>
                    </div>
                  </div>

                  <div class="col-12 d-flex flex-column justify-content-center ws-genre-item my-3 p-0">
                    <div class="col-auto d-flex justify-content-center py-3 text-center py-1" style="font-size: 6rem; min-height: 75px">
                      <a href="<?php echo base_url() ?>/product-list?genre=9">
                        <img src="https://zgames.ae/assets/others/ws-shopby-dancing.png" alt="">
                      </a>
                    </div>
                    <div class="col-12 p-0">
                      <h4 class="text-center p-2 m-0" style="background-color: #2c3240"><?php echo lg_put_text("Music" , "موسيقى") ?></h4>
                    </div>
                  </div>
                      
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Shop games by genre -->



<?php 
if($more_games && false){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false
    ];
    echo view("Product_carousel" , array_merge((array)$more_games , $car_params));
}

if($more_accessories && false){
    $car_params = [
        "section_background" => [],
        "section_division" => [],
        "no_bg" => false,
        "bts_font" => false
    ];
    echo view("Product_carousel" , array_merge((array)$more_accessories , $car_params)) ;
}

?>


<!-- shop by brand -->
<?php 

    if($brand){
?>
    <div class="container-fluid home-sec pt-4 pb-4 shop_brand_shop_by">
        <div class="row j-c-center">
            <div class="col-12 col-xl-10">
                <div class=" sec_title mb-4 text-center text-capitalize">
                    <h2><b><?php echo lg_get_text("lg_18")?></b></h2>
                    <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
                </div>
            </div>
            <div class="col-12 col-xl-10 pl-2 mb-2">
                <div class="owl-carousel owl-theme two_rows_grid_sliders">

                    <?php
                      $j=0;
                      $k=1;
                     
                       for($i=0;$i<count($brand)/2;$i++):
                        if(array_key_exists($j , $brand)):
                    ?>

                    <div class="item">
                        
                        <?php if($brand[$j]->image !== "" && $brand[$j]->title): ?>
                        <div class="new_design_box_categoryies shadow-sm bg-white border rounded">
                            <!-- <h2 style="position:absolute;top:5px;left:5px;color:green;z-index:1000"><?php echo($brand[$j]->title) ?></h2> -->
                            <a href="<?php echo $brandModel->get_brand_url($brand[$j]->id);?>">
                                <img alt="<?php echo $brand[$j]->title ?>" src="<?php echo base_url();?>/assets/uploads/<?php echo $brand[$j]->image;?>">
                            </a>
                        </div>
                       <?php endif; ?>
                        <?php if($brand[$k]->title && $brand[$k]->image !== ""): ?>
                        <div class="new_design_box_categoryies shadow-sm bg-white border rounded mt-2">
                            <!-- <h2 style="position:absolute;top:5px;left:5px;color:green;z-index:1000"><?php echo($brand[$k]->title) ?></h2> -->
                            <a href="<?php echo $brandModel->get_brand_url($brand[$k]->id);?>">
                                <img alt="<?php echo $brand[$k]->title ?>" src="<?php echo base_url();?>/assets/uploads/<?php echo @$brand[$k]->image;?>">
                            </a>
                        </div>
                       <?php endif; ?>

                    </div>
                    <?php   
                        $j=$j+2;
                        $k=$k+2;

                        endif;endfor;?>

                </div>
            </div>


        </div>
    </div>
<?php } ?>

<div class="container-fluid home-sec pt-4 pb-4">
    <div class="row j-c-center">
        <div class="text-justify col-12 col-xl-10" style="color: rgb(15, 15, 15)">
            <p>
                The ultimate destination for all your gaming needs in the United Arab Emirates. ZGames offers a wide range of gaming products, including the latest consoles, games, accessories, and more from all the top brands.
                Our website is user-friendly, easy to navigate and constantly updated with the latest releases and offers. You can browse our collection by platform, genre, or brand, making it            easy to find exactly what you're looking for.
                ZGames is dedicated to providing our customers with the best possible gaming experience. That's why ZGames only stocks the highest quality products and offers the most competitive prices in the market. Our team is highly knowledgeable about all the products we sell and can assist you with any questions or queries you may have.
                ZGames also offers a convenient and secure online shopping experience. You can place your order online, and we will deliver it right to your doorstep. We also offer a hassle-free return policy, so you can shop with confidence.
                We are passionate about gaming and are committed to providing our customers with the best possible service. So whether you're a hardcore gamer or just looking for a fun way to pass the time, ZGames got you covered.
            </p>
        </div>
    </div>
</div>