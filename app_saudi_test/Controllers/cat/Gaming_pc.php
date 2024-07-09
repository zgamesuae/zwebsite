<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Gaming_pc extends \App\Controllers\BaseController{


    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category');
        
        $banners=$categoryModel->get_category_page_banners("gaming-pc-1717603145");
        $data=array(
            "category_banners" => $banners
        );


        // OFFERS SECTION
        $offers_filter = [
            "master_category" => "gaming-pc-1717603145",
            "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($offers_filter))
		$data["offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_26")),"link"=> base_url()."/product-list?category=gaming-pc-1717603145&show-offer=yes");
        

        // PC SETUPS
        $filter = [            
            "categoryList" => ["gaming-desktops-1649784817"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["pcs"] = array("list"=>$products["product"],"title"=>strtoupper("PC SETUPS"),"link"=> base_url()."/gaming-pc/pc-setup");
        
        
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
		$data["pc_cases"] = array("list"=>$products["product"],"title"=>strtoupper("PC CASES"),"link"=> base_url()."/gaming-pc/pc-parts/computer-cases");
        
        // GRAPHIC CARDS SECTION
        $filter = [
            "categoryList" => ["graphics-card-1660652597"],
            // "type" => ["5"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["gpus"] = array("list"=>$products["product"],"title"=>strtoupper("GRAPHIC CARDS"),"link"=> base_url()."/gaming-pc/pc-parts/graphics-card");
        
        // OTHER PC COMPONENTS
        $filter = [
            "categoryList" => ["cooling-pads-1667654361","processor-1673691676","power-supply-1668593980","power-supply-1668593980"],
            // "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 16,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["cooling_and_power"] = array("list"=>$products["product"],"title"=>strtoupper("COOLING & POWER"),"link"=> base_url()."/product-list?categoryList=cooling-pads-1667654361,power-supply-1668593980,processor-1673691676,cooling-pads-1667654361");

        // PC GAMING FURNITURE
        $filter = [
            "categoryList" => ["gaming-furniture-1649507795"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 16,
            // "show_in_homepage" => "Yes",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["gaming_furniture"] = array("list"=>$products["product"],"title"=>strtoupper("GAMING FURNITURE"),"link"=> base_url()."/gaming-pc/gaming-furniture");

        // PC HEADSETS
        $filter = [
            "categoryList" => ["headsets-1637657090"],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            // "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 18,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["headsets"] = array("list"=>$products["product"],"title"=>strtoupper("GAMING HEADSETS"),"link"=> base_url()."/gaming-pc/pc-accessories/headset");
        
        // KEYBOARDS & MICE
        $filter = [
            "categoryList" => ["mousepads-1637657146","mouses-1637657171","keyboards-1637657116"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            // "show_in_homepage" => "Yes",
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["keyboards_and_mice"] = array("list"=>$products["product"],"title"=>strtoupper("KEYBOARDS & MICE"),"link"=> base_url()."/product-list?categoryList=keyboards-1637657116,mouses-1637657171,mousepads-1637657146");

        // STREAMING        
		$filter = [
            "categoryList" => ["streaming-1649678247"],
            // "show_in_homepage" => "Yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 12
        ];
        if($skins = $this->productModel->product_filter_query($filter))
		$data["streaming"] = array("list"=>$skins["product"],"title"=>strtoupper("STREAMING"),"link"=> base_url()."/product-list?categoryList=streaming-1649678247");

        echo view("Common/Header");
        echo view("Category_pc",$data);
        echo view("Common/Footer");

    }
    
}


?>