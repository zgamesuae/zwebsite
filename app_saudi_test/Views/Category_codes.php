
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

<!-- Shop By Catgories -->
<?php 
if($categories_elements): 
    echo view("Shopbycategory" , ["categories_elements" => $categories_elements]);
endif; 
?>

<!-- Shop By Region -->
<?php 
if($shop_by_region): 
    echo view("Shopbycategory" , ["categories_elements" => $shop_by_region , "title" => lg_put_text("Shop By Region" , "تسوق حسب المنطقة" , false) , "img_max_width" => "150px"]);
endif; 
?>

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

<!-- Playstation Digitals -->
<?php
    if($playstation_digitals){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$playstation_digitals , $params));
    }
?>

<!-- XBOX Digitals -->
<?php
    if($xbox_digitals){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$xbox_digitals , $params));
    }
?>

<!-- Game Cards -->
<?php
    if($game_cards){
        $params = [
            "section_background" => [],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$game_cards , $params));
    }
?>

<!-- Entertainment -->
<?php
    if($entertainment){
        $params = [
            "section_background" => [
                "desktop" => base_url() . "/assets/uploads/digital-entertainment-desktop.jpg",
                "mobile" => base_url() . "/assets/uploads/digital-entertainment-mobile.jpg",
            ],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$entertainment , $params));
    }
?>

<!-- Shopping -->
<?php
    if($shopping){
        $params = [
            "section_background" => [
                "desktop" => base_url() . "/assets/uploads/digital-shopping-desktop.jpg",
                "mobile" => base_url() . "/assets/uploads/digital-shopping-mobile.jpg",
            ],
            "section_division" => [],
            "no_bg" => false,
            "bts_font" => false
        ];
        echo view("Product_carousel" , array_merge((array)$shopping , $params));
    }
?>

<!-- Horizontal banner -->
<?php if(false){ ?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="<?php base_url() ?>/get_a_quote"><img alt="Gaming PC customization" class="d-none d-lg-block" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc.gif" alt=""></a>
        <a href="<?php base_url() ?>/get_a_quote"><img alt="Gaming PC customization" class="d-sm-block d-lg-none" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc_mobile.gif" alt=""></a>
    </div>
</div>
<?php } ?>



