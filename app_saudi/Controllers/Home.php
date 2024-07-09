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
		$best_offers_filter = [
            "showOffer" => "yes",
            "sort" => "Lowest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($best_offers = $this->productModel->product_filter_query($best_offers_filter))
        $data["best_offers"] = array( "list"=>$best_offers["product"], "title"=>lg_get_text("lg_26"), "link"=> base_url()."/product-list?show-offer=yes");

        // GAMING MERCHANDIZE
		$gaming_merchandise_filter = [
            "categoryList" => ["gaming-merchandise-1654092380"],
            "new_realesed" => ["Yes"],
            "show_in_homepage" => "Yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($gaming_merchandise = $this->productModel->product_filter_query($gaming_merchandise_filter))
		$data["new_gaming_merchandize"] = array("list"=>$gaming_merchandise["product"],"title"=>"New in Gaming Merchandise","link"=> base_url()."/gaming-merchandise?new_realesed=Yes");

        // NEW ARRIVALS IN VIDEO GAMES
        $new_arrivals_softwares_filter = [
            "new_realesed" => ["Yes"],
            "type" => ["5"],
            "show_in_homepage" => "Yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($new_arrivals_softwares = $this->productModel->product_filter_query($new_arrivals_softwares_filter))
		$data["new_arrivals_softwares"] = array("list"=>$new_arrivals_softwares["product"],"title"=>lg_get_text("lg_36"),"link"=> base_url()."/product-list?new_realesed=Yes&type=5");
		
		// NEW ARRIVALS IN ACCESSORIES
        $new_arrivals_accessories_filter = [
            "new_realesed" => ["Yes"],
            "type" => ["7","55","63","27","62","37","26","29","61","31","28","30","49","64","34","57"],
            "show_in_homepage" => "Yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($new_arrivals_accessories = $this->productModel->product_filter_query($new_arrivals_accessories_filter))
		$data["new_arrivals_accessories"] = array("list"=>$new_arrivals_accessories["product"],"title"=>lg_get_text("lg_23"),"link"=> base_url()."/product-list?new_realesed=Yes&type=7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57");

		// COMMIN SOON PRODUCTS
        $comming_soon_filter = [
            "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($comming_soon = $this->productModel->product_filter_query($comming_soon_filter))
		$data["coming_soon"] = array("list"=>$comming_soon["product"],"title"=>lg_get_text("lg_22"),"link"=> base_url()."/product-list?pre-order=enabled");

		// MORE PRODUCTS IN VIDEO GAMES
        $more_games_filter = [
            "type" => ["5"],            
            "precedence" => "1000",
            "show_in_homepage" => "Yes",
            "page" => 3,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($more_games = $this->productModel->product_filter_query($more_games_filter))
		$data["more_games"] = array("list"=>$more_games["product"],"title"=>lg_get_text("lg_20"),"link"=> base_url()."/product-list?type=5");

		// MORE PRODUCTS IN ACCESSORIES
        $more_accessories_filter = [
            "categoryList" => ["accessories-1636468761","accessories-1636468795","accessories-1636468817","pc-gaming-1637656902"],
            "precedence" => "1000",
            "show_in_homepage" => "Yes",
            // "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 5,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($more_accessories = $this->productModel->product_filter_query($more_accessories_filter))
		$data["more_accessories"] = array("list"=>$more_accessories["product"],"title"=>lg_get_text("lg_19"),"link"=> base_url()."/product-list?categoryList=pc-gaming-1637656902,accessories-1636468795,accessories-1636468761,accessories-1636468817");
	
        
        // NEW IN PC GAMING
        $new_pc_gaming_filter = [
            "type" => ["36"],
            "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($new_pc_gaming = $this->productModel->product_filter_query($new_pc_gaming_filter))
		$data["new_in_pc_gaming"] = array("list"=>$new_pc_gaming["product"],"title"=>lg_get_text("lg_358"),"link"=> base_url()."/product-list?&type=36");

        // SPIDER MAN SPECIAL SECTION
        $spiderman_filter = [
            "keyword" => "spider",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        // var_dump($this->productModel->product_filter_query($spiderman_filter));die();
        if($spiderman_products = $this->productModel->product_filter_query($spiderman_filter))
		$data["spiderman_section"] = array("list"=>$spiderman_products["product"],"title"=>strtoupper("SHOP IN SPIDER-MAN"),"link"=> base_url()."/product-list?&keyword=spider");

        // PC PARTS
        $pcparts_filter = [
            "categoryList" => ["ram-1673701222","power-supply-1668593980","graphics-card-1660652597","processor-1673691676"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
        ];
        if($pcparts_products = $this->productModel->product_filter_query($pcparts_filter))
		$data["pc_parts"] = array("list"=>$pcparts_products["product"],"title"=>strtoupper("PC PARTS"),"link"=> base_url()."/product-list?&categoryList=ram-1673701222,power-supply-1668593980,graphics-card-1660652597,processor-1673691676");

        // MARVEL CORNER
        $marvel_products_filter = [
            "keyword" => "marvel",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
            // "groupby" => "brand"
        ];
        if($products = $this->productModel->product_filter_query($marvel_products_filter))
		$data["marvel_corner"] = array("list"=>$products["product"],"title"=>strtoupper("MARVEL CORNER"),"link"=> base_url()."/product-list?keyword=marvel");
    
        // Bundle offers
        $bundle_offers_products_filter = [
            "categoryList" => ["new-year-1703760727"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 10,
            "show_in_homepage" => "Yes",
            // "groupby" => "brand"
        ];
        if($products = $this->productModel->product_filter_query($bundle_offers_products_filter))
		$data["bundle_offers"] = array("list"=>$products["product"],"title"=>strtoupper("Bundle offers"),"link"=> base_url()."/new-year");
    
		return $data;
	}
}
