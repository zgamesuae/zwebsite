<?php 
$session = session();
global $userModel,$productModel,$category_model,$brandModel,$reviewModel;
$userModel = model('App\Models\UserModel', false);
$productModel = model('App\Models\ProductModel');
$category_model = model('App\Models\Category');
$brandModel = model("App\Models\BrandModel");
$reviewModel = model("App\Models\ReviewModel");


$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
  $sql="select * from cart where user_id='$user_id'";
  $cartCount=$userModel->customQuery($sql);
}else{
    $sid=session_id(); 
    $sql="select * from cart where user_id='$sid'";
  $cartCount=$userModel->customQuery($sql);
}
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
$sql="select * from cms";
$cms=$userModel->customQuery($sql);
$sql1="";
global $uri1,$uri2,$uri3;


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
            "product"
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
$sql="select * from master_category where parent_id='0' AND status='Active' order by precedence asc limit 0,5";
$master_category=$userModel->customQuery($sql);
?>

<!DOCTYPE html>
<html>

<head>
<link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
<!-- Meta Pixel Code -->
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
        
        <link rel="canonical" href="<?php if(@$seo[0]){echo base_url().$_SERVER["REQUEST_URI"];} else {echo base_url();}?>">
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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/yahia_custom_css.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/reviews.css">


    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/responsive.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="p:domain_verify" content="a71ac49067cac8d86d6cde27b8dd70bc" />
 <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-221699796-1">
    </script>
    
    <script>
        window.dataLayer = window.dataLayer || [];
        
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
    
        gtag('config', 'UA-221699796-1');
        
        // gtag('config', 'AW-10869345900');
    
    </script>



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
    </style>
    <!-- Event snippet for Order Placed conversion page --> 
  
    
    <!-- GTAG events -->
    <?php 
    // var_dump($products);die();
        if($uri->getSegment(1)=="order-success" && ($products)):
         echo gtag_event_purchase($order , $products);     
         echo gtag_event_conversion($order);?>
    <?php endif; ?>

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
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    <div class="add_to_card_popup  show_indesktop">
        <div class="popup_design_close">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path
                    d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
            </svg>
        </div>
        <div class="card_popup_esign">
            <div class="products_list_gg">
                <div class="card_thumbnailk">
                    <img src="" id="cart-img">
                </div>
                <a href="#">
                    <h5 id="cart-heading"></h5>
                    <p id="cart-para"></p>
                </a>
            </div>
        </div>
        <div class="card_pop_foot">
            <a href="<?php echo base_url();?>/cart"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                        d="M7 8V6a5 5 0 1 1 10 0v2h3a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h3zm0 2H5v10h14V10h-2v2h-2v-2H9v2H7v-2zm2-2h6V6a3 3 0 0 0-6 0v2z" />
                </svg> view cart</a>
            <a class="btn-primary" href="<?php echo base_url();?>/checkout">checkout <svg
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                        fill="rgba(142,48,76,1)" />
                </svg></a>
        </div>
    </div>



    <header class="container-fluid header p-0" id="nav_bar">
        <div class="container-fluid d-flex-row j-c-center header_top px-0 py-1">
            <div class="row col-lg-10 col-md-12 col-sm-12 justify-content-between">
                <div class="col-md-auto col-sm-12 px-0">
                    <div class="row header_top_left a-a-center pt-1">
                      <div class="social_media col-auto">
                          <ul>
                              <li>
                                <a target="_blank" href="<?php echo @$settings[0]->facebook;?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                       <path fill="none" d="M0 0h24v24H0z" />
                                       <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z" />
                                    </svg>
                                </a></li>
                                <li>
                                <a target="_blank" href="<?php echo @$settings[0]->instagram;?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                       <path fill="none" d="M0 0h24v24H0z" />
                                       <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                                    </svg>
                                </a>
                              </li>
                              <li>
                                <a target="_blank" href="<?php echo @$settings[0]->tiktok;?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122. 18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
                                    </svg>
                                </a></li>
                                <li>
                                    <a target="_blank" href="<?php echo @$settings[0]->youtube;?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/>
                                        </svg>
                                    </a>
                                </li>
                              <!--<li><a target="_blank" href="tel:<?php echo @$settings[0]->whatsapp_no;?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308a.961.961 0 0 0-.371.1 1.293 1.293 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.729 2.729 0 0 0 6.9 9.62c.002.49.13.967.33 1.413.409.902 1.082 1.857 1.971 2.742.214.213.423.427.648.626a9.448 9.448 0 0 0 3.84 2.046l.569.087c.185.01.37-.004.556-.013a1.99 1.99 0 0 0 .833-.231c.166-.088.244-.132.383-.22 0 0 .043-.028.125-.09.135-.1.218-.171.33-.288.083-.086.155-.187.21-.302.078-.163.156-.474.188-.733.024-.198.017-.306.014-.373-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.401-.621a.498.498 0 0 0-.177-.041.482.482 0 0 0-.378.127v-.002c-.005 0-.072.057-.795.933a.35.35 0 0 1-.368.13 1.416 1.416 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.109l-.005-.002a6.01 6.01 0 0 1-1.57-1c-.126-.11-.243-.23-.363-.346a6.296 6.296 0 0 1-1.02-1.268l-.059-.095a.923.923 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41a4.38 4.38 0 0 0 .263-.373c.118-.19.155-.385.093-.536-.28-.684-.57-1.365-.868-2.041-.059-.134-.234-.23-.393-.249-.054-.006-.108-.012-.162-.016a3.385 3.385 0 0 0-.403.004z"/></svg></a></li>

                              -->
                          </ul>
                      </div>
                      <div class="customer-s-number d-flex col-auto" style="color:white;">
                        <div style="padding:1px">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="fill:white" width="20" height="20">
                            <path d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z"/>
                          </svg>
                        </div>
                        <p style="margin:3px 0 0 10px;">+971 568 016 786</p>
                      </div>
                      <div class="col-auto d-flex a-c-center our-stores">
                          <i class="fa-solid fa-location-dot"></i>
                          <a href="https://zamzamgames.com/page/ourstores" class="pl-2">Our stores</a>
                      </div>
                    </div>
                </div>
                <div class="col-md-auto col-sm-12 px-0">
                    <div class="header_top_right">
                        <?php if(@$user_id){?>
                        <div class="user_acount mr-3">
                            <div class="dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path
                                            d="M4 22a8 8 0 1 1 16 0h-2a6 6 0 1 0-12 0H4zm8-9c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                                    </svg>
                                    <span><?php echo $userDetails[0]->name;?></span>
                                    <span class="caret"></span>
                                </div>
                                <ul class="dropdown-menu border-0 p-3">
                                    <li class="pb-2"><a href="<?php echo base_url();?>/profile/">My Profile</a></li>
                                    <li class="pb-2"><a href="<?php echo base_url();?>/profile/changePassword">Change
                                            Password</a></li>
                                    <li class="pb-2"><a href="<?php echo base_url();?>/logout">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="login" data-toggle="modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M10 11V8l5 4-5 4v-3H1v-2h9zm-7.542 4h2.124A8.003 8.003 0 0 0 20 12 8 8 0 0 0 4.582 9H2.458C3.732 4.943 7.522 2 12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10c-4.478 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>login</span>
                        </div>
                        <div class="register" data-toggle="modal" data-target="#login-modal" data-form="register" onClick="get_form(this.getAttribute('data-form'))">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12.684 4.029a8 8 0 1 0 7.287 7.287 7.936 7.936 0 0 0-.603-2.44l1.5-1.502A9.933 9.933 0 0 1 22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2a9.982 9.982 0 0 1 4.626 1.132l-1.501 1.5a7.941 7.941 0 0 0-2.44-.603zM20.485 2.1L21.9 3.515l-9.192 9.192-1.412.003-.002-1.417L20.485 2.1z" />
                            </svg>
                            <span>register</span>
                        </div>
                        <?php } ?>

                    </div>
                    <!--  <div class="widhlist_header">
                        <ul>
                          <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg></a></li>
                          <li><a href="#"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"/></svg></a></li>
                        </ul>
                     </div> -->
                </div>
            </div>
        </div>

        <div class="container-fluid d-flex-row header_middle j-c-center pb-3 px-0">
            <div class="row col-sm-12 col-md-12 col-lg-10 a-a-center j-c-spacebetween py-2">
                <div class="col-md-3 d-flex-row j-c-start pl-0 a-a-center" id="logo_headre_s">
                    <div class="left_mobile_side_show desktop_hidden_mobile_show col-auto">
                        <div class="icon m-0 " id="menu_optn_mobile">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M3 4h18v2H3V4zm0 7h18v2H3v-2zm0 7h18v2H3v-2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="header_logo row j-c-center col-auto px-0">
                        <a href="<?php echo base_url();?>">
                            <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>" class="col-md-12">
                        </a>
                    </div>
                </div>
                <div class=" col-sm-12 col-md-5 p-md-0" id="search_column_main">
                    <div class="search_form">
                        <div class="container p-0" style="z-index:10; width: 100%; max-height:690px; min-width:100%; overflow-y: scroll; position: absolute; top:100%; background-color:gray">
                            <div class="result row col-12 j-c-center m-0 px-0">
                            </div>
                        </div>

                        <form class="search_form_main m-0" action="<?php echo base_url();?>/product-list">
                            <input type="text" id="search_bar" class="form_control" placeholder="I'm looking for" name="keyword"
                                value="<?php echo @$_GET['keyword']?>" required autocomplete="off" >
                            <button type="submit" class="submit_btn"><svg xmlns="https://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path
                                        d="M18.031 16.617l4.283 4.282-1.415 1.415-4.282-4.283A8.96 8.96 0 0 1 11 20c-4.968 0-9-4.032-9-9s4.032-9 9-9 9 4.032 9 9a8.96 8.96 0 0 1-1.969 5.617zm-2.006-.742A6.977 6.977 0 0 0 18 11c0-3.868-3.133-7-7-7-3.868 0-7 3.132-7 7 0 3.867 3.132 7 7 7a6.977 6.977 0 0 0 4.875-1.975l.15-.15z">
                                    </path>
                                </svg></button>
                        </form>
                    </div>
                </div>
                
                <div class="col-3" id="acount_menu_open_dic">

                    <div class="account_wishlist d-flex">

                        <?php if(@$user_id){?>
                        <a href="<?php echo base_url();?>/profile/wishlist">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0H24V24H0z"></path>
                                <path
                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                </path>
                            </svg>
                        </a>
                        <?php } else { ?>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#jagat-login-modal">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0H24V24H0z"></path>
                                <path
                                    d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z">
                                </path>
                            </svg>
                        </a>
                        <?php } ?>
                        <?php if(@$user_id){?>
                        <a class="cart color-white" href="<?php echo base_url();?>/cart">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z">
                                </path>
                            </svg>
                            <span>
                                <div class="counter_cart" id="counter_cart">
                                    <?php if($cartCount) echo count($cartCount);else echo 0;?></div>
                            </span>
                        </a>
                        <?php } else { ?>
                        <a class="cart color-white" href="<?php echo base_url();?>/cart">
                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path
                                    d="M4 16V4H2V2h3a1 1 0 0 1 1 1v12h12.438l2-8H8V5h13.72a1 1 0 0 1 .97 1.243l-2.5 10a1 1 0 0 1-.97.757H5a1 1 0 0 1-1-1zm2 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm12 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z">
                                </path>
                            </svg>
                            <span>
                                <div class="counter_cart" id="counter_cart">
                                    <?php if($cartCount) echo count($cartCount);else echo 0;?></div>
                            </span>
                        </a>
                        <?php } ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="container-fluid menu_bottom_div ">
            <div class="row justify-content-center">
                <div class="col-md-12 position_unset" id="menu_parent_coumn">
                    <div class="navigation_header">
                        <div class="fix_header_logo" style="display:none">
                            <a class="header_logo" href="<?php echo base_url();?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
                            </a>
                        </div>
                        <div class="navigation_mene" style="display: none;">
                            <div class="menui_icon_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z" />
                                    <path
                                        d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                                </svg>
                            </div>
                        </div>
                        <ul class="main_menu">
                            <?php  

                                $cat_pages=array("playstation-1634548926"=>"playstation","xbox-1634548911"=>"xbox","nintendo-switch-1634548899"=>"nintendo_switch");
                                $links = $category_model->categories_urls();
                                // var_dump($links);die();
                                if($master_category){
                                  foreach ($master_category as $key => $value) {
                                     // test wether to show the category in menu or no
                                    if($value->show_in_menu == "Yes"):



                                    if($value->show_category_page=="Yes"){
                                        if($cat_pages[$value->category_id])
                                        // $lnk=base_url().'/'.$links[$value->category_id];
                                        $lnk = (array_key_exists($value->category_id , $links)) ? base_url().'/'.$links[$value->category_id] : base_url().'/cat/'.$cat_pages[$value->category_id];
                                        else
                                        $lnk=base_url().'/category/'.$value->category_id;
                                    }
                                    else{
                                    //   $lnk=base_url().'/product-list?category='.$value->category_id;
                                        $lnk=(array_key_exists($value->category_id , $links)) ? base_url().'/'.$links[$value->category_id] : base_url()."/product-list?category=".$value->category_id;
                                    
                                    }

                                    $sql="select * from master_category where parent_id='$value->category_id' AND status='Active' order by precedence asc";
                                    $cat2=$userModel->customQuery($sql);

                                    if ($cat2) {
                            ?>
                            <li>
                                <div class="dropdown_m_menu">
                                    <a class="drop_down_enable" href="<?php echo $lnk;?>"><?php echo $value->category_name;?></a>
                                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z" />
                                    </svg>
                                </div>
                                <ul class="drop_drow_menu">
                                    <div class="drp_menu">
                                        <ul class="open_menu_mobile_s">
                                            <?php 
                                                if($cat2){
                                                 foreach($cat2 as $k2=>$v2){
                                                  $sql="select * from master_category where parent_id='$v2->category_id' AND status='Active' order by precedence asc";
                                                  $cat3=$userModel->customQuery($sql);
                                                  if ($cat3) {
                                                    ?>
                                            <li>
                                                <div class="dropdown_m_menu remove_after_arrow">
                                                    <a href="<?php echo(base_url()."/".$links[$v2->category_id]); ?>" class="drop_down_enable"><span><?php echo  $v2->category_name;?> </span>

                                                        <span class="dropdown_icon">
                                                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                    <path fill="none" d="M0 0h24v24H0z" />
                                                                    <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z" />
                                                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z" />
                                                    </svg>
                                                </div>
                                                <ul class="open_menu_mobile_s">
                                                    <?php 
                                                        if($cat3){
                                                          foreach($cat3 as $k3=>$v3){
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo(base_url()."/".$links[$v3->category_id]); ?>"><span><?php echo  $v3->category_name;?> </span>
                                                        </a>
                                                    </li>
                                                    <?php 
                                                       }
                                                     }
                                                    ?>
                                                </ul>
                                                
                                            </li>
                                            <?php
                                                }else {
                                             ?>
                                            <li>
                                                <a href="<?php echo(base_url()."/".$links[$v2->category_id]);?>"><span><?php echo  $v2->category_name;?> </span> </a>
                                            </li>
                                            <?php
                                                    }
                                                  }
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </ul>
                            </li>
                            <?php
                                }
                                else{
                            ?>
                            <li><a href="<?php echo $lnk;?>"><?php echo $value->category_name;?></a></li>
                            <?php 
                                }
                                // end of show cat in the menu test
                                endif;
                                }
                                }
                            ?>

                            <!-- Menu more element -->
                            <li>
                                <div class="dropdown_m_menu">
                                    <span style="color:white" class="drop_down_enable" href="">More</span>
                                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z" />
                                    </svg>
                                </div>
                                <ul class="drop_drow_menu">
                                    <div class="drp_menu">
                                        <ul class="open_menu_mobile_s">
                                        <?php
                                            $sql="select * from master_category where parent_id='0' AND status='Active' order by precedence asc LIMIT 5,20";
                                            $master_category=$userModel->customQuery($sql);

                                            if($master_category){
                                                foreach ($master_category as $key => $value) {
                                                   // test wether to show the category in menu or no
                                                  if($value->show_in_menu == "Yes"):
  
                                                  if($value->show_category_page=="Yes"){
                                                      if($cat_pages[$value->category_id])
                                                      // $lnk=base_url().'/'.$links[$value->category_id];
                                                      $lnk = (array_key_exists($value->category_id , $links)) ? base_url().'/'.$links[$value->category_id] : base_url().'/cat/'.$cat_pages[$value->category_id];
                                                      else
                                                      $lnk=base_url().'/category/'.$value->category_id;
                                                  }
                                                  else{
                                                  //   $lnk=base_url().'/product-list?category='.$value->category_id;
                                                      $lnk=(array_key_exists($value->category_id , $links)) ? base_url().'/'.$links[$value->category_id] : base_url()."/product-list?category=".$value->category_id;
                                                  }
  
                                                  $sql="select * from master_category where parent_id='$value->category_id' AND status='Active' order by precedence asc";
                                                  $cat2=$userModel->customQuery($sql);
                                                  if($cat2){
                                
                                        ?>
                                            <li>
                                                <div class="dropdown_m_menu remove_after_arrow">
                                                    <a href="<?php echo($lnk); ?>" class="drop_down_enable"><span><?php echo  $value->category_name;?> </span>

                                                        <span class="dropdown_icon">
                                                            <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                    <path fill="none" d="M0 0h24v24H0z" />
                                                                    <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                    <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                        <path fill="none" d="M0 0h24v24H0z" />
                                                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z" />
                                                    </svg>
                                                </div>

                                                <ul class="open_menu_mobile_s">

                                                <?php
                                                    foreach($cat2 as $k2 => $v2){
                                                    $sql="select * from master_category where parent_id='$v2->category_id' AND status='Active' order by precedence asc";
                                                    $cat3=$userModel->customQuery($sql);
                                                        if($cat3){
                                                ?>
                                                    <li>
                                                        <div class="dropdown_m_menu remove_after_arrow">
                                                            <a href="<?php echo(base_url()."/".$links[$v2->category_id]); ?>" class="drop_down_enable"><span><?php echo  $v2->category_name;?> </span>
                                                                <span class="dropdown_icon">
                                                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                            <path fill="none" d="M0 0h24v24H0z" />
                                                                            <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                                                    </svg>
                                                                </span>
                                                            </a>
                                                            <svg style="display: none;" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                                                <path fill="none" d="M0 0h24v24H0z" />
                                                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z" />
                                                            </svg>
                                                        </div>

                                                        <ul class="open_menu_mobile_s">
                                                            <?php
                                                                foreach ($cat3 as $v3) {
                                                            ?>
                                                                <li><a href="<?php echo base_url()."/".$links[$v3->category_id];?>"><?php echo $v3->category_name;?></a></li>
                                                            <?php
                                                                }
                                                            ?>

                                                        </ul>
                                                    </li>   
                                                <?php
                                                        }
                                                        else{
                                                ?>
                                                    <li><a href="<?php echo base_url()."/".$links[$v2->category_id];?>"><?php echo $v2->category_name;?></a></li>

                                                <?php
                                                        }
                                                    }
                                                ?>
                                                </ul>


                                            </li>

                                        <?php
                                            }
                                            else{
                                        ?>
                                            <li><a href="<?php echo $lnk;?>"><?php echo $value->category_name;?></a></li>
                                        <?php
                                            }
                                            endif;
                                            }
                                        }
                                        ?>

                                        </ul>
                                    </div>
                                </ul>


                            </li>
                            <!-- end Menu more element -->


                            <?php if($productModel->offers_exist()): ?>
                            <li style="font-weight:bold; background-color:#4a915e; box-shadow: inset black 1px 1px 3px"><a href="<?php echo base_url() ?>/product-list/offers">Offers</a></li>
                            <?php endif; ?>

                            <?php if($productModel->preorders_exist()): ?>
                            <li style="font-weight:bold; background-color:#6e4a91; box-shadow: inset black 1px 1px 3px"><a href="<?php echo base_url() ?>/product-list/pre-orders">Pre-orders</a></li>
                            <?php endif; ?>

                        </ul>
                    </div>
                    <div class="login_mobile_button" style="display: none">
                        <a href="javascript:void();" data-toggle="modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">login</a>
                        <a href="javascript:void();" data-toggle="modal" data-target="#login-modal" data-form="register" onClick="get_form(this.getAttribute('data-form'))">register</a>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <!--<div class="header_blanck_spoaCE"></div>-->
    <!--
<div class="container-fluid">
    <div class="owl-carousel header_bottom_slider">
      <div class="item">
        <a href="#">
            <img src="https://cdn.toysrusmena.com/storefront/tru/usp-shipping.svg">
            <span>FREE shipping for orders 100 AED and over</span>
        </a>
      </div>
      <div class="item">
          <a href="#">
                <img src="https://cdn.toysrusmena.com/storefront/tru/usp-offer.svg" >
                <span>10% when you create an account</span>
            </a>
      </div>
      <div class="item">
        <a href="#">
            <img src="https://cdn.toysrusmena.com/storefront/tru/usp-return.svg" >
            <span>FREE 30-day returns</span>
        </a>
      </div>
    </div>
</div>
-->

   

 <!-- Yahia login modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md rounded">
            <div class="modal-content" style="background-color: #373a47;">
                <div class="model_eader " style="z-index: 1; top: 10px; right: 10px; background: none">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">×</span></button>
                </div>
                <div class="modal-body" style="color: white">

                    <!-- Conent start -->

                    <!-- Content end -->

                </div>
            </div>
        </div>
    </div>







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