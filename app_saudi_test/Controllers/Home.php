<?php
namespace App\Controllers;
class Home extends BaseController {
    public function index() {
        
        
        // var_dump($data);
        // die();
        // echo view('Home',$data);
        
        
        $data=$this->home_products_carousel();
        $data['flashData']=$this->session->getFlashdata();

        echo $this->header();
        echo view('Home' , $data);
        echo $this->footer();
    }
    
    public function header($data = []) {
        return view('Common/Header' , $data);
    }
    public function footer() {
        return view('Common/Footer');
    }
    public function ContactSubmit() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $res = $this->userModel->do_action('contact_us_form', '', '', 'insert', $p, '');
            $this->session->setFlashdata('success', 'Your message has been successfully sent. ');
            return redirect()->to(site_url('contact-us'));
        }
    }

	private function home_products_carousel(){
		$data=array();
		$product_model=model('App\Models\ProductModel');

        
        // BEST OFFERS
        if(!cache("home_best_offers_filter")){
            $filter=[
                "showOffer" => "yes",
                "sort" => "Lowest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_best_offers_filter" , $products , 300);
        }
        if($products = cache("home_best_offers_filter"))
        $data["best_offers"] = array( "list"=>$products["product"], "title"=>lg_get_text("lg_26"), "link"=> base_url()."/product-list?show-offer=yes");
        
        
        // GAMING MERCHANDIZE
        if(!cache("home_gamming_merchandize")){
            $filter=[
                "categoryList" => ["gaming-merchandise-1654092380"],
                "new_realesed" => ["Yes"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_gamming_merchandize" , $products , 300);
        }
        if($products = cache("home_gamming_merchandize"))
        $data["new_gaming_merchandize"] = array("list"=>$products["product"],"title"=>"New in Gaming Merchandise","link"=> base_url()."/gaming-merchandise?new_realesed=Yes");
        
        
        // NEW ARRIVALS IN VIDEO GAMES
        if(!cache("home_new_video_games")){
            $filter=[
                "new_realesed" => ["Yes"],
                "type" => ["5"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_new_video_games" , $products , 300);
        }
        if($products = cache("home_new_video_games"))
        $data["new_arrivals_softwares"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_36"),"link"=> base_url()."/product-list?new_realesed=Yes&type=5");
        
        
        // NEW ARRIVALS IN ACCESSORIES
        if(!cache("home_new_accessories")){
            $filter=[
                "new_realesed" => ["Yes"],
                "type" => ["7","55","63","27","62","37","26","29","61","31","28","30","49","64","34","57"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_new_accessories" , $products , 300);
        }
        if($products = cache("home_new_accessories"))
        $data["new_arrivals_accessories"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_23"),"link"=> base_url()."/product-list?new_realesed=Yes&type=7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57");
        
        
        // COMMIN SOON PRODUCTS
        if(!cache("home_coming_soon")){
            $filter=[
                "preOrder" => ["Yes"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "show_in_homepage" => "Yes",
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_coming_soon" , $products , 300);
        }
        if($products = cache("home_coming_soon"))
        $data["coming_soon"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_22"),"link"=> base_url()."/product-list?pre-order=enabled");
        
        
        // MORE PRODUCTS IN VIDEO GAMES
        if(!cache("home_more_video_games")){
            $filter=[
                "type" => ["5"],            
                "precedence" => "1000",
                "show_in_homepage" => "Yes",
                "page" => 3,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_more_video_games" , $products , 300);
        }
        if($products = cache("home_more_video_games"))
        $data["more_games"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_20"),"link"=> base_url()."/product-list?type=5");
        
        
        // MORE PRODUCTS IN ACCESSORIES
        if(!cache("home_more_accessories")){
            $filter=[
                "categoryList" => ["accessories-1636468761","accessories-1636468795","accessories-1636468817","pc-gaming-1637656902"],
                "precedence" => "1000",
                "show_in_homepage" => "Yes",
                // "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 5,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_more_accessories" , $products , 300);
        }
        if($products = cache("home_more_accessories"))
        $data["more_accessories"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_19"),"link"=> base_url()."/product-list?categoryList=pc-gaming-1637656902,accessories-1636468795,accessories-1636468761,accessories-1636468817");
        
        
        // NEW IN PC GAMING
        if(!cache("home_new_in_pc")){
            $filter=[
                "type" => ["36"],
                "show_in_homepage" => "Yes",
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_new_in_pc" , $products , 300);
        }
        if($products = cache("home_new_in_pc"))
        $data["new_in_pc_gaming"] = array("list"=>$products["product"],"title"=>lg_get_text("lg_358"),"link"=> base_url()."/product-list?&type=36");
        
        
        // SPIDER MAN SPECIAL SECTION
        if(!cache("home_spideman_products")){
            $filter=[
                "keyword" => "spider",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_spideman_products" , $products , 300);
        }
        if($products = cache("home_spideman_products"))
        $data["spiderman_section"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_386")),"link"=> base_url()."/product-list?&keyword=spider");
        
        
        // PC PARTS
        if(!cache("home_pc_parts")){
            $filter=[
                "categoryList" => ["ram-1673701222","power-supply-1668593980","graphics-card-1660652597","processor-1673691676"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_pc_parts" , $products , 300);
        }
        if($products = cache("home_pc_parts"))
        $data["pc_parts"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_387")),"link"=> base_url()."/product-list?&categoryList=ram-1673701222,power-supply-1668593980,graphics-card-1660652597,processor-1673691676");
        
        
        // MARVEL CORNER
        if(!cache("home_marvel_products")){
            $filter=[
                "keyword" => "marvel",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_marvel_products" , $products , 300);
        }
        if($products = cache("home_marvel_products"))
        $data["marvel_corner"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_389")),"link"=> base_url()."/product-list?keyword=marvel");
        
        
        // Bundle offers
        if(!cache("home_bundle_offers")){
            $filter=[
                "categoryList" => ["new-year-1703760727"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $products = $this->productModel->product_filter_query($filter);
            if($products)
            cache()->save("home_bundle_offers" , $products , 300);
        }
        if($products = cache("home_bundle_offers"))
        $data["bundle_offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_391")),"link"=> base_url()."/new-year");

		return $data;
	}
}
