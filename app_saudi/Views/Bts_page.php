<style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@500&family=Rock+Salt&display=swap');
  
    .promo-page{
        background-color: #10200d;
    }

    .bts_logo_container{
        left: 50%;
        top: 50%;
        transform: translate(-50% , -50%);
        margin: auto;
        position: absolute;
    }
    
    .bts_logo{
        max-height: 300px;
    }

    .promo-page-cover{
        background-image: url("<?php echo base_url() ?>/assets/others/bts_template/back_to_school_page_cover.png");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 100%;
        /* background: transparent; */
        height: 50vh;
    }

    .promo-page-cover h1{
        color: white;
        font-size: 5rem;
        font-weight: bold;
        position: absolute;
        margin: auto;
        top: 50%;
        left: 50%;
        transform: translate(-50%,-70%);
        font-family: 'Rock Salt', cursive;
        line-height: 1.2em;
    }
    .promo-page-cover h1 span{
        font-size: 3.5rem
    }

    .promo-page-cats{
        max-height: 400px;
    }

    .promo-page-cats .cats-container{
        position: relative;
        top: -100px;
    }

    @media screen and (max-width: 992px){
        .promo-page-cats{
            max-height: 350px;
        }
        .promo-page-cover{
            height: 50vh!important;
        }
        .promo-page-cover h1{
            font-size: 2.8rem;
        }

        .promo-page-cover h1 span{
            font-size: 1.9rem
        }

    }
</style>

<div class="container-fluid promo-page row m-0 p-0 justify-content-center">

    <div class="promo-page-cover col-lg-10">
        <!-- <h1 class="m-0 text-center">
            <span>BACK TO</span> <br> SCHOOL
        </h1> -->
        <div class="bts_logo_container">
            <img class="bts_logo" src="<?php echo base_url() ?>/assets/others/bts_template/bts_logo.png" alt="">
        </div>
    </div>

    <div class="promo-page-cats col-lg-10">
        <div class="row j-c-center p-0 cats-container">
            <div class="col-12 mt-3 overflow-hidden p-0">
                <div class="owl-carousel owl-theme catpage_bts_slider">
                    <!-- <div class="item d-flex flex-row justify-content-center" style="height:auto;"><a href="<?php echo base_url() ?>/trading-card-games"><img alt="Collectible card games" style="border-radius: 20px" src="https://zgames.ae/assets/others/other_cats/collectible_cards_cat_home_carousel.jpg" alt=""></a></div> -->
                    <div class="item d-flex flex-row justify-content-center p-5" style="height:auto;"><a href="<?php echo base_url() ?>/product-list/offers?type=28,26"><img alt="Drinkware gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/bts_template/bts_mice_&_headsets_cat.jpg" alt=""></a></div>
                    <div class="item d-flex flex-row justify-content-center p-5" style="height:auto;"><a href="<?php echo base_url() ?>/product-list/offers?type=46,43"><img alt="Stationary gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/bts_template/bts_toys_&_funko_cat.jpg" alt=""></a></div>
                    <div class="item d-flex flex-row justify-content-center p-5" style="height:auto;"><a href="<?php echo base_url() ?>/product-list/offers?type=5"><img alt="Apparels gaming merchandise" style="border-radius: 20px" src="<?php echo base_url() ?>/assets/others/bts_template/bts_video_games_cat.jpg" alt=""></a></div>
                </div>
            </div>
        </div>
    </div>

    <!-- videogames -->
    <?php 
        if($videogames)
        echo view("Product_carousel" , array_merge((array)$videogames , ["no_bg" => true , "bts_font" => false]));
    ?>
    <!-- stationary -->
    <?php 
        if($controllers)
        echo view("Product_carousel" , array_merge((array)$controllers , ["no_bg" => true , "bts_font" => false]));
    ?>
    <!-- figurines -->
    <?php 
        if($figurines)
        echo view("Product_carousel" , array_merge((array)$figurines , ["no_bg" => true , "bts_font" => false]));
    ?>
    <!-- consoles -->
    <?php 
        if($consoles)
        echo view("Product_carousel" , array_merge((array)$consoles , ["no_bg" => true , "bts_font" => false]));
    ?>
    <!-- monitors -->
    <?php 
        if($monitors)
        echo view("Product_carousel" , array_merge((array)$monitors , ["no_bg" => true , "bts_font" => false]));
    ?>

</div>