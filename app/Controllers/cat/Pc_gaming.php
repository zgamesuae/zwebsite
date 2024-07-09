<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Pc_gaming extends \App\Controllers\BaseController{


    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category');
        
        $banners=$categoryModel->get_category_page_banners("pc-gaming-1712224246");
        $data=array(
            "category_banners" => $banners
        );


        // OFFERS SECTION
        $offers_filter = [
            "master_category" => "pc-gaming-1712224246",
            "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($offers_filter))
		$data["offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_26")),"link"=> base_url()."/product-list?category=pc-gaming-1712224246&show-offer=yes");
        

        // PC SETUPS
        $filter = [            
            "categoryList" => ["pc-setup-1712226063"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["pcs"] = array("list"=>$products["product"],"title"=>strtoupper("PC SETUPS"),"link"=> base_url()."/pc-gaming/pc-setup");
        
        
        // PC CASES SECTION
        $filter = [
            "categoryList" => ["pc-cases-1712224852"],
            // "type" => ["26"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["pc_cases"] = array("list"=>$products["product"],"title"=>strtoupper("PC CASES"),"link"=> base_url()."/pc-gaming/pc-parts/pc-cases");
        
        // GRAPHIC CARDS SECTION
        $filter = [
            "categoryList" => ["graphic-cards-1712224809"],
            // "type" => ["5"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["gpus"] = array("list"=>$products["product"],"title"=>strtoupper("GRAPHIC CARDS"),"link"=> base_url()."/pc-gaming/pc-parts/graphic-cards");
        
        // OTHER PC COMPONENTS
        $filter = [
            "categoryList" => ["cooling-1712225053","processors-1712224900","power-supplies-1712225136","motherboards-1712224945"],
            // "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 16,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["cooling_and_power"] = array("list"=>$products["product"],"title"=>strtoupper("COOLING & POWER"),"link"=> base_url()."/product-list?categoryList=cooling-1712225053,processors-1712224900,power-supplies-1712225136,motherboards-1712224945");

        // PC GAMING FURNITURE
        $filter = [
            "categoryList" => ["furniture-1712225180"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 16,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["gaming_furniture"] = array("list"=>$products["product"],"title"=>strtoupper("GAMING FURNITURE"),"link"=> base_url()."/pc-gaming/furniture");

        // PC HEADSETS
        $filter = [
            "categoryList" => ["headsets-1712224387"],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            // "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 18,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["headsets"] = array("list"=>$products["product"],"title"=>strtoupper("GAMING HEADSETS"),"link"=> base_url()."/pc-gaming/pc-accessories/headsets");
        
        // KEYBOARDS & MICE
        $filter = [
            "categoryList" => ["mice-1712224630","mouse-pads-1712224682","keyboards-1712224434"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            // "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["keyboards_and_mice"] = array("list"=>$products["product"],"title"=>strtoupper("KEYBOARDS & MICE"),"link"=> base_url()."/product-list?categoryList=mice-1712224630,mouse-pads-1712224682,keyboards-1712224434");

        // STREAMING        
		$filter = [
            "categoryList" => ["cameras-1712226448","microphones-1712224731"],
            // "show_in_homepage" => "Yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12
        ];
        if($skins = $this->productModel->product_filter_query($filter))
		$data["streaming"] = array("list"=>$skins["product"],"title"=>strtoupper("STREAMING"),"link"=> base_url()."/product-list?categoryList=cameras-1712226448,microphones-1712224731");

        echo view("Common/Header");
        echo view("Category_pc",$data);
        echo view("Common/Footer");

    }
    
}


?>