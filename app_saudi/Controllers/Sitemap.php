<?php
namespace App\Controllers;



class Sitemap extends BaseController{

    protected $userModel;
    protected $productModel;
    protected $categoryModel;
    protected $xmlparser;
    protected $attributeModel;
    
    public function __construct(){
        // parent::__construct();
        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");
        $this->categoryModel = model("App\Models\Category");
        $this->brandModel = model("App\Models\BrandModel");
        $this->attributeModel = model("App\Models\AttributeModel");
    }

    public function getlastsitemap(){
        $filepath = ROOTPATH."/sa_sitemap/sitemap.xml";
        // $file = fopen( $filepath, "r");
        // $content .=  fread($file , filesize($filepath));
        // $content .="XML";

        $xml = simplexml_load_file($filepath );
        // $xml->url[0]->lastmod = "sdfsdfsdf";
        var_dump($xml->children()->children());
        // var_dump($content);

        // fclose($file);
    }

    public function constructsitemap(){
        // var_dump($this->categoryModel->categories_urls() , $this->productModel->product_urls());
        $file = ROOTPATH."sa_sitemap/sitemap.xml";
        $products = $this->productModel->product_urls();
        $categories = $this->categoryModel->categories_urls();
        $brands = $this->brandModel->brand_urls();
        $blogs = $this->blogModel->get_blogs_url();
        // var_dump($blogs);die();
        $xmlstart = '
        <?xml version="1.0" encoding="UTF-8"?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
        $xmlend = "</urlset>";
        $xml="";

      
        // if(file_exists($file)){

            $xml.=$xmlstart;

            foreach($categories as $key => $link){
                $xml .= trim($this->category_xml_dom($key , $link))."\n";
            }

            foreach($products as $key => $link){
                $xml .= trim($this->product_xml_dom($key , $link))."\n";
            }

            foreach($brands as $key => $link){
                $xml .= trim($this->brand_xml_dom($link));
            }

            foreach($blogs as $key => $link){
                $xml .= trim($this->blog_xml_dom($link));
            }

            $xml .= $xmlend;

            
            file_put_contents($file , trim($xml));

        // }
        
    }
    
    
    public function construct_xml_feed(){
        $file = ROOTPATH."sa_sitemap/productfeed.xml";
        $products = $this->productModel->product_urls(false);
        // var_dump(base_url());die();
        $xmlstart = '
        <?xml version="1.0" encoding="utf-8"?>
        <rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" xmlns:atom="http://www.w3.org/2005/Atom">
            <channel> 
                <title>Zamzamgames product feed</title>
                <description>zamzamgales Product Feed for Facebook</description> 
                <link>'.base_url().'</link>
                <atom:link href="'.base_url().'/sitemap/construct_xml_feed" rel="self" type="application/rss+xml" />';
        $xmlend = "
            </channel>
        </rss>";
        $xml="";

      
        // if(file_exists($file)){

            $xml.=$xmlstart;

            foreach($products as $key => $link){
                $xml.="<item>";
                $xml .= trim($this->product_feed_xml_dom($key , $link))."\n";
                $xml.="</item>";

            }

            $xml.=$xmlend;

            
            file_put_contents($file , trim($xml) );
    }


    public function product_xml_dom($id , $link){
        $productimage = $this->productModel->get_product_image($id);
        $productscreenshots = $this->productModel->get_product_screenshots($id);
        $element ="<url>";
        
        $element .= '
            <loc>'.htmlspecialchars($link).'</loc>
            <lastmod>'.(new \DateTime($this->productModel->getlastmodified($id) , new \DateTimeZone("Asia/Dubai")))->format("Y-m-d").'</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.0</priority>';

        if($productimage !== "" && $productimage !== null)
        $element .='
        <image:image>
            <image:loc>'.htmlspecialchars($productimage).'</image:loc>
            <image:title>'.htmlspecialchars($this->productModel->get_product_name($id)).'</image:title>
        </image:image>';

        if($productscreenshots !== "" && $productscreenshots !== null){
            foreach(explode("," , $productscreenshots) as $image){
                $element .='
                <image:image>
                    <image:loc>'.htmlspecialchars($image).'</image:loc>
                    <image:title>'.htmlspecialchars($this->productModel->get_product_name($id)).'</image:title>
                </image:image>
                ';
            }
        }

        if($productimage !== "" && $productimage !== null)
        $element .= '
        <PageMap xmlns="http://www.google.com/schemas/sitemap-pagemap/1.0">
            <DataObject type="thumbnail">
                <Attribute name="name" value="'.htmlspecialchars($this->productModel->get_product_name($id)).'"/>
                <Attribute name="src" value="'.htmlspecialchars($productimage).'"/>
            </DataObject>
        </PageMap>';

        $element .="</url>";

        return $element;
    }


    public function category_xml_dom($id , $link){
        $element ="<url>";
        $element .= '
            <loc>'.htmlspecialchars(base_url().'/'.$link).'</loc>
            
            <lastmod>'.(new \DateTime($this->categoryModel->getlastmodified($id) , new \DateTimeZone("Asia/Dubai")))->format("Y-m-d").'</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>';

        $element .="</url>";

        return $element;
    }

    public function brand_xml_dom($link){
        $element ="<url>\n";
        
        $element .= '
            <loc>'.htmlspecialchars(base_url()."/".$link).'</loc>
            <changefreq>daily</changefreq>
            <priority>0.4</priority>';

        $element .="</url>\n";

        return $element;
    }
    
    public function blog_xml_dom($link){
        $element ="<url>\n";
        
        $element .= '
            <loc>'.htmlspecialchars($link).'</loc>
            <changefreq>daily</changefreq>
            <priority>0.4</priority>';

        $element .="</url>\n";
        return $element;
    }


    public function product_feed_xml_dom($id , $link){
        $element="";
        $productimage = $this->productModel->get_product_image($id);
        $otherimages = $this->productModel->get_product_image($id , true);
        $productscreenshots = $this->productModel->get_product_screenshots($id);
        $product = $this->productModel->get_product_infos($id);

        if($product){

            // gtin, sku, title, link and product image link
            $element .="
                <g:gtin>".htmlspecialchars($product->sku)."</g:gtin>
                <g:id>".htmlspecialchars($product->sku)."</g:id>
                <g:title>".htmlspecialchars($product->name)."</g:title>            
                <g:link>".htmlspecialchars($link)."</g:link>
                <g:image_link>".htmlspecialchars($productimage)."</g:image_link>  
            ";

            // Product description
            if(!empty($product->page_description))
            $element .= "<g:description>".strip_tags(htmlspecialchars($product->page_description))."</g:description>";
            else
            $element .= "<g:description>".strip_tags(htmlspecialchars($product->description))."</g:description>";

            // Product screenshots
            if($productscreenshots !== "" && $productscreenshots !== null){
                foreach(explode("," , $productscreenshots) as $image){
                    $element .="
                    <additional_image_link>".htmlspecialchars($image)."</additional_image_link>
                    ";
                }
            }
            else{
                if($otherimages !== "" && sizeof($otherimages) > 1){
                    for($i=1 ; $i<sizeof($otherimages) ; $i++){
                        $element .="
                            <additional_image_link>".htmlspecialchars($otherimages[$i])."</additional_image_link>
                        ";
                    }
                }
            }

            // product variant attribute
            if($product->product_nature == "Variation" && $product->attribute_variation != ""){
                $variations = $this->productModel->get_variations($id);
                $i = 0;
                $additional_attributes = "";

                    foreach($variations as $key=>$value){
                        $variation = get_object_vars($value);
                        $attribute = $this->attributeModel->get_attribute_name(array_key_first($variation));
                        $option = $this->attributeModel->get_option_name($variation[array_key_first($variation)]);

                        if($i == 0){
                            $element .= "<".$attribute.">".htmlspecialchars($option)."</".$attribute.">";
                        }
                    
                        else{
                            $additional_attributes .= "
                                <label>".htmlspecialchars($attribute)."</label>
                                <value>".htmlspecialchars($option)."</value>
                            ";
                        }
                        $i++;
                    }

                    if($i > 1 && $additional_attributes !== "")
                    $element .= "<additional_variant_attribute>".$additional_attributes."</additional_variant_attribute>";
            }

            // product Brand,Condition,Availability,Price
            $stock = ($product->available_stock > 0) ? "in stock" : "out of stock";
            $element .= "
                <g:brand>".htmlspecialchars($this->productModel->get_brand_name($product->brand))."</g:brand>
                <g:condition>New</g:condition>  
                <g:availability>".$stock."</g:availability>
                <g:price>".$product->price." ".CURRENCY."</g:price>
            ";

            // Filter label by brand 
            $element .= "<g:custom_label_0>".htmlspecialchars($this->productModel->get_brand_name($product->brand))."</g:custom_label_0>";

            // Filter label by category / Sammer sale
            $summer_promo_condition = ($this->productModel->get_discounted_percentage($product->product_id) > 0) && $product->offer_start_date == "2023-05-08 12:00:00" && $product->offer_end_date == "2023-06-08 11:59:00";

            if($summer_promo_condition):
            $element .= "<g:custom_label_1>Sammer sale</g:custom_label_1>";
            else:
            $categories = explode("," , $this->productModel->get_product_categories($product->category));
            $element .= "<g:custom_label_1>".htmlspecialchars($categories[sizeof($categories)- 1] )."</g:custom_label_1>";
            endif;

            // Filter label by type 
            $product_type = explode(",",$this->productModel->get_product_types($product->type))[0];
            if($product_type !== "")
            $element .= "<g:custom_label_2>".htmlspecialchars($product_type)."</g:custom_label_2>";

            // Filter label by is NEW
            if($this->productModel->is_new($product->product_id))
            $element .= "<g:custom_label_3>NEW PRODUCT</g:custom_label_3>";
            else{
                
                $element .= "<g:custom_label_3>OLD PRODUCT</g:custom_label_3>";
            }


            // Filter labels by genre
            $genres = explode(",",$this->productModel->get_product_genres($product->color));
            if(sizeof($genres) > 0){
                $i=0;
                foreach ($genres as $genre) {
                    if($i < 3 && $genre !== "")
                    $element .= "<g:custom_label_".($i+4).">".htmlspecialchars($genre)."</g:custom_label_".($i+4).">";
                    $i++;
                }

            }

            // product type
            if($product_type !== "")
            $element .= "<g:product_type>".htmlspecialchars($product_type)."</g:product_type>";

            // google product category
            $gpc = htmlspecialchars($this->productModel->get_gp_category_name($product->google_category));
            if($gpc !== null)
            $element .= "<g:google_product_category>".$gpc."</g:google_product_category>";
            else if($product_type !== "")
            $element .= "<g:google_product_category>".$product_type."</g:google_product_category>";

            // product Sale price if it has
            if($this->productModel->get_discounted_percentage($id) > 0){
                $element .= "<g:sale_price>".round(bcdiv($product->price - ($product->discount_percentage*$product->price)/100, 1, 2))." ".CURRENCY."</g:sale_price>";

                // product has sale date range
                if($this->productModel->has_daterange_discount($product->offer_start_date,$product->offer_end_date)){
                    $timeZone = new \DateTimeZone("Asia/Dubai");
                    $start = new \DateTime($product->offer_start_date , $timeZone);
                    $end= new \DateTime($product->offer_end_date , $timeZone);
                    $element .= "<g:sale_price_effective_date>".$start->format("Y-m-d")."T".$start->format("H:i")."+04:00/".$end->format("Y-m-d")."T".$end->format("H:i")."+04:00"."</g:sale_price_effective_date>";
                }
            }
        
        }

        return $element;
    }

    public function test(){
        // $variations = $this->productModel->get_variations("4gamers-stereo-hs-wired-pro4-16587595843283");
        // var_dump(get_object_vars($variations[2]));

        // var_dump($this->product_feed_xml_dom("4gamers-stereo-hs-wired-pro4-16587595843283","zamzamgames.com"));
        // $p=$this->productModel->get_product_infos("paladone-playstation-control-16593696641253")->type;
        // var_dump(explode(",",$p));
        // $product = $this->productModel->get_product_infos("ps4-fifa-23-16589125394368");
        // var_dump(explode(",",$this->productModel->get_product_categories($product->category)));
        $t = new \DateTimeZone("Asia/Dubai");
        $date = new \DateTime("now" , $t);
        echo($date->format("Y-m-d")."T".$date->format("H:i")."+04:00");
    }






}
?>