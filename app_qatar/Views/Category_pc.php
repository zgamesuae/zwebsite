
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
            <?php endfor; ?>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 mt-3 overflow-hidden ">
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
<div class="container-fluid home-sec d-flex-column">
    <div class="sec_title"><h2><?php echo lg_get_text("lg_27") ?></h2></div>
    <div class="categories cat d-flex-row">
            <div class="category j-c-center c-pc d-flex-column ">
                <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/pc-gaming/pc-setup">
                    <div class="overlay_title"><h3><?php echo "PC TOWERS" ?></h3></div>
                    <img src="<?php echo base_url()?>/assets/others/pc_category/pc_cat_page_towers.png" alt="PC Towers">
                 </a>
            </div>

            <div class="category j-c-center c-pc d-flex-column ">
                <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/pc-gaming/pc-accessories">
                    <div class="overlay_title"><h3><?php echo "ACCESSORIES" ?></h3></div>
                    <img src="<?php echo base_url()?>/assets/others/pc_category/pc_cat_page_accessories.png" alt="PC Accessories">
                </a>
            </div>

            <div class="category j-c-center c-pc d-flex-column ">
                <a class="j-c-center d-flex-column" href="<?php echo base_url()?>/pc-gaming/pc-accessories/pc-monitors">
                    <div class="overlay_title"><h3><?php echo "MONITORS" ?></h3></div>
                    <img src="<?php echo base_url()?>/assets/others/pc_category/pc_cat_page_monitors.png" alt="PC Monitors">
                </a>
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

<!-- PC SETUPS -->
<?php
    if($pcs){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$pcs , $params));
    }
?>

<!-- PC CASES SECTION -->
<?php
    if($pc_cases){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$pc_cases , $params));
    }
?>

<!-- GRAPHIC CARDS SECTION -->
<?php
    if($gpus){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$gpus , $params));
    }
?>

<!-- OTHER PC COMPONENTS -->
<?php
    if($cooling_and_power){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$cooling_and_power , $params));
    }
?>

<!-- PC GAMING FURNITURE -->
<?php
    if($gaming_furniture){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$gaming_furniture , $params));
    }
?>

<!-- PC HEADSETS -->
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

<!-- KEYBOARDS & MICE -->
<?php
    if($keyboards_and_mice){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$keyboards_and_mice , $params));
    }
?>

<!-- STREAMING -->
<?php
    if($streaming){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$streaming , $params));
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



<?php 

// PLAYSTATION EXCLUSIVE SECTION
if($exclusive){
    $car_params = [
        "section_background" => [
            "desktop" => base_url()."/assets/others/carrousel_banner_ps_exclusive_corner_desktop.jpg",
            "mobile" => base_url()."/assets/others/carrousel_banner_ps_exclusive_corner_mobile.jpg",
        ],
    "section_division" => [],
        "no_bg" => false,
        "bts_font" => false
    ];
    echo view("products/Product_carousel_vertical" , array_merge((array)$exclusive , $car_params)) ;
}

?>



