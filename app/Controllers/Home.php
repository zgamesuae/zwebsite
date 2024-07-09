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
        if(!cache("home_best_offers")){
		    $best_offers_filter = [
                "showOffer" => "yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 2,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $best_offers = $this->productModel->product_filter_query($best_offers_filter);
            if($best_offers)
            cache()->save("home_best_offers" , $best_offers , 300);
        }
        if($best_offers = cache("home_best_offers"))
        $data["best_offers"] = array( "list"=>$best_offers["product"], "title"=>strtoupper(lg_get_text("lg_26")), "link"=> base_url()."/product-list?show-offer=yes");



        // CONSOLES SKINS
        if(!cache("home_skins")){
            $skins_filter = [
                "type" => ["49"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $skins = $this->productModel->product_filter_query($skins_filter);
            if($skins)
            cache()->save("home_skins" , $skins , 300);
        }
        if($skins = cache("home_skins"))
		$data["console_skins"] = array("list"=>$skins["product"],"title"=>strtoupper(lg_get_text("lg_359")),"link"=> base_url()."/product-list?type=49");



        // NEW ARRIVALS IN VIDEO GAMES
        if(!cache("home_new_arrivals_softwares")){
            $new_arrivals_softwares_filter = [
                "new_realesed" => ["Yes"],
                "type" => ["5"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $new_arrivals_softwares = $this->productModel->product_filter_query($new_arrivals_softwares_filter);
            if($new_arrivals_softwares)
            cache()->save("home_new_arrivals_softwares" , $new_arrivals_softwares , 300);
        }
        if($new_arrivals_softwares = cache("home_new_arrivals_softwares"))
		$data["new_arrivals_softwares"] = array("list"=>$new_arrivals_softwares["product"],"title"=>strtoupper(lg_get_text("lg_36")),"link"=> base_url()."/product-list?new_realesed=Yes&type=5");
		


		// NEW ARRIVALS IN ACCESSORIES
        if(!cache("home_new_arrivals_accessories")){
            $new_arrivals_accessories_filter = [
                "new_realesed" => ["Yes"],
                "type" => ["72" , "7","55","63","27","62","37","26","29","61","31","28","30","49","64","34","57"],
                "show_in_homepage" => "Yes",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
                "groupby" => "brand",
            ];
            $new_arrivals_accessories = $this->productModel->product_filter_query($new_arrivals_accessories_filter);
            if($new_arrivals_accessories)
            cache()->save("home_new_arrivals_accessories" , $new_arrivals_accessories , 300);
        }
        if($new_arrivals_accessories = cache("home_new_arrivals_accessories"))
		$data["new_arrivals_accessories"] = array("list"=>$new_arrivals_accessories["product"],"title"=>strtoupper(lg_get_text("lg_23")),"link"=> base_url()."/product-list?new_realesed=Yes&type=72,7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57");



		// COMMIN SOON PRODUCTS
        if(!cache("home_coming_soon")){
            $comming_soon_filter = [
                "preOrder" => ["Yes"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "show_in_homepage" => "Yes",
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $comming_soon = $this->productModel->product_filter_query($comming_soon_filter);
            if($comming_soon)
            cache()->save("home_coming_soon" , $comming_soon , 300);
        }
        if($comming_soon = cache("home_coming_soon"))
		$data["coming_soon"] = array("list"=>$comming_soon["product"],"title"=>strtoupper(lg_get_text("lg_22")),"link"=> base_url()."/product-list?pre-order=enabled");



		// MORE PRODUCTS IN VIDEO GAMES
        if(!cache("home_more_games")){
            $more_games_filter = [
                "type" => ["5"],            
                "precedence" => "1000",
                "show_in_homepage" => "Yes",
                "page" => 3,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $more_games = $this->productModel->product_filter_query($more_games_filter);
            if($more_games)
            cache()->save("home_more_games" , $comming_soon , 300);
        }
        if($more_games = cache("home_more_games"))
		$data["more_games"] = array("list"=>$more_games["product"],"title"=>strtoupper(lg_get_text("lg_20")),"link"=> base_url()."/product-list?type=5");



		// MORE PRODUCTS IN ACCESSORIES
        if(!cache("home_more_accessories")){
            $more_accessories_filter = [
                "type" => ["7","55","63","27","62","37","26","29","61","31","28","30","49","64","34","57"],
                "precedence" => "1000",
                "show_in_homepage" => "Yes",
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $more_accessories = $this->productModel->product_filter_query($more_accessories_filter);
            if($more_accessories)
            cache()->save("home_more_accessories" , $comming_soon , 300);
        }
        if($more_accessories = cache("home_more_accessories"))
		$data["more_accessories"] = array("list"=>$more_accessories["product"],"title"=>strtoupper(lg_get_text("lg_19")),"link"=> base_url()."/product-list?type=7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57");
	
        
        // NEW IN PC GAMING
        if(!cache("home_new_pc_gaming")){
            $new_pc_gaming_filter = [
                "type" => ["42"],
                "show_in_homepage" => "Yes",
                "page" => 1,
                "limit" => 8,
                "groupby" => "brand",
                "show_in_homepage" => "Yes",
            ];
            $new_pc_gaming = $this->productModel->product_filter_query($new_pc_gaming_filter);
            if($new_pc_gaming)
            cache()->save("home_new_pc_gaming" , $new_pc_gaming , 300);
        }
        if($new_pc_gaming = cache("home_new_pc_gaming"))
		$data["new_in_pc_gaming"] = array("list"=>$new_pc_gaming["product"],"title"=>strtoupper(lg_get_text("lg_371")),"link"=> base_url()."/product-list?&type=42");
        
        

        // SPIDER MAN SPECIAL SECTION
        if(!cache("home_spiderman_products")){
            $spiderman_filter = [
                "keyword" => "spider",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $spiderman_products = $this->productModel->product_filter_query($spiderman_filter);
            if($spiderman_products)
            cache()->save("home_spiderman_products" , $spiderman_products , 300);
        }
        // var_dump($this->productModel->product_filter_query($spiderman_filter));die();
        if($spiderman_products = cache("home_spiderman_products"))
		$data["spiderman_section"] = array("list"=>$spiderman_products["product"],"title"=>strtoupper(lg_get_text("lg_386")),"link"=> base_url()."/product-list?&keyword=spider");



        // PC PARTS
        if(!cache("home_pcparts_products")){
            $pcparts_filter = [
                "categoryList" => ["motherboard-1691751115","power-supply-1668593980","graphics-card-1660652597","processor-1697895866","internal-data-storage-1660738636,internal-data-storage-1660738636,external-data-storage-1660816365"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "groupby" => "brand",
                "show_in_homepage" => "Yes",
            ];
            $pcparts_products = $this->productModel->product_filter_query($pcparts_filter);
            if($pcparts_products)
            cache()->save("home_pcparts_products" , $pcparts_products , 300);

        }
        if($pcparts_products = cache("home_pcparts_products"))
		$data["pc_parts"] = array("list"=>$pcparts_products["product"],"title"=>strtoupper(lg_get_text("lg_387")),"link"=> base_url()."/product-list?&categoryList=motherboard-1691751115,power-supply-1668593980,graphics-card-1660652597,processor-1697895866,internal-data-storage-1660738636,");
        


        // RACING
        if(!cache("home_racing_products")){
            $racing_products_filter = [
                "master_category" => "special-racing-1699456301",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $products = $this->productModel->product_filter_query($racing_products_filter);
            if($products)
            cache()->save("home_racing_products" , $products , 300);

        }
        if($products = cache("home_racing_products"))
		$data["racing_corner"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_388")),"link"=> base_url()."/special-racing");



        // MARVEL CORNER
        if(cache("home_marvel_corner")){
            $marvel_products_filter = [
                "keyword" => "marvel",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $products = $this->productModel->product_filter_query($marvel_products_filter);
            if($products)
            cache()->save("marvel_products_filter" , $products , 300);

        }
        if($products = cache("marvel_products_filter"))
		$data["marvel_corner"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_389")),"link"=> base_url()."/product-list?keyword=marvel");
        


        // New in Collectibles
        if(!cache("home_new_collectibles")){
            $new_collectibles_filter = [
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "categoryList" => ["action-figure-1654092603"],
                "new_realesed" => ["Yes"],
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
            ];
            $products = $this->productModel->product_filter_query($new_collectibles_filter);
            if($products)
            cache()->save("home_new_collectibles" , $products , 300);
        }
        if($products = cache("home_new_collectibles"))
		$data["new_in_collectibles"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_390")),"link"=> base_url()."/gaming-merchandise/figurines-&-collectible?new_realesed=Yes");



        // Bundle offers
        if(!cache("home_bundle_offers")){
            $cart_bundle_offers = [
                "type" => ["18"],
                "showOffer" => "yes",
                "offer_cdn" => "42,43,52,53,50,51,49,48,40,37",
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                // "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $bundle_offers_products_filter = [
                "type" => ["12"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 8,
                "show_in_homepage" => "Yes",
                // "groupby" => "brand"
            ];
            $products_2 = $this->productModel->product_filter_query($cart_bundle_offers);
            $products = $this->productModel->product_filter_query($bundle_offers_products_filter);
            $products["product"] = (is_array($products_2["product"])) ? array_merge($products["product"] , $products_2["product"]) : $products["product"];
            if($products || $products_2)
            cache()->save("home_bundle_offers" , $products , 300);
        }
        if($products = cache("home_bundle_offers"))
		$data["bundle_offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_391")),"link"=> base_url()."/product-list?type=12");
        


        // Gaming Lightning Decoration / PALADON
        if(!cache("home_paladon_products")){
            $paladon_filter = [
                "brand" => ["2325"],
                "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                "page" => 1,
                "limit" => 10,
                "show_in_homepage" => "Yes",
                // "groupby" => "type"
            ];
            $products = $this->productModel->product_filter_query($paladon_filter);
            if($products)
            cache()->save("home_paladon_products" , $products , 300);
        }
        if($products = cache("home_paladon_products"))
		$data["paladon_merchandize"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_372")),"link"=> base_url()."/product-list?brand=2325");
    
		return $data;
	}
}
