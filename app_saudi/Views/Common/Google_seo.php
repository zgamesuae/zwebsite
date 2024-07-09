<?php


// GET SEO RECORDS (URI)
function pageseo($uri){
    $i=1;
    $uri_length = sizeof($uri->getSegments());
    
    $sql="select * from seo where ";
    if($uri_length > 0){
    
        foreach($uri->getSegments() as $key=>$segment){

            $sql.= "segment_".$i." ='".$uri->getSegment($i)."'";

            if($i < sizeof($uri->getSegments()))
            $sql .= " AND ";
            $i++;
        }

        if($i <= 3)
        $sql .= " AND (segment_".$i." IS NULL  OR segment_".$i."='')";
        
        // echo $sql;
        $seo = $GLOBALS["userModel"]->customQuery($sql);
        // var_dump($seo);die();
        if($seo){
            return $seo;
        }
    }

    else{
        $sql .= "(segment_1 is NULL or segment_1='') AND (segment_2 is NULL or segment_2='') AND (segment_3 is NULL or segment_3='')"; 
        $seo = $GLOBALS["userModel"]->customQuery($sql);
        // var_dump($seo);die();
        if($seo){
            return $seo;
        }
    }

    return false; 

}

// CREATE GOOGLE BREADCRUMP (URI)
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
            // "product-list",
            "category",
            "product",
            "blogs"
        );

        if(!in_array($uri->getSegment(1) , $tab)){
            $link="";
            switch ($uri->getSegment(1)) {
                case 'product-list':
                    # code...
                    foreach($uri->getSegments() as $key=>$segment){

                        $link .= "/".$segment;
                        $listitem["position"] = $i;
                        $listitem["name"] = ($i == 1) ? "Product list" :  $GLOBALS["brandModel"]->get_brand_from_slug($segment)->title;
                        $listitem["item"] = base_url().$link;
        
                        array_push($breadcrumb["itemListElement"] , $listitem);
            
                        // if($i < sizeof($uri->getSegments()))
                        $i++;
                    }

                    break;
                
                default:
                    # code...

                    foreach($uri->getSegments() as $key=>$segment){

                        $link .= "/".$segment;
                        $listitem["position"] = $i;
                        $listitem["name"] = $GLOBALS["category_model"]->get_cat_from_slug($segment)->category_name;
                        $listitem["item"] = base_url().$link;
        
                        array_push($breadcrumb["itemListElement"] , $listitem);
            
                        // if($i < sizeof($uri->getSegments()))
                        $i++;
                    }
                    
                    break;
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
                
                case 'blogs':
                    # code...
                    foreach($uri->getSegments() as $key=>$segment){

                        $link .= "/".$segment;
                        $listitem["position"] = $i;
                        $blog = (!$GLOBALS["blogModel"]->get_blog(null,$segment)) ? $GLOBALS["blogModel"]->get_blog($segment,"") : $GLOBALS["blogModel"]->get_blog(null,$segment);
                        $listitem["name"] = ($i == 1) ? "Blog" : $blog[0]->title;
                        $listitem["item"] = ($i == 1) ? base_url()."/blogs" : base_url().'/blogs/'.$segment;
        
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

// GTAG PURCHASE EVENT (order obj , products list )
function gtag_event_purchase($order , $products){
    
    $purchase = array(
      "transaction_id" => $order[0]->order_id,
      "affiliation" => "Google online store",
      "value" => $order[0]->total,
      "currency" => CURRENCY,
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

// GTAG CONVERSION EVENT (order object)
function gtag_event_conversion($order){
  $conversion =array(
    "send_to" => "AW-10869345900/ejQICKfFuMcDEOyc9L4o",
    "value" => $order[0]->total, 
    "currency" => CURRENCY, 
    "transaction_id" => $order[0]->order_id, 

  );

  return "<script> gtag('event', 'conversion', ".json_encode($conversion).");gtag('config', 'AW-10869345900');</script>";
}

function productseo($prod , $product_screenshot , $product_image){
    // var_dump($product_image);die();
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

    $product_page_title = ($prod->page_title !== "" && !is_null($prod->page_title)) ? $prod->page_title : $prod->name;
    $product_page_desc = ($prod->page_description !== "" && !is_null($prod->page_description)) ? strip_tags($prod->page_description) : strip_tags($prod->description) ;
    $product_page_keywords = ($prod->page_keywords !== "" && !is_null($prod->page_keywords)) ? $prod->page_keywords : $prod->name ;
    $products_page_image = ($product_image && $product_image !== "") ? $product_image : "";
    $product_seo = '

        <title>'.$product_page_title.'</title>
        <link rel="canonical" href="'.$GLOBALS["productModel"]->getproduct_url($prod->product_id).'">
        <meta name="description" content="'.$product_page_desc.'">
        <meta name="keywords" content="'.$product_page_keywords.'">
        <meta property="og:description" content="'.$product_page_desc.'">
        <meta property="og:image" content="'.$products_page_image.'">
        <meta property="og:url" content="'.base_url().$_SERVER["REQUEST_URI"].'">
        <meta name="twitter:card" content="'.$product_page_title.'">
    ';
    // <meta property="og:title" content="'.$product_page_title.'">

    // offer
    if($GLOBALS["productModel"]->get_discounted_percentage($prod->product_id) > 0){
        $offer = array(
            "@type" => "Offer",
            "url" => $GLOBALS["productModel"]->getproduct_url($prod->product_id),
            "priceCurrency" => CURRENCY,
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
    $images = array();
    if(!is_null($product_screenshot) && trim($product_screenshot) !== ""){
        foreach(explode("," , $product_screenshot) as $image){
            array_push($images , $image);
        }
    }

    if(!is_null($product_image) && trim($product_image) !== ""){
        // foreach(explode("," , $product_image) as $image){
            array_push($images , $product_image);
        // }
    }
    // Images


    $product["image"] = $images;

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
    echo $product_seo;

}





?>