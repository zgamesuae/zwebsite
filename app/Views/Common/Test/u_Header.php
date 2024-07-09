<?php 
$uri = service('uri'); 
$session = session();
global $userModel,$productModel,$category_model,$brandModel,$reviewModel,$blogModel;
global $uri1,$uri2,$uri3;
if(is_null(get_cookie("language")))
set_cookie("language" , "EN" , 3600);

$userModel = model('App\Models\UserModel', false);
$productModel = model('App\Models\ProductModel');
$category_model = model('App\Models\Category');
$brandModel = model("App\Models\BrandModel");
$reviewModel = model("App\Models\ReviewModel");
$blogModel = model("App\Models\BlogModel");


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

function pageseo($uri){
    $i=1;

    if(sizeof($uri->getSegments()) > 0){
        $sql="select * from seo where ";

        foreach($uri->getSegments() as $key=>$segment){

            $sql.= "segment_".$i." ='".$uri->getSegment($i)."'";

            if($i < sizeof($uri->getSegments()))
            $sql .= " AND ";
            $i++;
        }

        $seo = $GLOBALS["userModel"]->customQuery($sql);
        if($seo){
            return $seo;
        }
    }

    return false; 

}

function breadcrumb($uri){
    $i=1;

    $listitem = array(
        "@type"=> "ListItem" ,
        "position"=> "" ,
        "name"=> "" ,
        "item"=> "" ,
    );

    $breadcrumb = array(
        "@context" => "https://schema.org",
        "@type" => "BreadcrumbList" ,
        "itemListElement" => array(),
    ); 

    if(sizeof($uri->getSegments()) > 0){
        $tab = array(
            "product-list",
            "category",
            "product",
            "blog"
        );

        if(!in_array($uri->getSegment(1) , $tab)){
            $link="";
            foreach($uri->getSegments() as $key=>$segment){

                $link .= "/".$segment;
                $listitem["position"] = $i;
                $listitem["name"] = $GLOBALS["category_model"]->get_cat_from_slug($segment)->category_name;
                $listitem["item"] = base_url().$link;

                array_push($breadcrumb["itemListElement"] , $listitem);
    
                // if($i < sizeof($uri->getSegments()))
                $i++;
            }
            
        }
        
        else{
            switch ($uri->getSegment(1)) {
                case 'product':
                    # code...
                    foreach($uri->getSegments() as $key=>$segment){

                        $link .= "/".$segment;
                        $listitem["position"] = $i;
                        $listitem["name"] = ($i == 1) ? "Product list" : $GLOBALS["productModel"]->get_product_name_from_slug($segment);
                        $listitem["item"] = ($i == 1) ? base_url()."/product-list" : base_url().'/'.$segment;
        
                        array_push($breadcrumb["itemListElement"] , $listitem);
            
                        // if($i < sizeof($uri->getSegments()))
                        $i++;
                    }
                break;
                
                case 'blog':
                    # code...
                    foreach($uri->getSegments() as $key=>$segment){

                        $link .= "/".$segment;
                        $listitem["position"] = $i;
                        $blog = (!$GLOBALS["blogModel"]->get_blog(null,$segment)) ? $GLOBALS["blogModel"]->get_blog($segment,"") : $GLOBALS["blogModel"]->get_blog(null,$segment);
                        $listitem["name"] = ($i == 1) ? "Blog" : $blog[0]->title;
                        $listitem["item"] = ($i == 1) ? base_url()."/blog" : base_url().'/'.$segment;
        
                        array_push($breadcrumb["itemListElement"] , $listitem);
            
                        // if($i < sizeof($uri->getSegments()))
                        $i++;
                    }
                break;
                
                default:
                    # code...
                break;
            }
        }

            echo "<script type='application/ld+json'>".json_encode($breadcrumb)."</script>";
    }


}

function gtag_event_purchase($order , $products){
    
    $purchase = array(
      "transaction_id" => $order[0]->order_id,
      "affiliation" => "Google online store",
      "value" => $order[0]->total,
      "currency" => "AED",
      "tax" => 0,
      "shipping" => $order[0]->charges,
      "items" => array(),
    );

    $i=1;

    foreach($products as $item){
      $category = explode("," , $item->category);

      array_push($purchase["items"] , array(
        "id" => $item->product_id,
        "name" => $item->product_name,
        "list_name" => "Search Results",
        "brand" => $GLOBALS["brandModel"]->_getbrandname($item->brand),
        "category" => $GLOBALS["category_model"]->_getcatnames($category),
        // "variant" => "Black",
        "list_position" => $i,
        "quantity" => $item->quantity,
        "price" => $item->product_price
      ));


      $purchase["tax"] += $GLOBALS["productModel"]->calculate_vat($item->product_price , $item->quantity);
      $i++;
    }

    return "<script>gtag('event', 'purchase', ".json_encode($purchase).");</script>";
}

function gtag_event_conversion($order){
  $conversion =array(
    "send_to" => "AW-10869345900/ejQICKfFuMcDEOyc9L4o",
    "value" => $order[0]->total, 
    "currency" => "AED", 
    "transaction_id" => $order[0]->order_id, 

  );

  return "<script> gtag('event', 'conversion', ".json_encode($conversion).");gtag('config', 'AW-10869345900');</script>";
}

function productseo($prod , $product_screenshot , $product_image){
    $product = array(
        "@context" => "https://schema.org/",
        "@type" => "Product",
        "name" => @$prod->name,
        "description" => strip_tags($prod->description),
        "sku" => $prod->sku,
        "gtin" => $prod->sku,
        "productID" => $prod->product_id,
        "url" => $GLOBALS["productModel"]->getproduct_url($prod->product_id),
        
    );


    // offer
    if($GLOBALS["productModel"]->get_discounted_percentage($prod->product_id) > 0){
        $offer = array(
            "@type" => "Offer",
            "url" => $GLOBALS["productModel"]->getproduct_url($prod->product_id),
            "priceCurrency" => "AED",
            "price" => $GLOBALS["productModel"]->_discounted_price($prod->product_id),
            "itemCondition" => "https://schema.org/NewCondition",
            "availability" => ($prod->available_stock > 0) ? "https://schema.org/InStock" :  "https://schema.org/SoldOut"
        );

        if($offerdate = $GLOBALS["productModel"]->get_offer_date($prod->product_id)){
            if($GLOBALS["productModel"]->has_daterange_discount($offerdate["start"],$offerdate["end"])){ 
                $enddate = (new \DateTime($offerdate["end"],new \DateTimeZone("Asia/Dubai")))->format("Y-m-d"); 
                $offer["priceValidUntil"] = $enddate;
            }

        }

        $product["offers"] = $offer;

    }

    // Brand
    if($GLOBALS["productModel"]->get_brand_name($prod->brand)){
        $product["brand"] = array(
            "@type" => "Brand",
            "name" => $GLOBALS["productModel"]->get_brand_name($prod->brand)
        );
    }

    // Images
    if(!is_null($product_screenshot) || !is_null($product_image)){
        $images = array();
        if(!is_null($product_screenshot)){
            foreach($product_screenshot as $image){
                array_push($images , base_url()."/assets/uploads/".$image->image);
            }
        }

        if(!is_null($product_image)){
            foreach($product_image as $image){
                array_push($images , base_url()."/assets/uploads/".$image->image);
            }
        }

        $product["image"] = $images;
    }

    // Reviews
    $reviews = array();
    $product_reviews = $GLOBALS["reviewModel"]->get_product_reviews($prod->product_id);
    
    if($product_reviews && sizeof($product_reviews) > 0 && true){
        foreach($product_reviews as $review){
            $r = array(
                "@type"=> "Review",
                "reviewRating"=> array(
                    "@type"=> "Rating",
                    "ratingValue"=> $review->rating,
                    "bestRating"=> "5"
                ),
                "author" => array(
                    "@type"=> "Person",
                    "name"=> $review->user_name
                )
            );

            array_push($reviews , $r);
        }

        // array_push($product , $reviews);
        $product["review"] = $r;

    }
    // var_dump($reviews);


    // agregateRating
    $ratevalue = $GLOBALS["reviewModel"]->get_product_rating($prod->product_id);

    $product["aggregateRating"] = array(
      "@type"=> "AggregateRating",
      "ratingValue"=> (int)$ratevalue,
      "reviewCount"=> (int)$GLOBALS["reviewModel"]->get_total_nbr_rating($prod->product_id)
    );

    echo "<script type='application/ld+json'>".json_encode($product)."</script>";


}







// var_dump(json_encode(breadcrumb($uri)));
$seo = pageseo($uri)

?>
<?php
$sql="select * from master_category where parent_id='0' AND status='Active' order by precedence asc limit 6";
$master_category=$userModel->customQuery($sql);
?>

<!DOCTYPE html>
<html>

<head>

    <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">

    <!-- Meta Pixel Code -->
    <?php if(true): ?>
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '560177771810180');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=560177771810180&ev=PageView&noscript=1"
    /></noscript>
    <?php endif; ?>
    <!-- End Meta Pixel Code -->


    <?php
    // If it is product pages
    if($uri->getSegment(1)=="product"){
        // $sql="select * from products where product_id='$uri2';";
        $prod=$productModel->get_product_id_from_slug($uri->getSegment(2) , true); 
        $sql="select image from product_screenshot where product='".$prod->product_id."' and status='Active' ";
        $product_screenshot=$userModel->customQuery($sql);
        
        $sql="select image from product_image where product='".$prod->product_id."' and status='Active' ";
        $product_image=$userModel->customQuery($sql);

        // var_dump($prod);die();
    ?>

     <title><?php  if(@$prod){ echo "Buy ".@$prod->name;}else{ echo ucwords($settings[0]->business_name);}?></title>
     <link rel="canonical" href="<?php echo $GLOBALS["productModel"]->getproduct_url($prod->product_id)?>">


     <!-- YAHIA SEO -->
     <?php productseo($prod , $product_screenshot , $product_image) ?>
     <!-- END YAHIA SEO -->


    <?php breadcrumb($uri); ?>
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
        <meta property="og:title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
        <meta property="og:description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_description);}?>">
        <meta property="og:image" content="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
        <meta property="og:url" content="<?php if(@$seo[0]){echo base_url().$_SERVER["REQUEST_URI"];} else {echo base_url();}?>">
        <meta name="twitter:card" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
        <!--  Non-Essential, But Recommended -->
        <meta property="og:site_name" content="<?php  echo ucwords($settings[0]->business_name);?>">
        

      
        <meta name="title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
        <meta name="robots" content="index,follow">
        
        <?php breadcrumb($uri); ?>

        <?php
    }
    ?>
    
    <!--<meta name="facebook-domain-verification" content="qd7k6t5w0jkfkjr06anbcz2qye8zxk" />-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/yahia_custom_css.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/reviews.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/menu/index.css">


    <!-- Bootstrat new version css -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <!-- Bootstrat new version css -->
    
    <!-- Spin wheel css -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/wheel/spin.scss">
    <!-- Spin wheel css -->

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/responsive.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="p:domain_verify" content="a71ac49067cac8d86d6cde27b8dd70bc" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-221699796-1">
    </script>

    <!-- Bootstrat new version script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrat new version script -->

    <?php if(true): ?>
    <script>
        window.dataLayer = window.dataLayer || [];
        
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
    
        gtag('config', 'UA-221699796-1');
        
        // gtag('config', 'AW-10869345900');
    
    </script>
    <?php endif; ?>



    <meta name="p:domain_verify" content="a71ac49067cac8d86d6cde27b8dd70bc" />
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
  
    <!-- Event snippet for Order Placed conversion page --> 
    <!-- GTAG events -->
    <?php 
        if($uri->getSegment(1)=="order-success" && ($products)):
        echo gtag_event_purchase($order , $products);     
        echo gtag_event_conversion($order);?>
    <?php endif; ?>
    <!-- GTAG events -->
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/6362536adaff0e1306d54c2d/1ggs1bmkt';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
    <!--End of Tawk.to Script-->

</head>


<body class="page-<?php echo @$uri1;?>">

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
                <div class="btn px-0 px-sm-0">
                    <span><?php echo lg_get_text("lg_87") ?></span>
                </div>
            </a>
            <a href="<?php echo base_url() ?>/checkout" class="col-5 d-flex justify-content-center border rounded bg-dark">
                <div class="btn px-0 px-sm-0">
                    <span><?php echo lg_get_text("lg_86") ?></span>
                </div>
            </a>
        </div>  
    </div>
    <!-- User cart content -->

    <header class="container-fluid header justify-content-center p-0" id="nav_bar" >
        <div class="row justify-content-center m-0 p-0">
            <div class="col-lg-11 col-sm-12 col-md-12">
                <?php echo view("Common/Top_bar" , ["user_loggedin"=> $user_loggedin, "user_details"=> (isset($user_details)) ? $user_details : null , "settings" => $settings]) ?>
                <?php echo view("Common/Middle_header" , ["user_loggedin" => $user_loggedin , "cart_count" => $cart_count , "settings" => $settings]) ?>
                <?php echo view("Common/Main_menu" , ["settings" => $settings]) ?>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show errors-back" role="alert" style="position: absolute; top: 100%; z-index: 15; width: 100%; display: none">
            <strong>Alert:</strong> <span class="error-content"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </header>
    
    <!-- login modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md rounded">
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
    <!-- login modal -->

    <?php
        if($uri1=="checkout"){
         
        if(@$user_id){
          $sql="select * from user_address where user_id='$user_id' order by created_at desc";
          $user_address=$userModel->customQuery($sql);
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