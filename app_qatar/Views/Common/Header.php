<?php 

    $uri = service('uri'); 
    $session = session();
    global $userModel,$productModel,$category_model,$brandModel,$reviewModel,$blogModel,$orderModel,$offerModel;
    global $uri1,$uri2,$uri3;
    if(is_null(get_cookie("language")))
    set_cookie("language" , "EN" , 3600);

    $userModel = model('App\Models\UserModel');
    $productModel = model('App\Models\ProductModel');
    $category_model = model('App\Models\Category');
    $brandModel = model("App\Models\BrandModel");
    $reviewModel = model("App\Models\ReviewModel");
    $blogModel = model("App\Models\BlogModel");
    $orderModel = model("App\Models\OrderModel");
    $offerModel = model("App\Models\OfferModel");


    $user_loggedin = $session->get('userLoggedin'); 
    $user_id = ($user_loggedin) ? $user_loggedin : session_id();

    if($user_loggedin){
        $user_details_req = "select * from users where user_id='".$user_id."'";
        $user_details = $userModel->customQuery($user_details_req);
    }

    $setting_req = "select * from settings";
    $settings = $userModel->customQuery($setting_req);

    $cart_count_req = "select * from cart where user_id='".$user_id."'";
    $cart_count = $userModel->customQuery($cart_count_req);
    $cart_count = (is_null($cart_count)) ? [] : $cart_count; 
    include 'Google_seo.php';
    $seo = pageseo($uri);


?>

<!DOCTYPE html>
<html lang="<?php echo (get_cookie("language") !== null) ? get_cookie("language") : 'EN'; ?>">

<head>
    
    <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
    
    <?php
    // If it is product pages
    if($uri->getSegment(1)=="product"){
        $prod=$productModel->get_product_id_from_slug($uri->getSegment(2) , true); 
        $product_screenshot = $productModel->get_product_screenshots($prod->product_id);
        $product_image = $productModel->get_product_image($prod->product_id);
        preg_match("/[\D]+/" , $prod->sku , $matchs);
        $sku = (sizeof($matchs) > 0) ? "" : "| $prod->sku" ;
    ?>

     <title><?php  if(@$prod){ echo "Shop $prod->name with ".$settings[0]->business_name." in UAE - Dubai,Abu Dhabi,Sharjah $sku";}else{ echo ucwords($settings[0]->business_name);}?></title>

     <!-- PRODUCT GOOGLE SEO -->
     <?php productseo($prod , $product_screenshot , $product_image) ?>
     <!-- END PRODUCT GOOGLE SEO -->

    <?php 
    }
    // if it is other than product page
    else{
    ?>
        <title><?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?></title>
        <link rel="canonical" href="<?php echo base_url().$_SERVER["REQUEST_URI"];?>">
        <meta name="description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_description);}?>">
        <?php if($seo[0]): ?>
        <meta name="keywords" content="<?php echo @$seo[0]->page_keywords;?>">
        <?php endif; ?>
        <?php if(false): ?>
        <meta property="og:title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
        <?php endif; ?>
        <meta property="og:description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_description);}?>">
        <meta property="og:image" content="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
        <meta property="og:url" content="<?php echo base_url().$_SERVER["REQUEST_URI"] ?>">
        <meta name="twitter:card" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">

        <!--  Non-Essential, But Recommended -->
        <meta property="og:site_name" content="<?php  echo ucwords($settings[0]->business_name);?>">
        <meta name="title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
        
    <?php } ?>
        
    <?php breadcrumb($uri); ?>

    <meta name="robots" content="index,follow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/style.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/yahia_custom_css.css"> -->
    <link rel="preload" href="<?php echo base_url();?>/assets/css/uae/custom/yahia_custom.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/custom/yahia_custom.css"></noscript>

    <link rel="stylesheet" media="screen and (max-width: 992px)" href="<?php echo base_url();?>/assets/css/uae/responsive_css/mobile.css">
    <link rel="stylesheet" media="screen and (max-width: 980px)" href="<?php echo base_url();?>/assets/css/uae/custom/responsive/mobile.css">

    <!-- <link rel="stylesheet" media="screen and (min-width: 1199px)" href="<?php echo base_url();?>/assets/css/uae/responsive_css/desktop.css"> -->
    <link media="screen and (min-width: 1199px)" rel="preload" href="<?php echo base_url();?>/assets/css/uae/responsive_css/desktop.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/responsive_css/desktop.css"></noscript>
    <!--  -->
    <!-- <link rel="stylesheet" media="screen and (min-width: 1220px)" href="<?php echo base_url();?>/assets/css/uae/custom/responsive/desktop.css"> -->
    <link media="screen and (min-width: 1199px)" rel="preload" href="<?php echo base_url();?>/assets/css/uae/custom/responsive/desktop.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/custom/responsive/desktop.css"></noscript>
    
    


    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/reviews.css"> -->
    <link rel="preload" href="<?php echo base_url();?>/assets/css/uae/reviews.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/reviews.css"></noscript>

    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/uae/menu/index.css">
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/main.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/content.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/custom/yahia_custom_home.css"> -->
    
    <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/responsive.css"> -->
    <link rel="preload" href="<?php echo base_url();?>/assets/css/uae/responsive.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/responsive.css"></noscript>

    <?php if(sizeof($uri->getSegments()) > 0 && false): ?>
        <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/style2.css"> -->
        <!-- <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/custom/yahia_custom.css"> -->
    <?php endif; ?>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/wheel/spin.scss">
    
    

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C5N5HZJJ9D"></script>
    
    
    
        
    <!-- GTag --> 
        <?php if(true): ?>
        <script defer="true">
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());

              gtag('config', 'G-C5N5HZJJ9D');
            </script>
        <?php endif; ?>
    <!-- GTag --> 
 
    
    <!-- Event snippet for Order Placed conversion page -->
        <?php 
            if($uri->getSegment(1)=="order-success" && ($products)):
            echo gtag_event_purchase($order , $products);     
            echo gtag_event_conversion($order);?>
        <?php endif; ?>
    <!-- Event snippet for Order Placed conversion page -->
    
    <!-- Tiktok Events -->
        <?php 
            if(true)
            include 'Tiktok_events.php'; 
        ?>
    <!-- Tiktok Events -->

    <!-- Google Tag Manager -->
        <script defer="true">
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-W4FSM8K');
        </script>
    <!-- End Google Tag Manager -->

    <!-- Social Login -->
        <script defer="true">
            function auth_popup(provider) {
                // replace 'path/to/hybridauth' with the real path to this script
                sw = screen.width/2 - 300
                sh = screen.height/2 - 200
                var authWindow = window.open('<?php echo base_url()?>/auth/social_login/?provider=' + provider, 'authWindow', 'width=600,height=400,scrollbars=yes,top='+sh+'px,left='+sw+'px');
                window.closeAuthWindow = function () {
                  authWindow.close();
                }

                return false;
            }
        </script>
    <!-- Social Login -->
    
    

    <style>
        #verifyOTP {
            /*display: none*/
        }

        .search_box {
            margin-right: 10px
        }

        .search_box {
            fill: #fff
        }

        .header_serach_parent {
            display: none;
            padding: 0 10px 9px 13px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            background: #fff
        }

        .header_serach_parent .header_serach {
            width: fit-content;
            margin-left: auto;
            margin-right: 7px;
            margin-top: 4px;
            margin-bottom: 9px
        }

        form.search_box {
            display: flex;
            border: 1px solid #eae8e8;
            border-radius: 4px
        }

        form.search_box input {
            width: 100%;
            border: unset
        }

        <?php if(get_cookie("language") == "AR"): ?>

        /* Arabic style */
            /* GENERAL FONT STYLE */
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;400&display=swap');
            body *{
                font-family: 'Cairo', sans-serif;
            }

            /* END GENERAL FONT STYLE */

        
            /* footer style */
                .footer_inner h5::after{
                right: 0
            }

            .footer_inner ul{
                padding-right:0px
            }
            /* end footer style */

            /* MENU STYLE  */

            .open_menu_mobile_s{
                right:100%
            }

            .cart.color-white{
                margin: 0px 11px 0px;
            }
            .cart.color-white span{
                position: relative
            }
            
            .account_wishlist{
                margin-right:auto;
                margin-left:0px;
            }

            @media only screen and (max-width: 767px){
                div#acount_menu_open_dic{
                    left: 15px;
                    right: auto
                }
            }

            .header_top_right{
                margin-right: auto;
                margin-left: 0
            }

            ul.main_menu .dropdown_icon{
                transform: rotateY(180deg)
            }

            /* END MENU STYLE */

            /* CATEGORY PAGE SHOP BY CATEGORY */

            .container-fluid .categories .category .overlay_title{
                clip-path: polygon(100% 50%,0% 100%,100% 100%)
            }

            .container-fluid .categories .category .overlay_title h3{
                right: 10px;
                left: auto
            }

            /* CATEGORY PAGE SHOP BY CATEGORY */

            /* LOGIN FORM ARABIC STYLING */
            .eye_password{
                right:auto;
                left: 25px
            }
            /* END LOGIN FORM ARABIC STYLING */


            /* FILTERS PRODUCT LIST */

            .titie_heasder svg{
                right: auto;
                left: 13px
            }

            /* END FILTERS PRODUCT LIST */

            /* MODAL STYLING */
            .modal-header .close{
                margin-right: auto;
                margin-left: -1rem
            }




        /* END Arabic style */
        <?php endif; ?>


    </style>

    <?php if(true): ?>
    <style>
        /* Yahia custom css */
            .container-fluid.home-sec{
                height: auto;
                background-color: #ffffff;
                box-sizing: border-box;
            }
            /* home sections  */
            .container-fluid .sec_title{
                width: 100%;
                height: 40px;
                margin: 35px 0px 0px;
                position: relative;
                /* background-color:red; */
            }

            .container-fluid .sec_title h2{
                width: 100%;
                text-transform: capitalize;
                text-align: center;
                color: rgb(15, 15, 15);
            }

            /* Shop by category home section */
            .container-fluid .categories,.container-fluid .two-banners{
                height:auto;
                width: 85%;
                padding: 10px 10px;
            
            }
            .container-fluid .categories .platform_category{
                min-width: 280px;
                height: 250px;
                width: 30%;
                margin: 10px 10px;
                overflow: hidden;
                /* align-content: center; */
                border-radius: 10px;
                position: relative;
            
            }

            .container-fluid .categories .platform_category.xbox_homecat{
                background-image:  linear-gradient(to bottom, #04dd15, #04440b),url("<?php echo base_url() ?>/assets/uploads/cat_card_bg.png");
                background-blend-mode: overlay;
            
            }

            .container-fluid .categories .platform_category.playstation_homecat{
                background-image:  linear-gradient(to bottom, #001fff, #08004e),url("<?php echo base_url() ?>/assets/uploads/cat_card_bg.png");;
                background-blend-mode: overlay;
            
            }

            .container-fluid .categories .platform_category img{
                /* position: absolute; */
                /* height: 100%; */
                /* width: auto; */
                max-width: 85%;
                max-height: 100%;
                /* right: 10px; */
                /* top: 50%; */
                /* transform: translateY(-50%); */
                transition: all .3s 0s ease-out;
            }  
            .container-fluid .categories .platform_category h3{
                /* position: absolute; */
                /* top: 15px; */
                /* left: 15px; */
                color: white;
            }

            .container-fluid .categories .platform_category ul.home_subcat_links{
                max-height:180px;
                /* background: white; */
                list-style: none;
                /* position: absolute; */
                /* top: 70px; */
                /* left: 25px; */
                padding-left: 10px;
            }

            .container-fluid .categories .platform_category ul.home_subcat_links li{
                line-height: 30px;
                font-size: 15px;
            }

            .container-fluid .categories .platform_category ul.home_subcat_links li a{
                color: rgb(211, 211, 211);
            }
            .product_box_image{
                height: 294px;
                width: 100%;
                position:relative;
            }
            /* Home horizzontal banner */
            .home_h_banner{
                /* width: 83%; */
                justify-content: center;
                margin: auto;
                padding: 45px 0 0;
            }

            .home_h_banner a,.home_h_banner img{
                width: 100%;
                /* width: auto; */
                max-width: 100%;
            }
            /* product elements */
            .product_box_image img {
                height: 100% !important;
                max-width: 100%;
                width: 100%;
            }

            /* two banners */
            button.view_detail a{
                height: 100%;
                width:100%;
                padding:0px;
                margin:0px;
                background:transparent;
                border: none;
                color: white;
            
            }
            .sb_cat_card{
                background: linear-gradient(to bottom,#0383fd,#9a64c3) ,url("<?php echo base_url() ?>/assets/uploads/cat_card_bg.png");
                background-size: cover; 
                background-blend-mode: overlay;
                /* max-height: 450px; */
                max-width: 330px;
                min-height: 400px;
                border-radius: 15px;
                align-content: flex-start;
            }

            .sb_cat_card a{
                color: inherit;
            }

            .sb_cat_card .sb_cat_img{
                height: 40%;
                transition: all 0.4s 0s ease;
                cursor: pointer;
            
            }
            .sb_cat_card .sb_cat_title{
                text-align: left;
                color:white
            }   

            .sb_cat_card .sb_cat_links ul{
                list-style: none;
            }

            .sb_cat_card .sb_cat_links ul{
                list-style: none;
                flex-wrap: wrap;
                text-align: left;
                color: rgb(219, 219, 219)
            }
            .sb_cat_card .sb_cat_links li{
                line-height: 20px;
                font-size: 16px;
            }

            .sb_cat_card img{
                /* max-height:100%; */
                max-width: 100%;
                max-height: 100%;
            }
            /* Home other categories */
            .mosaic_banners .ggg{
                overflow: hidden;
                border-radius: 10px;
                position: relative;
            }
            .ggg img{
                width: 100%;
                z-index: 8;
                transition: all .5s .1s ease;
            }

            .ggg .overlay{
                height: 100%;
                width: 100%;
                position: absolute;
                background-color: rgba(0, 0, 0, 0.24);
                z-index:10;
                pointer-events: none;
                display: none;
            }

            .ggg .ring{
                height: calc(100% - 20px);
                width: calc(100% - 20px);
                border: #5daff180 2px solid;
                margin: auto;
                top:50%;
                left: 50%;
                transform: translate(-50% , -50%);
                position: absolute;
                border-radius: 10px;
                pointer-events: none;
                z-index: 9;
            }

            .ggg h3{
                position: absolute;
                font-size:14px;
                font-weight: 500;
                bottom: 0px;
                left: 50%;
                color: white;
                z-index: 11;
                transform: translate(-50% , 55px);
                padding: 13px 5px;
                background-color: #22398d; 
                width: 100%;
                text-align: center;
                margin: 0px;
                transition: all .1s 0s ease-in;
            }
            /* Promotion sticker */
            .promotion_sticker_tag{
                clip-path: polygon(0 0 , 100% 0 , 100% 100%);
                background: linear-gradient(168deg , #c80000 11% , #ff5656 31%, rgb(101 0 0) 80%);
                color: white;
                box-shadow: 2px 2px 15px black;
                /* z-index: 10; */
                height: 100%;
                width: auto;
            }
            
            /* Get_N sticker */
            .get_sticker_tag{
                clip-path: polygon(0 0 , 100% 0 , 100% 50% , 50% 70% , 0 50%);
                background: linear-gradient(180deg , #75d51a 2% , #85cd13 23%, rgb(80 145 18) 53%);
                color: white;
                box-shadow: 2px 2px 15px black;
                /* z-index: 10; */
                height: 100%;
                width: auto;
                font-size: 13px
            }
            /* prize sticker */
            .prize_sticker_tag{
                clip-path: polygon(0 0 , 100% 0 , 100% 50% , 50% 70% , 0 50%);
                background: linear-gradient(180deg , #1ad4d5 2% , #13bacd 23%, rgb(18 110 145) 53%);
                color: white;
                box-shadow: 2px 2px 15px black;
                /* z-index: 10; */
                height: 100%;
                width: auto;
                font-size: 11px
            }

            .new_sticker_tag{
                /* clip-path: polygon(50% 0 , 100% 0 , 0% 100% , 0% 50%); */
                background: linear-gradient(to left , #004ac8 8% , #5677ff 50%, rgb(1 0 101) 90%);
                color: white;
                box-shadow: 2px 2px 15px black;
                height: 100%;
                width: 100%;
                position: relative;
            }

            .new_sticker_tag p{
                font-weight: bold;
                font-size: 17px;
                line-height: 15px;
                transform: translate(-50% , -50%);
                top: 50%;
                left: 50%;
                text-align: center;
                transform-origin: center;
                position: absolute;
            }

            .promotion_sticker{
                height: 100px;
                position: absolute;
                top: 0px;
                z-index: 5;
            }
            .promotion_sticker.left_sticker{
                left: 0;
                width: 70%;
                height: 40px;
                transform-origin: center;
                transform: rotateZ(-45deg) translate(-25%, -55%);
                /* display: none; */
            }
            .promotion_sticker.right_sticker{
                right: 0;
                width: auto;
                filter: drop-shadow(0px 3px 4px rgba(0, 0, 0, 0.644));
            }
            .promotion_sticker.get_right_sticker{
                right: 10px;
                max-width: 45px;
                filter: drop-shadow(0px 3px 4px rgba(0, 0, 0, 0.644));
            }
            /* Promotion sticker */

            /* online Stores Select  */
            .ws-online-locations .dropdown-item:hover{
                background: #021b32!important
            }
            /* online Stores Select  */

            /* Home Top Category Carousel */
            .ws-hcat-carousel-item{
                /* height:auto; */
                /* background-color:white; */
                overflow: hidden;
            }
            .ws-hcat-carousel-item img{
                transition: .2s 0s ease;
                position: relative;
            }
            .ws-hcat-carousel-item img:hover{
                transform: translateY(-5px);
            }
            /* Home Top Category Carousel */

            /* Shop By Genre Section */
            .ws-genre-item{
              background: linear-gradient(to top , #616b83d4 60% , #616b8300 50%);
              cursor: pointer;
            }
            .ws-genre-item img{
              max-width: 100px;
            }
            .ws-genre-item:hover img{
              transition: .2s 0s ease;
            }
            .ws-genre-item:hover img{
              transform: translateY(-20px);
            }
            /* Shop By Genre Section */
        /* Yahia custom css */

        /* responsive_css _desktop */
            /* Max-width 1200px */
            @media (min-width: 1200px) {
            
            /* .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1232px;
            } */
            .service_box img {
                max-height: 418px;
                object-fit: contain;
            }
            }
            /* Max-width 1150px */
        /* responsive_css _desktop */

        /* custom responsive desktop css */
            /* large screens */
            @media screen and (min-width:1240px) {
                .product_box_image {
                    max-height: 225px !important
                }

                .horizontal_product_box .product_box_image {
                    max-height: 145px !important
                }

            }
            @media screen and (min-width: 770px) {
             .home_h_banner .mobile_img {
                    display: none;
                }
            }
        /* custom responsive desktop css */

        /* custom responsive mobile css */
            @media screen and (max-width: 550px) {
                .container-fluid .categories .platform_category {
                    width: 100%;
                    height: 250px;
                }

                .pricing-card .card-text {
                    font-size: .85rem
                }
            }
        /* custom responsive mobile css */
        
    </style>    
    <?php endif; ?>

</head>


<body class="page-<?php echo @$uri1;?>">

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4FSM8K" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <div class="header_serach_parent">
        <div class="header_serach">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                    d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
            </svg>
        </div>
        <form class="search_box" action="<?php echo base_url();?>/product-list">
            <input name="keyword" required type="text" value="<?php echo @$_GET['keyword']?>">
            <button class="btn btn-primary"><?php echo lg_get_text("lg_85") ?></button>
        </form>
    </div>
    
    <!-- Website Overlay on loading -->
    <div class="ws-overlay"></div>
    <!-- Website Overlay on loading -->

    <!-- User cart content -->
    <div class="ws-user-cart col-10 col-md-3 bg-white hide">
        <div class="col-12 row m-0 px-0 py-2 ws-user-cart-close align-items-center justify-content-start">
            <i class="fa-solid fa-arrow-right"></i>
        </div>

        <div class="ws-user-cart-content col-12 row m-0 px-0 py-2 align-items-center justify-content-start" >
            <div class="row col-12 m-0 p-0 ws-cart-elements <?php text_from_right() ?>" <?php content_from_right() ?>>
                <!-- Cart content to be displayed  -->
            </div>
        </div>

        <div class="col-12 row m-0 mt-2 justify-content-around ws-cart-action" <?php content_from_right() ?>>
            <a href="<?php echo base_url() ?>/cart" class="col-5 d-flex justify-content-center border rounded bg-secondary">
                <div class="btn px-0 px-sm-0" style="padding-left: 0px!important;padding-right: 0px!important;">
                    <span><?php echo lg_get_text("lg_87") ?></span>
                </div>
            </a>
            <a href="<?php echo base_url() ?>/checkout" class="col-5 d-flex justify-content-center border rounded bg-dark">
                <div class="btn px-0 px-sm-0" style="padding-left: 0px!important;padding-right: 0px!important;">
                    <span><?php echo lg_get_text("lg_86") ?></span>
                </div>
            </a>
        </div>  
    </div>
    <!-- User cart content -->

    <header class="container-fluid header justify-content-center p-0" id="nav_bar" >
        <div class="row justify-content-center m-0 p-0">
            <div class="col-12 col-xl-11 col-md-12">
                <?php echo view("Common/Top_bar" , ["user_loggedin"=> $user_loggedin, "user_details"=> (isset($user_details)) ? $user_details : null , "settings" => $settings]) ?>
                <?php echo view("Common/Middle_header" , ["user_loggedin" => $user_loggedin , "cart_count" => $cart_count , "settings" => $settings]) ?>
                <?php 
                    if(true)
                    echo view("Common/Main_menu" , ["settings" => $settings]) 
                ?>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show errors-back" role="alert" style="position: absolute; top: 100%; z-index: 15; width: 100%; display: none">
            <strong>Alert:</strong> <span class="error-content"></span>
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> -->
        </div>
    </header>
    
    <!-- login modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md rounded">
            <div class="modal-content" style="background-color: #092E49;">
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
    <!-- login modal -->

    <!-- general modal -->
        <?php if(false): ?>
        <div class="modal fade" data-modal-autoshow="<?php if($session->getFlashdata("ns-sub-success")): echo "true"; else: echo "false"; endif; ?>" id="generalmodal" tabindex="-1" aria-labelledby="generalmodallabel" aria-hidden="<?php if($session->getFlashdata("ns-sub-success")): echo "false"; else: echo "true"; endif; ?>">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <?php if(!$session->getFlashdata("ns-sub-success")): ?>
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">Title</h2>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <?php endif; ?>

                    <div class="modal-body">
                        <div class="row m-0 justify-content-center" <?php if($session->getFlashdata("ns-sub-success")): ?> style="background: linear-gradient(145deg , #5a0111 5% , #98253a 55% , #5a0111 85%); color:white" <?php endif; ?>>
                        <?php if($session->getFlashdata("ns-sub-success")): ?>
                            <div class="col-12 p-0 row m-0" <?php content_from_right() ?>>
                                <div class="col-12 border p-3 rounded">
                                    <?php echo view("newsletter/Ns_subscribe_feedback" , ["status" => $session->getFlashdata("ns-sub-success") , "settings" => $settings]); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lg_get_text("lg_186") ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <!-- general modal -->

    <!-- AD PopUp window -->
    <?php
    if(sizeof($uri->getSegments()) == 0 && false):
        echo view("Common/Popup.php");
    endif;
    ?>
    <!-- AD PopUp window -->

    <?php
    if($uri1=="checkout"){
        if(@$user_id){
            $user_address = $userModel->get_user_addresses($user_id);
        }
    ?>
    <!--#########################################################-->
    <!--jagat Change Address MODAL start-->
    <div class="modal fade " id="changeAddressModla" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="model_eader " style="    z-index: 1;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="  bg-white">
                        <ul class="nav nav-tabs checkout_nav">
                            <li class="nav-item">
                                <a id="loginTab" class="nav-link active" data-toggle="tab" href="#savedAddress">Saved
                                    address lists </a>
                            </li>
                            <li class="nav-item">
                                <a id="signupTab" class="nav-link " data-toggle="tab" href="#CrateNewAddress">Create new
                                    address</a>
                            </li>
                        </ul>
                        <div class="tab-content p-4">
                            <div class="tab-pane active myaddress_card" id="savedAddress">
                                <div class="mt-3 headding text-center text-capitalize">
                                    <h6 class="font-weight-bold" id="LoginUsingEmial">-- Saved Address --</h6>
                                </div>
                                <div class="row">
                                    <?php
         if($user_address){
           foreach($user_address as $k=>$v ){
             ?>
                                    <div class="col-md-6 mar-10">
                                        <a
                                            href="<?php echo base_url();?>/page/selectAddress/<?php echo $v->address_id;?>">
                                            <div
                                                class="address_message myaddress_card jagat-address-list  <?php if( $v->status=='Active') echo 'active-addresss';?> ">

                                                <h5><?php echo $v->name;?>

                                                    <?php if( $v->status=="Active"){?>
                                                    <span class="text-white badge bg-primary  m-0">
                                                        <?php echo $v->status;?></span>
                                                    <?php }else {
                ?>

                                                    <span class="text-white badge bg-secondary  m-0">
                                                        <?php echo $v->status;?></span>
                                                    <?php
                }?>
                                                </h5>
                                                <span><?php echo $v->street;?> <?php echo $v->apartment_house;?>,
                                                    <?php echo $v->address;?> </span>

                                            </div>
                                        </a>
                                    </div>
                                    <?php
          }
        }else{
          ?>
                                    <h6>Address list is empty!</h6>
                                    <?php
        }
        ?>
                                </div>
                            </div>
                            <div class="tab-pane" id="CrateNewAddress">
                                <div class="mt-3 headding text-center text-capitalize">
                                    <h6 class="font-weight-bold">-- Create New Address --</h6>
                                </div>
                                <form method="post" action="<?php echo base_url();?>/page/saveAddress">
                                    <input class="form-control" name="address_id" type="hidden" required=""
                                        placeholder="Street" value="">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="checkout-fn">Name</label>
                                                <input class="form-control" name="name" required="" type="text"
                                                    placeholder="Name" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="checkout-fn">Street</label>
                                                <input class="form-control" name="street" required="" type="text"
                                                    placeholder="Street" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="checkout-fn">Apartment/House No.</label>
                                                <input class="form-control" name="apartment_house" required=""
                                                    type="text" placeholder="Apartment/House No." value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="checkout-fn">Address</label>
                                                <input class="form-control" name="address" required="" type="text"
                                                    placeholder="Address" value="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="checkout-fn">Status</label>
                                                <select name="status" required="" class="form-control">
                                                    <option value="">Select status</option>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <button type="submit" class="w-100 btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--jagat Change Address MODAL end-->
    <?php } ?>